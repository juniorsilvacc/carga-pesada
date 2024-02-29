<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionUserController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/api/v1/login/access-token', [AuthController::class, 'login'])->name('auth.login');
Route::post('/api/v1/login/check-token', [AuthController::class, 'checkToken'])->name('auth.check-token')->middleware('auth:sanctum');
Route::post('/api/v1/login/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->prefix('api/v1/')->group(function () {
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

    // Travels
    Route::delete('/travels/{id}', [TravelController::class, 'destroy'])->name('travels.destroy');
    Route::put('/travels/{id}', [TravelController::class, 'update'])->name('travels.update');
    Route::post('/travels', [TravelController::class, 'store'])->name('travels.store');
    Route::get('/travels/{id}', [TravelController::class, 'show'])->name('travels.show');
    Route::get('/travels', [TravelController::class, 'index'])->name('travels.index');

    // Notes
    Route::delete('/notes/{id}', [NoteController::class, 'destroy'])->name('notes.destroy');
    Route::put('/notes/{id}', [NoteController::class, 'update'])->name('notes.update');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/{id}', [NoteController::class, 'show'])->name('notes.show');
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');

    // Contacts
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::put('/contacts/{id}', [ContactController::class, 'update'])->name('contacts.update');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('contacts.show');
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
});
