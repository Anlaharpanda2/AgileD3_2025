<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataNilai extends Model
{
    use HasFactory;

    protected $table = 'data_nilai';

    protected $fillable = [
        'nik',
        'pretest_score',
        'posttest_score',
        'kategori',
        'tanggal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }
}
