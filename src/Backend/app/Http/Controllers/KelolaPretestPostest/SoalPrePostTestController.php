<?php
    namespace App\Http\Controllers\KelolaPretestPostest;
    use App\Http\Controllers\Controller;
    use App\Models\SoalPrePostTest;
    use Illuminate\Http\Request;

class SoalPrePostTestController extends Controller
{
   public function index()
{
    return response()->json(SoalPrePostTest::all(), 200);
}

    public function store(Request $request)
    {
    try {
        // Validasi input
        $validated = $request->validate([
            'jenis' => 'required|in:pretest,postest',
            'pertanyaan' => 'required|string',
            'pilihan' => 'required|array',
            'jawaban_benar' => 'required|string',
        ]);

        // Simpan data ke database
        $soal = SoalPrePostTest::create([
            'jenis' => $validated['jenis'],
            'pertanyaan' => $validated['pertanyaan'],
            'pilihan' => json_encode($validated['pilihan']),
            'jawaban_benar' => $validated['jawaban_benar'],
        ]);

        return response()->json([
            'message' => 'Soal berhasil disimpan',
            'data' => $soal
        ], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Jika validasi gagal
        return response()->json([
            'message' => 'Validasi gagal',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        // Jika terjadi error umum lainnya
        return response()->json([
            'message' => 'Terjadi kesalahan saat menyimpan soal',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function destroy($id)
    {
        $soal = SoalPrePostTest::find($id);

        if (!$soal) {
            return response()->json(['message' => 'Soal tidak ditemukan'], 404);
        }

        $soal->delete();

        return response()->json(['message' => 'Soal berhasil dihapus']);
    }

    public function update(Request $request, $id)
{
    try {
        $validated = $request->validate([
            'jenis' => 'required|in:pretest,postest',
            'pertanyaan' => 'required|string',
            'pilihan' => 'required|array',
            'jawaban_benar' => 'required|string',
        ]);

        $soal = SoalPrePostTest::findOrFail($id);

        $soal->update([
            'jenis' => $validated['jenis'],
            'pertanyaan' => $validated['pertanyaan'],
            'pilihan' => json_encode($validated['pilihan']),
            'jawaban_benar' => $validated['jawaban_benar'],
        ]);

        return response()->json([
            'message' => 'Soal berhasil diperbarui',
            'data' => $soal
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'message' => 'Validasi gagal',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Terjadi kesalahan saat memperbarui soal',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
