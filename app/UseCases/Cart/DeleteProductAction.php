<?php

namespace App\UseCases\Cart;

use App\Models\CartProduct;
use Illuminate\Support\Facades\Auth;

class DeleteProductAction
{
    public function __invoke(int $productId)
    {
        if (Auth::guard('web')->check()) {
            CartProduct::query()
                ->where('product_id', $productId)
                ->delete();
        } else {
            $cart = session()->get('cartList', []);
            unset($cart[$productId]);
            session()->put('cartList', $cart);
        }
    }
}
