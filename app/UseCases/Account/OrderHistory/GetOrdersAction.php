<?php

namespace App\UseCases\Account\OrderHistory;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class GetOrdersAction
{
    public function __invoke(int $userId): Collection
    {
        $orders = Order::query()
            ->select([
                'id',
                'user_id',
                'total_price',
                'status',
                'created_at',
            ])
            ->with('orderDetails', function ($query) {
                $query->select([
                    'order_id',
                    'product_id',
                    'count',
                    'price_tax',
                ]);
                $query->with('product', function ($query) {
                    $query->select([
                        'id',
                        'name',
                        'price',
                    ]);
                    $query->with('mainProductImage', function ($query) {
                        $query->select([
                            'product_id',
                            'image',
                        ]);
                    });
                });
            })
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return $orders;
    }
}
