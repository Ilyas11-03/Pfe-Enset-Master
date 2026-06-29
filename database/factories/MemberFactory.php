<?php

namespace Database\Factories;

use App\Models\Gym;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'gym_id' => Gym::factory(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'status' => 'active',
            'join_date' => $this->faker->date(),
            'profile_image' => null,
            'created_by' => null,
            'updated_by' => null,
        ];
    }
}
