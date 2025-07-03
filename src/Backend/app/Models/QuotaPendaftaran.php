<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotaPendaftaran extends Model
{
    
    protected $table = 'quota_pendaftaran';

    
    public $timestamps = false;

    
    protected $fillable = [
        'status',
        'quota',
    ];

    
    protected $casts = [
        'status' => 'boolean',
        'quota' => 'integer',
    ];
}