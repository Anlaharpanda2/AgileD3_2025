<?php

namespace App\Http\Controllers\KelolaDataFasilitas;

use App\Http\Controllers\Controller;
use App\Models\DataFasilitas;
use Illuminate\Http\Request;

class KelolaDataFasilitasController extends Controller
{
    public function index()
    {
        return DataFasilitas::all();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama_fasilitas' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'kategori' => 'nullable|string|max:100',
                'jumlah' => 'required|integer|min:0',
                'status' => 'required|string|max:100',
            ]);

            $data = DataFasilitas::create($validated);

            return response()->json([
                'message' => 'Data fasilitas berhasil disimpan.',
                'data' => $data,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, DataFasilitas $dataFasilitas)
    {
        try {
            $validated = $request->validate([
                'nama_fasilitas' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'kategori' => 'nullable|string|max:100',
                'jumlah' => 'required|integer|min:0',
                'status' => 'required|string|max:100',
            ]);

            $dataFasilitas->update($validated);

            return response()->json([
                'message' => 'Data fasilitas berhasil diperbarui.',
                'data' => $dataFasilitas,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(DataFasilitas $dataFasilitas)
    {
        $dataFasilitas->delete();
        return response()->json(['message' => 'Data fasilitas berhasil dihapus.']);
    }

    public function trash()
    {
        return DataFasilitas::onlyTrashed()->get();
    }

    public function restore($id)
    {
        $data = DataFasilitas::onlyTrashed()->find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $data->restore();
        return response()->json(['message' => 'Data fasilitas berhasil dipulihkan.']);
    }

    public function restoreMassal(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'Daftar ID tidak valid atau kosong.'], 400);
        }

        $restored = DataFasilitas::onlyTrashed()->whereIn('id', $ids)->update(['deleted_at' => null]);
        return response()->json(['message' => "Berhasil memulihkan {$restored} data fasilitas."]);
    }

    public function destroyMassal(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'Daftar ID tidak valid atau kosong.'], 400);
        }

        $deleted = DataFasilitas::whereIn('id', $ids)->delete();
        return response()->json(['message' => "Berhasil menghapus {$deleted} data fasilitas."]);
    }

    public function forceDelete($id)
    {
        $data = DataFasilitas::onlyTrashed()->find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);
        }

        $data->forceDelete();
        return response()->json(['message' => 'Data fasilitas berhasil dihapus permanen.']);
    }

    public function forceDeleteMassal(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'Daftar ID tidak valid atau kosong.'], 400);
        }

        $items = DataFasilitas::onlyTrashed()->whereIn('id', $ids)->get();
        foreach ($items as $item) {
            $item->forceDelete();
        }

        return response()->json(['message' => 'Data fasilitas berhasil dihapus permanen.']);
    }
}
