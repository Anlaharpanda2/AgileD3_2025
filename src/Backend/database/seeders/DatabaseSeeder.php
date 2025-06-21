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
            DataPelatihanSeeder::class,
            Masyarakat::class,
            PengaduanSeeder::class,
            UserSeeder::class,
            StrukturPegawaiSeeder::class,
        ]);
    }
}