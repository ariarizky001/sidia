<?php

namespace App\Http\Controllers;

use App\Models\UnitKerja;
use App\Models\Pegawai;
use App\Models\Rombel;
use App\Models\FormasiJabatan;
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

        // Query SEMUA SEKOLAH (level 3) - biar user bisa lihat semua dan update data
        $query = UnitKerja::where('level', 3)
            ->with(['parent', 'rombels', 'pegawais.formasiJabatanData'])
            ->orderBy('parent_id')
            ->orderBy('nama');

        // Apply filter kecamatan
        if ($filterKecamatan && $filterKecamatan !== 'semua') {
            $query->where('parent_id', $filterKecamatan);
        }

        // Get total before pagination untuk statistik
        $totalSekolah = $query->count();
        
        $sekolahList = $query->paginate(10)->appends(request()->query());

        // Hitung mapping untuk setiap sekolah
        $mappingData = [];
        $statusCount = ['LENGKAP' => 0, 'PARSIAL' => 0, 'KOSONG' => 0];
        
        foreach ($sekolahList as $sekolah) {
            $mapping = $this->hitungKebutuhanGuru($sekolah);
            
            // Apply filter status jika ada
            if ($filterStatus && $filterStatus !== 'semua' && $mapping['status'] !== $filterStatus) {
                continue;
            }
            
            $mappingData[$sekolah->id] = $mapping;
            $statusCount[$mapping['status']]++;
        }

        // Hitung statistik untuk semua sekolah
        $statistik = $this->hitungStatistik($totalSekolah);

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
        $sekolah = UnitKerja::where('level', 3)->with(['parent', 'rombels', 'pegawais.formasiJabatanData'])->findOrFail($id);
        
        $mapping = $this->hitungKebutuhanGuru($sekolah);
        
        // Formasi IDs dari database
        $formasiKelasId = 24;    // Guru Kelas
        $formasiPenjasId = 26;   // Guru Penjas
        $formasiAgamaId = 25;    // Guru Agama Islam (default agama)
        
        // Ambil guru per formasi
        $guruKelas = $sekolah->pegawais()
            ->where('formasi_jabatan_id', $formasiKelasId)
            ->where('status_aktif', 'aktif')
            ->get();
            
        $guruPenjas = $sekolah->pegawais()
            ->where('formasi_jabatan_id', $formasiPenjasId)
            ->where('status_aktif', 'aktif')
            ->get();
            
        $guruAgama = $sekolah->pegawais()
            ->whereIn('formasi_jabatan_id', [25, 27, 28, 29])  // All agama formasi
            ->where('status_aktif', 'aktif')
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
        // Formasi IDs dari database
        $formasiKelasId = 24;    // Guru Kelas SD
        $formasiPenjasId = 26;   // Guru Penjas SD
        // Guru Agama: 25=Islam, 27=Kristen, 28=Katolik, 29=Hindu
        $formasiAgamaIds = [25, 27, 28, 29];
        
        // Hitung jumlah rombel
        $jumlahRombel = 0;
        
        // Ambil dari tabel rombel
        $rombelData = $sekolah->rombels()->first();
        if ($rombelData) {
            // Jika tabel rombel punya jumlah_rombel field
            if (isset($rombelData->jumlah_rombel)) {
                $jumlahRombel = $rombelData->jumlah_rombel;
            } else {
                // Jika jumlah_rombel adalah jumlah records rombel
                $jumlahRombel = $sekolah->rombels()->count();
            }
        }

        // Kebutuhan
        $kebutuhanKelas = $jumlahRombel;
        $kebutuhanPenjas = 1;
        $kebutuhanAgama = 1;

        // Guru yang ada - query berdasarkan formasi_jabatan_id
        $adaKelas = $sekolah->pegawais()
            ->where('status_aktif', 'aktif')
            ->where('formasi_jabatan_id', $formasiKelasId)
            ->count();
            
        $adaPenjas = $sekolah->pegawais()
            ->where('status_aktif', 'aktif')
            ->where('formasi_jabatan_id', $formasiPenjasId)
            ->count();
            
        $adaAgama = $sekolah->pegawais()
            ->where('status_aktif', 'aktif')
            ->whereIn('formasi_jabatan_id', $formasiAgamaIds)
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
        // Total sekolah = unit kerja level 3 yang memiliki rombel
        $totalSekolah = UnitKerja::where('level', 3)
            ->whereExists(function ($q) {
                $q->select('id')
                    ->from('rombels')
                    ->whereRaw('rombels.unit_kerja_id = unit_kerjas.id');
            })
            ->count();
        
        $sekolahLengkap = 0;
        $sekolahParsial = 0;
        $sekolahKosong = 0;

        $sekolahList = UnitKerja::where('level', 3)
            ->whereExists(function ($q) {
                $q->select('id')
                    ->from('rombels')
                    ->whereRaw('rombels.unit_kerja_id = unit_kerjas.id');
            })
            ->with(['rombels', 'pegawais'])
            ->get();
            
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
     * Get formasi_jabatan ID berdasarkan nama/jenis
     * Mapping dari nama ke formasi_jabatan_id
     */
    private function getFormasiIdByNama($nama)
    {
        // Cache untuk menyimpan formasi ID
        static $formasiCache = [];
        
        if (isset($formasiCache[$nama])) {
            return $formasiCache[$nama];
        }

        // Query formasi berdasarkan nama_formasi atau jenis_jabatan
        $formasi = FormasiJabatan::where('nama_formasi', 'like', '%' . str_replace('_', '%', $nama) . '%')
            ->orWhere('jenis_jabatan', $nama)
            ->first();

        $id = $formasi ? $formasi->id : null;
        $formasiCache[$nama] = $id;

        return $id;
    }
}
