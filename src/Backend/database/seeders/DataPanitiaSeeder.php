<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataPanitia;
use Faker\Factory as Faker;

class DataPanitiaSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(int $jumlah = 10): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < $jumlah; $i++) {
            DataPanitia::create([
                'email' => $faker->unique()->safeEmail,
                'jabatan' => $faker->randomElement(['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Anggota']),
                'nama_panitia' => $faker->name,
                'no_hp' => $faker->phoneNumber,
                'foto' => 'panitia/default.jpg', // path dummy di storage/app/public/panitia
            ]);
        }
    }
}
