<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PendaftarImport;
use Illuminate\Support\Facades\Log; // Import kelas Log

class ImporPendaftarController extends Controller
{
    /**
     * Unggah dan impor file Excel ke tabel pendaftar.
     */
    public function impor(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls',
    ]);

    try {
        Excel::import(new PendaftarImport, $request->file('file'));
        return response()->json(['message' => 'Data pendaftar berhasil diimpor'], 200);
    } catch (\Exception $e) {
        // Log kesalahan untuk debugging lebih lanjut
        Log::error('Error saat mengimpor data Excel: ' . $e->getMessage(), [
            'file' => $request->file('file')->getClientOriginalName(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);
        return response()->json(['error' => 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage()], 500); // Sertakan pesan error
    }
}

}