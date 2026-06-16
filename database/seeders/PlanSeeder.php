<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'name' => 'Basic',
            'description' => 'Basic plan description',
            'price' => 20.00,
            'discount_percentage' => 0,
            'user_limit' => 10,
        ]);

        Plan::create([
            'name' => 'Standard',
            'description' => 'Standard plan description',
            'price' => 25.00,
            'discount_percentage' => 5,
            'user_limit' => 20,
        ]);

        Plan::create([
            'name' => 'Premium',
            'description' => 'Premium plan description',
            'price' => 35.00,
            'discount_percentage' => 10,
            'user_limit' => 30,
        ]);
    }
}