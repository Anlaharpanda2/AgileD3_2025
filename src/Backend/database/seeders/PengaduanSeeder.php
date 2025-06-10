<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaduanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pengaduans')->insert([
            [
                'nik' => '1234567890123456',
                'nama' => 'Budi Santoso',
                'jenis_kelamin' => 'Laki-laki',
                'umur' => 35,
                'alamat' => 'Jl. Merdeka No. 1',
                'no_hp' => '081234567890',
                'jenis_kasus' => 'KDRT',
                'kasus' => 'Kekerasan',
                'deskripsi_laporan' => 'Terjadi kekerasan dalam rumah tangga.',
                'waktu_kejadian' => '2025-06-01 08:00:00',
                'nama_korban' => 'Siti Aminah',
                'saksi' => 'Joko',
                'jenis_pengaduan' => 'langsung',
                'lampiran' => null,
                'status' => 'dikirim',
                'tanggapan' => null,
                'tanggal_pengaduan' => '2025-06-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nik' => '2345678901234567',
                'nama' => 'Siti Aminah',
                'jenis_kelamin' => 'Perempuan',
                'umur' => 28,
                'alamat' => 'Jl. Sudirman No. 2',
                'no_hp' => '082345678901',
                'jenis_kasus' => 'Penipuan',
                'kasus' => null,
                'deskripsi_laporan' => 'Menjadi korban penipuan online.',
                'waktu_kejadian' => '2025-06-02 10:30:00',
                'nama_korban' => null,
                'saksi' => 'Budi',
                'jenis_pengaduan' => 'tidak langsung',
                'lampiran' => null,
                'status' => 'diproses',
                'tanggapan' => null,
                'tanggal_pengaduan' => '2025-06-02',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}