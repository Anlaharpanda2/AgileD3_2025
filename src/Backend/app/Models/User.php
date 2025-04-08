<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // opsional: jika tidak pakai timestamps, tambahkan ini
    public $timestamps = false;
    
    protected $fillable = ['name', 'email'];
}
