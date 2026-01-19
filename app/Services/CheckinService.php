<?php

namespace App\Services;

use App\Repositories\CheckinRepository;
use App\Models\Member;

class CheckinService
{
    public function __construct(private CheckinRepository $repo) {}

    public function checkin(Member $member)
    {
        return $this->repo->create($member->id);
    }
}
