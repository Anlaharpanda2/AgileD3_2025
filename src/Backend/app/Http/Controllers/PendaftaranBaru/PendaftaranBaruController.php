<?php

namespace App\Http\Controllers\PendaftaranBaru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftarBaru;

class PendaftaranBaruController extends Controller
{
    // Ambil data dengan pagination dan pencarian
    public function index(Request $request)
    {
        $query = PendaftarBaru::query();

        if ($request->search) {
            $query->where('peserta', 'like', "%{$request->search}%");
        }

        return response()->json($query->paginate(10));
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:pendaftar_baru,nik',
            'email' => 'required|email|unique:pendaftar_baru,email',
            'peserta' => 'required',
            // tambahkan validasi lain sesuai kebutuhan
        ]);

        $data = PendaftarBaru::create($request->all());
        return response()->json($data);
    }

    // Update data
    public function update(Request $request, $nik)
    {
        $data = PendaftarBaru::findOrFail($nik);

        $request->validate([
            'email' => 'required|email|unique:pendaftar_baru,email,' . $nik . ',nik',
            'peserta' => 'required',
            'alamat' => 'required'
            // validasi kolom lainnya jika perlu
        ]);

        $data->update($request->all());

        return response()->json(['message' => 'Data berhasil diupdate', 'data' => $data]);
    }


    // Hapus data
    public function destroy($nik)
    {
        $data = PendaftarBaru::where('nik', $nik)->firstOrFail();
        $data->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
    public function trash()
    {
        $data = PendaftarBaru::onlyTrashed()->get();
        return response()->json($data);
    }

    public function restore($nik)
    {
        $data = PendaftarBaru::onlyTrashed()->where('nik', $nik)->first();
        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->restore();
        return response()->json(['message' => 'Data berhasil dipulihkan']);
    }
    public function forceDelete($nik)
    {
        $data = PendaftarBaru::onlyTrashed()->where('nik', $nik)->first();

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data->forceDelete();
        return response()->json(['message' => 'Data berhasil dihapus permanen']);
    }

}
