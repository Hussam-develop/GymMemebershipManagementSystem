<?php


namespace App\Services;

use App\Enums\StatusEnum;
use App\Repositories\MemberRepository;
use App\Models\Member;
use App\Models\Plan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MemberService
{
    public function __construct(private MemberRepository $repo) {}

    // 1) إنشاء العضو

    public function create(array $data): Member
    {
        return $this->repo->create($data);
    }


    public function createWithSubscription(array $memberData, Plan $plan, bool $isPaid = true)
    {
        return DB::transaction(function () use ($memberData, $plan, $isPaid) {
            
            // 1) إنشاء العضو
            $member = Member::create($memberData);
            // 2) إنشاء الاشتراك
            $start = Carbon::now();
            $end = $start->copy()->addDays($plan->duration_in_days);
            $member->subscriptions()->create(['plan_id' => $plan->id, 'subscription_start_date' => $start, 'subscription_end_date' => $end, 'is_paid' => $isPaid, 'status' => $isPaid ? StatusEnum::Active : StatusEnum::Pending,]);
            return $member;
        });
    }



    public function find(int $id): Member
    {
        return $this->repo->find($id);
    }
}
