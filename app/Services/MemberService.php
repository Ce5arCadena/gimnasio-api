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

    public function getMembersTrashed(Request $request) {
        $members = $this->memberRepository->getMembersTrashed($request->search);

        return response()->json([
            'status' => 'success',
            'message' => 'Lista de usuarios eliminados.',
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

        $this->memberRepository->updateMember($fields, $member);
        return response()->json([
            'status' => 'success',
            'message' => 'Registro actualizado éxitosamente',
            'data' => $member
        ]);
    }

    public function deleteMember(Member $member) {
        $this->memberRepository->deleteMember($member);

        return response()->json([
            'status' => 'success',
            'message' => 'Registro eliminado éxitosamente'
        ]);
    }

    public function restoreMember(Request $request) {
        $idMember = $request->route('id');

        $memberRestore = $this->memberRepository->getMemberTrashed($idMember);
        if (!$memberRestore) {
            return response()->json([
                'status' => 'error',
                'message' => 'Recurso no encontrado'
            ], 404);
        }
        $this->memberRepository->restoreMember($memberRestore);

        return response()->json([
            'status' => 'success',
            'message' => 'Registro restaurado éxitosamente',
            'data' => $memberRestore
        ]);
    }
}
