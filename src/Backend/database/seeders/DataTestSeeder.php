<?php

namespace Database\Seeders;

use App\Models\DataTest;
use Illuminate\Database\Seeder;

class DataTestSeeder extends Seeder
{
    public function run(): void
    {
        $kelompokPretest = 'Pretest-1';
        $kelompokPosttest = 'Posttest-1';

        // Seeder untuk pretest
        for ($i = 1; $i <= 5; $i++) {
            DataTest::create([
                'soal' => "Apa jawaban dari soal pretest ke-$i?",
                'tipe' => 'pretest',
                'opsi_a' => 'Jawaban A',
                'opsi_b' => 'Jawaban B',
                'opsi_c' => 'Jawaban C',
                'opsi_d' => 'Jawaban D',
                'jawaban_benar' => 'a',
                'kategori' => 'Dasar',
                'nomor_soal' => $i,
                'kelompok_soal' => $kelompokPretest,
            ]);
        }

        // Seeder untuk posttest
        for ($i = 1; $i <= 5; $i++) {
            DataTest::create([
                'soal' => "Apa jawaban dari soal posttest ke-$i?",
                'tipe' => 'posttest',
                'opsi_a' => 'Jawaban A',
                'opsi_b' => 'Jawaban B',
                'opsi_c' => 'Jawaban C',
                'opsi_d' => 'Jawaban D',
                'jawaban_benar' => 'b',
                'kategori' => 'Lanjutan',
                'nomor_soal' => $i,
                'kelompok_soal' => $kelompokPosttest,
            ]);
        }
    }
}
