<?php

namespace App\Http\Controllers\KelolaDataPendaftaran;

use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use Illuminate\Http\Request;

 class KelolaDataPendaftaranController extends Controller
 {
    public function index(){
        return DataPendaftaran::all();
    }
    
    public function store(Request $request)
    {
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
        $peserta = DataPendaftaran::create($validated);
        return response()->json([
            'message' => 'Data berhasil disimpan.',
            'data' => $peserta
        ], 201);
    }
    
    public function update(Request $request, $nik)
    {
        $data = DataPendaftaran::where('nik', $nik)->firstOrFail();
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
        $data = DataPendaftaran::where('nik', $nik)->firstOrFail();
        $data->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function destroyMassal(Request $request)
    {
        $niks = $request->input('niks');

        if (!is_array($niks) || empty($niks)) {
            return response()->json(['error' => 'Parameter niks tidak valid'], 422);
        }
        $deleted = DataPendaftaran::whereIn('nik', $niks)->delete();
        return response()->json([
            'message' => "Berhasil menghapus {$deleted} data Pendaftaran"
        ]);
    }

    public function trash()
    {
        $data = DataPendaftaran::onlyTrashed()->get();
        return response()->json($data);
    }

    public function restore($nik)
    {
        $data = DataPendaftaran::onlyTrashed()->where('nik', $nik)->first();
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
        $restoredCount = DataPendaftaran::onlyTrashed()
            ->whereIn('nik', $niks)
            ->update(['deleted_at' => null]);
        $msg = $restoredCount
            ? "Berhasil memulihkan $restoredCount data"
            : "Tidak ada data yang dipulihkan";
        return response()->json(['message' => $msg], 200);
    }

    public function forceDelete($nik)
    {
        $data = DataPendaftaran::onlyTrashed()->where('nik', $nik)->first();
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
        $deletedCount = DataPendaftaran::onlyTrashed()
            ->whereIn('nik', $niks)
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
            // Gunakan langsung dari UploadedFile tanpa getRealPath untuk performa
            Excel::import(new PendaftaranImport, $request->file('file'));

            return response()->json([
                'message' => 'Data Pendaftaran berhasil diimpor',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengimpor data: ' . $e->getMessage(),
            ], 500);
        }
    }
}