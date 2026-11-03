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
                '196902061992032004',
                'ENY DWI SURYANI, S.H., M.M.',
                '06-02-1969',
                '01/03/2027',
                '58',
                'IV/a',
                '01-04-2017',
                'SEKRETARIS',
                '01-01-2026',
                'III/a',
                '01-03-1992',
                'PASCA SARJANA (S2)',
                2010,
                'PNS',
                'PEJABAT PEMBUAT KOMITMEN',
                'DINAS PENDIDIKAN DAN KEBUDAYAAN',
                'SEKRETARIAT',
                'SEKRETARIAT',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'NIP',
            'NAMA_LENGKAP',
            'TGL_LAHIR',
            'Pensiun',
            'BUP',
            'GOL',
            'TMT_GOL',
            'JABATAN',
            'TMT_JABATAN',
            'ESL',
            'TMT_CPNS',
            'PENDIDIKAN',
            'THN_LULUS',
            'STATUS_ASN',
            'FORMASI_JABATAN',
            'UNIT_KERJA_1',
            'UNIT_KERJA_2',
            'UNIT_KERJA_3',
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
