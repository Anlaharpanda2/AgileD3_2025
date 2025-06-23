<?php

namespace App\Http\Controllers\KelolaDataPanitia;

use App\Http\Controllers\Controller;
use App\Models\DataPanitia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelolaDataPanitiaController extends Controller
{
    public function index()
    {
        return DataPanitia::all();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email|unique:data_panitia,email',
                'jabatan' => 'required|string|max:255',
                'nama_panitia' => 'required|string|max:255',
                'no_hp' => 'required|string|max:20',
                'foto' => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('foto')) {
                $validated['foto'] = $request->file('foto')->store('panitia', 'public');
            }

            $dataPanitia = DataPanitia::create($validated);

            return response()->json([
                'message' => 'Data panitia berhasil disimpan.',
                'data' => $dataPanitia,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, DataPanitia $dataPanitia)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email|unique:data_panitia,email,' . $dataPanitia->id,
                'jabatan' => 'required|string|max:255',
                'nama_panitia' => 'required|string|max:255',
                'no_hp' => 'required|string|max:20',
                'foto' => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('foto')) {
                if ($dataPanitia->getRawOriginal('foto')) {
                    Storage::disk('public')->delete($dataPanitia->getRawOriginal('foto'));
                }
                $validated['foto'] = $request->file('foto')->store('panitia', 'public');
            }

            $dataPanitia->update($validated);

            return response()->json([
                'message' => 'Data berhasil diupdate',
                'data' => $dataPanitia,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(DataPanitia $dataPanitia)
    {
        $dataPanitia->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function trash()
    {
        return DataPanitia::onlyTrashed()->get();
    }

    public function restore($id)
    {
        $data = DataPanitia::onlyTrashed()->find($id);
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

        $restoredCount = DataPanitia::onlyTrashed()
            ->whereIn('id', $ids)
            ->update(['deleted_at' => null]);

        return response()->json([
            'message' => "Berhasil memulihkan {$restoredCount} data"
        ]);
    }

    public function destroyMassal(Request $request)
    {
        $ids = $request->input('ids');
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['error' => 'Parameter ids tidak valid'], 422);
        }

        $deleted = DataPanitia::whereIn('id', $ids)->delete();
        return response()->json([
            'message' => "Berhasil menghapus {$deleted} data panitia"
        ]);
    }

    public function forceDelete($id)
    {
        $data = DataPanitia::onlyTrashed()->find($id);
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        if ($data->getRawOriginal('foto')) {
            Storage::disk('public')->delete($data->getRawOriginal('foto'));
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

        $items = DataPanitia::onlyTrashed()->whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->getRawOriginal('foto')) {
                Storage::disk('public')->delete($item->getRawOriginal('foto'));
            }
            $item->forceDelete();
        }

        return response()->json(['message' => 'Data berhasil dihapus permanen']);
    }
}