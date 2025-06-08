<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Auth\AuthMasyarakatController;
use App\Http\Controllers\Auth\AuthOperatorController;
use App\Http\Controllers\Auth\AuthPegawaiController;
use App\Http\Controllers\KelolaDataPelatihan\KelolaDataPelatihanController;
use App\Http\Controllers\KelolaDataPelatihan\ImporPelatihanController;
use App\Http\Controllers\KelolaBerita\KelolaDataBeritaController;

// api untuak login
Route::post('/login/masyarakat', [AuthMasyarakatController::class, 'login']);
Route::post('/login/operator', [AuthOperatorController::class, 'login']);
Route::post('/login/pegawai', [AuthPegawaiController::class, 'login']);
Route::post('/logout',function(Request $request){
    Auth::logout();
    return response()->json(['message' => 'Logout berhasil']);
});

//api untuk halaman kelola data pelatihan
Route::put('/kelola/pelatihan/restore', [KelolaDataPelatihanController::class, 'restoreMassal']);
Route::delete('/kelola/pelatihan/permanent', [KelolaDataPelatihanController::class, 'forceDeleteMassal']);
Route::get('/kelola/pelatihan', [KelolaDataPelatihanController::class, 'index']);
Route::post('/kelola/pelatihan', [KelolaDataPelatihanController::class, 'store']);
Route::put('/kelola/pelatihan/{nik}', [KelolaDataPelatihanController::class, 'update']);
Route::get('/kelola/pelatihan/trash', [KelolaDataPelatihanController::class, 'trash']);
Route::put('/kelola/pelatihan/restore/{nik}', [KelolaDataPelatihanController::class, 'restore']);
Route::delete('/kelola/pelatihan/permanent/{nik}', [KelolaDataPelatihanController::class, 'forceDelete']);
Route::delete('/kelola/pelatihan/{nik}', [KelolaDataPelatihanController::class, 'destroy']);
Route::delete('/kelola/pelatihan', [KelolaDataPelatihanController::class, 'destroyMassal']);
Route::post('kelola/pelatihan/impor', [ImporPelatihanController::class, 'impor']);

//api untuk halaman kelola data berita
Route::put('/kelola/berita/restore', [KelolaDataBeritaController::class, 'restoreMassal']);
Route::delete('/kelola/berita/permanent', [KelolaDataBeritaController::class, 'forceDeleteMassal']);
Route::get('/kelola/berita', [KelolaDataBeritaController::class, 'index']);
Route::post('/kelola/berita', [KelolaDataBeritaController::class, 'store']);
Route::put('/kelola/berita/{id}', [KelolaDataBeritaController::class, 'update']);
Route::get('/kelola/berita/trash', [KelolaDataBeritaController::class, 'trash']);
Route::put('/kelola/berita/restore/{id}', [KelolaDataBeritaController::class, 'restore']);
Route::delete('/kelola/berita/permanent/{id}', [KelolaDataBeritaController::class, 'forceDelete']);
Route::delete('/kelola/berita/{id}', [KelolaDataBeritaController::class, 'destroy']);
Route::delete('/kelola/berita', [KelolaDataBeritaController::class, 'destroyMassal']);