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
            DataPendaftaranSeeder::class,
            PengaduanSeeder::class,
            UserSeeder::class,
        ]);
    }
}