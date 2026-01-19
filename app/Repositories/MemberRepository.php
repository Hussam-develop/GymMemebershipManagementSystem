<?php

namespace App\Repositories;

use App\Models\Member;

class MemberRepository
{
    public function create(array $data): Member
    {
        return Member::create($data);
    }

    public function find(int $id): Member
    {
        //get user with currunt subscription
        return Member::with('activeSubscription')->findOrFail($id);
    }
}
