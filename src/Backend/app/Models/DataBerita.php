<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage; 
class DataBerita extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'data_berita';
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
    /**
     * Get the URL for the news photo.
     *
     * @return string|null
     */
    public function getFotoAttribute($value)
    {
        $path = public_path('storage/' . $value);

        if ($value && file_exists($path)) {
            return asset('storage/' . $value);
        }

        return null;
    }

}