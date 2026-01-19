<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'created_at' => $this->created_at,
            // إضافة الاشتراك النشط
            'active_subscription' => $this->activeSubscription ? [
                'id' => $this->activeSubscription->id,
                'plan_id' => $this->activeSubscription->plan_id,
                'start_date' => $this->activeSubscription->subscription_start_date,
                'end_date' => $this->activeSubscription->subscription_end_date,
                'status' => $this->activeSubscription->status,
            ] : null,

        ];
    }
}
