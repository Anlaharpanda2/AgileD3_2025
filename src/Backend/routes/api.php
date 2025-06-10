<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Auth\AuthMasyarakatController;
use App\Http\Controllers\Auth\AuthOperatorController;
use App\Http\Controllers\Auth\AuthPegawaiController;
use App\Http\Controllers\KelolaDataPelatihan\KelolaDataPelatihanController;
use App\Http\Controllers\KelolaDataPelatihan\ImporPelatihanController;
use App\Http\Controllers\KelolaPesan\PesanController;
use App\Http\Controllers\KelolaPretestPostest\PrePostController;
use App\Http\Controllers\KelolaPretestPostest\PrePostTestController;
use App\Http\Controllers\Pengaduan\PengaduanController;


Route::post('/login/masyarakat', [AuthMasyarakatController::class, 'login']);
Route::post('/login/operator', [AuthOperatorController::class, 'login']);
Route::post('/login/pegawai', [AuthPegawaiController::class, 'login']);
Route::post('/logout',function(Request $request){
    Auth::logout();
    return response()->json(['message' => 'Logout berhasil']);
});

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

Route::get('/kelola/test', [PrePostTestController::class, 'index']);               // Semua nilai test
Route::post('/kelola/test', [PrePostTestController::class, 'store']);              // Tambah nilai
Route::put('/kelola/test/{id}', [PrePostTestController::class, 'update']);         // Edit nilai
Route::delete('/kelola/test/{id}', [PrePostTestController::class, 'destroy']);     // Hapus satu nilai
Route::post('/kelola/test/mass-delete', [PrePostTestController::class, 'massDestroy']); // Hapus banyak nilai

Route::get('/kelola/preposttest', [PrePostController::class, 'index']);                  // Semua soal
Route::get('/kelola/preposttest/{type}', [PrePostController::class, 'show']);            // Soal per tipe
Route::post('/kelola/preposttest', [PrePostController::class, 'store']);                 // Tambah soal
Route::delete('/kelola/preposttest/{id}', [PrePostController::class, 'destroy']);        // Hapus soal


Route::get('pengaduan', [PengaduanController::class, 'index']);
Route::get('pengaduan/{id}', [PengaduanController::class, 'show']);
Route::post('pengaduan', [PengaduanController::class, 'store']);
Route::put('pengaduan/{id}', [PengaduanController::class, 'update']);
Route::delete('pengaduan/{id}', [PengaduanController::class, 'destroy']);
