<?php
namespace App\Http\Controllers\KelolaDataPendaftaran;
use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\DataPelatihan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Imports\PendaftaranImport;
use Maatwebsite\Excel\Facades\Excel;
class KelolaDataPendaftaranController extends Controller
{
    /**
     * Menampilkan semua data pendaftar
     */
    public function index()
    {
        return response()->json(DataPendaftaran::all());
    }
    /**
     * Menambah data pendaftar
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:255|unique:data_pendaftaran,nik',
            'email' => 'nullable|email|max:255',
            'telepon' => 'nullable|string|max:20',
        ]);
        $pendaftar = DataPendaftaran::create($validated);
        return response()->json([
            'message' => 'Data pendaftar berhasil disimpan.',
            'data' => $pendaftar
        ], 201);
    }
    /**
     * Menerima peserta pendaftar tunggal
     */
    public function accept($id)
    {
        $pendaftar = DataPendaftaran::findOrFail($id);
        $pelatihanData = $pendaftar->toArray();
        unset($pelatihanData['id'], $pelatihanData['created_at'], $pelatihanData['updated_at']);
        DataPelatihan::create($pelatihanData);
        $pendaftar->delete();
        return response()->json(['message' => 'Peserta diterima dan data telah dipindahkan.']);
    }
    /**
     * Menerima peserta pendaftar secara massal
     */
    public function acceptMassal(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'Daftar ID tidak valid atau kosong.'], 422);
        }
        $pendaftarList = DataPendaftaran::whereIn('id', $ids)->get();
        foreach ($pendaftarList as $pendaftar) {
            $data = $pendaftar->toArray();
            unset($data['id'], $data['created_at'], $data['updated_at']);
            DataPelatihan::create($data);
            $pendaftar->delete();
        }
        return response()->json(['message' => 'Peserta massal berhasil diterima.']);
    }
    /**
     * Menolak peserta pendaftar tunggal
     */
    public function reject($id)
    {
        $pendaftar = DataPendaftaran::findOrFail($id);
        $pendaftar->delete();
        return response()->json(['message' => 'Peserta ditolak dan data dihapus.']);
    }
    /**
     * Menolak peserta pendaftar secara massal
     */
    public function rejectMassal(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'Daftar ID tidak valid atau kosong.'], 422);
        }
        $deletedCount = DataPendaftaran::whereIn('id', $ids)->delete();
        return response()->json([ 'message' => "Berhasil menolak {$deletedCount} peserta." ]);
    }
    /**
     * Mengimpor data pendaftar dari file Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);
        try {
            Excel::import(new PendaftaranImport, $request->file('file'));
            return response()->json([
                'message' => 'Data pendaftar berhasil diimpor.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengimpor data: ' . $e->getMessage()
            ], 500);
        }
    }
}
