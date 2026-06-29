<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\Gym;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    public function definition(): array
    {
        return [
            'member_id' => Member::factory(),
            'gym_id' => Gym::factory(),
            'check_in' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'check_out' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
