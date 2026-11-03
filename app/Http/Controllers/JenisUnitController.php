<?php

namespace App\Http\Controllers;

use App\Models\JenisUnit;
use Illuminate\Http\Request;

class JenisUnitController extends Controller
{
    public function index()
    {
        $jenisUnits = JenisUnit::withCount('unitKerjas')->paginate(10);
        return view('master-data.jenis-unit.index', compact('jenisUnits'));
    }

    public function create()
    {
        return view('master-data.jenis-unit.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:30|unique:jenis_units,kode',
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:255',
            'level' => 'required|integer|in:1,2,3',
            'is_sekolah' => 'required|boolean',
        ]);

        JenisUnit::create($validated);
        return redirect()->route('jenis-unit.index')->with('success', 'Jenis Unit berhasil ditambahkan');
    }

    public function show(JenisUnit $jenisUnit)
    {
        $unitKerjas = $jenisUnit->unitKerjas()->with('parent')->paginate(15);
        return view('master-data.jenis-unit.show', compact('jenisUnit', 'unitKerjas'));
    }

    public function edit(JenisUnit $jenisUnit)
    {
        return view('master-data.jenis-unit.edit', compact('jenisUnit'));
    }

    public function update(Request $request, JenisUnit $jenisUnit)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:30|unique:jenis_units,kode,' . $jenisUnit->id,
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:255',
            'level' => 'required|integer|in:1,2,3',
            'is_sekolah' => 'required|boolean',
        ]);

        $jenisUnit->update($validated);
        return redirect()->route('jenis-unit.index')->with('success', 'Jenis Unit berhasil diperbarui');
    }

    public function destroy(JenisUnit $jenisUnit)
    {
        if ($jenisUnit->unitKerjas()->count() > 0) {
            return redirect()->route('jenis-unit.index')->with('error', 'Jenis Unit tidak dapat dihapus karena masih memiliki unit kerja terkait');
        }

        $jenisUnit->delete();
        return redirect()->route('jenis-unit.index')->with('success', 'Jenis Unit berhasil dihapus');
    }
}
