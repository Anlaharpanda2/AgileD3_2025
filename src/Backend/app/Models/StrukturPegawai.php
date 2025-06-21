<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StrukturPegawai extends Model
{
    use SoftDeletes;

    protected $table = 'struktur_pegawais'; // nama tabel sesuai aslinya
    protected $primaryKey = 'idPegawai';    // sesuai ERD
    public $incrementing = false;           // karena idPegawai bukan auto-increment
    protected $keyType = 'int';

    protected $fillable = [
        'idPegawai',
        'nama',
        'alamat',
        'email',
        'jabatan',
        'noHp',
        'status',
    ];
}
