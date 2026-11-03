<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Level 1 - Induk (Dinas)
        $dinasyamobi = UnitKerja::create([
            'nama' => 'Dinas Yamobil',
            'level' => 1,
            'parent_id' => null,
        ]);

        $dinasPend = UnitKerja::create([
            'nama' => 'Dinas Pendidikan',
            'level' => 1,
            'parent_id' => null,
        ]);

        // Level 2 - Korwil/Bidang untuk Dinas Pendidikan
        $korwilJawaBarat = UnitKerja::create([
            'nama' => 'Korwil Jawa Barat',
            'level' => 2,
            'parent_id' => $dinasPend->id,
        ]);

        $korwilJawaTengah = UnitKerja::create([
            'nama' => 'Korwil Jawa Tengah',
            'level' => 2,
            'parent_id' => $dinasPend->id,
        ]);

        $bidangData = UnitKerja::create([
            'nama' => 'Bidang Data dan Informasi',
            'level' => 2,
            'parent_id' => $dinasPend->id,
        ]);

        // Level 3 - Sekolah/Seksi untuk Korwil Jawa Barat
        UnitKerja::create([
            'nama' => 'SMA Negeri 1 Bandung',
            'level' => 3,
            'parent_id' => $korwilJawaBarat->id,
        ]);

        UnitKerja::create([
            'nama' => 'SMA Negeri 2 Bandung',
            'level' => 3,
            'parent_id' => $korwilJawaBarat->id,
        ]);

        UnitKerja::create([
            'nama' => 'SMP Negeri 1 Bandung',
            'level' => 3,
            'parent_id' => $korwilJawaBarat->id,
        ]);

        // Level 3 - Sekolah/Seksi untuk Korwil Jawa Tengah
        UnitKerja::create([
            'nama' => 'SMA Negeri 1 Semarang',
            'level' => 3,
            'parent_id' => $korwilJawaTengah->id,
        ]);

        UnitKerja::create([
            'nama' => 'SMA Negeri 2 Semarang',
            'level' => 3,
            'parent_id' => $korwilJawaTengah->id,
        ]);

        // Level 3 - Seksi untuk Bidang Data
        UnitKerja::create([
            'nama' => 'Seksi Analisis Data',
            'level' => 3,
            'parent_id' => $bidangData->id,
        ]);

        UnitKerja::create([
            'nama' => 'Seksi Infrastruktur IT',
            'level' => 3,
            'parent_id' => $bidangData->id,
        ]);
    }
}
