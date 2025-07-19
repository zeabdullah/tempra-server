<?php

namespace Database\Seeders;

use App\Models\TimeCapsule;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(20)->create();

        $capsules = TimeCapsule::factory(100)
            ->recycle($users) // this reuses $users inside `UserFactory` when it calls `User::Factory()`
            ->hasAttached(User::factory()->recycle($users), [], 'favoritedByUsers')
            ->create();
    }
}
