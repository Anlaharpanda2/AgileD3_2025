<?php

// Direktori /tmp adalah satu-satunya tempat yang bisa kita tulis di Vercel
$storagePath = '/tmp/storage';
$configCachePath = $storagePath . '/bootstrap/cache/config.php';
$routesCachePath = $storagePath . '/bootstrap/cache/routes.php';

// Buat direktori yang diperlukan jika belum ada
// (mode 0777 dan rekursif diperlukan di lingkungan serverless)
if (!is_dir(dirname($configCachePath))) {
    mkdir(dirname($configCachePath), 0777, true);
}

// Bootstrap aplikasi Laravel untuk mengakses fungsionalitasnya
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

// Arahkan Laravel untuk menggunakan direktori /tmp untuk semua file storage & cache
$app->useStoragePath($storagePath);

// Cek dan buat cache jika tidak ada.
// Ini hanya akan berjalan pada request pertama ke sebuah instance lambda.
if (!file_exists($configCachePath)) {
    // Menjalankan 'config:cache' melalui object Kernel
    $app->make(Illuminate\Contracts\Console\Kernel::class)->call('config:cache');
}
if (!file_exists($routesCachePath)) {
    // Menjalankan 'route:cache' melalui object Kernel
    $app->make(Illuminate\Contracts\Console\Kernel::class)->call('route:cache');
}

// Perbaiki path request dari Vercel agar bisa dibaca oleh Router
if (isset($_SERVER['REQUEST_URI'])) {
    $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
}

// Teruskan request ke kernel HTTP Laravel untuk diproses
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);