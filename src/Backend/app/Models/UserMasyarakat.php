<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserMasyarakat extends Authenticatable
{
    use HasFactory;

    protected $table = 'users_masyarakat'; // karena datanya masih disimpan di tabel yang sama

    protected $fillable = [
        'nama',
        'nik',
    ];

    /**
     * Override untuk menentukan field autentikasi utama.
     */
    public function getAuthIdentifierName()
    {
        return 'nama';
    }

    /**
     * Override untuk mengambil password (dalam hal ini, nik digunakan sebagai "password").
     */
    public function getAuthPassword()
    {
        return $this->nik;
    }
}
