<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login\AuthenticateRequest;
use App\UseCases\Login\LoginAction;
use App\UseCases\Login\LogoutAction;
use App\UseCases\Login\SocialLoginAction;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function login()
    {
        return view('account.login');
    }

    public function authenticate(AuthenticateRequest $request, LoginAction $loginAction)
    {
        $input = $request->only(['email', 'password']);
        if (!$loginAction($input['email'], $input['password'])) {
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

    public function githubRedirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback(SocialLoginAction $socialLoginAction)
    {
        $socialiteUser = Socialite::driver('github')->user();
        $socialLoginAction($socialiteUser);

        return redirect()->route('top');
    }
}
