<?php

namespace App\UseCases\Checkout;

use App\Enums\Order\Status;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CreateOrderAction
{
    // 送料
    private const SHIPPING_FEE = 1000;

    public function __invoke(Collection $cartItems, int $totalPrice)
    {
        $order = Order::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'status' => Status::PAYMENT_WAITING,
            ],
            [
                'shipping_fee' => self::SHIPPING_FEE,
                'total_price' => $totalPrice,
            ]
        );

        OrderDetail::query()
            ->where('order_id', $order->id)
            ->delete();
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'count' => $item['count'],
                'price_tax' => $item['product']->price * $item['count'],
            ]);
        }

        return $order;
    }
}
