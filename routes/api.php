<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GymController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PlanController;

// Rutas de autenticación
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->prefix('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

// Rutas de super admin
Route::middleware(['auth:api', 'role:SUPER_ADMIN'])->group(function () {
    Route::get('/gyms', [GymController::class, 'index']);
    Route::get('/gyms/trashed', [GymController::class, 'getGymsTrashed']);
    Route::patch('/gyms/{id}/restore', [GymController::class, 'updateState']);
    Route::post('/gyms/create', [GymController::class, 'store']);
    Route::patch('/gyms/{gym}', [GymController::class, 'update']);
    Route::delete('/gyms/{gym}', [GymController::class, 'destroy']);
});

// Actualiza el perfil del gym, ya sea el ADMIN o SUPERADMIN
Route::middleware(['auth:api'])->group(function() {
    Route::patch('/profile', [UserController::class, 'updateProfile']);
});

// Rutas de miembros
Route::middleware(['auth:api', 'role:ADMIN'])->prefix('members')->group(function() {
    Route::get('/', [MemberController::class, 'index']);
    Route::get('/trashed', [MemberController::class, 'getMembersTrashed']);
    Route::patch('/{id}/restore', [MemberController::class, 'restoreMember']);
    Route::post('/create', [MemberController::class, 'store']);
    Route::patch('/update/{member}', [MemberController::class, 'update']);
    Route::delete('/delete/{member}', [MemberController::class, 'delete']);
});

// Rutas de plan
Route::middleware(['auth:api', 'role:ADMIN'])->prefix('plans')->group(function() {
    Route::get('/', [PlanController::class, 'index']);
    Route::post('/', [PlanController::class, 'store']);
    Route::patch('/update/{plan}', [PlanController::class, 'update']);
});