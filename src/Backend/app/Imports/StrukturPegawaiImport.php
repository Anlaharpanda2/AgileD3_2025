<?php

namespace App\Imports;

use App\Models\StrukturPegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class StrukturPegawaiImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, SkipsEmptyRows
{
    public function model(array $row)
    {
        return new StrukturPegawai([
            'nama' => $row['nama'] ?? null,
            'jabatan' => $row['jabatan'] ?? null,
            'bidang' => $row['bidang'] ?? null,
        ]);
    }

    public function headingRow(): int { return 1; }
    public function batchSize(): int { return 1000; }
    public function chunkSize(): int { return 1000; }
}