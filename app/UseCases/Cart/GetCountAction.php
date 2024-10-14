<?php

namespace App\UseCases\Cart;

use App\Models\CartProduct;
use Illuminate\Support\Facades\Auth;

class GetCountAction
{
    public function __invoke(): int
    {
        if (Auth::guard('web')->check()) {
            return CartProduct::query()
                ->where('user_id', Auth::guard('web')->id())
                ->count();
        } else {
            $cart = session()->get('cartList', []);

            return count($cart);
        }
    }
}
