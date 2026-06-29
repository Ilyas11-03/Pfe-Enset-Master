<?php

namespace Database\Factories;

use App\Models\Gym;
use Illuminate\Database\Eloquent\Factories\Factory;

class GymFactory extends Factory
{
    protected $model = Gym::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'domain' => $this->faker->unique()->domainName(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'region' => $this->faker->state(),
            'phone' => $this->faker->phoneNumber(),
            'operating_hours' => '08:00-22:00',
            'image' => null,
            'status' => 'active',
        ];
    }
}
