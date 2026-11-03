<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use Illuminate\Http\Request;

class GolonganController extends Controller
{
    public function index()
    {
        $golongans = Golongan::paginate(10);
        return view('master-data.golongan.index', compact('golongans'));
    }

    public function create()
    {
        return view('master-data.golongan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_golongan' => 'required|string|max:20|unique:golongans',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Golongan::create($validated);
        return redirect()->route('golongan.index')->with('success', 'Golongan berhasil ditambahkan');
    }

    public function show(Golongan $golongan)
    {
        return view('master-data.golongan.show', compact('golongan'));
    }

    public function edit(Golongan $golongan)
    {
        return view('master-data.golongan.edit', compact('golongan'));
    }

    public function update(Request $request, Golongan $golongan)
    {
        $validated = $request->validate([
            'nama_golongan' => 'required|string|max:20|unique:golongans,nama_golongan,' . $golongan->id,
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $golongan->update($validated);
        return redirect()->route('golongan.index')->with('success', 'Golongan berhasil diperbarui');
    }

    public function destroy(Golongan $golongan)
    {
        $golongan->delete();
        return redirect()->route('golongan.index')->with('success', 'Golongan berhasil dihapus');
    }
}
