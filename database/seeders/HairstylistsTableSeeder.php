<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HairstylistsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hairstylists')->insert([
            [
                'id' => 1,
                'business_id' => 3,
                'name' => 'Анна Петрова',
                'specialization' => 'Боядисване и стилизиране',
                'created_at' => Carbon::parse('2025-03-21 13:15:25'),
                'updated_at' => Carbon::parse('2025-03-21 15:12:11'),
            ],
            [
                'id' => 2,
                'business_id' => 3,
                'name' => 'Иван Стоянов',
                'specialization' => 'Подстригване и бради',
                'created_at' => Carbon::parse('2025-03-21 13:15:25'),
                'updated_at' => Carbon::parse('2025-03-21 15:12:18'),
            ],
            [
                'id' => 3,
                'business_id' => 3,
                'name' => 'Мила Николова',
                'specialization' => 'Мъжки прически',
                'created_at' => Carbon::parse('2025-03-21 13:15:25'),
                'updated_at' => Carbon::parse('2025-03-21 15:12:25'),
            ],
        ]);
    }
}
