<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use App\Models\Pegawai;
use App\Models\Rombel;
use Illuminate\Http\Request;

class KebutuhanGuruController extends Controller
{
    /**
     * Daftar kebutuhan guru per sekolah (Mapping)
     */
    public function index(Request $request)
    {
        // Get filter dari request
        $filterKecamatan = $request->get('kecamatan');
        $filterStatus = $request->get('status');

        // Fetch Unit Kerja Level 2 (Kecamatan) untuk dropdown
        $unitKerjaLevel2 = UnitKerja::where('level', 2)->orderBy('nama')->get();

        // Query Unit Kerja Level 3 (Sekolah)
        $query = UnitKerja::where('level', 3)
            ->with(['parent', 'rombels', 'pegawais'])
            ->orderBy('nama');

        // Apply filter kecamatan
        if ($filterKecamatan && $filterKecamatan !== 'semua') {
            $query->where('parent_id', $filterKecamatan);
        }

        $sekolahList = $query->paginate(10)->appends(request()->query());

        // Hitung mapping untuk setiap sekolah
        $mappingData = [];
        foreach ($sekolahList as $sekolah) {
            $mapping = $this->hitungKebutuhanGuru($sekolah);
            
            // Apply filter status jika ada
            if ($filterStatus && $filterStatus !== 'semua' && $mapping['status'] !== $filterStatus) {
                continue;
            }
            
            $mappingData[$sekolah->id] = $mapping;
        }

        // Hitung statistik
        $statistik = $this->hitungStatistik();

        return view('kebutuhan-guru.index', [
            'title' => 'Kebutuhan Guru per Sekolah',
            'sekolahList' => $sekolahList,
            'mappingData' => $mappingData,
            'unitKerjaLevel2' => $unitKerjaLevel2,
            'filterKecamatan' => $filterKecamatan,
            'filterStatus' => $filterStatus,
            'statistik' => $statistik
        ]);
    }

    /**
     * Detail kebutuhan guru per sekolah
     */
    public function show(string $id)
    {
        $sekolah = UnitKerja::where('level', 3)->with(['parent', 'rombels', 'pegawais'])->findOrFail($id);
        
        $mapping = $this->hitungKebutuhanGuru($sekolah);
        
        // Ambil guru per formasi
        $guruKelas = $sekolah->pegawais()
            ->where('formasi_jabatan_id', $this->getFormasiId('guru_kelas_sd'))
            ->where('status_aktif', 1)
            ->get();
            
        $guruPenjas = $sekolah->pegawais()
            ->where('formasi_jabatan_id', $this->getFormasiId('guru_penjas_sd'))
            ->where('status_aktif', 1)
            ->get();
            
        $guruAgama = $sekolah->pegawais()
            ->where('formasi_jabatan_id', $this->getFormasiId('guru_agama_sd'))
            ->where('status_aktif', 1)
            ->get();

        return view('kebutuhan-guru.show', [
            'title' => 'Detail Kebutuhan Guru',
            'sekolah' => $sekolah,
            'mapping' => $mapping,
            'guruKelas' => $guruKelas,
            'guruPenjas' => $guruPenjas,
            'guruAgama' => $guruAgama,
        ]);
    }

