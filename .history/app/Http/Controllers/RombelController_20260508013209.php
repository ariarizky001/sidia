<?php

namespace App\Http\Controllers;

use App\Models\Rombel;
use App\Models\UnitKerja;
use Illuminate\Http\Request;

class RombelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch Unit Kerja Level 2 (Koordinator Wilayah Kecamatan)
        $unitKerjaLevel2 = UnitKerja::where('level', 2)->orderBy('nama')->get();

        // Untuk setiap Unit Kerja Level 2, ambil child dan rombel nya
        $data = [];
        foreach ($unitKerjaLevel2 as $kecamatan) {
            $data[$kecamatan->id] = [
                'kecamatan' => $kecamatan,
                'sekolah' => [] // Unit Kerja Level 3
            ];

            // Get Unit Kerja Level 3 (Sekolah Dasar) yang parent nya adalah level 2 ini
            $sekolahList = UnitKerja::where('level', 3)
                ->where('parent_id', $kecamatan->id)
                ->orderBy('nama')
                ->get();

            foreach ($sekolahList as $sekolah) {
                $data[$kecamatan->id]['sekolah'][$sekolah->id] = [
                    'sekolah' => $sekolah,
                    'rombel' => Rombel::where('unit_kerja_id', $sekolah->id)
                        ->with('unitKerjaParent', 'unitKerja')
                        ->orderBy('nama_rombel')
                        ->get()
                ];
            }
        }

        return view('rombel.index', [
            'title' => 'Data Rombel',
            'data' => $data,
            'totalRombel' => Rombel::count()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unitKerjaLevel2 = UnitKerja::where('level', 2)->orderBy('nama')->get();
        $unitKerjaLevel3 = UnitKerja::where('level', 3)->orderBy('nama')->get();

        return view('rombel.create', [
            'title' => 'Tambah Rombel',
            'unitKerjaLevel2' => $unitKerjaLevel2,
            'unitKerjaLevel3' => $unitKerjaLevel3,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: Implementasi penyimpanan data
        $validated = $request->validate([
            'nama_rombel' => 'required|string|max:100',
            'unit_kerja_parent_id' => 'required|exists:unit_kerjas,id',
            'unit_kerja_id' => 'required|exists:unit_kerjas,id',
            'keterangan' => 'nullable|string',
        ]);

        Rombel::create($validated);

        return redirect()->route('rombel.index')->with('success', 'Rombel berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rombel = Rombel::with('unitKerjaParent', 'unitKerja')->findOrFail($id);

        return view('rombel.show', [
            'title' => 'Detail Rombel',
            'rombel' => $rombel
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rombel = Rombel::findOrFail($id);
        $unitKerjaLevel2 = UnitKerja::where('level', 2)->orderBy('nama')->get();
        $unitKerjaLevel3 = UnitKerja::where('level', 3)->orderBy('nama')->get();

        return view('rombel.edit', [
            'title' => 'Edit Rombel',
            'rombel' => $rombel,
            'unitKerjaLevel2' => $unitKerjaLevel2,
            'unitKerjaLevel3' => $unitKerjaLevel3,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // TODO: Implementasi update data
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // TODO: Implementasi hapus data
    }
}
