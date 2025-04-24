<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NikController;
use App\Http\Controllers\DaftarController;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/pendaftar', [PendaftarController::class, 'index']);

Route::get('/test', function () {
    return ['test' => 'oke'];
});

Route::post('/cek-nik', [NikController::class, 'cekNik']);
Route::post('/pendaftar', [DaftarController::class, 'store']);

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

Route::post('/test-nik', function (Request $request) {
    // Ambil NIK dari request
    $nik = $request->nik;

    // Lakukan request ke API RapidAPI
    $response = Http::withHeaders([
        'x-rapidapi-host' => 'ktp-validator.p.rapidapi.com',
        'x-rapidapi-key' => '297cff59c9msh9407bdd830bbc61p105e27jsn41523da548a7'
    ])->get("https://ktp-validator.p.rapidapi.com/parse-nik?nik={$nik}");

    // Periksa status dan data response dari API
    if ($response->successful()) {
        // API berhasil
        return response()->json([
            'status' => $response->status(),
            'data' => $response->json()
        ]);
    } else {
        // Jika API gagal
        return response()->json([
            'status' => $response->status(),
            'message' => 'Terjadi kesalahan saat memverifikasi NIK.'
        ], $response->status());
    }
});
