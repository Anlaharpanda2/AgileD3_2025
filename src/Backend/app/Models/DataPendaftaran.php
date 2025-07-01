<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataPendaftaran extends Model
{

    protected $table = 'data_pendaftaran';

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
        'photo',
        'status_pendaftaran',
        'keterangan', 
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    
    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo) {
            return null;
        }

        return asset('storage/' . $this->photo);
    }
}
