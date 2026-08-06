<?php

namespace App\Repositories;

use App\Models\Member;

class MemberRepository
{
    public function createMember(Array $fields) {
        return Member::create($fields);
    }

    public function getMembers(?string $search, $perPage = 15) {
        return Member::when($search, fn($query, $search) => $query->where('name', 'like', "%{$search}%")->orWhere('phone', 'like', "%{$search}%"))
            ->paginate($perPage);
    }

    public function updateMember(Array $fields, Member $member) {
        return $member->update($fields);
    }

    public function deleteMember(Member $member) {
        return $member->delete();
    }
}
