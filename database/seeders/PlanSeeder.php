<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $plans = [
            ['name' => 'Monthly',     'price' => 50,  'duration_in_days' => 30],
            ['name' => 'Quarterly',   'price' => 130, 'duration_in_days' => 90],
            ['name' => 'Yearly',      'price' => 400, 'duration_in_days' => 365],
            ['name' => 'Weekly',      'price' => 20,  'duration_in_days' => 7],
            ['name' => 'Semi-Annual', 'price' => 220, 'duration_in_days' => 180],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
