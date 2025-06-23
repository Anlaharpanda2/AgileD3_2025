<?php

namespace App\Http\Controllers\KelolaDataKonsultasi;

use App\Http\Controllers\Controller;
use App\Models\DataKonsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
                'nama_pelapor' => 'required|string|max:255',
                'nama_korban' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'alamat' => 'required|string',
                'waktu_kejadian' => 'required|date',
                'kasus' => 'required|string|max:255',
                'no_hp' => 'required|string|max:20',
                'saksi' => 'nullable|string|max:255',
                'status' => 'required|in:diproses,selesai',
                'lampiran' => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('lampiran')) {
                $validated['lampiran'] = $request->file('lampiran')->store('Konsultasi', 'public');
            }

            $data = DataKonsultasi::create($validated);

            return response()->json([
                'message' => 'Data Konsultasi berhasil disimpan.',
                'data' => $data,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, DataKonsultasi $dataKonsultasi)
    {
        try {
            $validated = $request->validate([
                'nama_pelapor' => 'required|string|max:255',
                'nama_korban' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'alamat' => 'required|string',
                'waktu_kejadian' => 'required|date',
                'kasus' => 'required|string|max:255',
                'no_hp' => 'required|string|max:20',
                'saksi' => 'nullable|string|max:255',
                'status' => 'required|in:diproses,selesai',
                'lampiran' => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('lampiran')) {
                if ($dataKonsultasi->getRawOriginal('lampiran')) {
                    Storage::disk('public')->delete($dataKonsultasi->getRawOriginal('lampiran'));
                }
                $validated['lampiran'] = $request->file('lampiran')->store('Konsultasi', 'public');
            }

            $dataKonsultasi->update($validated);

            return response()->json([
                'message' => 'Data berhasil diupdate',
                'data' => $dataKonsultasi,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(DataKonsultasi $dataKonsultasi)
    {
        $dataKonsultasi->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function trash()
    {
        return DataKonsultasi::onlyTrashed()->get();
    }

    public function restore($id)
    {
        $data = DataKonsultasi::onlyTrashed()->find($id);
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

        $restoredCount = DataKonsultasi::onlyTrashed()->whereIn('id', $ids)->update(['deleted_at' => null]);

        return response()->json(['message' => "Berhasil memulihkan {$restoredCount} data"]);
    }

    public function destroyMassal(Request $request)
    {
        $ids = $request->input('ids');
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['error' => 'Parameter ids tidak valid'], 422);
        }

        $deleted = DataKonsultasi::whereIn('id', $ids)->delete();
        return response()->json(['message' => "Berhasil menghapus {$deleted} data Konsultasi"]);
    }

    public function forceDelete($id)
    {
        $data = DataKonsultasi::onlyTrashed()->find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        if ($data->getRawOriginal('lampiran')) {
            Storage::disk('public')->delete($data->getRawOriginal('lampiran'));
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

        $items = DataKonsultasi::onlyTrashed()->whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->getRawOriginal('lampiran')) {
                Storage::disk('public')->delete($item->getRawOriginal('lampiran'));
            }
            $item->forceDelete();
        }

        return response()->json(['message' => 'Data berhasil dihapus permanen']);
    }
}