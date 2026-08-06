<?php

namespace App\Repositories;

use App\Models\Plan;

class PlanRepository
{
    public function create(array $fields) {
        return Plan::create($fields);
    }
}
