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
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
    Route::get('/signup', [SignUpController::class, 'signup'])->name('signup');
    Route::post('/register', [SignUpController::class, 'register'])->name('register');
    // TODO: メール認証時のページを作成
    // Route::get('/activate/{token}')
});
