<?php

namespace App\Imports;

use App\Models\DataKonsultasi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class KonsultasiImport implements 
    ToModel, 
    WithHeadingRow, 
    WithBatchInserts, 
    WithChunkReading, 
    SkipsEmptyRows
{
    public function headingRow(): int
    {
        return 1;
    }

    public function batchSize(): int
    {
        return 1000; 
    }

    public function chunkSize(): int
    {
        return 1000; 
    }

    public function model(array $row)
    {
        return new DataKonsultasi([
            'alamat' => $row['alamat'] ?? null,
            'deskripsi_data_konsultasi' => $row['deskripsi_data_konsultasi'] ?? null,
            'id_konsultasi' => $row['id_konsultasi'] ?? null,
            'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
            'kasus' => $row['kasus'] ?? null,
            'nama' => $row['nama'] ?? null,
            'nama_korban' => $row['nama_korban'] ?? null,
            'no_hp' => $row['no_hp'] ?? null,
            'saksi' => $row['saksi'] ?? null,
            'status' => $row['status'] ?? null,
            'umur' => $row['umur'] ?? null,
        ]);
    }
}
