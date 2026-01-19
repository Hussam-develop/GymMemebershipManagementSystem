<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

         Member::factory()->count(20)->create()->each(function ($member) {
            $plan = Plan::inRandomOrder()->first();
            Subscription::factory()->create(['member_id' => $member->id, 'plan_id' => $plan->id,]);
        });
    }
}
