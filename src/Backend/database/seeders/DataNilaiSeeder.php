<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataNilai;
use Illuminate\Support\Carbon;

class DataNilaiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nik' => '3201011234560001',
                'pretest_score' => 65,
                'posttest_score' => 85,
                'kategori' => 'Pelatihan Dasar',
                'tanggal' => Carbon::now()->subDays(5)->toDateString(),
            ],
            [
                'nik' => '3201011234560002',
                'pretest_score' => 70,
                'posttest_score' => 88,
                'kategori' => 'Pelatihan Lanjutan',
                'tanggal' => Carbon::now()->subDays(3)->toDateString(),
            ],
        ];

        foreach ($data as $item) {
            DataNilai::create($item);
        }
    }
}
