<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
//Auth
use App\Http\Controllers\Auth\AuthMasyarakatController;
use App\Http\Controllers\Auth\AuthOperatorController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\AuthPegawaiController;
//CRUD
use App\Http\Controllers\KelolaDataPendaftaran\KelolaDataPendaftaranController;
use App\Http\Controllers\KelolaBerita\KelolaDataBeritaController;
use App\Http\Controllers\KelolaDataPengaduan\KelolaDataPengaduanController;
use App\Http\Controllers\KelolaDataKonsultasi\KelolaDataKonsultasiController;
use App\Http\Controllers\KelolaDataPanitia\KelolaDataPanitiaController;
use App\Http\Controllers\KelolaAkses\KelolaAksesController;
use App\Http\Controllers\KelolaDataFasilitas\KelolaDataFasilitasController;
use App\Http\Controllers\KelolaStrukturPegawai\KelolaStrukturPegawaiController;
use App\Http\Controllers\DataNilai\DataNilaiController;
use App\Http\Controllers\kelolaDataTest\KelolaDataTestController;
use App\Http\Controllers\KelolaDataPelatihan\KelolaDataPelatihanController;
//Profile
use App\Http\Controllers\Profile\ProfileMasyarakatController;

use App\Http\Controllers\KelolaLokasi\KelolaLokasiController;

//Api auth

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


//Api CRUD

