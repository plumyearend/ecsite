<?php

namespace App\UseCases\Checkout;

use App\Models\Order;

class GetOrderDetailsAction
{
    public function __invoke(Order $order)
    {
        $orderDetails = $order->orderDetails()
            ->select([
                'product_id',
                'count',
                'price_tax',
            ])
            ->with('product', function ($query) {
                $query->select([
                    'id',
                    'status',
                    'name',
                    'price',
                ]);
                $query->with('mainProductImage', function ($query) {
                    $query->select([
                        'product_id',
                        'image',
                    ]);
                });
            })
            ->orderBy('id')
            ->get();

        return $orderDetails;
    }
}
