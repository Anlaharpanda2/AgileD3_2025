<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class userSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'baru',
            'password' => Hash::make('12345678aS@'),
            'email' => 'test2@example.com',
        ]);
    }
}