//1. api kelola data Pendaftaran
Route::prefix('kelola/pendaftaran')->group(function () {
    Route::post('/impor', [KelolaDataPendaftaranController::class, 'import']);
    Route::get('/', [KelolaDataPendaftaranController::class, 'index']);
    Route::post('/', [KelolaDataPendaftaranController::class, 'store']);
    Route::post('/accept', [KelolaDataPendaftaranController::class, 'acceptMassal']);
    Route::patch('/{id}/accept', [KelolaDataPendaftaranController::class, 'accept']);
    Route::post('/massal', [KelolaDataPendaftaranController::class, 'rejectMassal']);
    Route::post('/{id}', [KelolaDataPendaftaranController::class, 'reject']);
});
//2. pengelola berita dan pengumuman
Route::prefix('kelola/berita')->group(function () {
    Route::get('/trash', [KelolaDataBeritaController::class, 'trash']);
    Route::put('/restore', [KelolaDataBeritaController::class, 'restoreMassal']);
    Route::put('/restore/{id}', [KelolaDataBeritaController::class, 'restore']);
    Route::delete('/permanent', [KelolaDataBeritaController::class, 'forceDeleteMassal']);
    Route::delete('/permanent/{id}', [KelolaDataBeritaController::class, 'forceDelete']);
    Route::delete('/', [KelolaDataBeritaController::class, 'destroyMassal']);
    Route::get('/', [KelolaDataBeritaController::class, 'index']);
    Route::post('/', [KelolaDataBeritaController::class, 'store']);
    Route::put('/{dataBerita}', [KelolaDataBeritaController::class, 'update']);
    Route::delete('/{dataBerita}', [KelolaDataBeritaController::class, 'destroy']);
    Route::get('/{dataBerita}', [KelolaDataBeritaController::class, 'show']);
});
//3. pengelola pengaduan
Route::prefix('kelola/pengaduan')->group(function () {
    Route::get('/trash', [KelolaDataPengaduanController::class, 'trash']);
    Route::put('/restore', [KelolaDataPengaduanController::class, 'restoreMassal']);
    Route::put('/restore/{id}', [KelolaDataPengaduanController::class, 'restore']);
    Route::delete('/permanent', [KelolaDataPengaduanController::class, 'forceDeleteMassal']);
    Route::delete('/permanent/{id}', [KelolaDataPengaduanController::class, 'forceDelete']);
    Route::delete('/', [KelolaDataPengaduanController::class, 'destroyMassal']);
    Route::get('/', [KelolaDataPengaduanController::class, 'index']);
    Route::post('/', [KelolaDataPengaduanController::class, 'store']);
    Route::put('/{dataPengaduan}', [KelolaDataPengaduanController::class, 'update']);
    Route::delete('/{dataPengaduan}', [KelolaDataPengaduanController::class, 'destroy']);
    Route::get('/{id}', [KelolaDataPengaduanController::class, 'show']);
});
//4. pengelola konsultasi
Route::prefix('kelola/Konsultasi')->group(function () {
    Route::get('/trash', [KelolaDataKonsultasiController::class, 'trash']);
    Route::put('/restore', [KelolaDataKonsultasiController::class, 'restoreMassal']);
    Route::put('/restore/{id}', [KelolaDataKonsultasiController::class, 'restore']);
    Route::delete('/permanent', [KelolaDataKonsultasiController::class, 'forceDeleteMassal']);
    Route::delete('/permanent/{id}', [KelolaDataKonsultasiController::class, 'forceDelete']);
    Route::delete('/', [KelolaDataKonsultasiController::class, 'destroyMassal']);
    Route::get('/', [KelolaDataKonsultasiController::class, 'index']);
    Route::post('/', [KelolaDataKonsultasiController::class, 'store']);
    Route::put('/{dataKonsultasi}', [KelolaDataKonsultasiController::class, 'update']);
    Route::delete('/{dataKonsultasi}', [KelolaDataKonsultasiController::class, 'destroy']);
});
//5. pengelola data panitia kegiatan
Route::prefix('kelola/panitia')->group(function () {
    Route::get('/trash', [KelolaDataPanitiaController::class, 'trash']);
    Route::put('/restore', [KelolaDataPanitiaController::class, 'restoreMassal']);
    Route::put('/restore/{id}', [KelolaDataPanitiaController::class, 'restore']);
    Route::delete('/permanent', [KelolaDataPanitiaController::class, 'forceDeleteMassal']);
    Route::delete('/permanent/{id}', [KelolaDataPanitiaController::class, 'forceDelete']);
    Route::delete('/', [KelolaDataPanitiaController::class, 'destroyMassal']);
    Route::get('/', [KelolaDataPanitiaController::class, 'index']);
    Route::post('/', [KelolaDataPanitiaController::class, 'store']);
    Route::put('/{dataPanitia}', [KelolaDataPanitiaController::class, 'update']);
    Route::delete('/{dataPanitia}', [KelolaDataPanitiaController::class, 'destroy']);
});
//6. pengelola akses admin
Route::prefix('kelola/akses')->group(function () {
    Route::get('/', [KelolaAksesController::class, 'index']);             
    Route::post('/', [KelolaAksesController::class, 'store']);            
    Route::put('/{user}', [KelolaAksesController::class, 'update']);      
    Route::delete('/{user}', [KelolaAksesController::class, 'destroy']);  
});
//7. pengelola fasilitas
Route::prefix('kelola/fasilitas')->group(function () {
    Route::get('/trash', [KelolaDataFasilitasController::class, 'trash']);
    Route::put('/restore', [KelolaDataFasilitasController::class, 'restoreMassal']);
    Route::put('/restore/{id}', [KelolaDataFasilitasController::class, 'restore']);
    Route::delete('/permanent', [KelolaDataFasilitasController::class, 'forceDeleteMassal']);
    Route::delete('/permanent/{id}', [KelolaDataFasilitasController::class, 'forceDelete']);
    Route::delete('/', [KelolaDataFasilitasController::class, 'destroyMassal']);
    Route::get('/', [KelolaDataFasilitasController::class, 'index']);
    Route::post('/', [KelolaDataFasilitasController::class, 'store']);
    Route::put('/{dataFasilitas}', [KelolaDataFasilitasController::class, 'update']);
    Route::delete('/{dataFasilitas}', [KelolaDataFasilitasController::class, 'destroy']);
});
//8. pengelola struktur pegawai
Route::prefix('kelola/struktur-pegawai')->group(function () {
    Route::get('/trash', [KelolaStrukturPegawaiController::class, 'trash']);
    Route::put('/restore', [KelolaStrukturPegawaiController::class, 'restoreMassal']);
    Route::put('/restore/{id}', [KelolaStrukturPegawaiController::class, 'restore']);
    Route::delete('/permanent', [KelolaStrukturPegawaiController::class, 'forceDeleteMassal']);
    Route::delete('/permanent/{id}', [KelolaStrukturPegawaiController::class, 'forceDelete']);
    Route::delete('/', [KelolaStrukturPegawaiController::class, 'destroyMassal']);
    Route::get('/', [KelolaStrukturPegawaiController::class, 'index']);
    Route::post('/', [KelolaStrukturPegawaiController::class, 'store']);
    Route::put('/{strukturPegawai}', [KelolaStrukturPegawaiController::class, 'update']);
    Route::delete('/{strukturPegawai}', [KelolaStrukturPegawaiController::class, 'destroy']);
});
//9. melihat Nilai pretest dan postest peserta
Route::get('data/nilai', [DataNilaiController::class, 'index']);
//10. pengelola pretest dan postest
Route::prefix('kelola/test')->group(function () {
    Route::get('/', [KelolaDataTestController::class, 'index']);              
    Route::post('/', [KelolaDataTestController::class, 'store']);             
    Route::put('/', [KelolaDataTestController::class, 'update']);             
    Route::delete('/{id}', [KelolaDataTestController::class, 'destroy']);     
    Route::delete('/', [KelolaDataTestController::class, 'massDestroy']);     
});
//11. kelola data pelatihan
Route::prefix('kelola/pelatihan')->group(function () {
    Route::post('/impor', [KelolaDataPelatihanController::class, 'impor']);
    Route::get('/trash', [KelolaDataPelatihanController::class, 'trash']);
    Route::put('/restore', [KelolaDataPelatihanController::class, 'restoreMassal']);
    Route::post('/permanent', [KelolaDataPelatihanController::class, 'forceDeleteMassal']);
    Route::delete('/', [KelolaDataPelatihanController::class, 'destroyMassal']);
    Route::put('/{id}/restore', [KelolaDataPelatihanController::class, 'restore']);
    Route::delete('/{id}/permanent', [KelolaDataPelatihanController::class, 'forceDelete']);
    Route::get('/', [KelolaDataPelatihanController::class, 'index']);
    Route::post('/', [KelolaDataPelatihanController::class, 'store']);
    Route::put('/{data_pelatihan}', [KelolaDataPelatihanController::class, 'update']);
    Route::delete('/{data_pelatihan}', [KelolaDataPelatihanController::class, 'destroy']);
});

