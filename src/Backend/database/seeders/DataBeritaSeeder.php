<?php

namespace Database\Seeders;

use App\Models\DataBerita;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DataBeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Storage::disk('public')->exists('berita')) {
            Storage::disk('public')->makeDirectory('berita');
        }

        $beritas = [
            [
                'judul' => 'Pembukaan Pelatihan Kewirausahaan Digital Angkatan 1 Tahun 2025',
                'isi' => 'Dinas Koperasi dan UKM mengadakan pembukaan pelatihan kewirausahaan digital angkatan pertama tahun 2025...',
                'jenis_konten' => 'Pelatihan',
                'foto' => 'berita/berita1.jpg',
            ],
            [
                'judul' => 'Workshop Digital Marketing untuk UMKM: Strategi Pemasaran di Era Digital',
                'isi' => 'Dalam rangka mendukung transformasi digital UMKM, Dinas Koperasi dan UKM menyelenggarakan workshop...',
                'jenis_konten' => 'Workshop',
                'foto' => 'berita/berita2.png',
            ],
            [
                'judul' => 'Peluncuran Program Bantuan Modal Usaha untuk UMKM Tahun 2025',
                'isi' => 'Pemerintah melalui Dinas Koperasi dan UKM meluncurkan program bantuan modal usaha untuk UMKM...',
                'jenis_konten' => 'Bantuan',
                'foto' => 'berita/berita3.jpg',
            ],
        ];

        foreach ($beritas as $index => $beritaData) {
            DataBerita::create(array_merge($beritaData, [
                'created_at' => now()->subDays(10 - $index),
                'updated_at' => now()->subDays(10 - $index),
            ]));
        }

        $this->command->info('Data berita berhasil di-seed!');
    }
}