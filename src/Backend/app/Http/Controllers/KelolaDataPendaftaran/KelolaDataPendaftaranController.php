<?php
namespace App\Http\Controllers\KelolaDataPendaftaran;
use App\Http\Controllers\Controller;
use App\Models\DataPendaftaran;
use App\Models\UserMasyarakat;
use App\Models\DataPelatihan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Imports\PendaftaranImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
    public function accept(Request $request, $id)
    {
        Log::info('Diterima dari frontend:', $request->all());

        $request->validate([
            'kegiatan_dimulai' => 'required|date',
            'kegiatan_berakhir' => 'required|date',
            'tempat_kegiatan' => 'required|string',
            'angkatan' => 'required|integer|min:1',
        ]);

        $pendaftar = DataPendaftaran::findOrFail($id);

        // Update status, keterangan, dan detail pelatihan ke user_masyarakat
        UserMasyarakat::where('nik', $pendaftar->nik)
            ->update([
                'status_pendaftaran' => 'Diterima',
                'keterangan' => 'Pendaftaran anda diterima, silahkan lihat tanggal kegiatan dimulai serta perhatikan informasi pada halaman berita dan pengumuman',
                'kegiatan_dimulai' => $request->kegiatan_dimulai,
                'kegiatan_berakhir' => $request->kegiatan_berakhir,
                'tempat_kegiatan' => $request->tempat_kegiatan,
                'angkatan' => $request->angkatan,
            ]);

        // Salin data ke pelatihan + tambahkan status_pendaftaran dan keterangan
        $pelatihanData = $pendaftar->toArray();
        $pelatihanData['kegiatan_dimulai'] = $request->kegiatan_dimulai;
        $pelatihanData['kegiatan_berakhir'] = $request->kegiatan_berakhir;
        $pelatihanData['tempat_kegiatan'] = $request->tempat_kegiatan;
        $pelatihanData['angkatan'] = $request->angkatan;
        $pelatihanData['status_pendaftaran'] = 'Diterima';
        $pelatihanData['keterangan'] = 'Pendaftaran anda diterima, silahkan lihat tanggal kegiatan dimulai serta perhatikan informasi pada halaman berita dan pengumuman';

        unset($pelatihanData['id'], $pelatihanData['created_at'], $pelatihanData['updated_at']);

        DataPelatihan::create($pelatihanData);
        $pendaftar->delete();

        return response()->json(['message' => 'Peserta diterima dan data telah dipindahkan.']);
    }

    public function acceptMassal(Request $request)
    {
        $dataList = $request->all();

        foreach ($dataList as $data) {
            $validated = Validator::make($data, [
                'id' => 'required|exists:data_pendaftaran,id',
                'kegiatan_dimulai' => 'required|date',
                'kegiatan_berakhir' => 'required|date',
                'tempat_kegiatan' => 'required|string',
                'angkatan' => 'required|integer|min:1',
            ])->validate();

            $pendaftar = DataPendaftaran::findOrFail($validated['id']);

            // Update status dan keterangan di user_masyarakat
            UserMasyarakat::where('nik', $pendaftar->nik)
                ->update([
                    'status_pendaftaran' => 'Diterima',
                    'keterangan' => 'Pendaftaran anda diterima, silahkan lihat tanggal kegiatan dimulai serta perhatikan informasi pada halaman berita dan pengumuman',
                    'kegiatan_dimulai' => $validated['kegiatan_dimulai'],
                    'kegiatan_berakhir' => $validated['kegiatan_berakhir'],
                    'tempat_kegiatan' => $validated['tempat_kegiatan'],
                    'angkatan' => $validated['angkatan'],
                ]);

            $pelatihanData = array_merge($pendaftar->toArray(), [
                'kegiatan_dimulai' => $validated['kegiatan_dimulai'],
                'kegiatan_berakhir' => $validated['kegiatan_berakhir'],
                'tempat_kegiatan' => $validated['tempat_kegiatan'],
                'angkatan' => $validated['angkatan'],
                'status_pendaftaran' => 'Diterima',
                'keterangan' => 'Pendaftaran anda diterima, silahkan lihat tanggal kegiatan dimulai serta perhatikan informasi pada halaman berita dan pengumuman',
            ]);

            unset($pelatihanData['id'], $pelatihanData['created_at'], $pelatihanData['updated_at']);

            DataPelatihan::create($pelatihanData);
            $pendaftar->delete();
        }

        return response()->json(['message' => 'Data berhasil diproses dan dipindahkan.']);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
        ]);
        $pendaftar = DataPendaftaran::findOrFail($id);
        $keterangan = $request->input('keterangan');
        UserMasyarakat::where('nik', $pendaftar->nik)
            ->update([
                'status_pendaftaran' => 'Ditolak',
                'keterangan' => $keterangan
            ]);
        $pendaftar->delete();
        return response()->json([
            'message' => 'Peserta ditolak, data dihapus, dan keterangan disimpan.'
        ]);
    }

public function rejectMassal(Request $request)
{
    $niks = $request->input('niks', []);
    $keterangan = $request->input('keterangan', '');

    Log::info('Reject Massal Diterima:', ['niks' => $niks, 'keterangan' => $keterangan]);

    if (!is_array($niks) || empty($niks)) {
        return response()->json(['message' => 'Daftar NIK tidak valid atau kosong.'], 422);
    }

    // Debug jika tidak ada yang cocok
    $users = UserMasyarakat::whereIn('nik', $niks)->get();
    if ($users->isEmpty()) {
        Log::error('Tidak ada user_masyarakat yang cocok');
        return response()->json(['message' => 'Tidak ada pengguna yang ditemukan dengan NIK tersebut.'], 404);
    }

    UserMasyarakat::whereIn('nik', $niks)
        ->update([
            'status_pendaftaran' => 'Ditolak',
            'keterangan' => $keterangan
        ]);

    $deletedCount = DataPendaftaran::whereIn('nik', $niks)->delete();

    return response()->json([
        'message' => "Berhasil menolak {$deletedCount} peserta dan menyimpan keterangan."
    ]);
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
    public function show($id)
    {
        $data = DataPendaftaran::find($id);
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
    public function ubahFoto(Request $request, $id)
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
            $pendaftar = DataPendaftaran::findOrFail($id);
            if ($pendaftar->photo && Storage::disk('public')->exists($pendaftar->photo)) {
                Storage::disk('public')->delete($pendaftar->photo);
            }
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('photos/pendaftar', $filename, 'public');
            $pendaftar->update([
                'photo' => $path
            ]);
            $pendaftar->refresh();
            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil diperbarui.',
                'data' => [
                    'photo_url' => $pendaftar->photo_url,
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
