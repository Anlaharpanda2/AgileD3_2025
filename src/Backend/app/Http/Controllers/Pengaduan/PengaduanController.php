<?php

namespace App\Http\Controllers\Pengaduan;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    // Melaporkan pengaduan
    
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'umur' => 'required|integer',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'jenis_kasus' => 'required|string|max:255',
            'kasus' => 'nullable|string|max:255',
            'deskripsi_laporan' => 'required|string|min:10',
            'waktu_kejadian' => 'required|date',
            'nama_korban' => 'nullable|string|max:255',
            'saksi' => 'nullable|string|max:255',
            'jenis_pengaduan' => 'required|in:langsung,tidak langsung',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'tanggal_pengaduan' => 'nullable|date',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran_pengaduan', 'public');
        }

        $pengaduan = Pengaduan::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'umur' => $request->umur,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'jenis_kasus' => $request->jenis_kasus,
            'kasus' => $request->kasus,
            'deskripsi_laporan' => $request->deskripsi_laporan,
            'waktu_kejadian' => $request->waktu_kejadian,
            'nama_korban' => $request->nama_korban,
            'saksi' => $request->saksi,
            'jenis_pengaduan' => $request->jenis_pengaduan,
            'lampiran' => $lampiranPath,
            'status' => 'dikirim',
            'tanggapan' => null,
            'tanggal_pengaduan' => $request->tanggal_pengaduan,
        ]);

        return response()->json([
            'message' => 'Pengaduan berhasil dilaporkan',
            'data' => $pengaduan
        ], 201);
    }

    // Melihat semua pengaduan
    public function index(Request $request)
    {
        $query = Pengaduan::query();

        // Jika ada parameter nik, filter berdasarkan nik
        if ($request->has('nik')) {
            $query->where('nik', $request->nik);
        }

        $pengaduans = $query->latest()->get();
        return response()->json($pengaduans);
    }

    // Melihat detail pengaduan
    public function show($id)
    {
        $pengaduan = Pengaduan::find($id);
        if (!$pengaduan) {
            return response()->json(['message' => 'Pengaduan tidak ditemukan'], 404);
        }
        return response()->json($pengaduan);
    }
    public function getByNik($nik)
    {
        $pengaduans = Pengaduan::where('nik', $nik)->orderBy('created_at', 'desc')->get();

        if ($pengaduans->isEmpty()) {
            return response()->json([
                'status' => 'empty',
                'message' => 'Anda belum membuat laporan'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $pengaduans
        ]);
    }
}