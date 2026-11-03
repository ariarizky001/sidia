<?php

namespace Database\Seeders;

use App\Models\Eselon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EselonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eselons = [
            [
                'kode' => 'I',
                'nama_eselon' => 'Eselon I',
                'deskripsi' => 'Tingkat Eselon I - Pimpinan Tertinggi',
                'status' => 'aktif',
            ],
            [
                'kode' => 'II',
                'nama_eselon' => 'Eselon II',
                'deskripsi' => 'Tingkat Eselon II - Pimpinan Menengah Atas',
                'status' => 'aktif',
            ],
            [
                'kode' => 'III',
                'nama_eselon' => 'Eselon III',
                'deskripsi' => 'Tingkat Eselon III - Pimpinan Menengah',
                'status' => 'aktif',
            ],
            [
                'kode' => 'IV',
                'nama_eselon' => 'Eselon IV',
                'deskripsi' => 'Tingkat Eselon IV - Pimpinan Rendah',
                'status' => 'aktif',
            ],
            [
                'kode' => 'V',
                'nama_eselon' => 'Eselon V',
                'deskripsi' => 'Tingkat Eselon V - Staf',
                'status' => 'aktif',
            ],
        ];

        foreach ($eselons as $eselon) {
            Eselon::create($eselon);
        }
    }
}
