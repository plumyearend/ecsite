<?php

namespace App\UseCases\Checkout;

use App\Models\Order;
use App\Models\OrderAddress;

class SaveOrderAddressAction
{
    public function __invoke(string $encodedId, array $input): OrderAddress
    {
        $orderAddress = OrderAddress::updateOrCreate(
            [
                'order_id' => Order::decodeId($encodedId),
            ],
            [
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'postcode' => $input['postcode'],
                'prefecture_id' => $input['prefecture_id'],
                'address1' => $input['address1'],
                'address2' => $input['address2'],
                'address3' => $input['address3'],
                'tel' => $input['tel'],
            ]
        );

        return $orderAddress;
    }
}
