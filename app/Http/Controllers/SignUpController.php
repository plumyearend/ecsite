<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUp\RegisterRequest;
use App\UseCases\SignUp\RegisterAction;
use Exception;

class SignUpController extends Controller
{
    public function signup()
    {
        return view('account.signup');
    }

    public function register(RegisterRequest $request, RegisterAction $action)
    {
        $tmpRegistrationUser = $action($request->input('email'));
        if (!$tmpRegistrationUser) {
            throw new Exception('初回登録に失敗しました。');
        }

        return view('account.email-send-complete');
    }
}
