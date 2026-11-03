<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
{
    public function index()
    {
        $unitKerjas = UnitKerja::paginate(10);
        return view('master-data.unit-kerja.index', compact('unitKerjas'));
    }

    public function create()
    {
        return view('master-data.unit-kerja.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_unit' => 'required|string|max:100|unique:unit_kerjas',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        UnitKerja::create($validated);
        return redirect()->route('unit-kerja.index')->with('success', 'Unit Kerja berhasil ditambahkan');
    }

    public function show(UnitKerja $unitKerja)
    {
        return view('master-data.unit-kerja.show', compact('unitKerja'));
    }

    public function edit(UnitKerja $unitKerja)
    {
        return view('master-data.unit-kerja.edit', compact('unitKerja'));
    }

    public function update(Request $request, UnitKerja $unitKerja)
    {
        $validated = $request->validate([
            'nama_unit' => 'required|string|max:100|unique:unit_kerjas,nama_unit,' . $unitKerja->id,
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $unitKerja->update($validated);
        return redirect()->route('unit-kerja.index')->with('success', 'Unit Kerja berhasil diperbarui');
    }

    public function destroy(UnitKerja $unitKerja)
    {
        $unitKerja->delete();
        return redirect()->route('unit-kerja.index')->with('success', 'Unit Kerja berhasil dihapus');
    }
}
