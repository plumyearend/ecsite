<?php

namespace App\UseCases\Cart;

use App\Enums\Product\Status;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class GetListAction
{
    public function __invoke()
    {
        if (Auth::guard('web')->check()) {
            $cartProducts = CartProduct::query()
                ->select(['product_id', 'count'])
                ->where('user_id', Auth::guard('web')->id())
                ->orderBy('created_at')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->product_id,
                        'quantity' => $item->count,
                    ];
                });
        } else {
            $cartProducts = session()->get('cartList', []);
        }

        $cartProductIds = array_keys($cartProducts);
        $products = Product::query()
            ->select(['id', 'name', 'price'])
            ->with('productImages', function ($query) {
                $query->select(['product_id', 'image']);
                $query->where('sort', 1);
            })
            ->whereIn('id', $cartProductIds)
            ->where('status', Status::PUBLISHED)
            ->get();

        $list = collect();
        foreach ($cartProducts as $cartProduct) {
            $list->push([
                'quantity' => $cartProduct['quantity'],
                'product' => $products->first(function ($product) use ($cartProduct) {
                    return $product->id === $cartProduct['id'];
                }),
            ]);
        }

        return $list;
    }
}
