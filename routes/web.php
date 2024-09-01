<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:web')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('top');
});

Route::prefix('account')->name('account.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
        Route::get('/signup', [SignUpController::class, 'signup'])->name('signup');
        Route::post('/register', [SignUpController::class, 'register'])->name('register');
        Route::get('/activate/{token}', [SignUpController::class, 'activate'])
            ->whereAlphaNumeric('token')
            ->name('activate');
        Route::prefix('activate')->name('activate.')->group(function () {
            Route::post('/store', [SignUpController::class, 'store'])->name('store');
        });
    });
    Route::middleware('auth:web')->group(function () {
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('/addresses', [SignUpController::class, 'addresses'])->name('addresses');
    });
});
