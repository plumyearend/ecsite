<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login\AuthenticateRequest;
use App\UseCases\Cart\CollectCartToSessionAction;
use App\UseCases\Cart\CollectCartToTableAction;
use App\UseCases\Login\LoginAction;
use App\UseCases\Login\LogoutAction;
use App\UseCases\Login\SocialLoginAction;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function login()
    {
        return view('account.login');
    }

    public function authenticate(
        AuthenticateRequest $request,
        LoginAction $loginAction,
        CollectCartToTableAction $collectCartToTableAction,
    ) {
        $input = $request->only(['email', 'password']);
        if (!$loginAction($input['email'], $input['password'])) {
            session()->flash('login_error', trans('auth.failed'));

            return redirect()->route('account.login');
        }

        $collectCartToTableAction();

        return redirect()->route('top');
    }

    public function logout(
        LogoutAction $logoutAction,
        CollectCartToSessionAction $collectCartToSessionAction,
    ) {
        $userId = Auth::guard('web')->id();
        $logoutAction();
        $collectCartToSessionAction($userId);

        return redirect()->route('top');
    }

    public function githubRedirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback(
        SocialLoginAction $socialLoginAction,
        CollectCartToTableAction $collectCartToTableAction,
    ) {
        $socialiteUser = Socialite::driver('github')->user();
        $socialLoginAction($socialiteUser);
        $collectCartToTableAction();

        return redirect()->route('top');
    }
}
