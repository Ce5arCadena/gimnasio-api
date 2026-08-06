<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Services\PlanService;
use App\Http\Requests\CreatePlanRequest;

class PlanController extends Controller
{
    public function __construct(
        private PlanService $planService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            return $this->planService->getPlans($request);
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Error al ejecutar la petición.',
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePlanRequest $createPlanRequest)
    {
        try {
            return $this->planService->createPlan($createPlanRequest);
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Error al ejecutar la petición.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
