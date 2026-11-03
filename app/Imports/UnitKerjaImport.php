<?php

namespace App\Imports;

use App\Models\UnitKerja;
use App\Models\JenisUnit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Log;

class UnitKerjaImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    public $row = 0;
    public $failures = [];
    private $createdUnits = []; // Cache untuk unit yang baru dibuat
    private $jenisCache = [];   // Cache untuk jenis unit

    public function model(array $row)
    {
        $this->row++;

        // Get normalized column names (handle both uppercase and lowercase)
        $uk1 = $row['unit_kerja_1'] ?? $row['UNIT_KERJA_1'] ?? $row['unit kerja 1'] ?? null;
        $uk2 = $row['unit_kerja_2'] ?? $row['UNIT_KERJA_2'] ?? $row['unit kerja 2'] ?? null;
        $uk3 = $row['unit_kerja_3'] ?? $row['UNIT_KERJA_3'] ?? $row['unit kerja 3'] ?? null;

        // Validate at least level 1 is present
        if (empty($uk1)) {
            throw new \Exception('Kolom UNIT_KERJA_1 wajib diisi');
        }

        // Process the hierarchy
        $uk1Name = trim($uk1);
        $level1 = $this->findOrCreateUnit($uk1Name, null, 1);

        // If only level 1, return it
        if (empty($uk2)) {
            return $level1;
        }

        // Process level 2
        $uk2Name = trim($uk2);
        $level2 = $this->findOrCreateUnit($uk2Name, $level1->id, 2);

        // If only level 2, return it
        if (empty($uk3)) {
            return $level2;
        }

        // Process level 3
        $uk3Name = trim($uk3);
        $level3 = $this->findOrCreateUnit($uk3Name, $level2->id, 3);

        return $level3;
    }

    private function findOrCreateUnit($nama, $parentId = null, $level = 1)
    {
        // First check if exists in cache (created in this import)
        $cacheKey = $nama . '_' . ($parentId ?? 'null');
        if (isset($this->createdUnits[$cacheKey])) {
            return $this->createdUnits[$cacheKey];
        }

        // Check if exists in database
        $existing = UnitKerja::where('nama', $nama);
        if ($parentId) {
            $existing->where('parent_id', $parentId);
        } else {
            $existing->whereNull('parent_id');
        }
        $existing = $existing->first();

        // Tentukan jenis unit otomatis berdasarkan level & pola nama
        $jenisUnitId = $this->detectJenisUnit($nama, $level, $parentId);

        if ($existing) {
            // Update jenis unit jika belum ada
            if (!$existing->jenis_unit_id && $jenisUnitId) {
                $existing->update(['jenis_unit_id' => $jenisUnitId]);
            }
            $this->createdUnits[$cacheKey] = $existing;
            return $existing;
        }

        // Create new unit
        $unit = UnitKerja::create([
            'nama' => $nama,
            'parent_id' => $parentId,
            'level' => $level,
            'jenis_unit_id' => $jenisUnitId,
        ]);

        $this->createdUnits[$cacheKey] = $unit;
        return $unit;
    }

    /**
     * Deteksi jenis unit otomatis berdasarkan level dan pola nama
     */
    private function detectJenisUnit($nama, $level, $parentId = null)
    {
        $upper = strtoupper($nama);

        // LEVEL 1: selalu Dinas
        if ($level == 1) {
            return $this->getJenisId('dinas');
        }

        // LEVEL 2
        if ($level == 2) {
            if (str_contains($upper, 'KOORDINATOR WILAYAH')) {
                return $this->getJenisId('koordinator_wilayah');
            }
            if (str_contains($upper, 'TK') || str_contains($upper, 'PAUD')) {
                return $this->getJenisId('kelompok_tk');
            }
            if (str_contains($upper, 'SMP')) {
                return $this->getJenisId('kelompok_smp');
            }
            // Jika level 2 tapi bukan di atas, kemungkinan bidang/struktural
            return $this->getJenisId('bidang');
        }

        // LEVEL 3
        if ($level == 3) {
            if (str_starts_with($upper, 'SDN') || str_starts_with($upper, 'SD ') || str_starts_with($upper, 'TKN')) {
                return $this->getJenisId('sekolah_sd');
            }
            if (str_starts_with($upper, 'SMP') || str_starts_with($upper, 'SMPIT')) {
                return $this->getJenisId('sekolah_smp');
            }
            if (str_starts_with($upper, 'TK ') || str_starts_with($upper, 'RA ') || str_starts_with($upper, 'BA ')) {
                return $this->getJenisId('sekolah_tk');
            }
            if (str_starts_with($upper, 'SEKSI') || str_starts_with($upper, 'SUB BAGIAN') || str_contains($upper, 'KOORDINATOR WILAYAH')) {
                return $this->getJenisId('seksi');
            }

            // Cek parent untuk menentukan jenis
            if ($parentId) {
                $parent = UnitKerja::find($parentId);
                if ($parent) {
                    $parentUpper = strtoupper($parent->nama);
                    if (str_contains($parentUpper, 'KOORDINATOR WILAYAH')) {
                        return $this->getJenisId('sekolah_sd');
                    }
                    if (str_contains($parentUpper, 'TK') && !str_contains($parentUpper, 'SMP')) {
                        return $this->getJenisId('sekolah_tk');
                    }
                    if (str_contains($parentUpper, 'SMP')) {
                        return $this->getJenisId('sekolah_smp');
                    }
                    if (str_contains($parentUpper, 'SEKSI') || str_contains($parentUpper, 'BIDANG') || str_contains($parentUpper, 'SEKRETARIAT') || str_contains($parentUpper, 'UPTD')) {
                        return $this->getJenisId('seksi');
                    }
                }
            }
        }

        return null;
    }

    /**
     * Get jenis unit ID dengan cache
     */
    private function getJenisId($kode)
    {
        if (!isset($this->jenisCache[$kode])) {
            $this->jenisCache[$kode] = JenisUnit::where('kode', $kode)->value('id');
        }
        return $this->jenisCache[$kode];
    }

    public function rules(): array
    {
        return [
            'unit_kerja_1' => 'required|string',
            'unit_kerja_2' => 'nullable|string',
            'unit_kerja_3' => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'unit_kerja_1.required' => 'Kolom UNIT_KERJA_1 wajib diisi pada baris :attribute',
            'unit_kerja_1.string' => 'Kolom UNIT_KERJA_1 harus berupa teks pada baris :attribute',
        ];
    }

    public function onFailure(...$failures)
    {
        foreach ($failures as $failure) {
            $this->failures[] = $failure;
        }
    }
}
