<?php

namespace App\Imports;

use App\Models\ImportPelatihan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class PelatihanImport implements 
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
        return 1000; // Tingkatkan jika server cukup kuat
    }

    public function chunkSize(): int
    {
        return 1000; // Sesuaikan dengan memori dan ukuran file
    }

    public function model(array $row)
    {
        // Hapus logging demi performa
        return new ImportPelatihan([
            'nama'                      => $row['nama'],
            'nik'                       => $row['nik'],
            'jenis_bimtek'              => $row['jenis_bimtek'],
            'tanggal_kegiatan_dimulai'  => $this->transformDate($row['tanggal_kegiatan_dimulai']),
            'tanggal_kegiatan_berakhir' => $this->transformDate($row['tanggal_kegiatan_berakhir']),
            'tempat_kegiatan'           => $row['tempat_kegiatan'],
            'angkatan'                  => $row['angkatan'],
            'tempat_tanggal_lahir'      => $row['tempat_tanggal_lahir'],
            'pendidikan'                => $row['pendidikan'],
            'status'                    => $row['status'],
            'alamat'                    => $row['alamat'],
            'jenis_usaha'               => $row['jenis_usaha'],
            'penghasilan_perbulan'      => $row['penghasilan_perbulan'],
            'nomor_telefon'             => $row['nomor_telefon'],
        ]);
    }

    private function transformDate($value)
    {
        if (is_numeric($value)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
        }

        return date('Y-m-d', strtotime($value));
    }
}
