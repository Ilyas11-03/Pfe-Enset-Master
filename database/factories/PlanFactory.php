<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'discount_percentage' => $this->faker->optional()->randomFloat(2, 0, 50),
            'user_limit' => $this->faker->numberBetween(10, 1000),
            'member_limit' => $this->faker->optional()->numberBetween(10, 500),
        ];
    }
}