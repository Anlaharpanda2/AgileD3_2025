<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StrukturPegawai;

class StrukturPegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'idPegawai' => 101,
                'nama' => 'Budi Santoso',
                'alamat' => 'Jl. Merdeka No. 10, Padang',
                'email' => 'budisantoso@gmail.com',
                'jabatan' => 'Kepala Dinas',
                'noHp' => '081234567890',
                'status' => 'aktif',
            ],
            [
                'idPegawai' => 102,
                'nama' => 'Siti Aminah',
                'alamat' => 'Jl. Pancasila No. 23, Bukittinggi',
                'email' => 'sitiaminah@gmail.com',
                'jabatan' => 'Sekretaris',
                'noHp' => '081234567891',
                'status' => 'aktif',
            ],
            [
                'idPegawai' => 103,
                'nama' => 'Andi Saputra',
                'alamat' => 'Jl. Sudirman No. 5, Solok',
                'email' => 'ndisaputra@gmail.com',
                'jabatan' => 'Kepala Bidang',
                'noHp' => '081234567892',
                'status' => 'cuti',
            ],
            [
                'idPegawai' => 104,
                'nama' => 'Lina Marlina',
                'alamat' => 'Jl. Ahmad Yani No. 8, Payakumbuh',
                'email' => 'linamarlina@gmail.com',
                'jabatan' => 'Staf',
                'noHp' => '081234567893',
                'status' => 'nonaktif',
            ],
        ];

        foreach ($data as $pegawai) {
            StrukturPegawai::create($pegawai);
        }
    }
}
