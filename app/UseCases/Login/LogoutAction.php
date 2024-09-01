<?php

namespace App\UseCases\Login;

use Illuminate\Support\Facades\Auth;

class LogoutAction
{
    public function __invoke(): bool
    {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return true;
    }
}
