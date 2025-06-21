<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fasilitas extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'idFasilitas';
    protected $table = 'fasilitas';
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'kategori',
        'lokasi',
        'jumlah',
        'status',
    ];

    protected $dates = ['deleted_at'];
}