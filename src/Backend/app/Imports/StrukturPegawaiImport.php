<?php

namespace App\Imports;

use App\Models\StrukturPegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class StrukturPegawaiImport implements
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
        return new StrukturPegawai([
            'idPegawai' => $row['idpegawai'] ?? $row['IDPEGAWAI'] ?? $row['id_pegawai'] ?? null,
            'nama' => $row['nama'] ?? $row['Nama'] ?? $row['NAMA'] ?? null,
            'alamat' => $row['alamat'] ?? $row['Alamat'] ?? $row['ALAMAT'] ?? null,
            'email' => $row['email'] ?? $row['Email'] ?? $row['EMAIL'] ?? null,
            'jabatan' => $row['jabatan'] ?? $row['Jabatan'] ?? $row['JABATAN'] ?? null,
            'noHp' => $row['nohp'] ?? $row['no_hp'] ?? $row['NoHp'] ?? $row['No_Hp'] ?? null,
            'status' => $row['status'] ?? $row['Status'] ?? $row['STATUS'] ?? null,
        ]);
    }
}
