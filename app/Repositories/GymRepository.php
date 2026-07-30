<?php

namespace App\Repositories;

use App\Models\Gym;

class GymRepository
{
    public function createGym(Array $fields) {
        return Gym::create($fields);
    }


}
