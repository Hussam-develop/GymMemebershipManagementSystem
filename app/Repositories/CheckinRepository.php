<?php

namespace App\Repositories;

use App\Models\Checkin;
use Illuminate\Support\Carbon;

class CheckinRepository
{
    public function create(int $memberId): Checkin
    {
        return Checkin::create([
            'member_id'     => $memberId,
            'checked_in_at' => Carbon::now(),
        ]);
    }
}
