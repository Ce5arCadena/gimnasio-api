<?php

namespace App\Services;

use App\Repositories\PlanRepository;
use App\Http\Requests\CreatePlanRequest;
use Illuminate\Http\Request;

use function Laravel\Prompts\search;

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

    public function getPlans(Request $request) {
        $search = $request->search;

        $plans = $this->planRepository->getPlans($search);

        return response()->json([
            'status' => 'success',
            'message' => 'Lista de planes',
            'data' => $plans
        ]);
    }
}
