<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisUnit;

class JenisUnitSeeder extends Seeder
{
    public function run(): void
    {
        $jenisUnits = [
            [
                'id' => 1,
                'kode' => 'dinas',
                'nama' => 'Dinas',
                'deskripsi' => 'Dinas/Instansi Utama',
                'level' => 1,
                'is_sekolah' => false,
            ],
            [
                'id' => 2,
                'kode' => 'bidang',
                'nama' => 'Bidang',
                'deskripsi' => 'Bidang/Sekretariat/UPTD',
                'level' => 2,
                'is_sekolah' => false,
            ],
            [
                'id' => 3,
                'kode' => 'koordinator_wilayah',
                'nama' => 'Koordinator Wilayah',
                'deskripsi' => 'Koordinator Wilayah Kecamatan (untuk SD)',
                'level' => 2,
                'is_sekolah' => false,
            ],
            [
                'id' => 4,
                'kode' => 'kelompok_smp',
                'nama' => 'Kelompok SMP',
                'deskripsi' => 'Kelompok SMP',
                'level' => 2,
                'is_sekolah' => false,
            ],
            [
                'id' => 5,
                'kode' => 'kelompok_tk',
                'nama' => 'Kelompok TK',
                'deskripsi' => 'Kelompok TK',
                'level' => 2,
                'is_sekolah' => false,
            ],
            [
                'id' => 6,
                'kode' => 'seksi',
                'nama' => 'Seksi',
                'deskripsi' => 'Seksi/Sub Bagian',
                'level' => 3,
                'is_sekolah' => false,
            ],
            [
                'id' => 7,
                'kode' => 'sekolah_sd',
                'nama' => 'Sekolah Dasar',
                'deskripsi' => 'SD/SDN',
                'level' => 3,
                'is_sekolah' => true,
            ],
            [
                'id' => 8,
                'kode' => 'sekolah_smp',
                'nama' => 'Sekolah Menengah Pertama',
                'deskripsi' => 'SMP/SMPN',
                'level' => 3,
                'is_sekolah' => true,
            ],
            [
                'id' => 9,
                'kode' => 'sekolah_tk',
                'nama' => 'Taman Kanak-Kanak',
                'deskripsi' => 'TK/RA/BA',
                'level' => 3,
                'is_sekolah' => true,
            ],
        ];

        foreach ($jenisUnits as $jenis) {
            JenisUnit::updateOrCreate(
                ['kode' => $jenis['kode']],
                $jenis
            );
        }

        echo "\n✓ Seeded " . count($jenisUnits) . " jenis unit\n";
    }
}
