<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\UseCases\Account\OrderHistory\GetOrdersAction;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    public function index(GetOrdersAction $getOrdersAction)
    {
        $orders = $getOrdersAction(Auth::guard('web')->id());
        $data = [
            'orders' => $orders,
        ];

        return view('account.order-history.index', $data);
    }
}
