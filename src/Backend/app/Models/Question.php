<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    // Table name (opsional jika nama tabel bukan "questions")
    protected $table = 'questions';

    // Kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'type',        // pretest / postest
        'question',    // isi soal
        'options',     // jawaban pilihan ganda dalam bentuk array
        'answer'       // jawaban yang benar
    ];

    protected $casts = [
        'options' => 'array',
    ];
}
