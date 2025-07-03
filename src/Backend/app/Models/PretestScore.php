<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PretestScore extends Model
{
    protected $fillable = [
        'pretest_id',
        'user_nik',
        'user_name',
        'score',
        'total_questions',
        'submitted_at',
    ];

    public function pretest(): BelongsTo
    {
        return $this->belongsTo(Pretest::class);
    }
}
