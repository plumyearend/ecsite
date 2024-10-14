<?php

namespace App\UseCases\Cart;

use App\Models\CartProduct;
use Illuminate\Support\Facades\Auth;

class CollectCartToTableAction
{
    public function __invoke()
    {
        if (!Auth::guard('web')->check()) {
            return;
        }

        $cartList = session()->get('cartList', []);
        foreach ($cartList as $key => $item) {
            $cartProduct = CartProduct::query()
                ->select('count')
                ->where('product_id', $key)
                ->first();

            CartProduct::updateOrCreate(
                [
                    'user_id' => Auth::guard('web')->id(),
                    'product_id' => $key,
                ],
                [
                    'count' => $cartProduct ? $cartProduct->count + $item['quantity'] : $item['quantity'],
                ]
            );
        }

        session()->forget('cartList');
    }
}
