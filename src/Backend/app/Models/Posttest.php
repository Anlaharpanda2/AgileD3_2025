<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Posttest extends Model
{
    protected $fillable = [
        'title',
        'description',
        'is_active',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(PosttestQuestion::class);
    }
}
