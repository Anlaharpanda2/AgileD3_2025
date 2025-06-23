<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataPengaduan;
use Faker\Factory as Faker;

class DataPengaduanSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(int $total = 10): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < $total; $i++) {
            DataPengaduan::create([
                'nama_pelapor' => $faker->name(),
                'nama_korban' => $faker->name(),
                'deskripsi' => $faker->sentence(10),
                'alamat' => $faker->address(),
                'waktu_kejadian' => $faker->dateTimeBetween('-1 month', 'now'),
                'kasus' => $faker->randomElement(['KDRT', 'Pelecehan', 'Penelantaran']),
                'no_hp' => $faker->phoneNumber(),
                'saksi' => $faker->name(),
                'status' => $faker->randomElement(['diproses', 'selesai']),
                'lampiran' => 'lampiran/contoh' . $faker->numberBetween(1, 5) . '.jpg',
            ]);
        }
    }
}
