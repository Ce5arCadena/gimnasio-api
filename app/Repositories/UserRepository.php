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
}
