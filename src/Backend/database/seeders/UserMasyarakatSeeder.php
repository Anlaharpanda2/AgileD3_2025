<?php

namespace Database\Seeders;

use App\Models\UserMasyarakat;
use Illuminate\Database\Seeder;

class UserMasyarakatSeeder extends Seeder
{
    public function run(): void
    {
        UserMasyarakat::create([
            'nama' => 'Demo',
            'nik' => '1234567890123456',
            'tempat_tanggal_lahir' => 'Padang, 1 Januari 1990',
            'jenis_bimtek' => null,
            'kegiatan_dimulai' => null,
            'kegiatan_berakhir' => null,
            'tempat_kegiatan' => null,
            'angkatan' => null,
            'pendidikan' => 'SMA',
            'status' => 'lajang',
            'alamat' => 'Jl. Demo No. 1',
            'jenis_usaha' => 'Kuliner',
            'penghasilan_perbulan' => '1.000.000 - 2.000.000',
            'nomor_telefon' => '081234567890',
            'status_pendaftaran' => 'diterima',
            'keterangan' => null,
        ]);
    }
}
