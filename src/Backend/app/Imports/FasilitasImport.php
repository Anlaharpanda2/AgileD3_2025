<?php

namespace App\Imports;

use App\Models\DataFasilitas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class FasilitasImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, SkipsEmptyRows
{
    public function model(array $row)
    {
        return new DataFasilitas([
            'nama_fasilitas' => $row['nama_fasilitas'] ?? $row['nama'] ?? null,
            'deskripsi_fasilitas' => $row['deskripsi_fasilitas'] ?? $row['deskripsi'] ?? null,
            'lokasi_fasilitas' => $row['lokasi_fasilitas'] ?? $row['lokasi'] ?? null,
        ]);
    }

    public function headingRow(): int { return 1; }
    public function batchSize(): int { return 1000; }
    public function chunkSize(): int { return 1000; }
}