<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_test',
        'nilai',
        'tanggal_test',
    ];

    /**
     * Relasi ke model User
     * Setiap test dimiliki oleh satu user (peserta)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
