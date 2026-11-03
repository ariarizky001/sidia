<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\JenisUnit;

class UnitKerjaJenisSeeder extends Seeder
{
    public function run(): void
    {
        echo "\n=== MULAI KATEGORISASI UNIT KERJA (dengan ID) ===\n\n";

        // Get jenis unit IDs
        $jenisIds = [
            'dinas' => JenisUnit::where('kode', 'dinas')->value('id'),
            'bidang' => JenisUnit::where('kode', 'bidang')->value('id'),
            'koordinator_wilayah' => JenisUnit::where('kode', 'koordinator_wilayah')->value('id'),
            'kelompok_smp' => JenisUnit::where('kode', 'kelompok_smp')->value('id'),
            'kelompok_tk' => JenisUnit::where('kode', 'kelompok_tk')->value('id'),
            'seksi' => JenisUnit::where('kode', 'seksi')->value('id'),
            'sekolah_sd' => JenisUnit::where('kode', 'sekolah_sd')->value('id'),
            'sekolah_smp' => JenisUnit::where('kode', 'sekolah_smp')->value('id'),
            'sekolah_tk' => JenisUnit::where('kode', 'sekolah_tk')->value('id'),
        ];

        // LEVEL 1: Dinas
        $updated = DB::table('unit_kerjas')
            ->where('level', 1)
            ->update(['jenis_unit_id' => $jenisIds['dinas']]);
        echo "✓ Level 1 (Dinas): {$updated} unit\n";

        // LEVEL 2: Bidang/Struktural (berdasarkan ID yang kita ketahui)
        $updated = DB::table('unit_kerjas')
            ->where('level', 2)
            ->whereIn('id', [2, 4, 8, 11, 14, 18, 22])
            ->update(['jenis_unit_id' => $jenisIds['bidang']]);
        echo "✓ Level 2 (Bidang/Struktural): {$updated} unit\n";

        // LEVEL 2: Koordinator Wilayah (untuk SD)
        $updated = DB::table('unit_kerjas')
            ->where('level', 2)
            ->where('nama', 'like', 'KOORDINATOR WILAYAH%')
            ->update(['jenis_unit_id' => $jenisIds['koordinator_wilayah']]);
        echo "✓ Level 2 (Koordinator Wilayah SD): {$updated} unit\n";

        // LEVEL 2: Kelompok SMP
        $updated = DB::table('unit_kerjas')
            ->where('level', 2)
            ->whereIn('id', [24, 349])
            ->update(['jenis_unit_id' => $jenisIds['kelompok_smp']]);
        echo "✓ Level 2 (Kelompok SMP): {$updated} unit\n";

        // LEVEL 2: Kelompok TK
        $updated = DB::table('unit_kerjas')
            ->where('level', 2)
            ->where('id', 76)
            ->update(['jenis_unit_id' => $jenisIds['kelompok_tk']]);
        echo "✓ Level 2 (Kelompok TK): {$updated} unit\n";

        // LEVEL 3: Seksi/Sub Bagian (di dalam bidang)
        $updated = DB::table('unit_kerjas')
            ->where('level', 3)
            ->where(function ($query) {
                $query->where('nama', 'like', 'SEKSI%')
                    ->orWhere('nama', 'like', 'SUB BAGIAN%')
                    ->orWhere('nama', 'like', 'KOORDINATOR WILAYAH%')
                    ->orWhereIn('parent_id', [2, 4, 8, 11, 14, 18, 22]);
            })
            ->update(['jenis_unit_id' => $jenisIds['seksi']]);
        echo "✓ Level 3 (Seksi/Sub Bagian): {$updated} unit\n";

        // LEVEL 3: Sekolah TK
        $updated = DB::table('unit_kerjas')
            ->where('level', 3)
            ->where(function ($query) {
                $query->where('nama', 'like', 'TK %')
                    ->orWhere('nama', 'like', 'RA %')
                    ->orWhere('nama', 'like', 'BA %')
                    ->orWhere('parent_id', 76);
            })
            ->whereNull('jenis_unit_id')
            ->update(['jenis_unit_id' => $jenisIds['sekolah_tk']]);
        echo "✓ Level 3 (Sekolah TK): {$updated} sekolah\n";

        // LEVEL 3: Sekolah SMP
        $updated = DB::table('unit_kerjas')
            ->where('level', 3)
            ->where(function ($query) {
                $query->where('nama', 'like', 'SMP%')
                    ->orWhere('nama', 'like', 'SMPIT%')
                    ->orWhereIn('parent_id', [24, 349]);
            })
            ->whereNull('jenis_unit_id')
            ->update(['jenis_unit_id' => $jenisIds['sekolah_smp']]);
        echo "✓ Level 3 (Sekolah SMP): {$updated} sekolah\n";

        // LEVEL 3: Sekolah SD (sisanya yang belum terisi)
        $updated = DB::table('unit_kerjas')
            ->where('level', 3)
            ->where(function ($query) {
                $query->where('nama', 'like', 'SDN%')
                    ->orWhere('nama', 'like', 'TKN%')
                    ->orWhere('nama', 'like', 'SD %');
            })
            ->whereNull('jenis_unit_id')
            ->update(['jenis_unit_id' => $jenisIds['sekolah_sd']]);
        echo "✓ Level 3 (Sekolah SD): {$updated} sekolah\n";

        // Verifikasi hasil
        echo "\n=== HASIL KATEGORISASI ===\n";
        $counts = DB::table('unit_kerjas')
            ->join('jenis_units', 'unit_kerjas.jenis_unit_id', '=', 'jenis_units.id')
            ->select('jenis_units.nama', DB::raw('count(*) as total'))
            ->groupBy('jenis_units.nama')
            ->orderBy('total', 'desc')
            ->get();

        foreach ($counts as $row) {
            echo "{$row->nama}: {$row->total} unit\n";
        }

        echo "\n=== SELESAI ===\n\n";
    }
}
