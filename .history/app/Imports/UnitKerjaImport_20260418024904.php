<?php

namespace App\Imports;

use App\Models\UnitKerja;
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

        if ($existing) {
            $this->createdUnits[$cacheKey] = $existing;
            return $existing;
        }

        // Create new unit
        $unit = UnitKerja::create([
            'nama' => $nama,
            'parent_id' => $parentId,
            'level' => $level,
        ]);

        $this->createdUnits[$cacheKey] = $unit;
        return $unit;
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
