<?php

namespace App\UseCases\Checkout;

use App\Models\Order;

class GetOrderAction
{
    public function __invoke(string $encodedId)
    {
        return Order::find(Order::decodeId($encodedId));
    }
}
