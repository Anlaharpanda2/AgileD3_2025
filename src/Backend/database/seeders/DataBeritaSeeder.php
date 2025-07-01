<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DataBerita;
use Illuminate\Support\Str;

class DataBeritaSeeder extends Seeder
{
    public function run(): void
    {
        $jenisKontenList = ['berita', 'pengumuman'];

        for ($i = 1; $i <= 100; $i++) {
            DataBerita::create([
                'judul' => 'Judul ' . ucfirst($jenisKontenList[$i % 2]) . ' #' . $i,
                'isi' => 'Ini adalah isi dari ' . $jenisKontenList[$i % 2] . ' ke-' . $i . '. ' . Str::random(100),
                'jenis_konten' => $jenisKontenList[$i % 2],
                'foto' => 'berita/foto_dummy_' . $i . '.jpg',
            ]);
        }
    }
}
