<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\Eselon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get eselons for reference
        $eselon1 = Eselon::where('kode', 'I')->first();
        $eselon2 = Eselon::where('kode', 'II')->first();
        $eselon3 = Eselon::where('kode', 'III')->first();
        $eselon4 = Eselon::where('kode', 'IV')->first();

        // Create parent jabatan
        $kepala = Jabatan::create([
            'nama_jabatan' => 'Kepala Dinas Pendidikan',
            'jenis_jabatan' => 'struktural',
            'eselon_id' => $eselon1->id,
            'parent_id' => null,
            'is_active' => true,
        ]);

        $wakil = Jabatan::create([
            'nama_jabatan' => 'Wakil Kepala Dinas',
            'jenis_jabatan' => 'struktural',
            'eselon_id' => $eselon2->id,
            'parent_id' => $kepala->id,
            'is_active' => true,
        ]);

        // Child jabatans
        Jabatan::create([
            'nama_jabatan' => 'Kepala Bidang Kurikulum',
            'jenis_jabatan' => 'struktural',
            'eselon_id' => $eselon2->id,
            'parent_id' => $kepala->id,
            'is_active' => true,
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Kepala Bidang Sarana Prasarana',
            'jenis_jabatan' => 'struktural',
            'eselon_id' => $eselon2->id,
            'parent_id' => $kepala->id,
            'is_active' => true,
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Kepala Bagian Administrasi',
            'jenis_jabatan' => 'struktural',
            'eselon_id' => $eselon2->id,
            'parent_id' => $kepala->id,
            'is_active' => true,
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Kepala Seksi Pengembangan Kurikulum',
            'jenis_jabatan' => 'struktural',
            'eselon_id' => $eselon3->id,
            'parent_id' => null,
            'is_active' => true,
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Analis Kebijakan Pendidikan',
            'jenis_jabatan' => 'fungsional',
            'eselon_id' => $eselon3->id,
            'parent_id' => null,
            'is_active' => true,
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Widyaiswara',
            'jenis_jabatan' => 'fungsional',
            'eselon_id' => $eselon3->id,
            'parent_id' => null,
            'is_active' => true,
        ]);

        Jabatan::create([
            'nama_jabatan' => 'Staf Administrasi',
            'jenis_jabatan' => 'non-struktural',
            'eselon_id' => $eselon4->id,
            'parent_id' => null,
            'is_active' => true,
        ]);
    }
}
