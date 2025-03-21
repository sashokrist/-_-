<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BusinessesTableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::parse('2025-03-21 12:07:33');

        DB::table('businesses')->insert([
            [
                'id' => 1,
                'name' => 'City Medical Center',
                'business_type_id' => 1, // Doctor
                'user_id' => 1,
                'location' => 'Downtown',
                'phone' => '123-456-7890',
                'email' => 'info@citymed.com',
                'description' => 'Welcome to City Medical Center, your best choice for healthcare.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'name' => 'The Fancy Restaurant',
                'business_type_id' => 2, // Restaurant
                'user_id' => 1,
                'location' => 'Main Street',
                'phone' => '555-789-1234',
                'email' => 'contact@fancyrest.com',
                'description' => 'Welcome to The Fancy Restaurant, your best choice for dining.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Modern Hair Studio',
                'business_type_id' => 3, // Hair Salon
                'user_id' => 1,
                'location' => 'Market Square',
                'phone' => '987-654-3210',
                'email' => 'hello@modernhair.com',
                'description' => 'Welcome to Modern Hair Studio, your best choice for hair styling.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
