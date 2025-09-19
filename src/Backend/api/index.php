<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

// 
// INI BAGIAN PENTINGNYA!
// Memperbaiki path request dari Vercel agar bisa dibaca oleh Router Laravel.
//
if (isset($_SERVER['REQUEST_URI'])) {
    $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
}

// Baris ini akan memanggil file index.php utama milik Laravel
// yang ada di dalam folder public.
require __DIR__ . '/../public/index.php';