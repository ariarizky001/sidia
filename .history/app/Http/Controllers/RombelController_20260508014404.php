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
                    $data[$kecamatan->id]['sekolah'][$sekolah->id] = [
                        'sekolah' => $sekolah,
                        'rombel' => Rombel::where('unit_kerja_id', $sekolah->id)
                            ->with('unitKerjaParent', 'unitKerja')
                            ->orderBy('nama_rombel')
                            ->get()
                    ];
                }
            }
        }

        return view('rombel.index', [
            'title' => 'Data Rombel',
            'data' => $data,
            'unitKerjaLevel2' => $unitKerjaLevel2,
            'filterKecamatan' => $filterKecamatan,
            'totalRombel' => Rombel::count(),
            'statistik' => $this->getStatistik()
        ]);
    }

    /**
     * Get statistik rombel per unit kerja
     */
    private function getStatistik()
    {
        // Statistik rombel per sekolah (Unit Kerja Level 3)
        $rombelPerSekolah = UnitKerja::where('level', 3)
            ->withCount(['rombels' => function ($query) {
                $query->where('unit_kerja_id', 'unit_kerjas.id');
            }])
            ->with(['parent' => function ($query) {
                $query->select('id', 'nama');
            }])
            ->orderBy('nama')
            ->get()
            ->map(function ($sekolah) {
                return [
                    'sekolah_id' => $sekolah->id,
                    'sekolah_nama' => $sekolah->nama,
                    'kecamatan_id' => $sekolah->parent_id,
                    'kecamatan_nama' => $sekolah->parent?->nama ?? '-',
                    'total_rombel' => Rombel::where('unit_kerja_id', $sekolah->id)->count()
                ];
            });

        // Statistik rombel per kecamatan (Unit Kerja Level 2)
        $rombelPerKecamatan = UnitKerja::where('level', 2)
            ->orderBy('nama')
            ->get()
            ->map(function ($kecamatan) {
                $totalRombel = Rombel::whereIn('unit_kerja_id', function ($query) use ($kecamatan) {
                    $query->select('id')
                        ->from('unit_kerjas')
                        ->where('level', 3)
                        ->where('parent_id', $kecamatan->id);
                })->count();

                return [
                    'kecamatan_id' => $kecamatan->id,
                    'kecamatan_nama' => $kecamatan->nama,
                    'total_rombel' => $totalRombel,
                    'total_sekolah' => UnitKerja::where('level', 3)->where('parent_id', $kecamatan->id)->count()
                ];
            });

        return [
            'rombel_per_sekolah' => $rombelPerSekolah,
            'rombel_per_kecamatan' => $rombelPerKecamatan,
            'total_sekolah' => UnitKerja::where('level', 3)->count(),
            'total_kecamatan' => UnitKerja::where('level', 2)->count()
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
        $rombel = Rombel::findOrFail($id);

        $validated = $request->validate([
            'nama_rombel' => 'required|string|max:100',
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
