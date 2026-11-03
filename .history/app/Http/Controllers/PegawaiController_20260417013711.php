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
        // TODO: Nanti akan diambil dari database
        $pegawai = [];

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
        // Validasi
        $validated = $request->validate([
            'nip' => 'required|unique:pegawai|max:50',
            'nama_lengkap' => 'required|max:100',
            'tgl_lahir' => 'required|date',
            'pensiun' => 'nullable|date',
            'bup' => 'nullable|date',
            'golongan' => 'required|max:10',
            'tmt_golongan' => 'nullable|date',
            'jabatan' => 'required|max:100',
            'tmt_jabatan' => 'nullable|date',
            'pendidikan' => 'required|max:50',
            'thn_lulus' => 'nullable|integer|min:1950|max:2100',
            'status_asn' => 'required|max:50',
            'formasi_jabatan' => 'nullable|max:100',
            'unit_kerja_satu' => 'required|max:100',
            'unit_kerja_2' => 'nullable|max:100',
            'unit_kerja_3' => 'nullable|max:100',
        ]);

        // TODO: Save ke database nanti
        // Pegawai::create($validated);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // TODO: Ambil data dari database
        $pegawai = (object) [
            'id' => $id,
            'nip' => '',
            'nama_lengkap' => '',
            'tgl_lahir' => '',
            'pensiun' => '',
            'bup' => '',
            'golongan' => '',
            'tmt_golongan' => '',
            'jabatan' => '',
            'tmt_jabatan' => '',
            'pendidikan' => '',
            'thn_lulus' => '',
            'status_asn' => '',
            'formasi_jabatan' => '',
            'unit_kerja_satu' => '',
            'unit_kerja_2' => '',
            'unit_kerja_3' => '',
        ];

        return view('pegawai.show', [
            'pegawai' => $pegawai,
            'title' => 'Detail Pegawai'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // TODO: Ambil data dari database
        $pegawai = (object) [
            'id' => $id,
            'nip' => '',
            'nama_lengkap' => '',
            'tgl_lahir' => '',
            'pensiun' => '',
            'bup' => '',
            'golongan' => '',
            'tmt_golongan' => '',
            'jabatan' => '',
            'tmt_jabatan' => '',
            'pendidikan' => '',
            'thn_lulus' => '',
            'status_asn' => '',
            'formasi_jabatan' => '',
            'unit_kerja_satu' => '',
            'unit_kerja_2' => '',
            'unit_kerja_3' => '',
        ];

        return view('pegawai.edit', [
            'pegawai' => $pegawai,
            'title' => 'Edit Pegawai'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi
        $validated = $request->validate([
            'nip' => 'required|max:50',
            'nama_lengkap' => 'required|max:100',
            'tgl_lahir' => 'required|date',
            'pensiun' => 'nullable|date',
            'bup' => 'nullable|date',
            'golongan' => 'required|max:10',
            'tmt_golongan' => 'nullable|date',
            'jabatan' => 'required|max:100',
            'tmt_jabatan' => 'nullable|date',
            'pendidikan' => 'required|max:50',
            'thn_lulus' => 'nullable|integer|min:1950|max:2100',
            'status_asn' => 'required|max:50',
            'formasi_jabatan' => 'nullable|max:100',
            'unit_kerja_satu' => 'required|max:100',
            'unit_kerja_2' => 'nullable|max:100',
            'unit_kerja_3' => 'nullable|max:100',
        ]);

        // TODO: Update di database nanti
        // Pegawai::findOrFail($id)->update($validated);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // TODO: Delete dari database nanti
        // Pegawai::findOrFail($id)->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus');
    }
}

