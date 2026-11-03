<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class DataSDController extends Controller
{
    /**
     * Display a listing of SD schools
     */
    public function index(Request $request)
    {
        $query = UnitKerja::with(['parent', 'jenisUnit'])
            ->where('level', 3)
            ->sekolahSD();

        // Filter berdasarkan pencarian nama
        $search = $request->get('search', '');
        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        // Filter berdasarkan Koordinator Wilayah (Unit Kerja Level 2)
        if ($request->filled('koordinator_id')) {
            $query->where('parent_id', $request->koordinator_id);
        }

        $sekolah = $query->orderBy('nama')->paginate(20)->withQueryString();

        // Ambil semua Koordinator Wilayah untuk dropdown filter
        $koordinatorWilayah = UnitKerja::where('level', 2)
            ->koordinatorWilayah()
            ->orderBy('nama')
            ->get();

        return view('data-sd.index', [
            'sekolah' => $sekolah,
            'koordinatorWilayah' => $koordinatorWilayah,
            'selectedKoordinator' => $request->koordinator_id,
            'search' => $search,
            'title' => 'Data Sekolah Dasar (SD)'
        ]);
    }

    /**
     * Display pegawai in a specific SD school
     */
    public function show($id)
    {
        $sekolah = UnitKerja::with('jenisUnit')->findOrFail($id);

        // Validasi bahwa ini adalah SD
        if (!$sekolah->jenisUnit || $sekolah->jenisUnit->kode !== 'sekolah_sd') {
            abort(404, 'Unit kerja ini bukan Sekolah Dasar');
        }

        // Ambil semua pegawai yang terdata di unit kerja ini
        $pegawai = Pegawai::where(function ($query) use ($id) {
                $query->where('unit_kerja_1_id', $id)
                    ->orWhere('unit_kerja_2_id', $id)
                    ->orWhere('unit_kerja_3_id', $id);
            })
            ->with([
                'golonganData', 
                'jabatanData', 
                'statusAsnData', 
                'eselonData', 
                'jenjangPendidikanData', 
                'unitKerja1', 
                'unitKerja2', 
                'unitKerja3', 
                'formasiJabatanData'
            ])
            ->orderBy('nama_lengkap')
            ->paginate(20);

        return view('data-sd.show', [
            'sekolah' => $sekolah,
            'pegawai' => $pegawai,
            'title' => 'Data Pegawai - ' . $sekolah->nama
        ]);
    }
}
