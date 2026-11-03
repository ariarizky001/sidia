<?php

namespace App\Http\Controllers;

use App\Models\FormasiJabatan;
use Illuminate\Http\Request;

class FormasiJabatanController extends Controller
{
    public function index()
    {
        $formasiJabatans = FormasiJabatan::orderBy('nama_formasi', 'asc')->paginate(10);
        return view('master-data.formasi-jabatan.index', compact('formasiJabatans'));
    }

    public function create()
    {
        $jenisJabatan = ['struktural', 'fungsional'];
        return view('master-data.formasi-jabatan.create', compact('jenisJabatan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_formasi' => 'required|string|max:100|unique:formasi_jabatans',
            'jenis_jabatan' => 'required|in:struktural,fungsional',
            'kategori' => 'nullable|string|max:100',
            'is_active' => 'required|in:true,false',
        ], [
            'nama_formasi.required' => 'Nama formasi wajib diisi',
            'nama_formasi.unique' => 'Nama formasi sudah terdaftar',
            'jenis_jabatan.required' => 'Jenis jabatan wajib dipilih',
        ]);

        // Convert string boolean to actual boolean
        $validated['is_active'] = filter_var($validated['is_active'], FILTER_VALIDATE_BOOLEAN);

        FormasiJabatan::create($validated);
        return redirect()->route('formasi-jabatan.index')->with('success', 'Formasi Jabatan berhasil ditambahkan');
    }

    public function edit(FormasiJabatan $formasiJabatan)
    {
        $jenisJabatan = ['struktural', 'fungsional'];
        return view('master-data.formasi-jabatan.edit', compact('formasiJabatan', 'jenisJabatan'));
    }

    public function update(Request $request, FormasiJabatan $formasiJabatan)
    {
        $validated = $request->validate([
            'nama_formasi' => 'required|string|max:100|unique:formasi_jabatans,nama_formasi,' . $formasiJabatan->id,
            'jenis_jabatan' => 'required|in:struktural,fungsional',
            'kategori' => 'nullable|string|max:100',
            'is_active' => 'required|in:true,false',
        ]);

        // Convert string boolean to actual boolean
        $validated['is_active'] = filter_var($validated['is_active'], FILTER_VALIDATE_BOOLEAN);

        $formasiJabatan->update($validated);
        return redirect()->route('formasi-jabatan.index')->with('success', 'Formasi Jabatan berhasil diperbarui');
    }

    public function destroy(FormasiJabatan $formasiJabatan)
    {
        $formasiJabatan->delete();
        return redirect()->route('formasi-jabatan.index')->with('success', 'Formasi Jabatan berhasil dihapus');
    }
}
