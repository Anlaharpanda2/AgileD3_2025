<?php
namespace App\Http\Controllers\kelolaDataTest;
use App\Http\Controllers\Controller;
use App\Models\DataTest;
use Illuminate\Http\Request;
class KelolaDataTestController extends Controller
{
    public function index(Request $request)
    {
        $query = DataTest::query();
        if ($request->has('tipe')) {
            $query->where('tipe', $request->tipe); 
        }
        if ($request->has('kelompok_soal')) {
            $query->where('kelompok_soal', $request->kelompok_soal);
        }
        return response()->json($query->orderBy('nomor_soal')->get());
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kelompok_soal' => 'required|string|max:100',
            'tipe' => 'required|in:pretest,posttest',
            'soal_list' => 'required|array|min:1',
            'soal_list.*.soal' => 'required|string',
            'soal_list.*.opsi_a' => 'required|string',
            'soal_list.*.opsi_b' => 'required|string',
            'soal_list.*.opsi_c' => 'required|string',
            'soal_list.*.opsi_d' => 'required|string',
            'soal_list.*.jawaban_benar' => 'required|in:a,b,c,d',
            'soal_list.*.kategori' => 'nullable|string|max:100',
            'soal_list.*.nomor_soal' => 'required|integer',
        ]);

        $created = [];

        foreach ($validatedData['soal_list'] as $soal) {
            $created[] = DataTest::create([
                'soal' => $soal['soal'],
                'tipe' => $validatedData['tipe'],
                'opsi_a' => $soal['opsi_a'],
                'opsi_b' => $soal['opsi_b'],
                'opsi_c' => $soal['opsi_c'],
                'opsi_d' => $soal['opsi_d'],
                'jawaban_benar' => $soal['jawaban_benar'],
                'kategori' => $soal['kategori'] ?? null,
                'nomor_soal' => $soal['nomor_soal'],
                'kelompok_soal' => $validatedData['kelompok_soal'],
            ]);
        }

        return response()->json([
            'message' => count($created) . ' soal berhasil disimpan.',
            'data' => $created,
        ], 201);
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'kelompok_soal' => 'required|string|max:100',
            'tipe' => 'required|in:pretest,posttest',
            'soal_list' => 'required|array|min:1',
            'soal_list.*.soal' => 'required|string',
            'soal_list.*.opsi_a' => 'required|string',
            'soal_list.*.opsi_b' => 'required|string',
            'soal_list.*.opsi_c' => 'required|string',
            'soal_list.*.opsi_d' => 'required|string',
            'soal_list.*.jawaban_benar' => 'required|in:a,b,c,d',
            'soal_list.*.kategori' => 'nullable|string|max:100',
            'soal_list.*.nomor_soal' => 'required|integer',
        ]);

        // Hapus soal lama dalam kelompok
        DataTest::where('kelompok_soal', $validatedData['kelompok_soal'])
            ->where('tipe', $validatedData['tipe'])
            ->delete();

        $updated = [];

        // Simpan soal-soal baru
        foreach ($validatedData['soal_list'] as $soal) {
            $updated[] = DataTest::create([
                'soal' => $soal['soal'],
                'tipe' => $validatedData['tipe'],
                'opsi_a' => $soal['opsi_a'],
                'opsi_b' => $soal['opsi_b'],
                'opsi_c' => $soal['opsi_c'],
                'opsi_d' => $soal['opsi_d'],
                'jawaban_benar' => $soal['jawaban_benar'],
                'kategori' => $soal['kategori'] ?? null,
                'nomor_soal' => $soal['nomor_soal'],
                'kelompok_soal' => $validatedData['kelompok_soal'],
            ]);
        }

        return response()->json([
            'message' => 'Soal pada kelompok ' . $validatedData['kelompok_soal'] . ' berhasil diperbarui.',
            'data' => $updated,
        ]);
    }
    public function destroy($id)
    {
        $soal = DataTest::find($id);

        if (!$soal) {
            return response()->json(['message' => 'Soal tidak ditemukan'], 404);
        }

        $soal->delete();

        return response()->json(['message' => 'Soal berhasil dihapus']);
    }
    public function massDestroy(Request $request)
    {
        $request->validate([
            'kelompok_soal' => 'required|string|max:100',
            'tipe' => 'required|in:pretest,posttest',
        ]);

        $deleted = DataTest::where('kelompok_soal', $request->kelompok_soal)
            ->where('tipe', $request->tipe)
            ->delete();

        return response()->json([
            'message' => "Berhasil menghapus $deleted soal dari kelompok '{$request->kelompok_soal}'"
        ]);
    }

}
