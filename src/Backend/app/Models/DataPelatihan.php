<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPelatihan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_pelatihan';

    protected $fillable = [
        'nama',
        'nik',
        'jenis_bimtek',
        'kegiatan_dimulai',
        'kegiatan_berakhir',
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

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
