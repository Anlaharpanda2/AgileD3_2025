<?php

namespace App\Http\Controllers\KelolaDataPelatihan;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PelatihanImport;
use App\Http\Controllers\Controller;

class ImporPelatihanController extends Controller
{
    public function impor(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            // Gunakan langsung dari UploadedFile tanpa getRealPath untuk performa
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
