<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersMasyarakatSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users_masyarakat')->insert([
            'nama' => 'Siti Aminah',
            'nik' => '3276011201990001',
            'jenis_bimtek' => 'Keterampilan Menjahit',
            'kegiatan_dimulai' => '2025-06-01',
            'kegiatan_berakhir' => '2025-06-15',
            'tempat_kegiatan' => 'Balai Latihan Kerja Jakarta',
            'angkatan' => 12,
            'tempat_tanggal_lahir' => 'Bandung, 12 Januari 1990',
            'pendidikan' => 'SMA',
            'status' => 'lajang',
            'alamat' => 'Jl. Merdeka No. 10, Bandung',
            'jenis_usaha' => 'Menjahit pakaian wanita',
            'penghasilan_perbulan' => '2000000',
            'nomor_telefon' => '081234567890',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
