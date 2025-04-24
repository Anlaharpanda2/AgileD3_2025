<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'username' => 'required',
        ]);

        $userByNik = User::where('nik', $request->nik)->first();
        $userByUsername = User::where('peserta', $request->username)->first();

        if ($userByNik && $userByUsername) {
            // Cocokkan keduanya
            if ($userByNik->peserta === $request->username) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'user' => $userByNik
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'NIK dan Username tidak cocok'
                ], 401);
            }
        } elseif (!$userByNik && !$userByUsername) {
            return response()->json([
                'success' => false,
                'message' => 'NIK dan Username tidak ditemukan'
            ], 401);
        } elseif (!$userByNik) {
            return response()->json([
                'success' => false,
                'message' => 'NIK tidak ditemukan'
            ], 401);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Username tidak ditemukan'
            ], 401);
        }
    }

}
