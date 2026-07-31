<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GymController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->prefix('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

Route::middleware(['auth:api', 'role:SUPER_ADMIN'])->group(function () {
    Route::get('/gyms', [GymController::class, 'index']);
    Route::post('/new-gym', [GymController::class, 'store']);
    Route::patch('/gyms/{gym}', [GymController::class, 'update']);
    Route::delete('/gyms/{gym}', [GymController::class, 'destroy']);
});
