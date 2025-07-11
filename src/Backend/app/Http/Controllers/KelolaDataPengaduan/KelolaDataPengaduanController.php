<?php

namespace App\Http\Controllers\KelolaDataPengaduan;

use App\Http\Controllers\Controller;
use App\Models\DataPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class KelolaDataPengaduanController extends Controller
{
    public function index()
    {
        return DataPengaduan::all();
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
                $validated['lampiran'] = $request->file('lampiran')->store('pengaduan', 'public');
            }

            // Generate kode_pengaduan unik 6 digit
            do {
                $kode = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            } while (DataPengaduan::where('kode_pengaduan', $kode)->exists());

            $validated['kode_pengaduan'] = $kode;

            $data = DataPengaduan::create($validated);

            return response()->json([
                'message' => 'Data pengaduan berhasil disimpan.',
                'data' => $data,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, DataPengaduan $dataPengaduan)
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
                if ($dataPengaduan->getRawOriginal('lampiran')) {
                    Storage::disk('public')->delete($dataPengaduan->getRawOriginal('lampiran'));
                }
                $validated['lampiran'] = $request->file('lampiran')->store('pengaduan', 'public');
            }

            $dataPengaduan->update($validated);

            return response()->json([
                'message' => 'Data berhasil diupdate',
                'data' => $dataPengaduan,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(DataPengaduan $dataPengaduan)
    {
        $dataPengaduan->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function trash()
    {
        return DataPengaduan::onlyTrashed()->get();
    }

    public function restore($id)
    {
        $data = DataPengaduan::onlyTrashed()->find($id);
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

        $restoredCount = DataPengaduan::onlyTrashed()->whereIn('id', $ids)->update(['deleted_at' => null]);

        return response()->json(['message' => "Berhasil memulihkan {$restoredCount} data"]);
    }

    public function destroyMassal(Request $request)
    {
        $ids = $request->input('ids');
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['error' => 'Parameter ids tidak valid'], 422);
        }

        $deleted = DataPengaduan::whereIn('id', $ids)->delete();
        return response()->json(['message' => "Berhasil menghapus {$deleted} data pengaduan"]);
    }

    public function forceDelete($id)
    {
        $data = DataPengaduan::onlyTrashed()->find($id);
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

        $items = DataPengaduan::onlyTrashed()->whereIn('id', $ids)->get();
        foreach ($items as $item) {
            if ($item->getRawOriginal('lampiran')) {
                Storage::disk('public')->delete($item->getRawOriginal('lampiran'));
            }
            $item->forceDelete();
        }

        return response()->json(['message' => 'Data berhasil dihapus permanen']);
    }
    public function show($id)
    {
        $data = DataPengaduan::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json(['data' => $data]);
    }
    public function cariByKode(Request $request)
    {
        $request->validate([
            'kode_pengaduan' => 'required|string',
        ]);

        $kode = trim($request->kode_pengaduan);

        \Log::info("Masuk ke cariByKode. Input: " . $kode);

        $data = DataPengaduan::withTrashed()
            ->where('kode_pengaduan', $kode)
            ->first();

        if (!$data) {
            $semuaKode = DataPengaduan::withTrashed()->pluck('kode_pengaduan');
            \Log::warning("Kode tidak ditemukan: $kode");
            \Log::info("Semua kode_pengaduan: " . $semuaKode->join(', '));

            return response()->json([
                'message' => 'Pengaduan dengan kode tersebut tidak ditemukan',
                'debug_input' => $kode,
                'debug_kode_tersedia' => $semuaKode,
            ], 404);
        }

        return response()->json([
            'data' => $data
        ]);
    }

}