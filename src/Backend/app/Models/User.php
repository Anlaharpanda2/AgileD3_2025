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
    protected $fillable = ['name', 'password', 'role'];
    public function getAuthIdentifierName()
    {
        return 'name';
    }
    public function getAuthPassword()
    {
        return $this->password;
    }
}
