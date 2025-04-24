<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class daftar extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = ['nik', 'nama'];
}
