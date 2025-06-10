<?php

namespace App\Http\Controllers\Auth;

use App\Models\UserMasyarakat;
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
        $pendaftar = UserMasyarakat::where('nik', $request->nik)
            ->where('nama', $request->nama)
            ->first();
        if (!$pendaftar) {
            return response()->json(['message' => 'NIK atau Nama tidak valid'], 401);
        }
        Auth::login($pendaftar);

        return response()->json(['message' => 'Login berhasil']);
    }
}