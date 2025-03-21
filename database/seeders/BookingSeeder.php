<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert 10 fake booking records
        for ($i = 0; $i < 10; $i++) {
            DB::table('bookings')->insert([
                'date_time' => Carbon::now()->addDays(rand(1, 30))->format('Y-m-d H:i:s'),
                'client_name' => 'Client ' . ($i + 1),
                'personal_id' => Str::random(10), // Random 10-character personal ID
                'description' => $i % 2 == 0 ? 'Consultation meeting' : 'Follow-up appointment',
                'notification_method' => $i % 2 == 0 ? 'SMS' : 'Email',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}