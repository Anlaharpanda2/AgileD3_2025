<?php

namespace App\Http\Controllers\KelolaStrukturPegawai;

use App\Http\Controllers\Controller;
use App\Models\StrukturPegawai;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Imports\StrukturPegawaiImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class StrukturPegawaiController extends Controller
{
    public function index()
    {
        return StrukturPegawai::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'idPegawai' => 'required|integer|unique:struktur_pegawais,idPegawai',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:struktur_pegawais,email',
            'jabatan' => 'required|string|max:255',
            'noHp' => 'required|string|max:20',
            'status' => 'required|in:aktif,nonaktif,cuti',
        ]);

        $pegawai = StrukturPegawai::create($validated);

        return response()->json([
            'message' => 'Data pegawai berhasil disimpan.',
            'data' => $pegawai
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $pegawai = StrukturPegawai::find($id);

        if (!$pegawai) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'idPegawai' => ['required', 'integer', Rule::unique('struktur_pegawais')->ignore($pegawai->idPegawai, 'idPegawai')],
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => ['required', 'email', Rule::unique('struktur_pegawais')->ignore($pegawai->idPegawai, 'idPegawai')],
            'jabatan' => 'required|string|max:255',
            'noHp' => 'required|string|max:20',
            'status' => 'required|in:aktif,nonaktif,cuti',
        ]);

        $pegawai->update($validated);

        return response()->json([
            'message' => 'Data berhasil diperbarui',
            'data' => $pegawai
        ]);
    }

    public function destroy($id)
    {
        $pegawai = StrukturPegawai::find($id);
        if (!$pegawai) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $pegawai->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function destroyMassal(Request $request)
    {
        $ids = $request->input('ids');
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['error' => 'Parameter ids tidak valid'], 422);
        }

        $deleted = StrukturPegawai::whereIn('idPegawai', $ids)->delete();
        return response()->json([
            'message' => "Berhasil menghapus {$deleted} data pegawai"
        ]);
    }

    public function trash()
    {
        $data = StrukturPegawai::onlyTrashed()->get();
        return response()->json($data);
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

        $restoredCount = StrukturPegawai::onlyTrashed()
            ->whereIn('idPegawai', $ids)
            ->update(['deleted_at' => null]);

        $msg = $restoredCount
            ? "Berhasil memulihkan $restoredCount data"
            : "Tidak ada data yang dipulihkan";

        return response()->json(['message' => $msg], 200);
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

        $deletedCount = StrukturPegawai::onlyTrashed()
            ->whereIn('idPegawai', $ids)
            ->forceDelete();

        $msg = $deletedCount
            ? "Berhasil menghapus permanen $deletedCount data"
            : "Tidak ada data yang dihapus permanen";

        return response()->json(['message' => $msg], 200);
    }

    public function impor(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new StrukturPegawaiImport, $request->file('file'));
            return response()->json([
                'message' => 'Data struktur pegawai berhasil diimpor',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengimpor data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($idPegawai)
    {
        $pegawai = StrukturPegawai::where('idPegawai', $idPegawai)->first();

        if (!$pegawai) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => $pegawai
        ]);
    }
}
