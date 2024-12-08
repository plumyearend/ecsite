<?php

namespace App\Http\Middleware;

use App\Enums\Order\Status;
use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExistsOrderAddress
{
    public function handle(Request $request, Closure $next): Response
    {
        $orderId = Order::decodeId($request->route('encodedId'));
        $exists = Order::query()
            ->where('id', $orderId)
            ->where('status', Status::PAYMENT_WAITING)
            ->has('orderAddress')
            ->exists();
        if (!$exists) {
            abort(404);
        }

        return $next($request);
    }
}
