<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendaftarBaru extends Model
{
    use SoftDeletes;

    protected $table = 'pendaftar_baru';
    protected $primaryKey = 'nik';
    public $incrementing = false; // Karena nik bukan auto increment
    protected $keyType = 'string';

    protected $fillable = [
        'nik', 'peserta', 'tempat_tanggal_lahir', 'jenis_kelamin',
        'alamat', 'pendidikan', 'pekerjaan', 'email',
        'pelatihan', 'tanggal_pelatihan', 'tempat_pelatihan'
    ];
}
