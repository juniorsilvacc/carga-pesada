<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionUserController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/login/access-token', [AuthController::class, 'login'])->name('auth.login');
Route::post('/v1/login/check-token', [AuthController::class, 'checkToken'])->name('auth.check-token')->middleware('auth:sanctum');
Route::post('/v1/login/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    // Users
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Permissions
    Route::post('/users/{id}/permissions/sync', [PermissionUserController::class, 'syncPermissionUser'])->name('permissions.user.sync');
    Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    Route::put('/permissions/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{id}', [PermissionController::class, 'show'])->name('permissions.show');
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');

    // Trucks
    Route::delete('/trucks/{id}', [TruckController::class, 'destroy'])->name('trucks.destroy');
    Route::put('/trucks/{id}', [TruckController::class, 'update'])->name('trucks.update');
    Route::post('/trucks', [TruckController::class, 'store'])->name('trucks.store');
    Route::get('/trucks/{id}', [TruckController::class, 'show'])->name('trucks.show');
    Route::get('/trucks', [TruckController::class, 'index'])->name('trucks.index');

    // Drivers
    Route::post('/drivers', [DriverController::class, 'store'])->name('drivers.store');
    Route::get('/drivers/{id}', [DriverController::class, 'show'])->name('drivers.show');
    Route::get('/drivers', [DriverController::class, 'index'])->name('drivers.index');
});
