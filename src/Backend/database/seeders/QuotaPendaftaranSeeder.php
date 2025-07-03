<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuotaPendaftaran;

class QuotaPendaftaranSeeder extends Seeder
{
    public function run()
    {
        QuotaPendaftaran::create([
            'status' => true,
            'quota' => 50,
        ]);
    }
}
