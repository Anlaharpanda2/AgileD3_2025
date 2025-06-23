<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportKonsultasi extends Model
{
    use SoftDeletes;

    // Nama tabel sesuai struktur database
    protected $table = 'konsultasi';

    // Enable timestamps (created_at & updated_at)
    public $timestamps = true;

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'alamat',
        'deskripsi_data_konsultasi',
        'id_konsultasi',
        'jenis_kelamin',
        'kasus',
        'nama',
        'nama_korban',
        'no_hp',
        'saksi',
        'status',
        'umur',
    ];

    // Cast kolom tertentu ke format data yang sesuai
    protected $casts = [
        'id_konsultasi'          => 'integer',
        'no_hp'                  => 'integer',
        'umur'                   => 'integer',
        'status'                 => 'string', // adjust this if you want to use an enum cast
    ];
}
