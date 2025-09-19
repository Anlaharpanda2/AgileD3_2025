<?php

// Tentukan path untuk cache di dalam direktori /tmp yang bisa ditulis oleh Vercel
$configCachePath = '/tmp/bootstrap/cache/config.php';
$routesCachePath = '/tmp/bootstrap/cache/routes.php';

// Hanya jalankan proses caching jika salah satu file cache tidak ada.
// Ini hanya akan berjalan pada request pertama ke sebuah instance lambda baru.
if (!file_exists($configCachePath) || !file_exists($routesCachePath)) {
    // 1. Bootstrap aplikasi Laravel. Ini akan membuat semua Facade tersedia.
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';

    // 2. Arahkan Laravel untuk menggunakan /tmp sebagai storage path-nya.
    // Ini memastikan cache ditulis di lokasi yang benar.
    $app->useStoragePath('/tmp/storage');

    // 3. Gunakan Artisan Facade untuk menjalankan perintah caching.
    // Ini adalah cara yang benar di Laravel 11.
    Illuminate\Support\Facades\Artisan::call('config:cache');
    Illuminate\Support\Facades\Artisan::call('route:cache');
}

// --- Setelah cache dipastikan ada, proses request seperti biasa ---

// Perbaiki path request Vercel untuk routing Laravel
if (isset($_SERVER['REQUEST_URI'])) {
    $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
}

// Teruskan request ke entry point publik utama Laravel
require __DIR__ . '/../public/index.php';