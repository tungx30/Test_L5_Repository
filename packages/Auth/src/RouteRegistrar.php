<?php

namespace Packages\Auth;

use Illuminate\Support\Facades\Route;
use Packages\Auth\Http\Controllers\AccountController;

class RouteRegistrar
{
    /**
     * Đăng ký tất cả các routes liên quan đến Auth.
     */
    public static function routes()
    {
        Route::prefix('account')->group(function () {
            Route::post('/login', [AccountController::class, 'login']);
            Route::post('/Register', [AccountController::class, 'register']);
            Route::middleware(['auth'])->group(function () {
                Route::post('/logout', [AccountController::class, 'logout']);
                Route::get('/profile', [AccountController::class, 'profile']);
                Route::put('/updatePass', [AccountController::class, 'updatePass']);
            });
        });
    }
}
