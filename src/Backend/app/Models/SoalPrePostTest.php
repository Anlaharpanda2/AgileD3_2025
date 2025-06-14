<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoalPrePostTest extends Model
{
    use HasFactory;

    protected $table = 'soal_pre_post_tests';

    protected $fillable = [
        'jenis',
        'pertanyaan',
        'pilihan',
        'jawaban_benar',
    ];

    // Cast kolom pilihan ke array saat diakses
    protected $casts = [
        'pilihan' => 'array',
    ];
}
