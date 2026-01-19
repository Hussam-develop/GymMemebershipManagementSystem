<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       /*  User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */

        //first create plans
        //Then create 20 members with their subscriptions
        $this->call([
            PlanSeeder::class,
            MemberSeeder::class,
        ]);




        // أول شي أنشئ خطط
        // بعدين أنشئ 20 عضو مع اشتراكاتهم

    }
}
