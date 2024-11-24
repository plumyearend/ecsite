<?php

namespace App\Http\Controllers;

use App\Http\Requests\Checkout\SaveAddressRequest;
use App\UseCases\Checkout\SaveOrderAddressAction;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function payment(string $encodedId)
    {

        // TODO: 決済選択画面を表示
    }
}
