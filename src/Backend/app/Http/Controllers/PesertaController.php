<?php

// app/Http/Controllers/PesertaController.php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index()
    {
        return response()->json(Peserta::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required',
            'peserta' => 'required',
            'tempat_tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'pendidikan' => 'required',
            'pekerjaan' => 'required',
            'email' => 'required|email',
            'pelatihan' => 'required',
            'tanggal_pelatihan' => 'required',
            'tempat_pelatihan' => 'required',
        ]);

        $peserta = Peserta::create($validated);

        // ✅ Kirim data balik ke frontend, biar frontend redirect ke /peserta
        return response()->json([
            'message' => 'Data berhasil disimpan.',
            'data' => $peserta
        ], 201);
    }
}
