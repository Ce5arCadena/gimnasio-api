<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Services\MemberService;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Requests\UpdateMemberRequest;

class MemberController extends Controller
{
    public function __construct(
        private MemberService $memberService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            return $this->memberService->getMembers($request);
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Error al ejecutar la petición.',
            ], 500);
        }
    }

    public function getMembersTrashed(Request $request)
    {
        try {
            return $this->memberService->getMembersTrashed($request);
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
    public function store(CreateMemberRequest $request)
    {
        try {
            return $this->memberService->create($request);
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Error al ejecutar la petición.',
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        try {
            return $this->memberService->updateMember($request, $member);
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Error al ejecutar la petición.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Member $member)
    {
        try {
        return $this->memberService->deleteMember($member);
        } catch (\Throwable $th) {
            \Log::error($th);
            return response()->json([
                'status' => 'error',
                'message' => 'Error al ejecutar la petición.',
            ], 500);
        }
    }
}
