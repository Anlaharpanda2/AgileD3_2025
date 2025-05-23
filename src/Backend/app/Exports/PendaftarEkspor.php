<?php

namespace App\Exports;

use App\Models\Pendaftar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;

class PendaftarEkspor extends DefaultValueBinder implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithCustomValueBinder
{
    public function collection()
    {
        // Pilih kolom yang akan diekspor
        return Pendaftar::select([
            'nik',
            'peserta',
            'tempat_tanggal_lahir',
            'jenis_kelamin',
            'alamat',
            'pendidikan',
            'pekerjaan',
            'email',
            'pelatihan',
            'tanggal_pelatihan',
            'tempat_pelatihan',
        ])->get();
    }

    /**
     * Tentukan header kolom di Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'nik',
            'peserta',
            'tempat_tanggal_lahir',
            'jenis_kelamin',
            'alamat',
            'pendidikan',
            'pekerjaan',
            'email',
            'pelatihan',
            'tanggal_pelatihan',
            'tempat_pelatihan'
        ];
    }
    
    /**
     * Map data untuk tiap baris.
     *
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            // Pastikan NIK dikonversi ke string
            (string) $row->nik,
            $row->peserta,
            $row->tempat_tanggal_lahir,
            $row->jenis_kelamin,
            $row->alamat,
            $row->pendidikan,
            $row->pekerjaan,
            $row->email,
            $row->pelatihan,
            $row->tanggal_pelatihan,
            $row->tempat_pelatihan,
        ];
    }
    
    /**
     * Define custom format untuk kolom tertentu.
     *
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // Kolom A adalah NIK
        ];
    }
    
    /**
     * Bind value secara custom untuk NIK
     *
     * @param Cell $cell
     * @param mixed $value
     * @return bool
     */
    public function bindValue(Cell $cell, $value)
    {
        // Jika kolom adalah kolom A (NIK) dan bukan header
        if ($cell->getColumn() === 'A' && $cell->getRow() > 1) {
            // Paksa nilai sebagai string
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        // Untuk kolom lainnya, gunakan binding default
        return parent::bindValue($cell, $value);
    }
}