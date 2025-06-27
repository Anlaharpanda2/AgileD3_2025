<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataPengaduan extends Model
{
    use SoftDeletes;

    protected $table = 'data_pengaduan';

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
    
    protected $appends = ['lampiran_url'];

    public function getLampiranUrlAttribute()
    {
        if (!$this->lampiran) return null;
        return asset('storage/' . $this->lampiran);
    }
}
