<?php

namespace Database\Seeders;

use App\Models\FormasiJabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormasiJabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formasiJabatans = [
            [
                'nama_formasi' => 'Formasi Kepala Dinas',
                'jenis_jabatan' => 'struktural',
                'kategori' => 'Pimpinan',
                'is_active' => true,
            ],
            [
                'nama_formasi' => 'Formasi Wakil Kepala Dinas',
                'jenis_jabatan' => 'struktural',
                'kategori' => 'Pimpinan',
                'is_active' => true,
            ],
            [
                'nama_formasi' => 'Formasi Kepala Bidang',
                'jenis_jabatan' => 'struktural',
                'kategori' => 'Kepemimpinan Menengah',
                'is_active' => true,
            ],
            [
                'nama_formasi' => 'Formasi Kepala Seksi',
                'jenis_jabatan' => 'struktural',
                'kategori' => 'Kepemimpinan Rendah',
                'is_active' => true,
            ],
            [
                'nama_formasi' => 'Formasi Analis',
                'jenis_jabatan' => 'fungsional',
                'kategori' => 'Pelaksana Khusus',
                'is_active' => true,
            ],
            [
                'nama_formasi' => 'Formasi Pengawas',
                'jenis_jabatan' => 'fungsional',
                'kategori' => 'Pelaksana Khusus',
                'is_active' => true,
            ],
            [
                'nama_formasi' => 'Formasi Widyaiswara',
                'jenis_jabatan' => 'fungsional',
                'kategori' => 'Pelaksana Khusus',
                'is_active' => true,
            ],
            [
                'nama_formasi' => 'Formasi Staf Administrasi',
                'jenis_jabatan' => 'non-struktural',
                'kategori' => 'Pelaksana',
                'is_active' => true,
            ],
            [
                'nama_formasi' => 'Formasi Operator',
                'jenis_jabatan' => 'non-struktural',
                'kategori' => 'Pelaksana',
                'is_active' => true,
            ],
            [
                'nama_formasi' => 'Formasi Sopir',
                'jenis_jabatan' => 'non-struktural',
                'kategori' => 'Dukungan',
                'is_active' => true,
            ],
        ];

        foreach ($formasiJabatans as $formasi) {
            FormasiJabatan::create($formasi);
        }
    }
}
