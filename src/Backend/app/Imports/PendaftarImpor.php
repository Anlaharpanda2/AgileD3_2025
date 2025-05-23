<?php

namespace App\Imports;

use App\Models\ImporPendaftar;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log; // Pastikan untuk mengimpor kelas Log

class PendaftarImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Tambahkan logging untuk melihat data yang sedang diproses
        Log::info('Row data yang sedang diproses: ', $row);
        
        return new ImporPendaftar([
            'nik'                  => $row['nik'],
            'peserta'              => $row['peserta'],
            'tempat_tanggal_lahir' => $row['tempat_tanggal_lahir'],
            'jenis_kelamin'        => $row['jenis_kelamin'],
            'alamat'               => $row['alamat'],
            'pendidikan'           => $row['pendidikan'],
            'pekerjaan'            => $row['pekerjaan'],
            'email'                => $row['email'],
            'pelatihan'            => $row['pelatihan'],
            'tanggal_pelatihan'    => $row['tanggal_pelatihan'],
            'tempat_pelatihan'     => $row['tempat_pelatihan'],
        ]);
    }
}
