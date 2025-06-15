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
        'jenis_bimtek',
        'kegiatan_dimulai',
        'kegiatan_berakhir',
        'tempat_kegiatan',
        'angkatan',
        'tempat_tanggal_lahir',
        'pendidikan',
        'status',
        'alamat',
        'jenis_usaha',
        'penghasilan_perbulan',
        'nomor_telefon',
        'photo',
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    
    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo) {
            return null;
        }

        return asset('storage/' . $this->photo);
    }
    public function getAuthIdentifierName()
    {
        return 'nama';
    }
    public function getAuthPassword()
    {
        return $this->nik;
    }
}
