<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:web')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

Route::prefix('account')->name('account.')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])
        ->name('login');
});
