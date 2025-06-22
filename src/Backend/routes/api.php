<?php

use App\Http\Controllers\KelolaDataFasilitas\KelolaDataFasilitasController;
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
use App\Http\Controllers\KelolaDataPanitia\KelolaDataPanitiaController;
use App\Http\Controllers\KelolaDataPelatihan\ImporPelatihanController;

use App\Http\Controllers\KelolaPretestPostest\PrePostController;
use App\Http\Controllers\KelolaPretestPostest\PrePostTestController;
use App\Http\Controllers\Pengaduan\PengaduanController;
use App\Http\Controllers\KelolaAkses\KelolaAksesController;
use App\Http\Controllers\KelolaBerita\KelolaDataBeritaController;
use App\Http\Controllers\KelolaStrukturPegawai\StrukturPegawaiController;
use App\Http\Controllers\KelolaDataKonsultasi\KelolaDataKonsultasiController;



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
Route::get('/peserta/{nik}', [KelolaDataPelatihanController::class, 'show']);
Route::patch('/peserta/{nik}/ubah-foto', [KelolaDataPelatihanController::class, 'ubahFoto']);

//api untuk halaman kelola data Pendaftaran
Route::post('kelola/pendaftaran/impor', [KelolaDataPendaftaranController::class, 'import']);
Route::get('kelola/pendaftaran', [KelolaDataPendaftaranController::class, 'index']);
Route::post('kelola/pendaftaran', [KelolaDataPendaftaranController::class, 'store']);
Route::post('kelola/pendaftaran/accept', [KelolaDataPendaftaranController::class, 'acceptMassal']);
Route::patch('kelola/pendaftaran/{id}/accept', [KelolaDataPendaftaranController::class, 'accept']);
Route::post('kelola/pendaftaran/massal', [KelolaDataPendaftaranController::class, 'rejectMassal']);
Route::post('kelola/pendaftaran/{id}', [KelolaDataPendaftaranController::class, 'reject']);

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
Route::delete('/hapus-massal', [StrukturPegawaiController::class, 'hapusMassal']);
Route::delete('/hapus-permanen-massal', [StrukturPegawaiController::class, 'hapusPermanenMassal']);
Route::post('/import', [StrukturPegawaiController::class, 'import']);
Route::get('/export', [StrukturPegawaiController::class, 'export']);

//api untuk kelola data fasilitas
Route::get('kelola/fasilitas', [KelolaDataFasilitasController::class, 'index']);
Route::get('kelola/fasilitas/sampah', [KelolaDataFasilitasController::class, 'sampah']);
Route::post('kelola/fasilitas', [KelolaDataFasilitasController::class, 'store']);
Route::put('kelola/fasilitas/{id}', [KelolaDataFasilitasController::class, 'update']);
Route::delete('kelola/fasilitas/{id}', [KelolaDataFasilitasController::class, 'destroy']);
Route::delete('kelola/fasilitas/{id}/permanen', [KelolaDataFasilitasController::class, 'deletePermanent']);
Route::put('kelola/fasilitas/{id}/restore', [KelolaDataFasilitasController::class, 'restore']);
Route::post('kelola/fasilitas/restore-massal', [KelolaDataFasilitasController::class, 'restoreMassal']);
Route::delete('kelola/fasilitas/hapus-massal', [KelolaDataFasilitasController::class, 'hapusMassal']);
Route::delete('kelola/fasilitas/hapus-permanen-massal', [KelolaDataFasilitasController::class, 'hapusPermanenMassal']);
Route::post('kelola/fasilitas/import', [KelolaDataFasilitasController::class, 'import']);
Route::get('kelola/fasilitas/export', [KelolaDataFasilitasController::class, 'export']);

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
