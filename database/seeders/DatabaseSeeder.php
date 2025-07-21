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

        $this->call([
            UserSeeder::class,
            TimeCapsuleSeeder::class,
        ]);

        $users = User::factory(25)->create();

        $capsules = TimeCapsule::factory(300)
            ->recycle($users) // reuses $users inside when `TimeCapsuleFactory` calls `User::factory()`
            ->hasAttached(User::factory()->recycle($users), [], 'favoritedByUsers') // Seeds `favorite_time_capsules` table with random $users
            ->create();
    }
}
