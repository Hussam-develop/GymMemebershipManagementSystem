<?php

namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Models\Subscription;
use App\Models\Member;
use Carbon\Carbon;

class SubscriptionRepository
{
    public function create(Member $member, array $data): Subscription
    {
        return $member->subscriptions()->create($data);
    }

    public function getExpired()
    {
        return Subscription::whereDate('subscription_end_date', '<', now())
            ->where('status', '!=', StatusEnum::Expired)
            ->with('member')
            ->get();
    }

    public function getExpiringSoon(int $days = 3)
    {
        $now   = Carbon::now();
        $limit = $now->copy()->addDays($days);

        return Subscription::active()
            ->whereBetween('subscription_end_date', [$now, $limit])
            ->with('member')
            ->get();
    }

    public function markExpired(Subscription $subscription): void
    {
        $subscription->update(['status' => StatusEnum::Expired]);
        $subscription->member->update(['status' => StatusEnum::Expired]);
    }
}
