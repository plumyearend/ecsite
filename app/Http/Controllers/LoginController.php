<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login\AuthenticateRequest;
use App\UseCases\Login\LoginAction;
use App\UseCases\Login\LogoutAction;

class LoginController extends Controller
{
    public function login()
    {
        return view('account.login');
    }

    public function authenticate(AuthenticateRequest $request, LoginAction $action)
    {
        $input = $request->only(['email', 'password']);
        if (!$action($input['email'], $input['password'])) {
            session()->flash('login_error', trans('auth.failed'));
            return redirect()->route('account.login');
        }

        return redirect()->route('top');
    }

    public function logout(LogoutAction $logoutAction)
    {
        $logoutAction();

        return redirect()->route('account.login');
    }
}
