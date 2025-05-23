<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class peserta extends Model
{
    protected $table = 'daftar_pendaftar'; // ← arahkan ke tabel yang sudah ada

    protected $fillable = [
        'nik',
        'peserta',
        'tempat_tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'pendidikan',
        'pekerjaan',
        'email',
        'pelatihan',
        'tanggal_pelatihan',
        'tempat_pelatihan',
    ];

    public $timestamps = true; // atau false jika tabel tidak punya kolom created_at & updated_at
}
