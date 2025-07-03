<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CombinedScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_nik',
        'user_name',
        'pretest_score',
        'posttest_score',
    ];
}
