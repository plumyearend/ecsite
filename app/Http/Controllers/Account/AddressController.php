<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class AddressController extends Controller
{
    public function index()
    {
        // TODO: ログインユーザーの住所情報を取得
        return view('account.addresses.index');
    }

    public function create()
    {
        return view('account.addresses.create');
    }
}
