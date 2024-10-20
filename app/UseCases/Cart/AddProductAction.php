<?php

namespace App\UseCases\Cart;

use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class AddProductAction
{
    public function __invoke(Product $product, int $count)
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
                    'count' => $cartProduct ? $cartProduct->count + $count : $count,
                ]
            );
        } else {
            $cart = session()->get('cartList', []);

            if (isset($cart[$product->id])) {
                $cart[$product->id]['count'] += $count;
            } else {
                $cart[$product->id] = [
                    'id' => $product->id,
                    'count' => $count,
                ];
            }

            session()->put('cartList', $cart);
        }
    }
}
