<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkout\SaveAddressRequest;
use App\Http\Requests\Checkout\StoreRequest;
use App\Notifications\Purchase;
use App\UseCases\Cart\DeleteProductAction;
use App\UseCases\Checkout\FixPurchaseAction;
use App\UseCases\Checkout\GetOrderAction;
use App\UseCases\Checkout\GetOrderDetailsAction;
use App\UseCases\Checkout\SaveOrderAddressAction;
use Exception;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\StripeClient;

class CheckoutController extends Controller
{
    use Notifiable;

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
                throw new Exception('送り先保存に失敗しました。');
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new Exception('エラーが発生しました。');
        }

        return redirect()->route('checkouts.payment.show', ['encodedId' => $encodedId]);
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

    public function store(
        StoreRequest $request,
        GetOrderAction $getOrderAction,
        FixPurchaseAction $fixPurchaseAction,
        DeleteProductAction $deleteProductAction,
        string $encodedId,
    ) {
        $stripeIntentId = $request->get('stripe_intent_id');
        $stripeMethodId = $request->get('stripe_method_id');
        $order = $getOrderAction($encodedId);

        try {
            DB::beginTransaction();
            if (!$fixPurchaseAction($order, $stripeIntentId, $stripeMethodId)) {
                DB::rollback();
                throw new Exception('商品購入に失敗しました。ID:' . $encodedId);
            }
            foreach ($order->orderDetails as $orderDetail) {
                $deleteProductAction($orderDetail->product_id);
            }
            $this->notify(new Purchase($order));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new Exception('エラーが発生しました。');
        }

        return redirect()->route('checkouts.complete');
    }

    public function complete()
    {
        return view('checkouts.complete');
    }
}
