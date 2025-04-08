<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa'; // beri tahu Laravel nama tabel sebenarnya

    public $timestamps = false; // nonaktifkan created_at dan updated_at jika tidak ada di tabel
}
