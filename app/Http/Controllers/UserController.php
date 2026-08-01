<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\UpdateProfileRequest;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ){}

    public function updateProfile(UpdateProfileRequest $request) {
        try {
            return $this->userService->updateProfile($request);
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Error al ejecutar la petición.',
            ], 500);
        }
    }
}
