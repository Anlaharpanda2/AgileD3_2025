<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesertaController;

// Endpoint untuk ambil semua peserta
Route::get('/peserta', [PesertaController::class, 'index']);

// Endpoint untuk menambahkan peserta
Route::post('/peserta', [PesertaController::class, 'store']);
