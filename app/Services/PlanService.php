<?php

namespace App\Services;

use App\Repositories\PlanRepository;
use App\Http\Requests\CreatePlanRequest;

class PlanService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private PlanRepository $planRepository
    ) {}

    public function createPlan(CreatePlanRequest $createPlanRequest) {
        $fields = $createPlanRequest->validated();

        $newPlan = $this->planRepository->create($fields);

        return response()->json([
            'status' => 'success',
            'message' => 'Plan creado',
            'data' => $newPlan
        ]);
    }
}
