<?php

namespace App\Imports;

use App\Models\DataPanitia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class PanitiaImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, SkipsEmptyRows
{
    public function model(array $row)
    {
        return new DataPanitia([
            'nama_panitia' => $row['nama_panitia'] ?? $row['nama'] ?? null,
            'jabatan_panitia' => $row['jabatan_panitia'] ?? $row['jabatan'] ?? null,
            'kontak_panitia' => $row['kontak_panitia'] ?? $row['kontak'] ?? null,
        ]);
    }

    public function headingRow(): int { return 1; }
    public function batchSize(): int { return 1000; }
    public function chunkSize(): int { return 1000; }
}