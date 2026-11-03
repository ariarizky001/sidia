<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Eselon;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::with('eselon', 'parent')->orderBy('nama_jabatan', 'asc')->paginate(10);
        return view('master-data.jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        $eselons = Eselon::where('status', 'aktif')->orderBy('kode', 'asc')->get();
        $parentJabatans = Jabatan::where('is_active', true)->orderBy('nama_jabatan', 'asc')->get();
        $jenisJabatan = ['struktural', 'fungsional', 'non-struktural'];

        return view('master-data.jabatan.create', compact('eselons', 'parentJabatans', 'jenisJabatan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:100|unique:jabatans',
            'jenis_jabatan' => 'required|in:struktural,fungsional,non-struktural',
            'eselon_id' => 'nullable|exists:eselons,id',
            'parent_id' => 'nullable|exists:jabatans,id|different:id',
            'is_active' => 'required|in:true,false',
        ], [
            'nama_jabatan.required' => 'Nama jabatan wajib diisi',
            'nama_jabatan.unique' => 'Nama jabatan sudah terdaftar',
            'jenis_jabatan.required' => 'Jenis jabatan wajib dipilih',
            'eselon_id.exists' => 'Eselon tidak valid',
            'parent_id.exists' => 'Parent jabatan tidak valid',
        ]);

        // Convert string boolean to actual boolean
        $validated['is_active'] = filter_var($validated['is_active'], FILTER_VALIDATE_BOOLEAN);

        Jabatan::create($validated);
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function edit(Jabatan $jabatan)
    {
        $eselons = Eselon::where('status', 'aktif')->orderBy('kode', 'asc')->get();
        $parentJabatans = Jabatan::where('is_active', true)
            ->where('id', '!=', $jabatan->id)
            ->orderBy('nama_jabatan', 'asc')
            ->get();
        $jenisJabatan = ['struktural', 'fungsional', 'non-struktural'];

        return view('master-data.jabatan.edit', compact('jabatan', 'eselons', 'parentJabatans', 'jenisJabatan'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:100|unique:jabatans,nama_jabatan,' . $jabatan->id,
            'jenis_jabatan' => 'required|in:struktural,fungsional,non-struktural',
            'eselon_id' => 'nullable|exists:eselons,id',
            'parent_id' => 'nullable|exists:jabatans,id|different:id',
            'is_active' => 'required|in:true,false',
        ]);

        // Convert string boolean to actual boolean
        $validated['is_active'] = filter_var($validated['is_active'], FILTER_VALIDATE_BOOLEAN);

        $jabatan->update($validated);
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diperbarui');
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus');
    }
}
