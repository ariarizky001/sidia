<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class DataSekolahController extends Controller
{
    /**
     * Display a listing of schools (Unit Kerja Level 3)
     */
    public function index(Request $request)
    {
        $query = UnitKerja::with('parent', 'jenisUnit')
            ->where('level', 3)
            ->whereHas('jenisUnit', function($q) {
                $q->where('is_sekolah', true);
            });

        // Filter berdasarkan pencarian nama
        $search = $request->get('search', '');
        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        // Filter berdasarkan Unit Kerja 2
        if ($request->filled('unit_kerja_2_id')) {
            $query->where('parent_id', $request->unit_kerja_2_id);
        }

        $sekolah = $query->orderBy('nama')->paginate(15)->withQueryString();

        // Ambil semua Unit Kerja Level 2 untuk dropdown filter
        $unitKerja2 = UnitKerja::where('level', 2)->orderBy('nama')->get();

        return view('data-sekolah.index', [
            'sekolah' => $sekolah,
            'unitKerja2' => $unitKerja2,
            'selectedUK2' => $request->unit_kerja_2_id,
            'search' => $search,
            'title' => 'Data Sekolah'
        ]);
    }

    /**
     * Display pegawai in a specific school
     */
    public function show($id)
    {
        $sekolah = UnitKerja::with('jenisUnit')->findOrFail($id);

        // Validasi bahwa ini adalah sekolah (level 3)
        if ($sekolah->level !== 3 || !$sekolah->jenisUnit || !$sekolah->jenisUnit->is_sekolah) {
            abort(404, 'Unit kerja ini bukan sekolah');
        }

        // Ambil semua pegawai yang terdata di unit kerja ini (dari ketiga field unit kerja)
        // Pegawai bisa terdata di unit_kerja_1_id, unit_kerja_2_id, atau unit_kerja_3_id
        $pegawai = Pegawai::where(function ($query) use ($id) {
                $query->where('unit_kerja_1_id', $id)
                    ->orWhere('unit_kerja_2_id', $id)
                    ->orWhere('unit_kerja_3_id', $id);
            })
            ->with('golonganData', 'jabatanData', 'statusAsnData', 'eselonData', 'jenjangPendidikanData', 'unitKerja1', 'unitKerja2', 'unitKerja3', 'formasiJabatanData')
            ->orderBy('nama_lengkap')
            ->paginate(15);

        return view('data-sekolah.show', [
            'sekolah' => $sekolah,
            'pegawai' => $pegawai,
            'title' => 'Data Pegawai - ' . $sekolah->nama
        ]);
    }
}
