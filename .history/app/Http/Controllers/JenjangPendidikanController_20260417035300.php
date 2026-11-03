<?php

namespace App\Http\Controllers;

use App\Models\JenjangPendidikan;
use Illuminate\Http\Request;

class JenjangPendidikanController extends Controller
{
    public function index()
    {
        $jenjangPendidikans = JenjangPendidikan::paginate(10);
        return view('master-data.jenjang-pendidikan.index', compact('jenjangPendidikans'));
    }

    public function create()
    {
        return view('master-data.jenjang-pendidikan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jenjang' => 'required|string|max:50|unique:jenjang_pendidikans',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        JenjangPendidikan::create($validated);
        return redirect()->route('jenjang-pendidikan.index')->with('success', 'Jenjang Pendidikan berhasil ditambahkan');
    }

    public function show(JenjangPendidikan $jenjangPendidikan)
    {
        return view('master-data.jenjang-pendidikan.show', compact('jenjangPendidikan'));
    }

    public function edit(JenjangPendidikan $jenjangPendidikan)
    {
        return view('master-data.jenjang-pendidikan.edit', compact('jenjangPendidikan'));
    }

    public function update(Request $request, JenjangPendidikan $jenjangPendidikan)
    {
        $validated = $request->validate([
            'nama_jenjang' => 'required|string|max:50|unique:jenjang_pendidikans,nama_jenjang,' . $jenjangPendidikan->id,
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $jenjangPendidikan->update($validated);
        return redirect()->route('jenjang-pendidikan.index')->with('success', 'Jenjang Pendidikan berhasil diperbarui');
    }

    public function destroy(JenjangPendidikan $jenjangPendidikan)
    {
        $jenjangPendidikan->delete();
        return redirect()->route('jenjang-pendidikan.index')->with('success', 'Jenjang Pendidikan berhasil dihapus');
    }
}
