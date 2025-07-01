<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserMasyarakat;
use App\Models\DataPendaftaran;
use Faker\Factory as Faker;

class UsersMasyarakat extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 15; $i++) {
            $data = [
                'nik' => $faker->unique()->numerify('################'),
                'nama' => $faker->name,
                'tempat_tanggal_lahir' => $faker->city . ', ' . $faker->date('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            UserMasyarakat::create($data);
        }
    }
}
