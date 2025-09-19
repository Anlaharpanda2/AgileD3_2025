<?php

// Tentukan path untuk file cache di direktori /tmp
$configCachePath = '/tmp/bootstrap/cache/config.php';
$routesCachePath = '/tmp/bootstrap/cache/routes.php';

// Jika cache tidak ada, ini berarti kita harus memuat file konfigurasi secara manual
// Ini adalah fallback untuk lingkungan serverless di mana build-time caching gagal.
if (!file_exists($configCachePath)) {
    // Trik ini "menipu" Laravel agar berpikir tidak ada cache dan harus memuat file config satu per satu
    define('LARAVEL_PRUNE_CONFIG', true);
}

// Perbaiki path request dari Vercel agar bisa dibaca oleh Router
if (isset($_SERVER['REQUEST_URI'])) {
    $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
}

// Teruskan request ke Laravel seperti biasa
require __DIR__ . '/../public/index.php';