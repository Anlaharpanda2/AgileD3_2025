<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ImportPelatihan extends Model
{
    use SoftDeletes;

    // Nama tabel sesuai struktur database
    protected $table = 'data_pelatihan';

    // Enable timestamps (created_at & updated_at)
    public $timestamps = true;

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'nama',
        'nik',
        'jenis_bimtek',
        'tanggal_kegiatan',
        'tempat_kegiatan',
        'angkatan',
        'tempat_tanggal_lahir',
        'pendidikan',
        'status',
        'alamat',
        'jenis_usaha',
        'penghasilan_perbulan',
        'nomor_telefon',
    ];

    // Cast kolom tertentu ke format data yang sesuai
    protected $casts = [
        'tanggal_kegiatan'       => 'date:Y-m-d',
        'tempat_tanggal_lahir'   => 'string',
        'angkatan'               => 'integer',
    ];
}
