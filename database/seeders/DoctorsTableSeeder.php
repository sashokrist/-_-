<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('doctors')->insert([
            [
                'id' => 1,
                'business_id' => 1,
                'name' => 'д-р Иванов',
                'specialty' => 'Очен',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'business_id' => 1,
                'name' => 'д-р Петрова',
                'specialty' => 'Кардиолог',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'business_id' => 1,
                'name' => 'д-р Антонова',
                'specialty' => 'Педиатър',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
