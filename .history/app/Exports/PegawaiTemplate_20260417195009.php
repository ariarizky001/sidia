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
                '198401162011011009',
                'REHATTA RAKASIWI, S.Psi., M.Si.',
                '16-01-1984',
                'III/d',
                'KEPALA SEKSI GURU DAN TENAGA KEPENDIDIKAN SMP',
                'PASCA SARJANA (S2)',
                'PNS',
                'DINAS PENDIDIKAN DAN KEBUDAYAAN',
                '01/02/2042',
                null,
                '01-04-2023',
                '01-02-2023',
                2019,
                'ANALIS KEPEGAWAIAN - AHLI',
                'BIDANG SEKOLAH MENENGAH PERTAMA',
                'SEKSI GURU DAN TENAGA KEPENDIDIKAN SMP',
                'aktif',
            ],
            [
                '197805051995121001',
                'SARI WULANDARI, S.Pd.',
                '05-08-1978',
                'III/a',
                'GURU MATEMATIKA SMP',
                'S1',
                'PNS',
                'DINAS PENDIDIKAN DAN KEBUDAYAAN',
                '05/08/2040',
                null,
                '01-03-2020',
                '01-03-2020',
                2000,
                'GURU MATEMATIKA',
                'BIDANG SEKOLAH MENENGAH PERTAMA',
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
