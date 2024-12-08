<?php

namespace App\UseCases\Checkout;

use App\Enums\Order\Status as OrderStatus;
use App\Enums\Payment\Method;
use App\Enums\Payment\Status;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;

class FixPurchaseAction
{
    public function __invoke(Order $order, string $stripeIntentId, string $stripeMethodId): ?Payment
    {
        $payment = Payment::create([
            'order_id' => $order->id,
            'status' => Status::PAY_COMPLETION,
            'method' => Method::CREDIT_CARD,
            'stripe_intent_id' => $stripeIntentId,
            'stripe_method_id' => $stripeMethodId,
        ]);

        $order->status = OrderStatus::DELIVERY_PENDING;
        $order->save();

        foreach ($order->orderDetails as $orderDetail) {
            $product = Product::find($orderDetail->product_id);
            if ($product->count < $orderDetail->count) {
                return null;
            }
            $product->decrement('count', $orderDetail->count);
        }

        return $payment;
    }
}
