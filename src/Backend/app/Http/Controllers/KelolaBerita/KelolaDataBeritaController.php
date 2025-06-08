<?php

namespace App\Http\Controllers\KelolaBerita;

use App\Http\Controllers\Controller;
use App\Models\DataBerita;
use Illuminate\Http\Request;

class KelolaDataBeritaController extends Controller
{
    public function index()
    {
        return DataBerita::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'jenis_konten' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('berita_foto', 'public');
        }

        $berita = DataBerita::create($validated);

        return response()->json([
            'message' => 'Berita berhasil disimpan.',
            'data' => $berita
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $data = DataBerita::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'jenis_konten' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('berita_foto', 'public');
        }

        $data->update($validated);

        return response()->json([
            'message' => 'Berita berhasil diupdate',
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        $data = DataBerita::findOrFail($id);
        $data->delete();
        return response()->json(['message' => 'Berita berhasil dihapus']);
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

    public function trash()
    {
        $data = DataBerita::onlyTrashed()->get();
        return response()->json($data);
    }

    public function restore($id)
    {
        $data = DataBerita::onlyTrashed()->find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->restore();
        return response()->json(['message' => 'Berita berhasil dipulihkan']);
    }

    public function restoreMassal(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'Daftar ID tidak valid atau kosong'], 400);
        }

        $restoredCount = DataBerita::onlyTrashed()
            ->whereIn('id', $ids)
            ->restore();

        $msg = $restoredCount
            ? "Berhasil memulihkan $restoredCount data"
            : "Tidak ada data yang dipulihkan";

        return response()->json(['message' => $msg], 200);
    }

    public function forceDelete($id)
    {
        $data = DataBerita::onlyTrashed()->find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->forceDelete();
        return response()->json(['message' => 'Berita berhasil dihapus permanen']);
    }

    public function forceDeleteMassal(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'Daftar ID tidak valid atau kosong'], 400);
        }

        $deletedCount = DataBerita::onlyTrashed()
            ->whereIn('id', $ids)
            ->forceDelete();

        $msg = $deletedCount
            ? "Berhasil menghapus permanen $deletedCount data"
            : "Tidak ada data yang dihapus permanen";

        return response()->json(['message' => $msg], 200);
    }
}
