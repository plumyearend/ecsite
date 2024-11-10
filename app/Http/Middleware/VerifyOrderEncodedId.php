<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyOrderEncodedId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            abort(404);
        }

        $orderId = Order::decodeId($request->route('encodedId'));
        $exists = Order::query()
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->exists();
        if (!$exists) {
            abort(404);
        }

        return $next($request);
    }
}
