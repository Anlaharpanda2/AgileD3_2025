<?php

/**
 * Vercel / Laravel Bridge
 *
 * Ini adalah entry point untuk semua request. Tujuannya adalah memastikan
 * semua variabel server ($_SERVER) diatur dengan benar sebelum meneruskan
 * request ke entry point publik Laravel.
 */

// Menangani path routing Vercel
$_SERVER['DOCUMENT_ROOT'] = getcwd();
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';

// Memperbaiki REQUEST_URI dan PATH_INFO (paling penting untuk API)
if (isset($_SERVER['REQUEST_URI'])) {
    // Menghapus query string dari URI jika ada
    $requestUri = strtok($_SERVER['REQUEST_URI'], '?');
    $_SERVER['PATH_INFO'] = $requestUri;
} else {
    $_SERVER['PATH_INFO'] = '/';
}

// Teruskan request ke entry point publik Laravel
require __DIR__ . '/../public/index.php';