<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\AddressController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\TopController;
use App\Http\Middleware\ExistsOrderAddress;
use App\Http\Middleware\VerifyOrderEncodedId;
use App\Livewire\Pages\Cart;
use App\Livewire\Pages\Checkouts\Information;
use App\Livewire\Pages\Products\Show;
use Filament\Actions\Exports\Http\Controllers\DownloadExport;
use Illuminate\Support\Facades\Route;

Route::get('/', [TopController::class, 'top'])->name('top');

Route::get('/products/{product}', Show::class)->name('products.show');
Route::get('/cart', Cart::class)->name('cart');

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
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::resource('/addresses', AddressController::class)
            ->except(['show', 'destroy']);
    });
});

Route::middleware(['auth:web', VerifyOrderEncodedId::class])->group(function () {
    Route::prefix('checkouts/{encodedId}')->name('checkouts.')->group(function () {
        Route::get('/information', Information::class)->name('information');
        Route::post('/information', [CheckoutController::class, 'saveAddress'])->name('information.save');
        Route::get('/payment', [CheckoutController::class, 'payment'])
            ->middleware([ExistsOrderAddress::class])
            ->name('payment');
    });
});

Route::middleware('guest')->prefix('auth')->name('auth.')->group(function () {
    Route::get('/github', [LoginController::class, 'githubRedirect'])->name('github');
    Route::get('/github/callback', [LoginController::class, 'githubCallback'])->name('github.callback');
});

Route::get('/filament/exports/{export}/download', DownloadExport::class)
    ->name('filament.exports.download')
    ->middleware(['web', 'auth:admin']);
