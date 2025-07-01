<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataPendaftaran;
use App\Models\UserMasyarakat;
use Faker\Factory as Faker;

class DataPendaftaranSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 15; $i++) {
            $data = [
                'nik' => $faker->unique()->numerify('################'),
                'nama' => $faker->name,
                'photo' => null,
                'jenis_bimtek' => $faker->randomElement([
                    'Memasak', 'Menjahit', 'Tata Rias', 'Membuat Kue', 'Desain Grafis'
                ]),
                'tempat_tanggal_lahir' => $faker->city . ', ' . $faker->date('Y-m-d'),
                'pendidikan' => $faker->randomElement(['SD', 'SMP', 'SMA', 'Diploma III', 'Sarjana (S1)']),
                'status' => $faker->randomElement(['kawin', 'lajang', 'janda']),
                'alamat' => $faker->address,
                'jenis_usaha' => $faker->randomElement([
                    'Dagang', 'Petani', 'Ibu Rumah Tangga', 'Buruh Tani', 'Guru TK'
                ]),
                'penghasilan_perbulan' => 'Rp ' . number_format($faker->numberBetween(500000, 10000000), 0, ',', '.'),
                'nomor_telefon' => $faker->e164PhoneNumber,
                'status_pendaftaran' => 'Diproses',
                'keterangan' => 'Pendaftaran sedang diproses oleh panitia, silahkan menunggu sampai waktu yang ditentukan',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DataPendaftaran::create($data);
            UserMasyarakat::create($data);
        }
    }
}
