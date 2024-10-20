<?php

namespace App\UseCases\Cart;

use App\Enums\Product\Status;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class GetListAction
{
    public function __invoke(): Collection
    {
        if (Auth::guard('web')->check()) {
            $cartProductCollection = CartProduct::query()
                ->select(['product_id', 'count'])
                ->where('user_id', Auth::guard('web')->id())
                ->orderBy('created_at')
                ->get();
            $cartProducts = [];
            foreach ($cartProductCollection as $product) {
                $cartProducts[$product->product_id] = [
                    'id' => $product->product_id,
                    'count' => $product->count,
                ];
            }
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
            $list[$cartProduct['id']] = [
                'count' => $cartProduct['count'],
                'product' => $products->first(function ($product) use ($cartProduct) {
                    return $product->id === $cartProduct['id'];
                }),
            ];
        }

        return $list;
    }
}
