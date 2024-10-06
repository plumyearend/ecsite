<?php

namespace App\UseCases\Product;

use App\Enums\Product\Status;
use App\Models\Product;
use Illuminate\Support\Collection;

class GetListAction
{
    public function __invoke(): Collection
    {
        $products = Product::query()
            ->select([
                'id',
                'name',
                'price',
                'count_max',
                'count',
            ])
            ->where('status', Status::PUBLISHED)
            ->with('productImages', function ($query) {
                $query->select(['product_id', 'image']);
                $query->where('sort', 1);
            })
            ->orderBy('id')
            ->get();

        return $products;
    }
}
