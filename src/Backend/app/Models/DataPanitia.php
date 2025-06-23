<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
class DataPanitia extends Model
{
    use SoftDeletes;
    protected $table = 'data_panitia';
    protected $fillable = [
        'email',
        'jabatan',
        'nama_panitia',
        'no_hp',
        'foto',
    ];
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    protected $appends = ['foto_url'];
    public function getFotoUrlAttribute()
    {
        return $this->foto ? Storage::disk('public')->url($this->foto) : null;
    }
}
