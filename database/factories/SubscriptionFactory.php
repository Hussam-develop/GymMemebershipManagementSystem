<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Subscription::class;

    public function definition()
    {
        $plan = Plan::inRandomOrder()->first() ?? Plan::factory()->create();
        $start = Carbon::now();
        $end = $start->copy()->addDays($plan->duration_in_days);
        return [
            'member_id' => Member::factory(),
            'plan_id' => $plan->id,
            'subscription_start_date' => $start,
            'subscription_end_date' => $end,
            'is_paid' => true,
            'status' => $this->faker->randomElement(['active', 'expired', 'pending']),
        ];
    }
}
