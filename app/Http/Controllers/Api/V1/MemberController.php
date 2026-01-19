<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\StoreMemberRequest;
use App\Http\Requests\Member\SubscribeMemberRequest;
use App\Models\Member;
use App\Models\Plan;
use App\Services\MemberService;
use App\Services\PlanService;
use App\Services\SubscriptionService;
use App\Traits\HandleResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    // Trait to handle response
    use HandleResponseTrait;

    public function __construct(
        private MemberService $memberService,
        private PlanService $planService,
        private SubscriptionService $subscriptionService
    ) {}

    public function store(StoreMemberRequest $request)
    {
        try {
            $plan = $this->planService->find($request->plan_id);
            // تسجيل عضو واسناده اليه خطة
            $member = $this->memberService->createWithSubscription(
                $request->validated(),
                $plan,
                $request->boolean('is_paid', true)
            );

            return $this->sendResponse($member, 'Member created successfully and subscribed', 201);
        } catch (\Exception $e) {
            return $this->sendError('Failed to create member', [$e->getMessage()], 500);
        }
    }



     /// اضافة اشتراك جديد للعضو
    public function subscribe(SubscribeMemberRequest $request, Member $member)
    {
        try {
            $plan = $this->planService->find($request->plan_id);
            $subscription = $this->subscriptionService->subscribe($member, $plan, $request->boolean('is_paid', true));
            return $this->sendResponse($subscription, 'Subscription created successfully', 201);
        } catch (\Exception $e) {
            return $this->sendError('Failed to subscribe member', [$e->getMessage()], 500);
        }
    }


}
