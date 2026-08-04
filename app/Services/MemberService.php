<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\MemberRepository;
use App\Http\Requests\CreateMemberRequest;

class MemberService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private MemberRepository $memberRepository
    ){}

    public function getMembers(Request $request) {
        $members = $this->memberRepository->getMembers($request->search);

        return response()->json([
            'status' => 'success',
            'message' => 'Lista de usuarios.',
            'data' => $members
        ]);
    }

    public function create(CreateMemberRequest $request): JsonResponse {
        $fields = $request->validated();

        $newMember = $this->memberRepository->createMember($fields);

        return response()->json([
            'status' => 'success',
            'message' => 'Registro creado éxitosamente.',
            'data' => $newMember
        ]);
    }
}
