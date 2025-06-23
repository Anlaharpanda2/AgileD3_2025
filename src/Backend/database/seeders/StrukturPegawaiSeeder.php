<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StrukturPegawai;
use Faker\Factory as Faker;

class StrukturPegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $i) {
            StrukturPegawai::create([
                'idPegawai' => 'PGW' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'nama' => $faker->name,
                'alamat' => $faker->address,
                'email' => $faker->unique()->safeEmail,
                'jabatan' => $faker->randomElement(['Kepala Dinas', 'Sekretaris', 'Staf', 'Bendahara']),
                'noHp' => $faker->phoneNumber,
                'status' => $faker->randomElement(['aktif', 'nonaktif']),
            ]);
        }
    }
}
