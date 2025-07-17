<?php

namespace Database\Seeders;

use App\Models\TimeCapsule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeCapsuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimeCapsule::factory(50)->create();
    }
}
