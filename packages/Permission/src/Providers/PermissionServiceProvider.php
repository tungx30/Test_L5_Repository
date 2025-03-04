<?php

namespace Packages\Permission\Providers;

use Packages\Permission\Repositories\Contracts\PermissionRepository;
use Packages\Permission\Repositories\Eloquents\PermissionRepositoryEloquent;
use Illuminate\Support\ServiceProvider;
use Packages\Permission\Repositories\Contracts\RoleRepository;
use Packages\Permission\Repositories\Eloquents\RoleRepositoryEloquent;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../../config/permissions.php', 'permissions');
        // dd(__DIR__ . '/../../config/permissions.php', file_exists(__DIR__ . '/../../config/permissions.php'));

        $this->app->bind(PermissionRepository::class, PermissionRepositoryEloquent::class);
        $this->app->bind(RoleRepository::class, RoleRepositoryEloquent::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {

    }
}
