<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataBerita extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'beritas';

    protected $fillable = [
        'judul',
        'isi',
        'jenis_konten',
        'foto',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Example relationship (if needed)
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // Example scope (if needed)
    // public function scopePublished($query)
    // {
    //     return $query->whereNotNull('published_at');
    // }
}
