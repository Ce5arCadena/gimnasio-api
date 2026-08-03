<?php

namespace App\Services;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Gym;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\GymRepository;
use App\Repositories\UserRepository;
use App\Http\Requests\CreateGymRequest;
use App\Http\Requests\UpdateGymRequest;
use Illuminate\Support\Facades\Storage;

class GymService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private GymRepository $gymRepository,
        private UserRepository $userRepository
    ){}

    public function getGyms(Request $request): JsonResponse {
        $gyms = $this->gymRepository->getGyms($request->search);

        return response()->json([
            "status" => "success",
            "data" => $gyms
        ]);
    }

    public function store(CreateGymRequest $request): JsonResponse {
        $fields = $request->validated();
        $rolAdminGym = Role::where('name', config('gym.rol_admin'))->firstOrFail();

        $pathImage = null;
        if (isset($fields["photo"])) {
            $pathImage = $fields["photo"]->store('gyms', 'public');
        }

        DB::transaction(function() use($fields, $rolAdminGym, $pathImage) {
            $gymFields = [
                "name" => $fields["name"],
                "address" => $fields["address"],
                "photo" => $pathImage,
                "owner_name" => $fields["owner_name"]
            ];
            $newGym = $this->gymRepository->createGym($gymFields);
    
            $userFields = [
                "name" => $fields["name"],
                "email" => $fields["email"],
                "password" => $fields["password"],
                "gym_id" => $newGym->id,
                "role_id" => $rolAdminGym->id
            ];
            $this->userRepository->createUser($userFields);
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Gym creado éxitosamente',
            'data' => $this->gymRepository->getGyms(null)
        ]);
    }

    public function update(UpdateGymRequest $request, Gym $gym): JsonResponse {
        $fields = $request->validated();

        if (isset($fields["photo"])) {
            if (isset($gym->photo)) {
                Storage::disk('public')->delete($gym->photo);
            }

            $fields["photo"] = $request->file("photo")->store('gyms', 'public');
        }

        $gym->update($fields);
        return response()->json([
            'status' => 'success',
            'message' => 'Gym actualizado éxitosamente',
            'data' => $this->gymRepository->getGyms(null)
        ]);
    }

    public function destroy(Gym $gym): JsonResponse {
        $rolAdmin = Role::where('name', config('gym.rol_admin'))->first();

        DB::transaction(function() use ($gym, $rolAdmin){
            $this->gymRepository->deleteGym($gym);
            $userAdminGym = $gym->users()->where('role_id', $rolAdmin->id)->first();
            $this->userRepository->deleteUser($userAdminGym);
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Gym eliminado éxitosamente',
            'data' => $this->gymRepository->getGyms(null)
        ]);
    }

    public function updateState(Request $request): JsonResponse {
        if (!$request->route('id')) {
            return response()->json([
                'status' => 'error',
                'message' => 'El recurso solicitado no existe.',
            ], 404);
        }

        $gymId = $request->route('id');
        $gymTrashed = $this->gymRepository->getGymTrashed($gymId);
        if (!$gymTrashed) {
            return response()->json([
                'status' => 'error',
                'message' => 'El recurso solicitado no existe.',
            ], 404);
        }

        $userTrashed = $this->userRepository->getUserGymTrashed($gymTrashed->id);
        if (!$userTrashed) {
            return response()->json([
                'status' => 'error',
                'message' => 'El recurso solicitado no existe.',
            ], 404);
        }

        DB::transaction(function() use ($gymTrashed, $userTrashed) {
            $this->gymRepository->restoreGym($gymTrashed);
            $this->userRepository->restoreUserGym($userTrashed);
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Gym restaurado éxitosamente',
            'data' => $this->gymRepository->getGyms(null)
        ]);
    }
}
