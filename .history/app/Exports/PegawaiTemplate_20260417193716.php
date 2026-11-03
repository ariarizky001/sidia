<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PegawaiTemplate implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            [
                '12345678901234',
                'AHMAD SURIANTO',
                '1990-05-15',
                'I/a',
                'Kepala Bagian',
                'S1',
                'PNS',
                'Dinas Pendidikan',
                null,
                null,
                '2020-01-01',
                '2022-06-01',
                2012,
                'Kepala Bagian',
                null,
                null,
                'aktif',
            ],
            [
                '12345678901235',
                'SITI NURHALIZA',
                '1992-08-22',
                'II/b',
                'Staf Administrasi',
                'S1',
                'PNS',
                'Dinas Kesehatan',
                null,
                null,
                '2021-03-01',
                '2022-12-01',
                2014,
                'Staf Administrasi',
                null,
                null,
                'aktif',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'nip',
            'nama_lengkap',
            'tgl_lahir',
            'golongan',
            'jabatan',
            'pendidikan',
            'status_asn',
            'unit_kerja_satu',
            'pensiun',
            'bup',
            'tmt_golongan',
            'tmt_jabatan',
            'thn_lulus',
            'formasi_jabatan',
            'unit_kerja_2',
            'unit_kerja_3',
            'status_aktif',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            ],
        ];
    }
}
