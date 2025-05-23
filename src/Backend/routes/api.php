<?php

use Illuminate\Http\Request;
use App\Http\Controllers\EksporPendaftarController;
use App\Http\Controllers\ImporPendaftarController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\Auth\AuthMasyarakatController;
use App\Http\Controllers\Auth\AuthOperatorController;
use App\Http\Controllers\Auth\AuthPegawaiController;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\DosenController; 
use App\Http\Controllers\NadyaController;
use App\Http\Controllers\VaniaController;
use App\Http\Controllers\PendaftaranBaru\PendaftaranBaruController;


Route::get('/', [Backend::class, 'index']);
Route::post('/login/masyarakat', [AuthMasyarakatController::class, 'login']);
Route::post('/login/operator', [AuthOperatorController::class, 'login']);
Route::post('/login/pegawai', [AuthPegawaiController::class, 'login']);
Route::post('/logout',function(Request $request){
    Auth::logout();
    return response()->json(['message' => 'Logout berhasil']);
});

// Endpoint untuk ambil semua peserta
Route::get('/peserta', [PesertaController::class, 'index']);

// Endpoint untuk menambahkan peserta
Route::post('/peserta', [PesertaController::class, 'store']);
Route::get('/test', function () {
    return ['test' => 'oke'];
});

Route::get('/pendaftar', [NadyaController::class, 'index']);

// Rute untuk impor data pendaftar
Route::post('/pendaftar/impor', [ImporPendaftarController::class, 'impor']);


Route::get('/pendaftar/ekspor', [EksporPendaftarController::class, 'ekspor']);
Route::get('/vaniaroute', [VaniaController::class, 'index']);

Route::get('/pendaftaranbaru', [PendaftaranBaruController::class, 'index']);
Route::post('/pendaftaranbaru', [PendaftaranBaruController::class, 'store']);
Route::put('/pendaftaranbaru/{nik}', [PendaftaranBaruController::class, 'update']);
Route::delete('/pendaftaranbaru/{nik}', [PendaftaranBaruController::class, 'destroy']);
Route::get('/pendaftaranbaru/trash', [PendaftaranBaruController::class, 'trash']); // Lihat yang dihapus
Route::put('/pendaftaranbaru/restore/{nik}', [PendaftaranBaruController::class, 'restore']); // Pulihkan
Route::delete('/pendaftaranbaru/permanent/{nik}', [PendaftaranBaruController::class, 'forceDelete']);
