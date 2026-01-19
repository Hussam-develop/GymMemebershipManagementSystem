<?php

namespace App\Http\Middleware;

use App\Models\Member;
use App\Traits\HandleResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveSubscription
{
    use HandleResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    public function handle($request, Closure $next): Response
    {
        $member = Member::with('activeSubscription')->findOrFail($request->member_id);
        $subscription = $member->activeSubscription;
        if (! $subscription || $subscription->isExpired() || ! $subscription->is_paid) {
            return $this->sendError('Member subscription is not active or not paid.',[],403);
        }
        $request->merge(['member' => $member]);
        return $next($request);
    }


}
