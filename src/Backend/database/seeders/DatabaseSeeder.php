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
            'name' => 'vania',
            'role' => 'pegawai',
            'email' => 'vania@gmail.com',
            'password' => Hash::make('vaniA12345!')
        ]);
    }
}
