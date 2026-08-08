<?php

namespace App\Repositories;

use App\Models\Plan;

class PlanRepository
{
    public function create(array $fields) {
        return Plan::create($fields);
    }

    public function getPlans(?string $search, int $perPage = 15) {
        return Plan::when($search, function($query, $search) {
            $query->where(function($q) use($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('duration_days', 'LIKE', "%{$search}%");
            });
        })
        ->paginate($perPage);
    }

    public function updatePlan(array $fields, Plan $plan) {
        return $plan->update($fields);
    }
}