//Profile
//1. Profile masyarakat
Route::prefix('profile/masyarakat')->group(function () {
    Route::get('{nik}', [ProfileMasyarakatController::class, 'show']);
    Route::patch('{nik}/ubah-foto', [ProfileMasyarakatController::class, 'ubahFoto']);
});

//Tambahan
Route::post('/data/lokasi', [KelolaLokasiController::class, 'storeOrReplace']);
Route::get('/data/lokasi', [KelolaLokasiController::class, 'index']);

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

//kelola data Panitia
Route::post('kelola/Panitia/impor', [KelolaDataPanitiaController::class, 'impor']);
Route::get('kelola/Panitia/trash', [KelolaDataPanitiaController::class, 'trash']);
Route::put('kelola/Panitia/restore', [KelolaDataPanitiaController::class, 'restoreMassal']);
Route::delete('kelola/Panitia/permanent', [KelolaDataPanitiaController::class, 'forceDeleteMassal']);
Route::delete('kelola/Panitia', [KelolaDataPanitiaController::class, 'destroyMassal']);
Route::put('kelola/Panitia/{id}/restore', [KelolaDataPanitiaController::class, 'restore']);
Route::delete('kelola/Panitia/{id}/permanent', [KelolaDataPanitiaController::class, 'forceDelete']);
Route::get('kelola/Panitia', [KelolaDataPanitiaController::class, 'index']);
Route::post('kelola/Panitia', [KelolaDataPanitiaController::class, 'store']);
Route::put('kelola/Panitia/{data_Panitia}', [KelolaDataPanitiaController::class, 'update']);
Route::delete('kelola/Panitia/{data_Panitia}', [KelolaDataPanitiaController::class, 'destroy']);
Route::get('/Panitia/{nik}', [KelolaDataPanitiaController::class, 'show']);
Route::patch('/Panitia/{nik}/ubah-foto', [KelolaDataPanitiaController::class, 'ubahFoto']);

//api untuk kelola akses
Route::get('/kelola/akses',[KelolaAksesController::class,'index']);
Route::get('/pengaduan/user/{nik}', [PengaduanController::class, 'getByNik']);

// api untuk kelola struktur pegawai
Route::get('/kelola/pegawai', [StrukturPegawaiController::class, 'index']);
Route::post('/kelola/pegawai', [StrukturPegawaiController::class, 'store']);
Route::get('/pegawai/{id}', [StrukturPegawaiController::class, 'show']);
Route::put('kelola/pegawai/{id}', [StrukturPegawaiController::class, 'update']);
Route::delete('kelola/pegawai/{id}', [StrukturPegawaiController::class, 'destroy']); 
Route::post('/destroy-massal', [StrukturPegawaiController::class, 'destroyMassal']);
Route::get('/trash', [StrukturPegawaiController::class, 'trash']);
Route::post('/restore/{id}', [StrukturPegawaiController::class, 'restore']);
Route::post('/restore-massal', [StrukturPegawaiController::class, 'restoreMassal']);
Route::delete('/force-delete/{id}', [StrukturPegawaiController::class, 'forceDelete']);
Route::post('/force-delete-massal', [StrukturPegawaiController::class, 'forceDeleteMassal']);
Route::post('/import', [StrukturPegawaiController::class, 'impor']);

// Konsultasi Data Management
Route::post('kelola/konsultasi/impor', [KelolaDataKonsultasiController::class, 'impor']);
Route::get('kelola/konsultasi/trash', [KelolaDataKonsultasiController::class, 'trash']);
Route::put('kelola/konsultasi/restore', [KelolaDataKonsultasiController::class, 'restoreMassal']);
Route::delete('kelola/konsultasi/permanent', [KelolaDataKonsultasiController::class, 'forceDeleteMassal']);
Route::delete('kelola/konsultasi', [KelolaDataKonsultasiController::class, 'destroyMassal']);
Route::put('kelola/konsultasi/{id}/restore', [KelolaDataKonsultasiController::class, 'restore']);
Route::delete('kelola/konsultasi/{id}/permanent', [KelolaDataKonsultasiController::class, 'forceDelete']);
Route::get('kelola/konsultasi', [KelolaDataKonsultasiController::class, 'index']);
Route::post('kelola/konsultasi', [KelolaDataKonsultasiController::class, 'store']);
Route::put('kelola/konsultasi/{data_konsultasi}', [KelolaDataKonsultasiController::class, 'update']);
Route::delete('kelola/konsultasi/{data_konsultasi}', [KelolaDataKonsultasiController::class, 'destroy']);
Route::get('/konsultasi/{id_konsultasi}', [KelolaDataKonsultasiController::class, 'show']);
Route::patch('/konsultasi/{id_konsultasi}/ubah-foto', [KelolaDataKonsultasiController::class, 'ubahFoto']);
