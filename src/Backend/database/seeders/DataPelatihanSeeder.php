<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataPelatihan;
use Faker\Factory as Faker;

class DataPelatihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $jenisBimtekList = [
            'Bimtek PEP 2023 Sijunjung 1',
            'Bimtek PEP 2023 Agam 1',
            'Bimtek PEP 2023 Agam 3',
            'Bimtek PEP Agam 2',
            'Bimtek Peningkatan Ekonomi Perempuan Angkatan ke 2 Sijunjung',
        ];

        $pendidikanList = ['SD', 'SMP', 'SMA', 'Diploma III', 'Sarjana (S1)'];
        $statusList = ['kawin', 'lajang', 'janda'];
        $usahaList = ['Dagang', 'Petani', 'Ibu Rumah Tangga', 'Buruh Tani', 'Tenaga Pendidik PAUD', 'Belum Bekerja'];

        for ($i = 0; $i < 500; $i++) {
            DataPelatihan::create([
                'nama' => $faker->name,
                'nik' => $faker->numerify('################'),
                'jenis_bimtek' => $faker->randomElement($jenisBimtekList),
                'tanggal_kegiatan' => $faker->dateTimeBetween('2023-01-01', '2023-12-31')->format('Y-m-d'),
                'tempat_kegiatan' => $faker->city,
                'angkatan' => $faker->numberBetween(1, 5),
                'tempat_tanggal_lahir' => $faker->city . ', ' . $faker->date('Y-m-d'),
                'pendidikan' => $faker->randomElement($pendidikanList),
                'status' => $faker->randomElement($statusList),
                'alamat' => $faker->address,
                'jenis_usaha' => $faker->randomElement($usahaList),
                'penghasilan_perbulan' => 'Rp ' . number_format($faker->numberBetween(500_000, 10_000_000), 0, ',', '.'),
                'nomor_telefon' => $faker->e164PhoneNumber,
            ]);
        }
    }
}
