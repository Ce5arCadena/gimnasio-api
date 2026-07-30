<?php

namespace App\Services;

use App\Models\Gym;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\GymRepository;
use App\Repositories\UserRepository;
use App\Http\Requests\CreateGymRequest;

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
            'data' => Gym::all()
        ]);
    }
}
