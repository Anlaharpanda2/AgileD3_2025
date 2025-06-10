<?php

namespace App\Http\Controllers\KelolaDataPelatihan;

use App\Http\Controllers\Controller;
use App\Models\DataPelatihan;
use Illuminate\Http\Request;

 class KelolaDataPelatihanController extends Controller
 {
    public function index(){
        return DataPelatihan::all();
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'jenis_bimtek' => 'required|string|max:255',
            'kegiatan_dimulai' => 'required|date',
            'kegiatan_berakhir' => 'required|date',
            'tempat_kegiatan' => 'required|string|max:255',
            'angkatan' => 'required|integer|min:1',
            'tempat_tanggal_lahir' => 'required|string|max:255',
            'pendidikan' => 'required|string|max:255',
            'status' => 'required|in:kawin,lajang,janda',
            'alamat' => 'required|string',
            'jenis_usaha' => 'required|string|max:255',
            'penghasilan_perbulan' => 'required|string|max:255',
            'nomor_telefon' => 'required|string|max:255',
        ]);
        $peserta = DataPelatihan::create($validated);
        return response()->json([
            'message' => 'Data berhasil disimpan.',
            'data' => $peserta
        ], 201);
    }
    
    public function update(Request $request, $nik)
    {
        $data = DataPelatihan::where('nik', $nik)->firstOrFail();
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'jenis_bimtek' => 'required|string|max:255',
            'tanggal_kegiatan_dimulai' => 'required|date',
            'tanggal_kegiatan_berakhir' => 'required|date',
            'tempat_kegiatan' => 'required|string|max:255',
            'angkatan' => 'required|integer|min:1',
            'tempat_tanggal_lahir' => 'required|string|max:255',
            'pendidikan' => 'required|string|max:255',
            'status' => 'required|in:kawin,lajang,janda',
            'alamat' => 'required|string',
            'jenis_usaha' => 'required|string|max:255',
            'penghasilan_perbulan' => 'required|string|max:255',
            'nomor_telefon' => 'required|string|max:255',
        ]);
        $data->update($validated);

        return response()->json([
            'message' => 'Data berhasil diupdate',
            'data' => $data,
        ]);
    }

    public function destroy($nik)
    {
        $data = DataPelatihan::where('nik', $nik)->firstOrFail();
        $data->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function destroyMassal(Request $request)
    {
        $niks = $request->input('niks');

        if (!is_array($niks) || empty($niks)) {
            return response()->json(['error' => 'Parameter niks tidak valid'], 422);
        }
        $deleted = DataPelatihan::whereIn('nik', $niks)->delete();
        return response()->json([
            'message' => "Berhasil menghapus {$deleted} data Pelatihan"
        ]);
    }

    public function trash()
    {
        $data = DataPelatihan::onlyTrashed()->get();
        return response()->json($data);
    }

    public function restore($nik)
    {
        $data = DataPelatihan::onlyTrashed()->where('nik', $nik)->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        $data->restore();
        return response()->json(['message' => 'Data berhasil dipulihkan']);
    }

    public function restoreMassal(Request $request)
    {
        $niks = $request->input('niks', []);
        if (!is_array($niks) || empty($niks)) {
            return response()->json(['message' => 'Daftar NIK tidak valid atau kosong'], 400);
        }
        $restoredCount = DataPelatihan::onlyTrashed()
            ->whereIn('nik', $niks)
            ->update(['deleted_at' => null]);
        $msg = $restoredCount
            ? "Berhasil memulihkan $restoredCount data"
            : "Tidak ada data yang dipulihkan";
        return response()->json(['message' => $msg], 200);
    }

    public function forceDelete($nik)
    {
        $data = DataPelatihan::onlyTrashed()->where('nik', $nik)->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }
        $data->forceDelete();
        return response()->json(['message' => 'Data berhasil dihapus permanen']);
    }

    public function forceDeleteMassal(Request $request)
    {
        $niks = $request->input('niks', []);
        if (!is_array($niks) || empty($niks)) {
            return response()
                ->json(['message' => 'Daftar NIK tidak valid atau kosong'], 400);
        }
        $deletedCount = DataPelatihan::onlyTrashed()
            ->whereIn('nik', $niks)
            ->forceDelete(); 
        $msg = $deletedCount
            ? "Berhasil menghapus permanen $deletedCount data"
            : "Tidak ada data yang dihapus permanen";

        return response()->json(['message' => $msg], 200);
    }
}