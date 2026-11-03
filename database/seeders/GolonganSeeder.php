<?php

namespace Database\Seeders;

use App\Models\Golongan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode' => 'I/a',
                'nama_golongan' => 'Juru Muda Tingkat I',
                'urutan' => 1,
                'deskripsi' => 'Golongan I/a - Juru Muda Tingkat I',
                'status' => 'aktif',
            ],
            [
                'kode' => 'I/b',
                'nama_golongan' => 'Juru Muda',
                'urutan' => 2,
                'deskripsi' => 'Golongan I/b - Juru Muda',
                'status' => 'aktif',
            ],
            [
                'kode' => 'I/c',
                'nama_golongan' => 'Juru',
                'urutan' => 3,
                'deskripsi' => 'Golongan I/c - Juru',
                'status' => 'aktif',
            ],
            [
                'kode' => 'I/d',
                'nama_golongan' => 'Juru Tingkat I',
                'urutan' => 4,
                'deskripsi' => 'Golongan I/d - Juru Tingkat I',
                'status' => 'aktif',
            ],
            [
                'kode' => 'II/a',
                'nama_golongan' => 'Pengatur Muda Tingkat I',
                'urutan' => 5,
                'deskripsi' => 'Golongan II/a - Pengatur Muda Tingkat I',
                'status' => 'aktif',
            ],
            [
                'kode' => 'II/b',
                'nama_golongan' => 'Pengatur Muda',
                'urutan' => 6,
                'deskripsi' => 'Golongan II/b - Pengatur Muda',
                'status' => 'aktif',
            ],
            [
                'kode' => 'II/c',
                'nama_golongan' => 'Pengatur',
                'urutan' => 7,
                'deskripsi' => 'Golongan II/c - Pengatur',
                'status' => 'aktif',
            ],
            [
                'kode' => 'II/d',
                'nama_golongan' => 'Pengatur Tingkat I',
                'urutan' => 8,
                'deskripsi' => 'Golongan II/d - Pengatur Tingkat I',
                'status' => 'aktif',
            ],
            [
                'kode' => 'III/a',
                'nama_golongan' => 'Penata Muda Tingkat I',
                'urutan' => 9,
                'deskripsi' => 'Golongan III/a - Penata Muda Tingkat I',
                'status' => 'aktif',
            ],
            [
                'kode' => 'III/b',
                'nama_golongan' => 'Penata Muda',
                'urutan' => 10,
                'deskripsi' => 'Golongan III/b - Penata Muda',
                'status' => 'aktif',
            ],
            [
                'kode' => 'III/c',
                'nama_golongan' => 'Penata',
                'urutan' => 11,
                'deskripsi' => 'Golongan III/c - Penata',
                'status' => 'aktif',
            ],
            [
                'kode' => 'III/d',
                'nama_golongan' => 'Penata Tingkat I',
                'urutan' => 12,
                'deskripsi' => 'Golongan III/d - Penata Tingkat I',
                'status' => 'aktif',
            ],
            [
                'kode' => 'IV/a',
                'nama_golongan' => 'Pembina Tingkat I',
                'urutan' => 13,
                'deskripsi' => 'Golongan IV/a - Pembina Tingkat I',
                'status' => 'aktif',
            ],
            [
                'kode' => 'IV/b',
                'nama_golongan' => 'Pembina',
                'urutan' => 14,
                'deskripsi' => 'Golongan IV/b - Pembina',
                'status' => 'aktif',
            ],
            [
                'kode' => 'IV/c',
                'nama_golongan' => 'Pembina Utama Muda',
                'urutan' => 15,
                'deskripsi' => 'Golongan IV/c - Pembina Utama Muda',
                'status' => 'aktif',
            ],
            [
                'kode' => 'IV/d',
                'nama_golongan' => 'Pembina Utama',
                'urutan' => 16,
                'deskripsi' => 'Golongan IV/d - Pembina Utama',
                'status' => 'aktif',
            ],
            [
                'kode' => 'IV/e',
                'nama_golongan' => 'Pembina Utama Madya',
                'urutan' => 17,
                'deskripsi' => 'Golongan IV/e - Pembina Utama Madya',
                'status' => 'aktif',
            ],
        ];

        foreach ($data as $item) {
            Golongan::firstOrCreate(
                ['kode' => $item['kode']],
                $item
            );
        }
    }
}
