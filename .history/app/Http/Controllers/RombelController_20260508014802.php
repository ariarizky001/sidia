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
    public function index(Request $request)
    {
        // Get filter dari request
        $filterKecamatan = $request->get('kecamatan');

        // Fetch Unit Kerja Level 2 (Koordinator Wilayah Kecamatan) untuk dropdown filter
        $unitKerjaLevel2 = UnitKerja::where('level', 2)->orderBy('nama')->get();

        // Jika ada filter, gunakan filter tersebut, jika tidak tampilkan semua
        if ($filterKecamatan && $filterKecamatan !== 'semua') {
            // Filter data berdasarkan kecamatan yang dipilih
            $data = [];
            $kecamatan = UnitKerja::where('level', 2)->where('id', $filterKecamatan)->first();

            if ($kecamatan) {
                $data[$kecamatan->id] = [
                    'kecamatan' => $kecamatan,
                    'sekolah' => []
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
        } else {
            // Tampilkan semua data
            $data = [];
            foreach ($unitKerjaLevel2 as $kecamatan) {
                $data[$kecamatan->id] = [
                    'kecamatan' => $kecamatan,
                    'sekolah' => []
                ];

                // Get Unit Kerja Level 3 (Sekolah Dasar) yang parent nya adalah level 2 ini
                $sekolahList = UnitKerja::where('level', 3)
                    ->where('parent_id', $kecamatan->id)
                    ->orderBy('nama')
                    ->get();

                foreach ($sekolahList as $sekolah) {
                    $rombel = Rombel::where('unit_kerja_id', $sekolah->id)->first();
                    $data[$kecamatan->id]['sekolah'][$sekolah->id] = [
                        'sekolah' => $sekolah,
                        'jumlah_rombel' => $rombel ? $rombel->jumlah_rombel : 0,
                        'keterangan' => $rombel ? $rombel->keterangan : '-',
                        'rombel_id' => $rombel ? $rombel->id : null
                    ];
                }
            }
        }

        // Hitung total rombel dari sum jumlah_rombel
        $totalRombel = Rombel::sum('jumlah_rombel');

        return view('rombel.index', [
            'title' => 'Data Rombel',
            'data' => $data,
            'unitKerjaLevel2' => $unitKerjaLevel2,
            'filterKecamatan' => $filterKecamatan,
            'totalRombel' => $totalRombel,
            'statistik' => $this->getStatistik()
        ]);
    }

    /**
     * Get statistik rombel per unit kerja
     */
    private function getStatistik()
    {
        return [
            'total_sekolah' => UnitKerja::where('level', 3)->count(),
            'total_kecamatan' => UnitKerja::where('level', 2)->count(),
            'total_rombel' => Rombel::sum('jumlah_rombel')
        ];

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
        $validated = $request->validate([
            'jumlah_rombel' => 'required|integer|min:0',
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
        $rombel = Rombel::findOrFail($id);

        $validated = $request->validate([
            'jumlah_rombel' => 'required|integer|min:0',
            'unit_kerja_parent_id' => 'required|exists:unit_kerjas,id',
            'unit_kerja_id' => 'required|exists:unit_kerjas,id',
            'keterangan' => 'nullable|string',
        ]);

        $rombel->update($validated);

        return redirect()->route('rombel.index')->with('success', 'Rombel berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rombel = Rombel::findOrFail($id);
        $rombel->delete();

        return redirect()->route('rombel.index')->with('success', 'Rombel berhasil dihapus');
    }
}
