<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use HasApiTokens, Notifiable;
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'role', 'create_at', 'update_at'];
    public function getAuthIdentifierName()
    {
        return 'name';
    }
    public function getAuthPassword()
    {
        return $this->password;
    }
}
