<?php

namespace Database\Seeders;

use App\Models\TimeCapsule;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();

        // Create some users with time capsules
        User::factory()
            ->count(20)
            ->has(TimeCapsule::factory()->count(10))
            ->create();
    }
}
