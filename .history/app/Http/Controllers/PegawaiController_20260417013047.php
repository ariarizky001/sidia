<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = [
            // Placeholder data - akan diganti dengan data dari database
        ];

        return view('pegawai.index', [
            'pegawai' => $pegawai,
            'title' => 'Data Pegawai'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pegawai.create', [
            'title' => 'Tambah Pegawai'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Placeholder untuk menyimpan pegawai baru
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Placeholder untuk menampilkan detail pegawai
        return view('pegawai.show', [
            'title' => 'Detail Pegawai'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pegawai.edit', [
            'title' => 'Edit Pegawai'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Placeholder untuk update pegawai
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Placeholder untuk menghapus pegawai
        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus');
    }
}
