<?php

namespace App\Imports;

use App\Models\DataKonsultasi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class KonsultasiImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, SkipsEmptyRows
{
    public function model(array $row)
    {
        return new DataKonsultasi([
            'nik_pemohon' => $row['nik_pemohon'] ?? $row['nik'] ?? null,
            'nama_pemohon' => $row['nama_pemohon'] ?? $row['nama'] ?? null,
            'topik_konsultasi' => $row['topik_konsultasi'] ?? $row['topik'] ?? null,
            'jadwal_konsultasi' => $this->transformDate($row['jadwal_konsultasi'] ?? $row['jadwal'] ?? null),
            'status_konsultasi' => $row['status_konsultasi'] ?? $row['status'] ?? 'pending',
        ]);
    }

    public function headingRow(): int { return 1; }
    public function batchSize(): int { return 1000; }
    public function chunkSize(): int { return 1000; }

    private function transformDate($value)
    {
        if (!$value) return null;
        if (is_numeric($value)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
        }
        return date('Y-m-d', strtotime($value));
    }
}