<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    // Nama tabel yang digunakan
    protected $table = 'daftar_pendaftar';

    // Nonaktifkan timestamps jika tabel tidak punya created_at/updated_at
    public $timestamps = false;
}
