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

            // Tambahkan nilai default untuk status_pendaftaran dan keterangan
            $extra = [
                'status_pendaftaran' => 'Diterima',
                'keterangan' => 'Pendaftaran anda diterima, silahkan lihat tanggal kegiatan dimulai serta perhatikan informasi pada halaman berita dan pengumuman',
            ];

            $fullData = array_merge($validated, $extra);

            // Simpan ke data_pelatihan
            $peserta = DataPelatihan::create($fullData);

            // Simpan juga ke users_masyarakat
            UserMasyarakat::create(array_merge($fullData, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));

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

        $nikLama = $dataPelatihan->nik;

        // Update data_pelatihan
        $dataPelatihan->update($validated);

        // Update juga users_masyarakat berdasarkan nik lama
        UserMasyarakat::where('nik', $nikLama)->update([
            'nama' => $validated['nama'],
            'nik' => $validated['nik'], // pastikan nik juga ikut diupdate di sini
            'photo' => $dataPelatihan->photo,
            'jenis_bimtek' => $validated['jenis_bimtek'],
            'kegiatan_dimulai' => $validated['kegiatan_dimulai'],
            'kegiatan_berakhir' => $validated['kegiatan_berakhir'],
            'tempat_kegiatan' => $validated['tempat_kegiatan'],
            'angkatan' => $validated['angkatan'],
            'tempat_tanggal_lahir' => $validated['tempat_tanggal_lahir'],
            'pendidikan' => $validated['pendidikan'],
            'status' => $validated['status'],
            'alamat' => $validated['alamat'],
            'jenis_usaha' => $validated['jenis_usaha'],
            'penghasilan_perbulan' => $validated['penghasilan_perbulan'],
            'nomor_telefon' => $validated['nomor_telefon'],
            'updated_at' => now(),
        ]);

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
}