<?php

namespace App\Http\Controllers\KelolaBerita;

use App\Http\Controllers\Controller;
use App\Models\DataBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BeritaImport;

class KelolaDataBeritaController extends Controller
{
    public function index()
    {
        return DataBerita::all();
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'isi' => 'required|string',
                'jenis_konten' => 'nullable|string|max:255',
                'foto' => 'nullable|image|max:2048', // max 2MB
            ]);

            if ($request->hasFile('foto')) {
                $validated['foto'] = $request->file('foto')->store('berita', 'public');
            }

            $dataBerita = DataBerita::create($validated);

            return response()->json([
                'message' => 'Data berita berhasil disimpan.',
                'data' => $dataBerita,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, DataBerita $dataBerita)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'isi' => 'required|string',
                'jenis_konten' => 'nullable|string|max:255',
                'foto' => 'nullable|image|max:2048',
            ]);

            if ($request->hasFile('foto')) {
                // Hapus foto lama kalau ada
                if ($dataBerita->getRawOriginal('foto')) {
                    Storage::disk('public')->delete($dataBerita->getRawOriginal('foto'));
                }
                $validated['foto'] = $request->file('foto')->store('berita', 'public');
            }

            $dataBerita->update($validated);

            return response()->json([
                'message' => 'Data berhasil diupdate',
                'data' => $dataBerita,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(DataBerita $dataBerita)
    {
        $dataBerita->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function trash()
    {
        return DataBerita::onlyTrashed()->get();
    }

    public function restore($id)
    {
        $data = DataBerita::onlyTrashed()->find($id);
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

        $restoredCount = DataBerita::onlyTrashed()
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

        $deleted = DataBerita::whereIn('id', $ids)->delete();
        return response()->json([
            'message' => "Berhasil menghapus {$deleted} data berita"
        ]);
    }

    public function forceDelete($id)
    {
        $data = DataBerita::onlyTrashed()->find($id);
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

        $items = DataBerita::onlyTrashed()->whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->getRawOriginal('foto')) {
                Storage::disk('public')->delete($item->getRawOriginal('foto'));
            }
            $item->forceDelete();
        }

        return response()->json(['message' => 'Data berhasil dihapus permanen']);
    }
    Public function show($id)
    {
        $dataBerita = DataBerita::find($id);

        if (! $dataBerita) {
            return response()->json([
                'message' => 'Data berita tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data berita ditemukan',
            'data'    => $dataBerita
        ], 200);
    }
}
