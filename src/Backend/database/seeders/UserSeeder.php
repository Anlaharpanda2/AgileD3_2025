<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user pertama
        User::factory()->create([
            'name' => 'anla harpanda',
            'username' => 'anla',
            'role' => 'operator',
            'email' => 'anlaharpanda@gmail.com',
            'password' => Hash::make('Aa12345!')
        ]);

        // Buat user kedua
        User::factory()->create([
            'name' => 'anla harpanda',
            'username' => 'aan',
            'role' => 'pegawai',
            'email' => 'anlaharpanda2@gmail.com',
            'password' => Hash::make('Aa12345!')
        ]);
    }
}
