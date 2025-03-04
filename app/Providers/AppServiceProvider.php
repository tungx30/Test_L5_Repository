<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\Permission\Providers\PermissionServiceProvider;
use Packages\Auth\Providers\AuthServiceProvider;
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

    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
