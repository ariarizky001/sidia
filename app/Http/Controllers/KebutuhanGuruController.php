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
        // Filter jenis sekolah - default SD, bisa dikembangkan untuk SMP
        $jenisSekolah = $request->get('jenis', 'sekolah_sd');
        
        // Validasi jenis yang diperbolehkan
        if (!in_array($jenisSekolah, ['sekolah_sd', 'sekolah_smp'])) {
            $jenisSekolah = 'sekolah_sd';
        }

        // Get filter dari request
        $filterKecamatan = $request->get('kecamatan');
        $filterStatus = $request->get('status');
        $filterSearch = $request->get('search');

        // Fetch Unit Kerja Level 2 sesuai jenis sekolah
        if ($jenisSekolah == 'sekolah_sd') {
            $unitKerjaLevel2 = UnitKerja::where('level', 2)
                ->koordinatorWilayah()
                ->orderBy('nama')->get();
        } else {
            $unitKerjaLevel2 = UnitKerja::where('level', 2)
                ->whereHas('jenisUnit', function($q) {
                    $q->where('kode', 'kelompok_smp');
                })
                ->orderBy('nama')->get();
        }

        // Query sekolah berdasarkan jenis
        $query = UnitKerja::where('level', 3)
            ->whereHas('jenisUnit', function($q) use ($jenisSekolah) {
                $q->where('kode', $jenisSekolah);
            })
            ->with(['parent', 'rombels', 'pegawaisSekolah.formasiJabatanData'])
            ->orderBy('parent_id')
            ->orderBy('nama');

        // Apply filter kecamatan
        if ($filterKecamatan && $filterKecamatan !== 'semua') {
            $query->where('parent_id', $filterKecamatan);
        }

        // Apply search by nama
        if ($filterSearch) {
            $query->where('nama', 'like', "%{$filterSearch}%");
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
        $statistik = $this->hitungStatistik($totalSekolah, $jenisSekolah);

        return view('kebutuhan-guru.index', [
            'title' => 'Kebutuhan Guru per Sekolah',
            'sekolahList' => $sekolahList,
            'mappingData' => $mappingData,
            'unitKerjaLevel2' => $unitKerjaLevel2,
            'filterKecamatan' => $filterKecamatan,
            'filterStatus' => $filterStatus,
            'filterSearch' => $filterSearch,
            'statistik' => $statistik,
            'jenisSekolah' => $jenisSekolah
        ]);
    }

    /**
     * Detail kebutuhan guru per sekolah
     */
    public function show(string $id)
    {
        $sekolah = UnitKerja::where('level', 3)->with(['parent', 'rombels', 'pegawaisSekolah.formasiJabatanData', 'pegawaisSekolah.statusAsnData'])->findOrFail($id);
        
        $mapping = $this->hitungKebutuhanGuru($sekolah);
        
        // Formasi IDs dari database
        $formasiKelasId = 24;    // Guru Kelas
        $formasiPenjasId = 26;   // Guru Penjas
        $formasiAgamaId = 25;    // Guru Agama Islam (default agama)
        
        // Ambil guru per formasi
        $guruKelas = $sekolah->pegawaisSekolah
            ->where('formasi_jabatan_id', $formasiKelasId)
            ->where('status_aktif', 'aktif')
            ->values();
            
        $guruPenjas = $sekolah->pegawaisSekolah
            ->where('formasi_jabatan_id', $formasiPenjasId)
            ->where('status_aktif', 'aktif')
            ->values();
            
        $guruAgama = $sekolah->pegawaisSekolah
            ->whereIn('formasi_jabatan_id', [25, 27, 28, 29])  // All agama formasi
            ->where('status_aktif', 'aktif')
            ->values();

        // Breakdown per status ASN untuk transparansi perhitungan
        $statusBreakdown = function ($collection) {
            $result = ['PNS' => 0, 'PPPK' => 0, 'PPPK-PW' => 0, 'Lainnya' => 0];
            foreach ($collection as $guru) {
                $namaStatus = optional($guru->statusAsnData)->nama ?? '';
                if (str_contains($namaStatus, 'PNS')) {
                    $result['PNS']++;
                } elseif (str_contains($namaStatus, 'PPPK-PW')) {
                    $result['PPPK-PW']++;
                } elseif (str_contains($namaStatus, 'PPPK')) {
                    $result['PPPK']++;
                } else {
                    $result['Lainnya']++;
                }
            }
            return $result;
        };

        $breakdownKelas = $statusBreakdown($guruKelas);
        $breakdownPenjas = $statusBreakdown($guruPenjas);
        $breakdownAgama = $statusBreakdown($guruAgama);

        return view('kebutuhan-guru.show', [
            'title' => 'Detail Kebutuhan Guru',
            'sekolah' => $sekolah,
            'mapping' => $mapping,
            'guruKelas' => $guruKelas,
            'guruPenjas' => $guruPenjas,
            'guruAgama' => $guruAgama,
            'breakdownKelas' => $breakdownKelas,
            'breakdownPenjas' => $breakdownPenjas,
            'breakdownAgama' => $breakdownAgama,
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
        $rombelData = $sekolah->rombels->first();
        if ($rombelData) {
            // Jika tabel rombel punya jumlah_rombel field
            if (isset($rombelData->jumlah_rombel)) {
                $jumlahRombel = $rombelData->jumlah_rombel;
            } else {
                // Jika jumlah_rombel adalah jumlah records rombel
                $jumlahRombel = $sekolah->rombels->count();
            }
        }

        // Kebutuhan
        $kebutuhanKelas = $jumlahRombel;
        $kebutuhanPenjas = 1;
        $kebutuhanAgama = 1;

        // Guru yang ada - query berdasarkan formasi_jabatan_id
        $adaKelas = $sekolah->pegawaisSekolah
            ->where('status_aktif', 'aktif')
            ->where('formasi_jabatan_id', $formasiKelasId)
            ->count();
            
        $adaPenjas = $sekolah->pegawaisSekolah
            ->where('status_aktif', 'aktif')
            ->where('formasi_jabatan_id', $formasiPenjasId)
            ->count();
            
        $adaAgama = $sekolah->pegawaisSekolah
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
    private function hitungStatistik($totalSekolah = null, $jenisSekolah = 'sekolah_sd')
    {
        // Total sekolah = semua unit kerja level 3 sesuai jenis
        if ($totalSekolah === null) {
            $totalSekolah = UnitKerja::where('level', 3)
                ->whereHas('jenisUnit', function($q) use ($jenisSekolah) {
                    $q->where('kode', $jenisSekolah);
                })
                ->count();
        }
        
        $sekolahLengkap = 0;
        $sekolahParsial = 0;
        $sekolahKosong = 0;

        // Query semua sekolah sesuai jenis untuk statistik
        $sekolahList = UnitKerja::where('level', 3)
            ->whereHas('jenisUnit', function($q) use ($jenisSekolah) {
                $q->where('kode', $jenisSekolah);
            })
            ->with(['rombels', 'pegawaisSekolah'])
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
