<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Repositories\SubscriptionRepository;
use App\Models\Member;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    public function __construct(private SubscriptionRepository $subscriptionRepository) {}


    public function subscribe(Member $member, Plan $plan, bool $isPaid = true)
    {
        return DB::transaction(function () use ($member, $plan, $isPaid) {
            $start = Carbon::now();
            $end = $start->copy()->addDays($plan->duration_in_days);
            $subscription = $member->subscriptions()->create(['plan_id' => $plan->id, 'subscription_start_date' => $start, 'subscription_end_date' => $end, 'is_paid' => $isPaid, 'status' => $isPaid ? StatusEnum::Active : StatusEnum::Pending,]);
            return $subscription;
        });
    }

    public function getExpired()
    {
        return $this->subscriptionRepository->getExpired();
    }

    public function markExpired($subscription): void
    {
        $this->subscriptionRepository->markExpired($subscription);
    }

    public function getExpiringSoon(int $days = 3)
    {
        return $this->subscriptionRepository->getExpiringSoon($days);
    }
}