    /**
     * Hitung kebutuhan guru berdasarkan jumlah rombel
     * Kebutuhan:
     * - Guru Kelas: = jumlah_rombel
     * - Guru Penjas: 1
     * - Guru Agama: 1
     */
    private function hitungKebutuhanGuru($sekolah)
    {
        // Hitung jumlah rombel
        $jumlahRombel = $sekolah->rombels()->count();
        if ($jumlahRombel == 0) {
            // Cek di tabel rombel apakah ada field jumlah_rombel
            $rombel = $sekolah->rombels()->first();
            if ($rombel && isset($rombel->jumlah_rombel)) {
                $jumlahRombel = $rombel->jumlah_rombel;
            }
        }

        // Kebutuhan
        $kebutuhanKelas = $jumlahRombel;
        $kebutuhanPenjas = 1;
        $kebutuhanAgama = 1;

        // Guru yang ada
        $adaKelas = $sekolah->pegawais()
            ->where('formasi_jabatan_id', $this->getFormasiId('guru_kelas_sd'))
            ->where('status_aktif', 1)
            ->count();
            
        $adaPenjas = $sekolah->pegawais()
            ->where('formasi_jabatan_id', $this->getFormasiId('guru_penjas_sd'))
            ->where('status_aktif', 1)
            ->count();
            
        $adaAgama = $sekolah->pegawais()
            ->where('formasi_jabatan_id', $this->getFormasiId('guru_agama_sd'))
            ->where('status_aktif', 1)
            ->count();

        // Kekurangan
        $kurangKelas = max(0, $kebutuhanKelas - $adaKelas);
        $kurangPenjas = max(0, $kebutuhanPenjas - $adaPenjas);
        $kurangAgama = max(0, $kebutuhanAgama - $adaAgama);

        // Status
        $statusKelas = ($adaKelas >= $kebutuhanKelas) ? 'LENGKAP' : ($adaKelas > 0 ? 'PARSIAL' : 'KOSONG');
        $statusPenjas = ($adaPenjas >= $kebutuhanPenjas) ? 'LENGKAP' : ($adaPenjas > 0 ? 'PARSIAL' : 'KOSONG');
        $statusAgama = ($adaAgama >= $kebutuhanAgama) ? 'LENGKAP' : ($adaAgama > 0 ? 'PARSIAL' : 'KOSONG');

        // Status keseluruhan
        $allLengkap = ($statusKelas === 'LENGKAP' && $statusPenjas === 'LENGKAP' && $statusAgama === 'LENGKAP');
        $someEmpty = ($statusKelas === 'KOSONG' || $statusPenjas === 'KOSONG' || $statusAgama === 'KOSONG');
        $status = $allLengkap ? 'LENGKAP' : ($someEmpty ? 'KOSONG' : 'PARSIAL');

        return [
            'jumlah_rombel' => $jumlahRombel,
            'guru_kelas' => [
                'kebutuhan' => $kebutuhanKelas,
                'ada' => $adaKelas,
                'kurang' => $kurangKelas,
                'status' => $statusKelas,
            ],
            'guru_penjas' => [
                'kebutuhan' => $kebutuhanPenjas,
                'ada' => $adaPenjas,
                'kurang' => $kurangPenjas,
                'status' => $statusPenjas,
            ],
            'guru_agama' => [
                'kebutuhan' => $kebutuhanAgama,
                'ada' => $adaAgama,
                'kurang' => $kurangAgama,
                'status' => $statusAgama,
            ],
            'status' => $status,
        ];
    }

    /**
     * Hitung statistik
     */
    private function hitungStatistik()
    {
        $totalSekolah = UnitKerja::where('level', 3)->count();
        $sekolahLengkap = 0;
        $sekolahParsial = 0;
        $sekolahKosong = 0;

        $sekolahList = UnitKerja::where('level', 3)->with(['rombels', 'pegawais'])->get();
        foreach ($sekolahList as $sekolah) {
            $mapping = $this->hitungKebutuhanGuru($sekolah);
            match ($mapping['status']) {
                'LENGKAP' => $sekolahLengkap++,
                'PARSIAL' => $sekolahParsial++,
                'KOSONG' => $sekolahKosong++,
                default => null,
            };
        }

        return [
            'total_sekolah' => $totalSekolah,
            'sekolah_lengkap' => $sekolahLengkap,
            'sekolah_parsial' => $sekolahParsial,
            'sekolah_kosong' => $sekolahKosong,
        ];
    }

    /**
     * Helper: Get formasi_jabatan_id by tipe
     */
    private function getFormasiId($tipe)
    {
        // Mapping dari tipe ke formasi_jabatan_id
        // Ini adalah placeholder - harus disesuaikan dengan data actual di database
        $formasiMap = [
            'guru_kelas_sd' => null,  // akan dicari dari database
            'guru_penjas_sd' => null,
            'guru_agama_sd' => null,
        ];

        // Query dari database jika ada tabel formasi_jabatans
        // Untuk sementara, return null dan cek di query
        return null;
    }
}
