<?php

namespace App\Repositories;

use App\Models\Member;

class MemberRepository
{
    public function createMember(Array $fields) {
        return Member::create($fields);
    }

    public function getMembers(?string $search, $perPage = 15) {
        return Member::when($search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");    
                });
            })
            ->paginate($perPage);
    }

    public function getMembersTrashed(?string $search, $perPage = 15) {
        return Member::onlyTrashed()
            ->when($search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");    
                });
            })
            ->paginate($perPage);
    }

    public function updateMember(Array $fields, Member $member) {
        return $member->update($fields);
    }

    public function deleteMember(Member $member) {
        return $member->delete();
    }

    public function getMemberTrashed(int $idMember) {
        return Member::onlyTrashed()->where('id', $idMember)->first();
    }

    public function restoreMember(Member $member) {
        return $member->restore();
    }
}
