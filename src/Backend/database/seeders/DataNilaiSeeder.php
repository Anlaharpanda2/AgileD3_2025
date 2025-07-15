<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataNilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('combined_scores')->insert([
            [
                'user_nik' => '1234567890123456',
                'user_name' => 'Anla Harpanda',
                'pretest_score' => 78,
                'posttest_score' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_nik' => '9876543210987654',
                'user_name' => 'Ewan Putra',
                'pretest_score' => 65,
                'posttest_score' => 85,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_nik' => '1928374655647382',
                'user_name' => 'Rina Sari',
                'pretest_score' => 80,
                'posttest_score' => 88,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
