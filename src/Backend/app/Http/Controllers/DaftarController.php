<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\daftar;

class DaftarController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nik' => 'required|numeric|unique:pendaftars',
            'nama' => 'required|string|max:255',
        ]);

        // Simpan data ke tabel pendaftar
        $pendaftar = Pendaftar::create([
            'nik' => $validated['nik'],
            'nama' => $validated['nama'],
        ]);

        return response()->json(['message' => 'Pendaftar berhasil disimpan.'], 201);
    }
}

