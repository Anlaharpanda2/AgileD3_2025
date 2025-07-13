<?php

namespace App\Http\Controllers\KelolaStrukturPegawai;

use App\Http\Controllers\Controller;
use App\Models\StrukturPegawai;
use Illuminate\Http\Request;

use App\Imports\StrukturPegawaiImport;
use Maatwebsite\Excel\Facades\Excel;

class KelolaStrukturPegawaiController extends Controller
{
    public function impor(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            Excel::import(new StrukturPegawaiImport, $request->file('file'));
            return response()->json(['message' => 'Data struktur pegawai berhasil diimpor.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage()], 500);
        }
    }

    public function index()
    {
        return StrukturPegawai::all();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'idPegawai' => 'required|string|unique:struktur_pegawais,idPegawai',
                'nama' => 'required|string|max:255',
                'alamat' => 'nullable|string',
                'email' => 'required|email|unique:struktur_pegawais,email',
                'jabatan' => 'required|string|max:100',
                'noHp' => 'nullable|string|max:20',
                'status' => 'required|in:aktif,nonaktif',
            ]);

            $data = StrukturPegawai::create($validated);

            return response()->json([
                'message' => 'Data Pegawai berhasil disimpan.',
                'data' => $data,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, StrukturPegawai $strukturPegawai)
    {
        try {
            $validated = $request->validate([
                'idPegawai' => 'required|string|unique:struktur_pegawais,idPegawai,' . $strukturPegawai->id,
                'nama' => 'required|string|max:255',
                'alamat' => 'nullable|string',
                'email' => 'required|email|unique:struktur_pegawais,email,' . $strukturPegawai->id,
                'jabatan' => 'required|string|max:100',
                'noHp' => 'nullable|string|max:20',
                'status' => 'required|in:aktif,nonaktif',
            ]);

            $strukturPegawai->update($validated);

            return response()->json([
                'message' => 'Data berhasil diupdate',
                'data' => $strukturPegawai,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(StrukturPegawai $strukturPegawai)
    {
        $strukturPegawai->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function trash()
    {
        return StrukturPegawai::onlyTrashed()->get();
    }

    public function restore($id)
    {
        $data = StrukturPegawai::onlyTrashed()->find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        $data->restore();
        return response()->json(['message' => 'Data berhasil dipulihkan']);
    }

    public function restoreMassal(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'Daftar ID tidak valid atau kosong'], 400);
        }

        $restoredCount = StrukturPegawai::onlyTrashed()->whereIn('id', $ids)->update(['deleted_at' => null]);

        return response()->json(['message' => "Berhasil memulihkan {$restoredCount} data"]);
    }

    public function destroyMassal(Request $request)
    {
        $ids = $request->input('ids');
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['error' => 'Parameter ids tidak valid'], 422);
        }

        $deleted = StrukturPegawai::whereIn('id', $ids)->delete();
        return response()->json(['message' => "Berhasil menghapus {$deleted} data pegawai"]);
    }

    public function forceDelete($id)
    {
        $data = StrukturPegawai::onlyTrashed()->find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->forceDelete();
        return response()->json(['message' => 'Data berhasil dihapus permanen']);
    }

    public function forceDeleteMassal(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'Daftar ID tidak valid atau kosong'], 400);
        }

        $deleted = StrukturPegawai::onlyTrashed()->whereIn('id', $ids)->forceDelete();
        return response()->json(['message' => 'Data berhasil dihapus permanen']);
    }
}
