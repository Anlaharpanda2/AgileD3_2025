<?php

namespace App\Http\Controllers\KelolaLokasi;

use Illuminate\Http\Request;
use App\Models\DataLokasi;
use App\Http\Controllers\Controller;

class KelolaLokasiController extends Controller
{
    public function index()
    {
        return response()->json(DataLokasi::all());
    }
    public function storeOrReplace(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        // Hapus semua data di tabel
        DataLokasi::truncate(); // atau DataLokasi::query()->delete();

        // Tambahkan data baru
        $lokasi = DataLokasi::create([
            'nama_lokasi' => $request->nama_lokasi,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json([
            'message' => 'Data berhasil diperbarui',
            'data' => $lokasi
        ], 201);
    }
}
