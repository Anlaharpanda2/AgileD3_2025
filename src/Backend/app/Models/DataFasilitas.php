<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataFasilitas extends Model
{
    use SoftDeletes;
    protected $table = 'data_fasilitas';
    
    protected $fillable = [
        'nama_fasilitas',
        'deskripsi',
        'kategori',
        'jumlah',
        'status',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}