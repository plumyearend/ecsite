<?php

namespace App\UseCases\Cart;

use App\Models\CartProduct;
use Illuminate\Support\Facades\Auth;

class UpdateProductCountAction
{
    public function __invoke(int $productId, int $count)
    {
        if (Auth::guard('web')->check()) {
            CartProduct::query()
                ->where('user_id', Auth::guard('web')->id())
                ->where('product_id', $productId)
                ->update(['count' => $count]);
        } else {
            $cart = session()->get('cartList', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['count'] = $count;
            }
            session()->put('cartList', $cart);
        }
    }
}
