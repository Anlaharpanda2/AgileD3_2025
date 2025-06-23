<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataTest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_tests';

    protected $fillable = [
        'soal',             
        'tipe',             
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'jawaban_benar',
        'kategori',         
        'nomor_soal',       
        'kelompok_soal',    
    ];

    protected $dates = ['deleted_at'];
}
