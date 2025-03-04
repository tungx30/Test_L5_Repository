<?php

namespace Packages\User;

use Illuminate\Support\Facades\Route;
use Packages\User\Http\Controllers\UserController;

class RouteRegistrar
{
    /**
     * Đăng ký tất cả các routes liên quan đến Auth.
     */
    public static function routes()
    {
        Route::prefix('user')->group(function () {
            Route::get('/test', [UserController::class, 'test']);
        });
    }
}
