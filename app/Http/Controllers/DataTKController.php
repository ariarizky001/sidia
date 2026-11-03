<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class DataTKController extends Controller
{
    /**
     * Display a listing of TK schools
     */
    public function index(Request $request)
    {
        $query = UnitKerja::with(['parent', 'jenisUnit'])
            ->where('level', 3)
            ->sekolahTK();

        $search = $request->get('search', '');
        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        $sekolah = $query->orderBy('nama')->paginate(20)->withQueryString();

        return view('data-tk.index', [
            'sekolah' => $sekolah,
            'search' => $search,
            'title' => 'Data Taman Kanak-Kanak (TK)'
        ]);
    }

    /**
     * Display pegawai in a specific TK school
     */
    public function show($id)
    {
        $sekolah = UnitKerja::with('jenisUnit')->findOrFail($id);

        if (!$sekolah->jenisUnit || $sekolah->jenisUnit->kode !== 'sekolah_tk') {
            abort(404, 'Unit kerja ini bukan Taman Kanak-Kanak');
        }

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

        return view('data-tk.show', [
            'sekolah' => $sekolah,
            'pegawai' => $pegawai,
            'title' => 'Data Pegawai - ' . $sekolah->nama
        ]);
    }
}
