<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkout\SaveAddressRequest;
use App\UseCases\Checkout\GetOrderAction;
use App\UseCases\Checkout\GetOrderDetailsAction;
use App\UseCases\Checkout\SaveOrderAddressAction;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    public function saveAddress(
        SaveAddressRequest $request,
        string $encodedId,
        SaveOrderAddressAction $saveOrderAddressAction,
    ) {
        $input = $request->all();
        try {
            DB::beginTransaction();
            if (!$saveOrderAddressAction($encodedId, $input)) {
                DB::rollback();
                throw new Exception('ユーザー作成に失敗しました。');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new Exception('エラーが発生しました。');
        }

        return redirect()->route('checkouts.payment', ['encodedId' => $encodedId]);
    }

    public function payment(
        GetOrderAction $getOrderAction,
        GetOrderDetailsAction $getOrderDetailsAction,
        string $encodedId,
    ) {
        $order = $getOrderAction($encodedId);
        $orderDetails = $getOrderDetailsAction($order)->toArray();

        $data = [
            'orderDetails' => $orderDetails,
            'order' => $order,
            'encodedId' => $encodedId,
        ];

        return view('checkouts.payment', $data);
    }

    public function purchase(
        GetOrderAction $getOrderAction,
        string $encodedId,
    ) {
        $order = $getOrderAction($encodedId);
        Stripe::setApiKey(config('stripe.secret'));

        try {
            $stripe = new StripeClient(config('services.stripe.secret'));
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $order->total_price,
                'currency' => 'jpy',
                'description' => '商品購入',
                'payment_method_types' => ['card'],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
