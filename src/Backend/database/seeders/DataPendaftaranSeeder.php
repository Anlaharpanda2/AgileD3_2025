<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataPendaftar;

class DataPendaftaranSeeder extends Seeder
{
    public function run(): void
    {
        $pendaftars = [
            [
                'nama' => 'Anla Harpanda',
                'nik' => '3276011204950001',
                'jenis_bimtek' => 'Manajemen Usaha',
                'tanggal_kegiatan' => '2025-07-01',
                'tempat_kegiatan' => 'Jakarta',
                'angkatan' => 1,
                'tempat_tanggal_lahir' => 'Bandung, 1995-04-12',
                'pendidikan' => 'S1 Ekonomi',
                'status' => 'lajang',
                'alamat' => 'Jl. Merdeka No. 10, Bandung',
                'jenis_usaha' => 'Kuliner',
                'penghasilan_perbulan' => '4000000',
                'nomor_telefon' => '081234567890',
            ],
            [
                'nama' => 'Siti Rahmawati',
                'nik' => '3403011003920002',
                'jenis_bimtek' => 'Digital Marketing',
                'tanggal_kegiatan' => '2025-07-10',
                'tempat_kegiatan' => 'Yogyakarta',
                'angkatan' => 2,
                'tempat_tanggal_lahir' => 'Yogyakarta, 1992-03-10',
                'pendidikan' => 'SMA',
                'status' => 'kawin',
                'alamat' => 'Jl. Malioboro No. 21, Yogyakarta',
                'jenis_usaha' => 'Fashion',
                'penghasilan_perbulan' => '6000000',
                'nomor_telefon' => '081298765432',
            ],
            [
                'nama' => 'Rina Dewi',
                'nik' => '3578012012900003',
                'jenis_bimtek' => 'Kewirausahaan',
                'tanggal_kegiatan' => '2025-08-05',
                'tempat_kegiatan' => 'Surabaya',
                'angkatan' => 3,
                'tempat_tanggal_lahir' => 'Surabaya, 1990-12-20',
                'pendidikan' => 'D3 Akuntansi',
                'status' => 'janda',
                'alamat' => 'Jl. Raya Darmo No. 15, Surabaya',
                'jenis_usaha' => 'Kerajinan',
                'penghasilan_perbulan' => '3000000',
                'nomor_telefon' => '081322334455',
            ],
            [
                'nama' => 'Ahmad Subekti',
                'nik' => '3374010707880004',
                'jenis_bimtek' => 'Keuangan Mikro',
                'tanggal_kegiatan' => '2025-08-15',
                'tempat_kegiatan' => 'Semarang',
                'angkatan' => 4,
                'tempat_tanggal_lahir' => 'Semarang, 1988-07-07',
                'pendidikan' => 'S1 Manajemen',
                'status' => 'kawin',
                'alamat' => 'Jl. Pandanaran No. 9, Semarang',
                'jenis_usaha' => 'Pertanian',
                'penghasilan_perbulan' => '4500000',
                'nomor_telefon' => '081366778899',
            ],
            [
                'nama' => 'Dewi Sartika',
                'nik' => '3276011406970005',
                'jenis_bimtek' => 'Teknologi UMKM',
                'tanggal_kegiatan' => '2025-09-01',
                'tempat_kegiatan' => 'Bandung',
                'angkatan' => 5,
                'tempat_tanggal_lahir' => 'Bandung, 1997-06-14',
                'pendidikan' => 'SMA',
                'status' => 'lajang',
                'alamat' => 'Jl. Soekarno Hatta No. 32, Bandung',
                'jenis_usaha' => 'Kecantikan',
                'penghasilan_perbulan' => '5000000',
                'nomor_telefon' => '081300011122',
            ],
        ];

        foreach ($pendaftars as $data) {
            DataPendaftar::create($data);
        }
    }
}
