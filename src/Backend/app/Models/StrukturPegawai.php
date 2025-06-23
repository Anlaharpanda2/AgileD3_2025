<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StrukturPegawai extends Model
{
    use SoftDeletes;

    protected $table = 'struktur_pegawais';

    protected $fillable = [
        'idPegawai',
        'nama',
        'alamat',
        'email',
        'jabatan',
        'noHp',
        'status',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
