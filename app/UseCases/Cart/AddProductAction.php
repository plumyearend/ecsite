<?php

namespace App\UseCases\Cart;

use App\Models\Product;

class AddProductAction
{
    public function __invoke(Product $product, int $quantity)
    {
        // TODO: カートに入れる
        // TODO: ログイン時はテーブルに保存
        // TODO: 非ログイン時はsessionに保存
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return null;
    }
}
