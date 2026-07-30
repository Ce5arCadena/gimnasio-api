<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function createUser(Array $fields) {
        return User::create($fields); 
    }
}
