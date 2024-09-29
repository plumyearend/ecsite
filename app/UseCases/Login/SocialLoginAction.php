<?php

namespace App\UseCases\Login;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialLoginAction
{
    public function __invoke($socialUser): User
    {
        $user = User::firstOrNew(['email' => $socialUser->email]);
        if (!$user->exists) {
            $user->password = Str::random(40);
        }
        $user->name = $socialUser->name ?? $socialUser->nickname;
        $user->github_id = $socialUser->id;
        $user->github_token = $socialUser->token;
        $user->github_refresh_token = $socialUser->refreshToken;
        $user->save();

        Auth::guard('web')->login($user);
        session()->regenerate();

        return $user;
    }
}
