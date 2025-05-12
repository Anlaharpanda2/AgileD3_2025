<?php

namespace App\Http\Controllers\Auth;

use App\Models\DaftarPendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthMasyarakatController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required|string',
            'nama' => 'required|string',
        ]);
        $peserta = DaftarPendaftar::where('nik', $request->nik)
            ->where('peserta', $request->nama)
            ->first();
        if (!$peserta) {
            return response()->json(['message' => 'NIK atau Nama tidak valid'], 401);
        }
        Auth::login($peserta);
        return response()->json(['message' => 'Login berhasil']);
    }
}