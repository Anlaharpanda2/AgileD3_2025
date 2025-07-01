<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataLokasi;

class DataLokasiSeeder extends Seeder
{
    public function run()
    {
        DataLokasi::create([
            'nama_lokasi' => 'DP3AP2KB Sumatera Barat',
            'alamat' => 'P2JN Sumbar, 85A, Jalan Rasuna Said, Rimbo Kaluang, Padang, Sumatera Barat, Sumatra, 25129, Indonesia',
            'latitude' => '-0.9299254558472511',
            'longitude' => '100.36146053540192',
        ]);
    }
}
