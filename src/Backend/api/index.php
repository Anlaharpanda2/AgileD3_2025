<?php

// Tentukan path untuk cache di dalam direktori /tmp yang bisa ditulis oleh Vercel
$configCachePath = '/tmp/bootstrap/cache/config.php';
$routesCachePath = '/tmp/bootstrap/cache/routes.php';

// Hanya jalankan proses caching jika salah satu file cache tidak ada.
if (!file_exists($configCachePath) || !file_exists($routesCachePath)) {
    // 1. Bootstrap aplikasi Laravel
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';

    // 2. Arahkan Laravel untuk menggunakan /tmp sebagai storage path-nya.
    $app->useStoragePath('/tmp/storage');
    
    // 3. Minta service Console Kernel dari aplikasi. 
    //    Meskipun filenya tidak ada, service-nya ada di dalam memori Laravel.
    //    Ini adalah cara yang benar dan akan berhasil.
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

    // 4. Jalankan perintah cache melalui instance Kernel.
    $kernel->call('config:cache');
    $kernel->call('route:cache');
}

// --- Setelah cache dipastikan ada, proses request HTTP seperti biasa ---

// Perbaiki path request Vercel untuk routing Laravel
if (isset($_SERVER['REQUEST_URI'])) {
    $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
}

// Teruskan request ke entry point publik utama Laravel
require __DIR__ . '/../public/index.php';