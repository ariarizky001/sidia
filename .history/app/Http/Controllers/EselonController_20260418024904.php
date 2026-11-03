<?php

namespace App\Http\Controllers;

use App\Models\Eselon;
use Illuminate\Http\Request;

class EselonController extends Controller
{
    public function index()
    {
        $eselons = Eselon::orderBy('kode', 'asc')->paginate(10);
        return view('master-data.eselon.index', compact('eselons'));
    }

    public function create()
    {
        return view('master-data.eselon.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:eselons',
            'nama_eselon' => 'required|string|max:100|unique:eselons',
            'deskripsi' => 'nullable|string|max:500',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'kode.required' => 'Kode eselon wajib diisi',
            'kode.unique' => 'Kode eselon sudah terdaftar',
            'nama_eselon.required' => 'Nama eselon wajib diisi',
            'nama_eselon.unique' => 'Nama eselon sudah terdaftar',
            'status.required' => 'Status wajib dipilih',
        ]);

        Eselon::create($validated);
        return redirect()->route('eselon.index')->with('success', 'Eselon berhasil ditambahkan');
    }

    public function edit(Eselon $eselon)
    {
        return view('master-data.eselon.edit', compact('eselon'));
    }

    public function update(Request $request, Eselon $eselon)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:eselons,kode,' . $eselon->id,
            'nama_eselon' => 'required|string|max:100|unique:eselons,nama_eselon,' . $eselon->id,
            'deskripsi' => 'nullable|string|max:500',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $eselon->update($validated);
        return redirect()->route('eselon.index')->with('success', 'Eselon berhasil diperbarui');
    }

    public function destroy(Eselon $eselon)
    {
        $eselon->delete();
        return redirect()->route('eselon.index')->with('success', 'Eselon berhasil dihapus');
    }
}
