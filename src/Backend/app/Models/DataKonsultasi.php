<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataKonsultasi extends Model
{
    use SoftDeletes;

    protected $table = 'data_konsultasi';

    protected $fillable = [
        'nama_pelapor',
        'nama_korban',
        'deskripsi',
        'alamat',
        'waktu_kejadian',
        'kasus',
        'no_hp',
        'saksi',
        'status',
        'lampiran',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
