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
use App\Http\Controllers\KelolaPretestPostest\NilaiPrePostTestController;
use App\Http\Controllers\KelolaPretestPostest\SoalPrePostTestController;

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


// API untuk Soal Pre/Post Test
Route::prefix('soal-prepost')->controller(SoalPrePostTestController::class)->group(function () {
    Route::get('/', 'index'); // Mengambil semua soal
    Route::post('/', 'store'); // Menambahkan soal baru
    Route::delete('/{id}', 'destroy'); // Menghapus soal berdasarkan ID
});
// API untuk Nilai Pre/Post Test
Route::prefix('nilai-prepost')->controller(NilaiPrePostTestController::class)->group(function () {
    Route::get('/', 'index'); // Mengambil semua nilai
    Route::post('/', 'store'); // Menambahkan nilai baru
    Route::delete('/{id}', 'destroy'); // Menghapus nilai berdasarkan ID
});