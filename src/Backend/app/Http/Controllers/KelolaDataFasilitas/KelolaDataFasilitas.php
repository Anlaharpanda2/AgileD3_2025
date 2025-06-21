<?php

namespace App\Http\Controllers\KelolaDataFasilitas;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Imports\FasilitasImport;
use App\Exports\FasilitasExport;
use Maatwebsite\Excel\Facades\Excel;

class KelolaDataFasilitasController extends Controller
{
    public function index()
    {
        return Fasilitas::all();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'kategori' => 'required|string|max:255',
                'lokasi' => 'required|string|max:255',
                'jumlah' => 'required|integer|min:0',
                'status' => 'required|in:aktif,nonaktif',
            ]);

            $data = Fasilitas::create($validated);
            return response()->json([
                'message' => 'Data fasilitas berhasil disimpan.',
                'data' => $data,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Fasilitas $fasilitas)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'kategori' => 'required|string|max:255',
                'lokasi' => 'required|string|max:255',
                'jumlah' => 'required|integer|min:0',
                'status' => 'required|in:aktif,nonaktif',
            ]);

            $fasilitas->update($validated);
            return response()->json([
                'message' => 'Data fasilitas berhasil diperbarui.',
                'data' => $fasilitas,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Fasilitas $fasilitas)
    {
        $fasilitas->delete();
        return response()->json(['message' => 'Data fasilitas berhasil dihapus.']);
    }

    public function destroyMassal(Request $request)
    {
        $ids = $request->input('ids');
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['error' => 'Parameter ids tidak valid'], 422);
        }

        $deleted = Fasilitas::whereIn('idFasilitas', $ids)->delete();
        return response()->json([
            'message' => "Berhasil menghapus {$deleted} data fasilitas"
        ]);
    }

    public function trash()
    {
        return Fasilitas::onlyTrashed()->get();
    }

    public function restore($id)
    {
        $data = Fasilitas::onlyTrashed()->find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        $data->restore();
        return response()->json(['message' => 'Data fasilitas berhasil dipulihkan']);
    }

    public function restoreMassal(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'Daftar ID tidak valid atau kosong'], 400);
        }

        $restored = Fasilitas::onlyTrashed()->whereIn('idFasilitas', $ids)->restore();
        return response()->json([
            'message' => "Berhasil memulihkan {$restored} data fasilitas"
        ]);
    }

    public function forceDelete($id)
    {
        $data = Fasilitas::onlyTrashed()->find($id);
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

        $deleted = Fasilitas::onlyTrashed()->whereIn('idFasilitas', $ids)->forceDelete();
        return response()->json(['message' => "Berhasil menghapus permanen {$deleted} data fasilitas"]);
    }

    public function impor(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new FasilitasImport, $request->file('file'));
            return response()->json(['message' => 'Data fasilitas berhasil diimpor'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengimpor data: ' . $e->getMessage()], 500);
        }
    }

    public function ekspor()
    {
        return Excel::download(new FasilitasExport, 'data-fasilitas.xlsx');
    }

    public function show($id)
    {
        $data = Fasilitas::find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => $data
        ]);
    }
}
