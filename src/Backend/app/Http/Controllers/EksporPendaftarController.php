<?php

namespace App\Http\Controllers;

use App\Exports\PendaftarEkspor;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class EksporPendaftarController extends Controller
{
    /**
     * Download file Excel berisi data pendaftar.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function ekspor()
    {
        // Langsung lakukan proses download tanpa pengecekan canExport()
        return Excel::download(new PendaftarEkspor, 'daftar_pendaftar.xlsx');
    }
}
