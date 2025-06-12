<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserMasyarakat extends Authenticatable
{
    use HasFactory;
    protected $table = 'users_masyarakat'; 
    protected $fillable = [
        'nama',
        'nik',
        'tempat_tanggal_lahir',
    ];
    public function getAuthIdentifierName()
    {
        return 'nama';
    }
    public function getAuthPassword()
    {
        return $this->nik;
    }
}
