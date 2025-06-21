<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataKonsultasi extends Model
{
    use SoftDeletes;

    protected $table = 'konsultasi';

    protected $fillable = [
        'alamat',
        'deskripsi_data_konsultasi',
        'id_konsultasi', // Jika ini diperlukan
        'jenis_kelamin',
        'kasus',
        'nama',
        'nama_korban',
        'no_hp',
        'saksi',
        'status',
        'umur',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
