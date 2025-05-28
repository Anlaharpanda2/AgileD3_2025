<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPendaftar extends Authenticatable
{
    use HasFactory, SoftDeletes;
    protected $table = 'data_pendaftar';
    public function getAuthIdentifierName()
    {
        return 'nama';
    }
    protected $fillable = [
        'nama',
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
    protected $dates = [
        'tanggal_kegiatan',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    public function getAuthPassword()
    {
        return $this->nik;
    }
}