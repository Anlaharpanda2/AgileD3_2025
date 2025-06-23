<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DataBeritaSeeder::class,
            DataFasilitasSeeder::class,
            DataKonsultasiSeeder::class,
            DataPelatihanSeeder::class,
            Masyarakat::class,
            StrukturPegawaiSeeder::class,
            DataNilaiSeeder::class,
            DataTestSeeder::class,
            UserSeeder::class,
            DataPengaduanSeeder::class,
            DataKonsultasiSeeder::class,
            DataPanitiaSeeder::class,
        ]);
    }
}