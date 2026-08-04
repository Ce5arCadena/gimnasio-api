<?php

namespace App\Repositories;

use App\Models\Member;

class MemberRepository
{
    public function createMember(Array $fields) {
        return Member::create($fields);
    }
}
