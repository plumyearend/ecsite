<?php

namespace App\Providers;

use App\View\Composers\CartComposer;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Authenticate::redirectUsing(function () {
            if (Route::is('admin.*')) {
                return route('admin.login');
            } else {
                return route('account.login');
            }
        });
        View::composer('components.header', CartComposer::class);
    }
}
