<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PlanSeeder::class,
        ]);

        User::firstOrCreate(
            ['email' => 'admin@mygym.com'],
            [
                'gym_id' => null,
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'phone' => null,
                'address' => null,
                'role' => 'main_admin',
                'status' => 'active',
                'profile_image' => null,
                'created_by' => null,
                'updated_by' => null,
            ]
        );
    }
}
