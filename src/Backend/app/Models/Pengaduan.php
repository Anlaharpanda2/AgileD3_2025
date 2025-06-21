<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduans'; // opsional, jika nama model tidak sesuai konvensi
    protected $primaryKey = 'id_pengaduan';

    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'umur',
        'alamat',
        'no_hp',
        'jenis_kasus',
        'kasus',
        'deskripsi_laporan',
        'waktu_kejadian',
        'nama_korban',
        'saksi',
        'jenis_pengaduan',
        'lampiran',
        'status',
        'tanggapan',
        'tanggal_pengaduan',
    ];

}