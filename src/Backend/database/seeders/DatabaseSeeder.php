<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'nadya',
            'role' => 'pegawai',
            'email' => 'wanita@gmail.com',
            'password' => Hash::make('Nad12345!')
        ]);
    }
}
