<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private UserRepository $userRepository
    ){}

    public function updateProfile(UpdateProfileRequest $request) {
        $fields = $request->validated();

        $userAuth = Auth::user();
        if (!Hash::check($fields["current_password"], $userAuth->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'La contraseña actual es incorrecta.',
            ], 401);
        }

        unset($fields["current_password"]);
        $this->userRepository->updateProfile($userAuth, $fields);

        return response()->json([
            'status' => 'success',
            'message' => 'Perfil actualizado éxitosamente'
        ]);
    }
}
