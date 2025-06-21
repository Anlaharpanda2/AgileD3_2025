<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataKonsultasi; // Make sure to create this model
use Faker\Factory as Faker;

class DataKonsultasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $kasusList = [
            'Kekerasan dalam rumah tangga',
            'Kekerasan Seksual',
            'Perundungan (Bullying)',
            'Kekerasan Pada Anak',
            'Eksploitasi Anak',
        ];

        $saksiList = [
            'Tetangga',
            'Keluarga',
            'Teman',
            'Dokter',
            'Psikolog',
        ];

        $statusList = [
            'pending',
            'selesai',
            'ditolak',
        ];

        for ($i = 0; $i < 500; $i++) {
            DataKonsultasi::create([
                'alamat' => $faker->address,
                'deskripsi_data_konsultasi' => $faker->text(200),
                'id_konsultasi' => $i + 1, // Assuming this is a sequential id
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'kasus' => $faker->randomElement($kasusList),
                'nama' => $faker->name,
                'nama_korban' => $faker->name,
                'no_hp' => $faker->numerify('##########'), // Assuming no_hp is an int
                'saksi' => $faker->randomElement($saksiList),
                'status' => $faker->randomElement($statusList),
                'umur' => $faker->numberBetween(18, 65),
            ]);
        }
    }
}
