<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('doctors')->insert([
            [
                'name' => 'д-р Иванов',
                'specialty' => 'Очен',
            ],
            [
                'name' => 'д-р Петрова',
                'specialty' => 'Кардиолог',
            ],
            [
                'name' => 'д-р Антонова',
                'specialty' => 'Педиатър',
            ],
        ]);
    }
}
