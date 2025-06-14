<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\DataPelatihan;
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
        return new DataPelatihan([
            'nama' => $row['nama'] ?? $row['Nama'] ?? $row['NAMA'] ?? null,
            'nik' => $row['nik'] ?? $row['NIK'] ?? null,
            'jenis_bimtek' => $row['jenis_bimtek'] ?? $row['Jenis_Bimtek'] ?? $row['jenis bimtek'] ?? $row['Jenis Bimtek'] ?? $row['JENIS BIMTEK'] ?? null,
            'kegiatan_dimulai' => $row['kegiatan_dimulai'] ?? $row['Kegiatan_Dimulai'] ?? $row['kegiatan dimulai'] ?? $row['Kegiatan Dimulai'] ?? null,
            'kegiatan_berakhir' => $row['kegiatan_berakhir'] ?? $row['Kegiatan_Berakhir'] ?? $row['kegiatan berakhir'] ?? $row['Kegiatan Berakhir'] ?? null,
            'tempat_kegiatan' => $row['tempat_kegiatan'] ?? $row['Tempat_Kegiatan'] ?? $row['tempat kegiatan'] ?? $row['Tempat Kegiatan'] ?? null,
            'angkatan' => $row['angkatan'] ?? $row['Angkatan'] ?? $row['ANGKATAN'] ?? null,
            'tempat_tanggal_lahir' => $row['tempat_tanggal_lahir'] ?? $row['Tempat_Tanggal_Lahir'] ?? $row['tempat tanggal lahir'] ?? $row['Tempat Tanggal Lahir'] ?? $row['TTL'] ?? null,
            'pendidikan' => $row['pendidikan'] ?? $row['Pendidikan'] ?? null,
            'status' => $row['status'] ?? $row['Status'] ?? null,
            'alamat' => $row['alamat'] ?? $row['Alamat'] ?? null,
            'jenis_usaha' => $row['jenis_usaha'] ?? $row['Jenis_Usaha'] ?? $row['jenis usaha'] ?? $row['Jenis Usaha'] ?? null,
            'penghasilan_perbulan' => $row['penghasilan_perbulan'] ?? $row['Penghasilan_Perbulan'] ?? $row['penghasilan perbulan'] ?? $row['Penghasilan Perbulan'] ?? null,
            'nomor_telefon' => $row['no._telp'] ?? $row['no_telp'] ?? $row['no telp'] ?? null,
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
