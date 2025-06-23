<?php
namespace App\Http\Controllers\Profile;
use Illuminate\Http\Request;
use App\Models\UserMasyarakat;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileMasyarakatController extends Controller
{
    public function show(string $nik)
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
    public function ubahFoto(Request $request, string $nik)
    {
        try {
            Log::info('Upload foto request:', [
                'method' => $request->method(),
                'has_file' => $request->hasFile('photo'),
                'files_info' => array_map(fn($file) => ['name' => $file->getClientOriginalName(), 'size' => $file->getSize()], $request->allFiles()),
                'all_data' => $request->all()
            ]);
            $validated = $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', 
            ]);
            $peserta = UserMasyarakat::where('nik', $nik)->first();
            if (!$peserta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data dengan NIK tersebut tidak ditemukan.'
                ], 404);
            }
            if ($peserta->photo && Storage::disk('public')->exists($peserta->photo)) {
                Storage::disk('public')->delete($peserta->photo);
            }
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('photos/peserta', $filename, 'public');
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
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Upload foto validasi error: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Upload foto error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server.',
                'debug' => app()->environment('local') ? $e->getMessage() : null
            ], 500);
        }
    }
}