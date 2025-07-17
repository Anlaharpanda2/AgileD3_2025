<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log; // Tambahkan ini di atas

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Log::info('AppServiceProvider: register() method started.'); // Log ini
        // ... kode yang sudah ada ...
        Log::info('AppServiceProvider: register() method finished.'); // Log ini
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Log::info('AppServiceProvider: boot() method started.'); // Log ini

        // Coba akses database sederhana di sini
        try {
            // Hanya lakukan ini jika Anda yakin tabel 'users' ada
            $userCount = \App\Models\User::count();
            Log::info('Database check: Found ' . $userCount . ' users.');
        } catch (\Exception $e) {
            Log::error('Database connection or query failed in boot(): ' . $e->getMessage());
        }

        // ... kode yang sudah ada ...
        Log::info('AppServiceProvider: boot() method finished.'); // Log ini
    }
}