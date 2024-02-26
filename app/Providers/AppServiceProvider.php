<?php

namespace App\Providers;

use App\Repositories\Eloquent\PermissionRepository;
use App\Repositories\Eloquent\TruckRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\TruckRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class,
        );

        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class,
        );

        $this->app->bind(
            TruckRepositoryInterface::class,
            TruckRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
