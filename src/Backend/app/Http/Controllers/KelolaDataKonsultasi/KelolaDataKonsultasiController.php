<?php

namespace App\Http\Controllers\KelolaDataKonsultasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Imports\KonsultasiImport;
use App\Models\DataKonsultasi;
use Maatwebsite\Excel\Facades\Excel;

class KelolaDataKonsultasiController extends Controller
{
    public function index()
    {
        return DataKonsultasi::all();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:100',
                'nama_korban' => 'required|string|max:100',
                'nik' => 'required|string|size:16|unique:konsultasi,nik',
                'jenis_kelamin' => 'required|string|max:10',
                'kasus' => 'required|string|max:255',
                'alamat' => 'required|string',
                'no_hp' => 'required|integer',
                'saksi' => 'nullable|string|max:255',
                'status' => ['required', 'string', Rule::in(['active', 'inactive'])],
                'umur' => 'required|integer',
                'deskripsi_data_konsultasi' => 'required|string',
            ]);

            $konsultasi = DataKonsultasi::create($validated);
            
            return response()->json([
                'message' => 'Data konsultasi berhasil disimpan.',
                'data' => $konsultasi
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, DataKonsultasi $konsultasi)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:100',
                'nama_korban' => 'required|string|max:100',
                'nik' => [
                    'required',
                    'string',
                    'size:16',
                    Rule::unique('konsultasi', 'nik')->ignore($konsultasi->id),
                ],
                'jenis_kelamin' => 'required|string|max:10',
                'kasus' => 'required|string|max:255',
                'alamat' => 'required|string',
                'no_hp' => 'required|integer',
                'saksi' => 'nullable|string|max:255',
                'status' => ['required', 'string', Rule::in(['active', 'inactive'])],
                'umur' => 'required|integer',
                'deskripsi_data_konsultasi' => 'required|string',
            ]);

            $konsultasi->update($validated);
            
            return response()->json([
                'message' => 'Data konsultasi berhasil diupdate',
                'data' => $konsultasi
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(DataKonsultasi $konsultasi)
    {
        $konsultasi->delete();
        return response()->json(['message' => 'Data konsultasi berhasil dihapus']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new KonsultasiImport, $request->file('file'));

            return response()->json([
                'message' => 'Data konsultasi berhasil diimpor',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengimpor data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($nik)
    {
        $data = DataKonsultasi::where('nik', $nik)->first();

        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => $data
        ]);
    }
}
