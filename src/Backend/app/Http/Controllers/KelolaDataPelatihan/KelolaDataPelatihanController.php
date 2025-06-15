<?php

namespace App\Http\Controllers\KelolaDataPelatihan;

use App\Http\Controllers\Controller;
use App\Models\DataPelatihan;
use App\Models\UserMasyarakat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\imports\PelatihanImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class KelolaDataPelatihanController extends Controller
{
    public function index()
    {
        return DataPelatihan::all();
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'nik' => 'required|string|max:255|unique:data_pelatihan,nik',
                'jenis_bimtek' => 'required|string|max:255',
                'kegiatan_dimulai' => 'required|date',
                'kegiatan_berakhir' => 'required|date|after_or_equal:kegiatan_dimulai',
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            if (isset($e->errors()['nik'])) {
                return response()->json(['message' => 'NIK sudah terdaftar.', 'errors' => $e->errors()], 422);
            }
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }
    public function update(Request $request, DataPelatihan $dataPelatihan)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'nik' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('data_pelatihan', 'nik')->ignore($dataPelatihan->id),
                ],
                'jenis_bimtek' => 'required|string|max:255',
                'kegiatan_dimulai' => 'required|date',
                'kegiatan_berakhir' => 'required|date|after_or_equal:kegiatan_dimulai',
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
            $dataPelatihan->update($validated);
            return response()->json([
                'message' => 'Data berhasil diupdate',
                'data' => $dataPelatihan,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if (isset($e->errors()['nik'])) {
                return response()->json(['message' => 'NIK sudah terdaftar.', 'errors' => $e->errors()], 422);
            }
            return response()->json(['message' => 'Validasi gagal.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }
    public function destroy(DataPelatihan $dataPelatihan)
    {
        $dataPelatihan->delete();
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
    public function restore($id)
    {
        $data = DataPelatihan::onlyTrashed()->find($id);
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
    public function forceDelete($id)
    {
        $data = DataPelatihan::onlyTrashed()->find($id);
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
    public function impor(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new PelatihanImport, $request->file('file'));

            return response()->json([
                'message' => 'Data pelatihan berhasil diimpor',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengimpor data: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function show($nik)
    {
        $data = UserMasyarakat::where('nik', $nik)->first();

        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data ditemukan',
            'data' => $data
        ]);
    }

   public function ubahFoto(Request $request, $nik)
{
    try {
        \Log::info('Upload request:', [
            'method' => $request->method(),
            'has_file' => $request->hasFile('photo'),
            'files' => $request->allFiles(),
            'all_data' => $request->all()
        ]);

        if (!$request->hasFile('photo')) {
            return response()->json([
                'message' => 'File tidak terkirim.',
                'debug' => [
                    'method' => $request->method(),
                    'content_type' => $request->header('Content-Type'),
                    'all_data' => $request->all(),
                    'files' => $request->allFiles()
                ]
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Cari peserta berdasarkan nik
        $peserta = UserMasyarakat::where('nik', $nik)->first();

        if (!$peserta) {
            return response()->json([
                'success' => false,
                'message' => 'Data dengan NIK tersebut tidak ditemukan.'
            ], 404);
        }

        // Hapus foto lama jika ada
        if ($peserta->photo && Storage::disk('public')->exists($peserta->photo)) {
            Storage::disk('public')->delete($peserta->photo);
        }

        // Upload foto baru
        $file = $request->file('photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('photos/peserta', $filename, 'public');

        // Update data
        $peserta->update([
            'photo' => $path
        ]);

        $peserta->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Foto berhasil diperbarui.',
            'data' => [
                'photo_url' => $peserta->photo_url,
                'photo_path' => $path
            ]
        ], 200);

    } catch (\Exception $e) {
        \Log::error('Upload photo error: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan server.',
            'debug' => app()->environment('local') ? $e->getMessage() : []
        ], 500);
    }
}

}