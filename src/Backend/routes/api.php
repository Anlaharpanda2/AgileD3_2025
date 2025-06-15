<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Auth\AuthMasyarakatController;
use App\Http\Controllers\Auth\AuthOperatorController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\AuthPegawaiController;
use App\Http\Controllers\KelolaDataPelatihan\KelolaDataPelatihanController;
use App\Http\Controllers\KelolaDataPendaftaran\KelolaDataPendaftaranController;
use App\Http\Controllers\KelolaDataPelatihan\ImporPelatihanController;
use App\Http\Controllers\KelolaPesan\PesanController;
use App\Http\Controllers\KelolaPretestPostest\PrePostController;
use App\Http\Controllers\KelolaPretestPostest\PrePostTestController;
use App\Http\Controllers\Pengaduan\PengaduanController;
use App\Http\Controllers\KelolaAkses\KelolaAksesController;
use App\Http\Controllers\KelolaBerita\KelolaDataBeritaController;

//login
Route::post('/login/masyarakat', [AuthMasyarakatController::class, 'login']);
Route::post('/login/pegawai', [AuthPegawaiController::class, 'login']);
Route::post('/login/operator', [AuthOperatorController::class, 'login']);

//daftar masyarakat
Route::post('/daftar/masyarakat', [AuthMasyarakatController::class, 'register']);

//reset password
Route::post('/email/check', [ResetPasswordController::class, 'checkEmail']);
Route::post('/password/forgot', [ResetPasswordController::class, 'sendOtp']);
Route::post('/otp/confirm', [ResetPasswordController::class, 'confirmOtp']);
Route::patch('/password/reset', [ResetPasswordController::class, 'resetPassword']);

//kelola data pelatihan
Route::post('kelola/pelatihan/impor', [KelolaDataPelatihanController::class, 'impor']);
Route::get('kelola/pelatihan/trash', [KelolaDataPelatihanController::class, 'trash']);
Route::put('kelola/pelatihan/restore', [KelolaDataPelatihanController::class, 'restoreMassal']);
Route::delete('kelola/pelatihan/permanent', [KelolaDataPelatihanController::class, 'forceDeleteMassal']);
Route::delete('kelola/pelatihan', [KelolaDataPelatihanController::class, 'destroyMassal']);
Route::put('kelola/pelatihan/{id}/restore', [KelolaDataPelatihanController::class, 'restore']);
Route::delete('kelola/pelatihan/{id}/permanent', [KelolaDataPelatihanController::class, 'forceDelete']);
Route::get('kelola/pelatihan', [KelolaDataPelatihanController::class, 'index']);
Route::post('kelola/pelatihan', [KelolaDataPelatihanController::class, 'store']);
Route::put('kelola/pelatihan/{data_pelatihan}', [KelolaDataPelatihanController::class, 'update']);
Route::delete('kelola/pelatihan/{data_pelatihan}', [KelolaDataPelatihanController::class, 'destroy']);
Route::get('/peserta/{id}', [KelolaDataPelatihanController::class, 'show']);
Route::patch('/peserta/{id}/ubah-foto', [KelolaDataPelatihanController::class, 'ubahFoto']);

//Prestest Postest
Route::get('/kelola/test', [PrePostTestController::class, 'index']);               // Semua nilai test
Route::post('/kelola/test', [PrePostTestController::class, 'store']);              // Tambah nilai
Route::put('/kelola/test/{id}', [PrePostTestController::class, 'update']);         // Edit nilai
Route::delete('/kelola/test/{id}', [PrePostTestController::class, 'destroy']);     // Hapus satu nilai
Route::post('/kelola/test/mass-delete', [PrePostTestController::class, 'massDestroy']); // Hapus banyak nilai
Route::get('/kelola/preposttest', [PrePostController::class, 'index']);                  // Semua soal
Route::get('/kelola/preposttest/{type}', [PrePostController::class, 'show']);            // Soal per tipe
Route::post('/kelola/preposttest', [PrePostController::class, 'store']);                 // Tambah soal
Route::delete('/kelola/preposttest/{id}', [PrePostController::class, 'destroy']);        // Hapus soal

//pengaduan
Route::get('pengaduan', [PengaduanController::class, 'index']);
Route::get('pengaduan/{id}', [PengaduanController::class, 'show']);
Route::post('pengaduan', [PengaduanController::class, 'store']);
Route::put('pengaduan/{id}', [PengaduanController::class, 'update']);
Route::delete('pengaduan/{id}', [PengaduanController::class, 'destroy']);

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
Route::get('/pengaduan/user/{nik}', [PengaduanController::class, 'getByNik']);
