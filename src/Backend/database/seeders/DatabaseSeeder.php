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
            'name' => 'AgelDeska',
            'role' => 'pegawai',
            'email' => 'prisz@sigma.com',
            'password' => Hash::make('Wisamulya23.')
        ]);
    }
}
