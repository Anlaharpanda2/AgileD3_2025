<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataLokasi extends Model
{
    protected $table = 'data_lokasi';

    protected $fillable = [
        'nama_lokasi',
        'alamat',
        'latitude',
        'longitude'
    ];
}
