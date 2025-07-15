<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Operator
        User::factory()->create([
            'name' => 'Operator',
            'username' => 'operator',
            'role' => 'operator',
            'email' => 'operator@example.com',
            'password' => Hash::make('Aa12345!')
        ]);

        // Akun Pegawai
        User::factory()->create([
            'name' => 'Pegawai',
            'username' => 'pegawai',
            'role' => 'pegawai',
            'email' => 'pegawai@example.com',
            'password' => Hash::make('Aa12345!')
        ]);
    }
}
