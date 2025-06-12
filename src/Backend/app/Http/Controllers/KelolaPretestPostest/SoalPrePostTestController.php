<?php
    namespace App\Http\Controllers\KelolaPretestPostest;
    use App\Http\Controllers\Controller;
    use App\Models\SoalPrePostTest;
    use Illuminate\Http\Request;

class SoalPrePostTestController extends Controller
{
    public function index()
    {
        return SoalPrePostTest::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:pretest,postest',
            'pertanyaan' => 'required|string',
            'pilihan' => 'required|array',
            'jawaban_benar' => 'required|string',
        ]);

        return SoalPrePostTest::create([
            'jenis' => $request->jenis,
            'pertanyaan' => $request->pertanyaan,
            'pilihan' => json_encode($request->pilihan),
            'jawaban_benar' => $request->jawaban_benar,
        ]);
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
}
