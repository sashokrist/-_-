<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Booking;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\DoctorsTableSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BusinessTypesTableSeeder::class,
            BusinessesTableSeeder::class,
            DoctorsTableSeeder::class,
            HairstylistsTableSeeder::class,
            TablesTableSeeder::class,
        ]);
    }
}
