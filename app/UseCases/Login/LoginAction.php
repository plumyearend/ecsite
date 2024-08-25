<?php

namespace App\UseCases\Login;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginAction
{
    public function __invoke(string $email, string $password): ?User
    {
        $credentials = [
            'email' => $email,
            'password' => $password,
        ];

        if (Auth::guard('web')->attempt($credentials)) {
            session()->regenerate();

            return Auth::guard('web')->user();
        }

        return null;
    }
}
