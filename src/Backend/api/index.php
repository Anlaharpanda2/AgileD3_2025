<?php

/**
 * Vercel / Laravel Bridge
 *
 * File ini hanya memiliki SATU tugas: memperbaiki path URL dari Vercel
 * sebelum meneruskannya ke Laravel.
 */

// Perbaiki REQUEST_URI menjadi PATH_INFO agar Router Laravel bisa membacanya.
if (isset($_SERVER['REQUEST_URI'])) {
    $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
}

// Teruskan request ke entry point publik Laravel yang sudah benar.
require __DIR__ . '/../public/index.php';