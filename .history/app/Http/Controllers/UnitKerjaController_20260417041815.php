<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    public function index()
    {
        $unitKerjas = UnitKerja::with('parent', 'children')->get();
        return view('master-data.unit-kerja.index', compact('unitKerjas'));
    }

    public function create()
    {
        $levels = [1 => 'Level 1 (Induk)', 2 => 'Level 2 (Korwil/Bidang)', 3 => 'Level 3 (Sekolah/Seksi)'];
        $parentsLevel1 = UnitKerja::getParentsByLevel(1);
        $parentsLevel2 = UnitKerja::byLevel(2)->get();

        return view('master-data.unit-kerja.create', compact('levels', 'parentsLevel1', 'parentsLevel2'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'level' => 'required|integer|in:1,2,3',
            'parent_id' => 'nullable|exists:unit_kerjas,id',
        ], [
            'nama.required' => 'Nama unit kerja wajib diisi',
            'level.required' => 'Level wajib dipilih',
            'parent_id.exists' => 'Parent unit kerja tidak valid',
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
        
        // Ambil parent yang sesuai dengan level
        if ($unitKerja->level == 1) {
            $selectableParents = collect([]);
        } elseif ($unitKerja->level == 2) {
            $selectableParents = UnitKerja::byLevel(1)->get();
        } else {
            $selectableParents = UnitKerja::byLevel(2)->get();
        }

        return view('master-data.unit-kerja.edit', compact('unitKerja', 'levels', 'selectableParents'));
    }

    public function update(Request $request, UnitKerja $unitKerja)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'level' => 'required|integer|in:1,2,3',
            'parent_id' => 'nullable|exists:unit_kerjas,id|different:id',
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

        $parents = UnitKerja::byLevel($level)
            ->whereNull('parent_id')
            ->orderBy('nama')
            ->get(['id', 'nama']);

        return response()->json($parents);
    }
}

