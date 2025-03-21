<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tables')->insert([
            [
                'id' => 1,
                'business_id' => 2,
                'number' => 1,
                'seats' => 4,
                'created_at' => '2025-03-21 13:17:41',
                'updated_at' => '2025-03-21 15:13:00',
            ],
            [
                'id' => 2,
                'business_id' => 2,
                'number' => 2,
                'seats' => 2,
                'created_at' => '2025-03-21 13:17:41',
                'updated_at' => '2025-03-21 15:13:09',
            ],
            [
                'id' => 3,
                'business_id' => 2,
                'number' => 3,
                'seats' => 6,
                'created_at' => '2025-03-21 13:17:41',
                'updated_at' => '2025-03-21 15:13:16',
            ],
            [
                'id' => 4,
                'business_id' => 2,
                'number' => 1,
                'seats' => 2,
                'created_at' => '2025-03-21 13:17:41',
                'updated_at' => '2025-03-21 15:13:24',
            ],
            [
                'id' => 5,
                'business_id' => 2,
                'number' => 2,
                'seats' => 4,
                'created_at' => '2025-03-21 13:17:41',
                'updated_at' => '2025-03-21 15:13:33',
            ],
        ]);
    }
}
