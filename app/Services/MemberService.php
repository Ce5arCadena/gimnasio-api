<?php

namespace App\Services;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\MemberRepository;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Requests\UpdateMemberRequest;

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

    public function updateMember(UpdateMemberRequest $request, Member $member) {
        $fields = $request->validated();

        $memberUpdated = $this->memberRepository->updateMember($fields, $member);
        return response()->json([
            'status' => 'success',
            'message' => 'Registro actualizado éxitosamente',
            'data' => $member
        ]);
    }
}
