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
            DataLokasiSeeder::class,
            DataPanitiaSeeder::class,
            DataPelatihanSeeder::class,
            DataPendaftaranSeeder::class,
            DataPengaduanSeeder::class,
            DataTestSeeder::class,
            QuotaPendaftaranSeeder::class,
            StrukturPegawaiSeeder::class,
            UserSeeder::class,
            UserMasyarakatSeeder::class,
            UsersMasyarakat::class,
        ]);
    }
}