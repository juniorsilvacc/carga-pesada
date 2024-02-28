<?php

namespace App\Providers;

use App\Repositories\DriverRepositoryInterface;
use App\Repositories\Eloquent\DriverRepository;
use App\Repositories\Eloquent\NoteRepository;
use App\Repositories\Eloquent\PermissionRepository;
use App\Repositories\Eloquent\TravelRepository;
use App\Repositories\Eloquent\TruckRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\NoteRepositoryInterface;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\TravelRepositoryInterface;
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

        $this->app->bind(
            DriverRepositoryInterface::class,
            DriverRepository::class,
        );

        $this->app->bind(
            TravelRepositoryInterface::class,
            TravelRepository::class,
        );

        $this->app->bind(
            NoteRepositoryInterface::class,
            NoteRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
