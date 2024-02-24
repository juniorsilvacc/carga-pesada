<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->json(['message' => 'OK']));

Route::prefix('v1')->group(function () {
    // Users
    Route::get('/users', [UserController::class, 'index']);
});
