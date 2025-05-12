<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class DaftarPendaftar extends Authenticatable
{
    // Tentukan nama tabel custom
    protected $table = 'daftar_pendaftar';

    // Kolom yang dapat diisi
    protected $fillable = ['peserta', 'nik'];

    // Kolom username yang digunakan untuk autentikasi
    public function getAuthIdentifierName()
    {
        return 'peserta';
    }

    // Kolom password yang digunakan untuk autentikasi
    public function getAuthPassword()
    {
        return $this->nik;
    }
}
