<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use Illuminate\Http\Request;

class GolonganController extends Controller
{
    public function index()
    {
        $golongans = Golongan::orderBy('urutan', 'asc')->paginate(10);
        return view('master-data.golongan.index', compact('golongans'));
    }

    public function create()
    {
        return view('master-data.golongan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:golongans',
            'nama_golongan' => 'required|string|max:50|unique:golongans',
            'urutan' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'kode.required' => 'Kode golongan wajib diisi',
            'kode.unique' => 'Kode golongan sudah terdaftar',
            'nama_golongan.required' => 'Nama golongan wajib diisi',
            'nama_golongan.unique' => 'Nama golongan sudah terdaftar',
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
            'status.required' => 'Status wajib dipilih',
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
            'kode' => 'required|string|max:10|unique:golongans,kode,' . $golongan->id,
            'nama_golongan' => 'required|string|max:50|unique:golongans,nama_golongan,' . $golongan->id,
            'urutan' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'kode.required' => 'Kode golongan wajib diisi',
            'kode.unique' => 'Kode golongan sudah terdaftar',
            'nama_golongan.required' => 'Nama golongan wajib diisi',
            'nama_golongan.unique' => 'Nama golongan sudah terdaftar',
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
            'status.required' => 'Status wajib dipilih',
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
