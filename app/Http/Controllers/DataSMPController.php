<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class DataSMPController extends Controller
{
    /**
     * Display a listing of SMP schools
     */
    public function index(Request $request)
    {
        $query = UnitKerja::with(['parent', 'jenisUnit'])
            ->where('level', 3)
            ->sekolahSMP();

        $search = $request->get('search', '');
        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        // Filter berdasarkan kelompok SMP
        if ($request->filled('kelompok_id')) {
            $query->where('parent_id', $request->kelompok_id);
        }

        $sekolah = $query->orderBy('nama')->paginate(20)->withQueryString();

        // Ambil kelompok SMP untuk filter
        $kelompokSMP = UnitKerja::where('level', 2)
            ->whereHas('jenisUnit', function($q) {
                $q->where('kode', 'kelompok_smp');
            })
            ->orderBy('nama')
            ->get();

        return view('data-smp.index', [
            'sekolah' => $sekolah,
            'kelompokSMP' => $kelompokSMP,
            'selectedKelompok' => $request->kelompok_id,
            'search' => $search,
            'title' => 'Data Sekolah Menengah Pertama (SMP)'
        ]);
    }

    /**
     * Display pegawai in a specific SMP school
     */
    public function show($id)
    {
        $sekolah = UnitKerja::with('jenisUnit')->findOrFail($id);

        if (!$sekolah->jenisUnit || $sekolah->jenisUnit->kode !== 'sekolah_smp') {
            abort(404, 'Unit kerja ini bukan Sekolah Menengah Pertama');
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

        return view('data-smp.show', [
            'sekolah' => $sekolah,
            'pegawai' => $pegawai,
            'title' => 'Data Pegawai - ' . $sekolah->nama
        ]);
    }
}
