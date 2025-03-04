<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\Permission\Providers\PermissionServiceProvider;
use Packages\Auth\Providers\AuthServiceProvider;
use Packages\User\Providers\UserProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // Đăng ký thủ công provider của bạn:
        $this->app->register(PermissionServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(UserProvider::class);
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
