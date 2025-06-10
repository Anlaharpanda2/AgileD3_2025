<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Auth\AuthMasyarakatController;
use App\Http\Controllers\Auth\AuthOperatorController;
use App\Http\Controllers\Auth\AuthPegawaiController;
use App\Http\Controllers\KelolaDataPelatihan\KelolaDataPelatihanController;
use App\Http\Controllers\KelolaDataPendaftaran\KelolaDataPendaftaranController;
use App\Http\Controllers\KelolaDataPelatihan\ImporPelatihanController;
use App\Http\Controllers\KelolaAkses\KelolaAksesController;


// api untuak login
Route::post('/login/masyarakat', [AuthMasyarakatController::class, 'login']);
Route::post('/login/pegawai', [AuthPegawaiController::class, 'login']);
Route::post('/login/operator', [AuthOperatorController::class, 'login']);
Route::post('/email/check', [AuthOperatorController::class, 'checkEmail']);
Route::post('/password/forgot', [AuthOperatorController::class, 'sendOtp']);
Route::post('/otp/confirm', [AuthOperatorController::class, 'confirmOtp']);
Route::post('/password/reset', [AuthOperatorController::class, 'resetPassword']);

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

//api untuk halaman kelola data Pendaftaran
Route::put('/kelola/Pendaftaran/restore', [KelolaDataPendaftaranController::class, 'restoreMassal']);
Route::delete('/kelola/Pendaftaran/permanent', [KelolaDataPendaftaranController::class, 'forceDeleteMassal']);
Route::get('/kelola/Pendaftaran', [KelolaDataPendaftaranController::class, 'index']);
Route::post('/kelola/Pendaftaran', [KelolaDataPendaftaranController::class, 'store']);
Route::put('/kelola/Pendaftaran/{nik}', [KelolaDataPendaftaranController::class, 'update']);
Route::get('/kelola/Pendaftaran/trash', [KelolaDataPendaftaranController::class, 'trash']);
Route::put('/kelola/Pendaftaran/restore/{nik}', [KelolaDataPendaftaranController::class, 'restore']);
Route::delete('/kelola/Pendaftaran/permanent/{nik}', [KelolaDataPendaftaranController::class, 'forceDelete']);
Route::delete('/kelola/Pendaftaran/{nik}', [KelolaDataPendaftaranController::class, 'destroy']);
Route::delete('/kelola/Pendaftaran', [KelolaDataPendaftaranController::class, 'destroyMassal']);
Route::post('kelola/Pendaftaran/impor', [KelolaDataPendaftaranController::class, 'impor']);

//api untuk kelola akses
Route::get('/kelola/akses',[KelolaAksesController::class,'index']);