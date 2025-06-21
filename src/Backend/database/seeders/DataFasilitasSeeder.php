<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fasilitas;


class DataFasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Ruang Serbaguna',
                'deskripsi' => 'Ruang untuk pelatihan dan rapat umum.',
                'kategori' => 'Gedung',
                'lokasi' => 'Lantai 2, Gedung A',
                'jumlah' => 1,
                'status' => 'aktif',
            ],
            [
                'nama' => 'Proyektor LCD',
                'deskripsi' => 'Digunakan untuk presentasi pelatihan.',
                'kategori' => 'Peralatan',
                'lokasi' => 'Ruang Pelatihan 1',
                'jumlah' => 2,
                'status' => 'aktif',
            ],
            [
                'nama' => 'Komputer',
                'deskripsi' => 'Unit komputer untuk peserta pelatihan.',
                'kategori' => 'Elektronik',
                'lokasi' => 'Lab Komputer',
                'jumlah' => 10,
                'status' => 'aktif',
            ],
            [
                'nama' => 'Printer Laser',
                'deskripsi' => 'Untuk mencetak dokumen pelatihan.',
                'kategori' => 'Peralatan',
                'lokasi' => 'Admin Room',
                'jumlah' => 1,
                'status' => 'nonaktif',
            ],
        ];

        foreach ($data as $item) {
            Fasilitas::create($item);
        }
    }
}