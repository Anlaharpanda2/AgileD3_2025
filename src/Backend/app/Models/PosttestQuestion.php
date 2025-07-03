<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PosttestQuestion extends Model
{
    protected $table = 'posttest_questions';

    protected $fillable = [
        'posttest_id',
        'question_text',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'order',
    ];

    public function posttest(): BelongsTo
    {
        return $this->belongsTo(Posttest::class);
    }
}
