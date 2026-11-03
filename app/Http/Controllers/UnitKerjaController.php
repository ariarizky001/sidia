<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use App\Imports\UnitKerjaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UnitKerjaController extends Controller
{
    public function index()
    {
        $unitKerjas = UnitKerja::with('parent', 'children', 'jenisUnit')->get();
        return view('master-data.unit-kerja.index', compact('unitKerjas'));
    }

    public function create()
    {
        $jenisUnits = \App\Models\JenisUnit::orderBy('nama')->get();
        return view('master-data.unit-kerja.create', compact('jenisUnits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'level' => 'required|integer|in:1,2,3',
            'parent_id' => 'nullable|exists:unit_kerjas,id',
            'jenis_unit_id' => 'nullable|exists:jenis_units,id',
        ], [
            'nama.required' => 'Nama unit kerja wajib diisi',
            'level.required' => 'Level wajib dipilih',
            'parent_id.exists' => 'Parent unit kerja tidak valid',
            'jenis_unit_id.exists' => 'Jenis unit tidak valid',
        ]);

        // Validasi parent berdasarkan level
        if ($validated['level'] == 1) {
            $validated['parent_id'] = null;
        } elseif ($validated['level'] == 2) {
            if (empty($validated['parent_id'])) {
                return back()->withErrors(['parent_id' => 'Parent dari Level 2 harus dipilih (pilih Level 1)'])->withInput();
            }
            $parent = UnitKerja::find($validated['parent_id']);
            if ($parent->level != 1) {
                return back()->withErrors(['parent_id' => 'Parent harus dari Level 1'])->withInput();
            }
        } elseif ($validated['level'] == 3) {
            if (empty($validated['parent_id'])) {
                return back()->withErrors(['parent_id' => 'Parent dari Level 3 harus dipilih (pilih Level 2)'])->withInput();
            }
            $parent = UnitKerja::find($validated['parent_id']);
            if ($parent->level != 2) {
                return back()->withErrors(['parent_id' => 'Parent harus dari Level 2'])->withInput();
            }
        }

        UnitKerja::create($validated);
        return redirect()->route('unit-kerja.index')->with('success', 'Unit Kerja berhasil ditambahkan');
    }

    public function edit(UnitKerja $unitKerja)
    {
        $levels = [1 => 'Level 1 (Induk)', 2 => 'Level 2 (Korwil/Bidang)', 3 => 'Level 3 (Sekolah/Seksi)'];
        $jenisUnits = \App\Models\JenisUnit::orderBy('nama')->get();

        // Ambil parent yang sesuai dengan level
        if ($unitKerja->level == 1) {
            $selectableParents = collect([]);
        } elseif ($unitKerja->level == 2) {
            $selectableParents = UnitKerja::byLevel(1)->get();
        } else {
            $selectableParents = UnitKerja::byLevel(2)->get();
        }

        return view('master-data.unit-kerja.edit', compact('unitKerja', 'levels', 'selectableParents', 'jenisUnits'));
    }

    public function update(Request $request, UnitKerja $unitKerja)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'level' => 'required|integer|in:1,2,3',
            'parent_id' => 'nullable|exists:unit_kerjas,id|different:id',
            'jenis_unit_id' => 'nullable|exists:jenis_units,id',
        ]);

        // Validasi parent berdasarkan level
        if ($validated['level'] == 1) {
            $validated['parent_id'] = null;
        } elseif ($validated['level'] == 2) {
            if (empty($validated['parent_id'])) {
                return back()->withErrors(['parent_id' => 'Parent dari Level 2 harus dipilih'])->withInput();
            }
            $parent = UnitKerja::find($validated['parent_id']);
            if ($parent->level != 1) {
                return back()->withErrors(['parent_id' => 'Parent harus dari Level 1'])->withInput();
            }
        } elseif ($validated['level'] == 3) {
            if (empty($validated['parent_id'])) {
                return back()->withErrors(['parent_id' => 'Parent dari Level 3 harus dipilih'])->withInput();
            }
            $parent = UnitKerja::find($validated['parent_id']);
            if ($parent->level != 2) {
                return back()->withErrors(['parent_id' => 'Parent harus dari Level 2'])->withInput();
            }
        }

        $unitKerja->update($validated);
        return redirect()->route('unit-kerja.index')->with('success', 'Unit Kerja berhasil diperbarui');
    }

    public function destroy(UnitKerja $unitKerja)
    {
        $unitKerja->delete();
        return redirect()->route('unit-kerja.index')->with('success', 'Unit Kerja berhasil dihapus');
    }

    /**
     * API endpoint untuk dropdown dinamis
     */
    public function getChildrenByParent(Request $request)
    {
        $parentId = $request->query('parent_id');
        $level = $request->query('level');

        if (!$parentId || !$level) {
            return response()->json([]);
        }

        $children = UnitKerja::where('parent_id', $parentId)
            ->where('level', $level)
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return response()->json($children);
    }

    /**
     * API endpoint untuk mendapatkan semua parent dari level tertentu
     */
    public function getParentsByLevel(Request $request)
    {
        $level = $request->query('level');

        if (!$level) {
            return response()->json([]);
        }

        // Return all units with the specified level
        // When called with level=1, returns all Level 1 units (for Level 2 parent selection)
        // When called with level=2, returns all Level 2 units (for Level 3 parent selection)
        $parents = UnitKerja::where('level', (int)$level)
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return response()->json($parents);
    }

    /**
     * Show import form
     */
    public function importForm()
    {
        return view('master-data.unit-kerja.import');
    }

    /**
     * Process Excel import
     */
    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240'
        ], [
            'file.required' => 'File wajib diunggah',
            'file.mimes' => 'File harus berformat Excel (.xlsx, .xls) atau CSV',
            'file.max' => 'Ukuran file maksimal 10MB'
        ]);

        try {
            $import = new UnitKerjaImport();
            Excel::import($import, $request->file('file'));

            if (count($import->failures) > 0) {
                $errors = [];
                foreach (array_slice($import->failures, 0, 10) as $failure) {
                    $row = $failure->row();
                    $errors[] = "Baris {$row}: " . implode(', ', $failure->errors());
                }

                return back()->with('error',
                    "Import gagal untuk " . count($import->failures) . " baris.\n\n" .
                    "Baris yang bermasalah:\n" . implode("\n", $errors) .
                    (count($import->failures) > 10 ? "\n... dan " . (count($import->failures) - 10) . " baris lainnya" : "")
                )->withInput();
            }

            return redirect()->route('unit-kerja.index')->with('success',
                'Data Unit Kerja berhasil diimport! Total: ' . ($import->row - 1) . ' data'
            );

        } catch (\Exception $e) {
            return back()->with('error',
                "Terjadi kesalahan saat import:\n" . $e->getMessage()
            )->withInput();
        }
    }

    /**
     * Download import template
     */
    public function downloadTemplate()
    {
        // Create sample data with 3-level hierarchy
        $sample = [
            ['UNIT_KERJA_1', 'UNIT_KERJA_2', 'UNIT_KERJA_3'],
            ['DINAS PENDIDIKAN DAN KEBUDAYAAN', 'DIPERBANTUKAN (TK SEDERAJAT)', 'TK AISYIYAH 02 BOLON COLOMADU'],
            ['DINAS PENDIDIKAN DAN KEBUDAYAAN', 'DIPERBANTUKAN (TK SEDERAJAT)', 'TK AISYIYAH 03 BOLON COLOMADU'],
            ['DINAS PENDIDIKAN DAN KEBUDAYAAN', 'DIPERBANTUKAN (TK SEDERAJAT)', 'TK ISLAM SITI AMINAH'],
            ['DINAS PENDIDIKAN DAN KEBUDAYAAN', 'SEKOLAH DASAR NEGERI', 'SDN COLOMADU 01'],
            ['DINAS PENDIDIKAN DAN KEBUDAYAAN', 'SEKOLAH DASAR NEGERI', 'SDN COLOMADU 02'],
            ['DINAS PENDIDIKAN DAN KEBUDAYAAN', 'SMP NEGERI', 'SMP NEGERI 1 COLOMADU'],
            ['DINAS PENDIDIKAN DAN KEBUDAYAAN', 'SMA NEGERI', 'SMA NEGERI 1 COLOMADU'],
        ];

        $filename = 'Template-Unit-Kerja-' . date('Y-m-d-His') . '.csv';

        // Create CSV response
        $handle = fopen('php://output', 'w');
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        foreach ($sample as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);
        exit;
    }
}

