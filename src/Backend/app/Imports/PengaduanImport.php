<?php

namespace App\Imports;

use App\Models\DataPengaduan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class PengaduanImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading, SkipsEmptyRows
{
    public function model(array $row)
    {
        return new DataPengaduan([
            'nik_pengadu' => $row['nik_pengadu'] ?? $row['nik'] ?? null,
            'nama_pengadu' => $row['nama_pengadu'] ?? $row['nama'] ?? null,
            'judul_pengaduan' => $row['judul_pengaduan'] ?? $row['judul'] ?? null,
            'isi_pengaduan' => $row['isi_pengaduan'] ?? $row['isi'] ?? null,
            'tanggal_pengaduan' => $this->transformDate($row['tanggal_pengaduan'] ?? $row['tanggal'] ?? null),
            'status_pengaduan' => $row['status_pengaduan'] ?? $row['status'] ?? 'pending',
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