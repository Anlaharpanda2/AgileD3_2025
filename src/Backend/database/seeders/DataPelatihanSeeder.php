<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserMasyarakat;
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
            'Memasak',
            'Menjahit',
            'Tata Rias',
            'Membuat Kue',
            'Bordir',
            'Kecantikan',
            'E-Commerce',
            'Kerajinan',
            'Servis HP',
            'Desain Grafis',
        ];

        $pendidikanList = ['SD', 'SMP', 'SMA', 'Diploma III', 'Sarjana (S1)'];
        $statusList = ['kawin', 'lajang', 'janda'];
        $usahaList = ['Dagang', 'Petani', 'Ibu Rumah Tangga', 'Buruh Tani', 'Tenaga Pendidik PAUD', 'Belum Bekerja'];

        for ($i = 0; $i < 500; $i++) {
            $nik = $faker->numerify('################');

            $tanggalMulai = $faker->dateTimeBetween('2023-01-01', '2025-12-31');
            $tanggalBerakhir = $faker->dateTimeBetween($tanggalMulai, '2025-12-31');

            // Simpan ke tabel data_pelatihan
            DataPelatihan::create([
                'nama' => $faker->name,
                'nik' => $nik,
                'jenis_bimtek' => $faker->randomElement($jenisBimtekList),
                'kegiatan_dimulai' => $tanggalMulai->format('Y-m-d'),
                'kegiatan_berakhir' => $tanggalBerakhir->format('Y-m-d'),
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

            // Jika nik sudah ada di users_masyarakat, update 2 kolom
            $user = UserMasyarakat::where('nik', $nik)->first();
            if ($user) {
                $user->update([
                    'status_pendaftaran' => 'Diterima',
                    'keterangan' => 'Pendaftaran anda diterima, silahkan lihat tanggal kegiatan dimulai serta perhatikan informasi pada halaman berita dan pengumuman'
                ]);
            }
        }
    }
}
