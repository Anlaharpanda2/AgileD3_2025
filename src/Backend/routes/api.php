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
