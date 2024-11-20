<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(function () {
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/signin', [AuthController::class, 'signin']);
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('/user')->group(function () {
        Route::get('/me', [AuthenticatedSessionController::class, 'me']);
    });
});
