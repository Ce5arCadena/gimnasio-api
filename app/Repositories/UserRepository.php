<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function createUser(Array $fields) {
        return User::create($fields); 
    }

    public function deleteUser(User $user) {
        return $user->delete();
    }

    public function updateProfile(User $user, Array $fields) {
        return $user->update($fields);
    }

    public function getUserGymTrashed(int $gymId) {
        return User::onlyTrashed()->where('gym_id', $gymId)->first();
    }

    public function restoreUserGym(User $user) {
        return $user->restore();
    }
}
