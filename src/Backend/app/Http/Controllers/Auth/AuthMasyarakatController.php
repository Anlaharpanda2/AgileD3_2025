<?php

namespace App\Http\Controllers\Auth;

use App\Models\UserMasyarakat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


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

    return response()->json([
        'message' => 'Login berhasil',
        'id' => $pendaftar->id,
        'tempat_tanggal_lahir' => $pendaftar->tempat_tanggal_lahir,
    ]);
}

    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nama' => 'required|string|max:255',
        'nik' => 'required|string|max:255|unique:users_masyarakat,nik',
        'tempat_tanggal_lahir' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        $errors = $validator->errors();

        if ($errors->has('nik')) {
            return response()->json([
                'message' => 'Gagal mendaftar: NIK sudah terdaftar',
                'errors' => $errors
            ], 422);
        }

        return response()->json([
            'message' => 'Validasi gagal',
            'errors' => $errors
        ], 422);
    }

    try {
        $user = UserMasyarakat::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'tempat_tanggal_lahir' => $request->tempat_tanggal_lahir,
            'jenis_bimtek' => '',
            'kegiatan_dimulai' => null,
            'kegiatan_berakhir' => null,
            'tempat_kegiatan' => '',
            'angkatan' => null,
            'pendidikan' => '',
            'status' => null,
            'alamat' => '',
            'jenis_usaha' => '',
            'penghasilan_perbulan' => '',
            'nomor_telefon' => '',
        ]);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'data' => $user,
        ], 201);

    } catch (QueryException $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat menyimpan data.',
            'error' => $e->getMessage()
        ], 500);
    }
}

}