<?php

use App\Http\Controllers\EksporPendaftarController;
use App\Http\Controllers\ImporPendaftarController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\NadyaController;


Route::get('/mahasiswa', [MahasiswaController::class, 'index']);

Route::get('/users', function () {
    return [
        ['id' => 1, 'name' => 'Frontend ketemu Backend! 🎉'],
        ['id' => 2, 'name' => 'Laravel + Vue sukses!'],
    ];
});

Route::get('/test', function () {
    return ['test' => 'oke'];
});

Route::get('/pendaftar', [NadyaController::class, 'index']);

// Rute untuk impor data pendaftar
Route::post('/pendaftar/impor', [ImporPendaftarController::class, 'impor']);


Route::get('/pendaftar/ekspor', [EksporPendaftarController::class, 'ekspor']);