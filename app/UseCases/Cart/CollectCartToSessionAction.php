<?php

namespace App\UseCases\Cart;

use App\Models\CartProduct;

class CollectCartToSessionAction
{
    public function __invoke(int $userId)
    {
        $cartProducts = CartProduct::query()
            ->select(['id', 'product_id', 'count'])
            ->where('user_id', $userId)
            ->orderBy('created_at')
            ->get();

        $cartProductArray = $cartProducts->map(function ($item) {
            return [
                'id' => $item['product_id'],
                'quantity' => $item['count'],
            ];
        });

        session()->forget('cartList');
        $cart = [];
        foreach ($cartProductArray as $product) {
            $cart[$product['id']] = [
                'id' => $product['id'],
                'quantity' => $product['quantity'],
            ];
        }
        session()->put('cartList', $cart);

        CartProduct::query()
            ->where('user_id', $userId)
            ->delete();
    }
}
