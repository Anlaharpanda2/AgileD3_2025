<?php

// Tentukan path untuk file cache di direktori /tmp yang bisa ditulis
$configCachePath = '/tmp/config.php';
$routesCachePath = '/tmp/routes.php';

// Jika file cache konfigurasi atau rute tidak ada, buat sekarang
if (!file_exists($configCachePath) || !file_exists($routesCachePath)) {
    // Bootstrap aplikasi Laravel secara manual untuk mengakses Artisan
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    // Jalankan perintah cache
    // Ini akan membaca Environment Variables dari Vercel dan membuat cache
    $kernel->call('config:cache');
    $kernel->call('route:cache');
}

// Perbaiki path request dari Vercel agar bisa dibaca oleh Router
if (isset($_SERVER['REQUEST_URI'])) {
    $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
}

// Setelah cache dibuat (atau sudah ada), teruskan request ke Laravel
require __DIR__ . '/../public/index.php';