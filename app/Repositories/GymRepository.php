<?php

namespace App\Repositories;

use App\Models\Gym;

class GymRepository
{
    public function createGym(Array $fields) {
        return Gym::create($fields);
    }

    public function getGyms(?string $search, int $perPage = 15) {
        return Gym::query()
            ->when($search, fn($query, $search) => $query->where('name', 'like', "%{$search}%"))
            ->paginate($perPage);
    }

    public function deleteGym(Gym $gym) {
        return $gym->delete();
    }

    public function getGymTrashed(int $gymId) {
        return Gym::onlyTrashed()->where('id', $gymId)->first();
    }

    public function restoreGym(Gym $gym) {
        return $gym->restore();
    }
}
