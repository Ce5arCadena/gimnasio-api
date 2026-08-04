<?php

namespace App\Services;

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

    public function create(CreateMemberRequest $request): JsonResponse {
        $fields = $request->validated();

        $newMember = $this->memberRepository->createMember($fields);

        return response()->json([
            'status' => 'success',
            'message' => 'Registro creado éxitosamente.'
        ]);
    }
}
