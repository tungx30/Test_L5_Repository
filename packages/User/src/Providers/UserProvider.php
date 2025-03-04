<?php
namespace Packages\User\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\User\Repositories\Contracts\UserRepository;
use Packages\User\Repositories\Eloquents\UserRepositoryEloquent;

class UserProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        // Load migrations nếu package có migrations riêng
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Bind interface với implementation
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
    }
}
