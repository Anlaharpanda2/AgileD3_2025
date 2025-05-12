<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory; 
    protected $table = 'users';
    
    // Kolom yang dapat diisi
    protected $fillable = ['name', 'password'];

    // Kolom username yang digunakan untuk autentikasi
    public function getAuthIdentifierName()
    {
        return 'name';
    }

    // Kolom password yang digunakan untuk autentikasi
    public function getAuthPassword()
    {
        return $this->password;
    }
}
