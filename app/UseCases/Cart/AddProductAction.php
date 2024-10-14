<?php

namespace App\UseCases\Cart;

use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AddProductAction
{
    public function __invoke(Product $product, int $quantity)
    {
        if (Auth::guard('web')->check()) {
            $cartProduct = CartProduct::query()
                ->select('count')
                ->where('product_id', $product->id)
                ->first();

            CartProduct::updateOrCreate(
                [
                    'user_id' => Auth::guard('web')->id(),
                    'product_id' => $product->id,
                ],
                [
                    'count' => $cartProduct ? $cartProduct->count + $quantity : $quantity,
                ]
            );
        } else {
            $cart = session()->get('cartList', []);

            if (isset($cart[$product->id])) {
                $cart[$product->id]['quantity'] += $quantity;
            } else {
                $cart[$product->id] = [
                    'id' => $product->id,
                    'quantity' => $quantity,
                ];
            }

            session()->put('cartList', $cart);
        }
    }
}
