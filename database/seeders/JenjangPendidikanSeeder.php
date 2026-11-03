<?php

namespace Database\Seeders;

use App\Models\JenjangPendidikan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenjangPendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode' => 'S1',
                'nama_jenjang' => 'Sarjana',
                'deskripsi' => 'Pendidikan Sarjana (Strata 1)',
                'status' => 'aktif',
            ],
            [
                'kode' => 'S2',
                'nama_jenjang' => 'Magister',
                'deskripsi' => 'Pendidikan Magister (Strata 2)',
                'status' => 'aktif',
            ],
            [
                'kode' => 'S3',
                'nama_jenjang' => 'Doktor',
                'deskripsi' => 'Pendidikan Doktor (Strata 3)',
                'status' => 'aktif',
            ],
            [
                'kode' => 'D1',
                'nama_jenjang' => 'Diploma Satu',
                'deskripsi' => 'Pendidikan Diploma Satu',
                'status' => 'aktif',
            ],
            [
                'kode' => 'D2',
                'nama_jenjang' => 'Diploma Dua',
                'deskripsi' => 'Pendidikan Diploma Dua',
                'status' => 'aktif',
            ],
            [
                'kode' => 'D3',
                'nama_jenjang' => 'Diploma Tiga',
                'deskripsi' => 'Pendidikan Diploma Tiga',
                'status' => 'aktif',
            ],
            [
                'kode' => 'D4',
                'nama_jenjang' => 'Diploma Empat',
                'deskripsi' => 'Pendidikan Diploma Empat',
                'status' => 'aktif',
            ],
            [
                'kode' => 'SMA',
                'nama_jenjang' => 'Sekolah Menengah Atas',
                'deskripsi' => 'Pendidikan Sekolah Menengah Atas',
                'status' => 'aktif',
            ],
            [
                'kode' => 'SMK',
                'nama_jenjang' => 'Sekolah Menengah Kejuruan',
                'deskripsi' => 'Pendidikan Sekolah Menengah Kejuruan',
                'status' => 'aktif',
            ],
        ];

        foreach ($data as $item) {
            JenjangPendidikan::firstOrCreate(
                ['kode' => $item['kode']],
                $item
            );
        }
    }
}
