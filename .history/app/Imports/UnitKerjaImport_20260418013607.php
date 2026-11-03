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
    private $row = 0;
    public $failures = [];

    public function model(array $row)
    {
        $this->row++;

        // Get normalized column names
        $nama = $row['nama'] ?? $row['unit_kerja'] ?? $row['unit kerja'] ?? null;
        
        if (empty($nama)) {
            throw new \Exception('Kolom nama/unit_kerja tidak ditemukan');
        }

        // Determine level based on parent
        $parentNama = $row['parent'] ?? $row['parent_id'] ?? $row['parent unit'] ?? null;
        
        $parentId = null;
        $level = 1; // Default level 1

        // If parent is specified, find it and set level accordingly
        if (!empty($parentNama)) {
            $parent = UnitKerja::where('nama', 'LIKE', '%' . trim($parentNama) . '%')->first();
            
            if ($parent) {
                $parentId = $parent->id;
                $level = $parent->level + 1;
            } else {
                throw new \Exception("Parent '{$parentNama}' tidak ditemukan. Pastikan parent sudah diinput terlebih dahulu.");
            }
        }

        // Check if unit kerja already exists
        $existing = UnitKerja::where('nama', trim($nama))->first();
        if ($existing) {
            throw new \Exception("Unit Kerja '{$nama}' sudah ada di database");
        }

        return new UnitKerja([
            'nama' => trim($nama),
            'parent_id' => $parentId,
            'level' => $level,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string',
            // parent is optional
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama.required' => 'Kolom Nama Unit Kerja wajib diisi pada baris :attribute',
            'nama.string' => 'Kolom Nama Unit Kerja harus berupa teks pada baris :attribute',
        ];
    }

    public function onFailure(...$failures)
    {
        foreach ($failures as $failure) {
            $this->failures[] = $failure;
        }
    }
}
