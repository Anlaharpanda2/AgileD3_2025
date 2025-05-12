<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Model;
    
    class ImporPendaftar extends Model
    {
        // Menentukan nama tabel yang digunakan oleh model ini
        protected $table = 'daftar_pendaftar'; // Pastikan ini sesuai dengan nama tabel dalam database
    
        // Menonaktifkan fitur timestamps jika tabel tidak menggunakan created_at dan updated_at
        public $timestamps = false;
    
        // Menentukan kolom yang bisa diisi secara massal (mass assignment)
        protected $fillable = [
            'nik',
            'peserta',
            'tempat_tanggal_lahir',
            'jenis_kelamin',
            'alamat',
            'pendidikan',
            'pekerjaan',
            'email',
            'pelatihan',
            'tanggal_pelatihan',
            'tempat_pelatihan',
        ];
    
        protected $casts = [
            'tempat_tanggal_lahir' => 'date:Y-m-d',  // Cast ke format tanggal Y-m-d
            'tanggal_pelatihan' => 'date:Y-m-d',
        ];
    }