<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\VaniaController;
use App\Http\Controllers\PendaftaranBaru\PendaftaranBaruController;

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

Route::get('/vaniaroute', [VaniaController::class, 'index']);

Route::get('/pendaftaranbaru', [PendaftaranBaruController::class, 'index']);
Route::post('/pendaftaranbaru', [PendaftaranBaruController::class, 'store']);
Route::put('/pendaftaranbaru/{nik}', [PendaftaranBaruController::class, 'update']);
Route::delete('/pendaftaranbaru/{nik}', [PendaftaranBaruController::class, 'destroy']);
Route::get('/pendaftaranbaru/trash', [PendaftaranBaruController::class, 'trash']); // Lihat yang dihapus
Route::put('/pendaftaranbaru/restore/{nik}', [PendaftaranBaruController::class, 'restore']); // Pulihkan
Route::delete('/pendaftaranbaru/permanent/{nik}', [PendaftaranBaruController::class, 'forceDelete']);