<?php

namespace App\Http\Controllers;

use App\Exports\PegawaiTemplate;
use App\Imports\PegawaiImport;
use App\Models\Pegawai;
use App\Models\Eselon;
use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\FormasiJabatan;
use App\Models\JenjangPendidikan;
use App\Models\StatusAsn;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = Pegawai::with('golonganData', 'jabatanData', 'statusAsnData', 'eselonData', 'jenjangPendidikanData', 'unitKerja1', 'unitKerja2', 'unitKerja3', 'formasiJabatanData')->get();

        return view('pegawai.index', [
            'pegawai' => $pegawai,
            'title' => 'Data Pegawai'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $golongans = Golongan::all()->sortBy('kode');
        $jabatans = Jabatan::where('is_active', true)->orderBy('nama_jabatan')->get();
        $eselons = Eselon::where('status', 'aktif')->orderBy('kode')->get();
        $formasiJabatans = FormasiJabatan::where('is_active', true)->orderBy('nama_formasi')->get();
        $jenjangPendidikans = JenjangPendidikan::all()->sortBy('kode');
        $statusAsns = StatusAsn::where('aktif', true)->orderBy('nama')->get();
        $unitKerjas = UnitKerja::all()->sortBy('nama');

        return view('pegawai.create', [
            'title' => 'Tambah Pegawai',
            'golongans' => $golongans,
            'jabatans' => $jabatans,
            'eselons' => $eselons,
            'formasiJabatans' => $formasiJabatans,
            'jenjangPendidikans' => $jenjangPendidikans,
            'statusAsns' => $statusAsns,
            'unitKerjas' => $unitKerjas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'nip' => 'required|unique:pegawais|numeric',
            'nama_lengkap' => 'required|max:100',
            'tgl_lahir' => 'required|date',
            'pensiun' => 'nullable|date',
            'bup' => 'nullable|integer',
            'golongan_id' => 'required|exists:golongans,id',
            'tmt_golongan' => 'required|date',
            'jabatan_id' => 'required|exists:jabatans,id',
            'tmt_jabatan' => 'required|date',
            'eselon_id' => 'nullable|exists:eselons,id',
            'tmt_cpns' => 'required|date',
            'jenjang_pendidikan_id' => 'required|exists:jenjang_pendidikans,id',
            'thn_lulus' => 'nullable|integer|min:1950|max:2100',
            'status_asn_id' => 'required|exists:status_asns,id',
            'status_aktif' => 'required|in:aktif,nonaktif',
            'formasi_jabatan_id' => 'nullable|exists:formasi_jabatans,id',
            'unit_kerja_1_id' => 'required|exists:unit_kerjas,id',
            'unit_kerja_2_id' => 'nullable|exists:unit_kerjas,id',
            'unit_kerja_3_id' => 'nullable|exists:unit_kerjas,id',
        ]);

        Pegawai::create($validated);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pegawai = Pegawai::with('golonganData', 'jabatanData', 'statusAsnData', 'eselonData', 'jenjangPendidikanData', 'unitKerja1', 'unitKerja2', 'unitKerja3', 'formasiJabatanData')->findOrFail($id);

        return view('pegawai.show', [
            'pegawai' => $pegawai,
            'title' => 'Detail Pegawai'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pegawai = Pegawai::with('golonganData', 'jabatanData', 'statusAsnData', 'eselonData', 'jenjangPendidikanData', 'unitKerja1', 'unitKerja2', 'unitKerja3', 'formasiJabatanData')->findOrFail($id);
        $golongans = Golongan::all()->sortBy('kode');
        $jabatans = Jabatan::where('is_active', true)->orderBy('nama_jabatan')->get();
        $eselons = Eselon::where('status', 'aktif')->orderBy('kode')->get();
        $formasiJabatans = FormasiJabatan::where('is_active', true)->orderBy('nama_formasi')->get();
        $jenjangPendidikans = JenjangPendidikan::all()->sortBy('kode');
        $statusAsns = StatusAsn::where('aktif', true)->orderBy('nama')->get();
        $unitKerjas = UnitKerja::all()->sortBy('nama');

        return view('pegawai.edit', [
            'pegawai' => $pegawai,
            'title' => 'Edit Pegawai',
            'golongans' => $golongans,
            'jabatans' => $jabatans,
            'eselons' => $eselons,
            'formasiJabatans' => $formasiJabatans,
            'jenjangPendidikans' => $jenjangPendidikans,
            'statusAsns' => $statusAsns,
            'unitKerjas' => $unitKerjas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi
        $validated = $request->validate([
            'nip' => 'required|numeric',
            'nama_lengkap' => 'required|max:100',
            'tgl_lahir' => 'required|date',
            'pensiun' => 'nullable|date',
            'bup' => 'nullable|integer',
            'golongan_id' => 'required|exists:golongans,id',
            'tmt_golongan' => 'required|date',
            'jabatan_id' => 'required|exists:jabatans,id',
            'tmt_jabatan' => 'required|date',
            'eselon_id' => 'nullable|exists:eselons,id',
            'tmt_cpns' => 'required|date',
            'jenjang_pendidikan_id' => 'required|exists:jenjang_pendidikans,id',
            'thn_lulus' => 'nullable|integer|min:1950|max:2100',
            'status_asn_id' => 'required|exists:status_asns,id',
            'status_aktif' => 'required|in:aktif,nonaktif',
            'formasi_jabatan_id' => 'nullable|exists:formasi_jabatans,id',
            'unit_kerja_1_id' => 'required|exists:unit_kerjas,id',
            'unit_kerja_2_id' => 'nullable|exists:unit_kerjas,id',
            'unit_kerja_3_id' => 'nullable|exists:unit_kerjas,id',
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($validated);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus');
    }

    /**
     * Show import form
     */
    public function importForm()
    {
        return view('pegawai.import', [
            'title' => 'Import Data Pegawai'
        ]);
    }

    /**
     * Process Excel import
     */
    public function processImport(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240', // Max 10MB
        ], [
            'file.required' => 'File wajib diupload',
            'file.mimes' => 'File harus format Excel (.xlsx, .xls) atau CSV',
            'file.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            $import = new PegawaiImport();

            // Try import
            Excel::import($import, $validated['file']);

            // Check if there are failures
            $failures = $import->failures();

            if (!empty($failures)) {
                $errorDetails = [];
                foreach ($failures as $failure) {
                    $rowNum = $failure->row();
                    $errors = $failure->errors();
                    $errorDetails[] = "Baris $rowNum: " . implode(", ", $errors);
                }

                $errorMessage = "❌ IMPORT GAGAL pada " . count($failures) . " baris\n\n";
                $errorMessage .= "DETAIL ERROR:\n";
                $errorMessage .= implode("\n", array_slice($errorDetails, 0, 10)); // Show first 10 errors
                if (count($errorDetails) > 10) {
                    $errorMessage .= "\n\n... dan " . (count($errorDetails) - 10) . " error lainnya";
                }

                $errorMessage .= "\n\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
                $errorMessage .= "KEMUNGKINAN PENYEBAB & SOLUSI:\n\n";

                // Check if error contains field-specific issues
                $allErrors = implode(" ", $errorDetails);
                if (strpos($allErrors, 'nip') !== false) {
                    $errorMessage .= "📌 ERROR: NIP\n";
                    $errorMessage .= "   • NIP harus UNIK (tidak boleh duplikat)\n";
                    $errorMessage .= "   • NIP tidak boleh kosong\n";
                    $errorMessage .= "   • Contoh format: 123456789\n\n";
                }
                if (strpos($allErrors, 'gol') !== false || strpos($allErrors, 'GOL') !== false) {
                    $errorMessage .= "📌 ERROR: GOLONGAN (GOL)\n";
                    $errorMessage .= "   • Kolom 'GOL' tidak boleh kosong\n";
                    $errorMessage .= "   • Format: I/a, I/b, II/a, II/b, III/d, IV/a, dll\n";
                    $errorMessage .= "   • Pastikan header Excel tepat bernama 'GOL' (case-sensitive)\n";
                    $errorMessage .= "   • Jika pakai lowercase 'gol', ubah ke 'GOL'\n\n";
                }
                if (strpos($allErrors, 'unit_kerja') !== false) {
                    $errorMessage .= "📌 ERROR: UNIT_KERJA_1\n";
                    $errorMessage .= "   • Kolom 'UNIT_KERJA_1' tidak boleh kosong\n";
                    $errorMessage .= "   • Pastikan header Excel: 'UNIT_KERJA_1' (bukan 'UNIT KERJA_1' atau 'unit_kerja_1')\n";
                    $errorMessage .= "   • Isi dengan nama unit kerja sesuai master data\n\n";
                }

                $errorMessage .= "✅ SOLUSI CEPAT:\n";
                $errorMessage .= "1. Download template import terbaru\n";
                $errorMessage .= "2. Copy data Anda ke template\n";
                $errorMessage .= "3. Pastikan SEMUA field wajib terisi:\n";
                $errorMessage .= "   - NIP, NAMA_LENGKAP, TGL_LAHIR, GOL, JABATAN,\n";
                $errorMessage .= "   - PENDIDIKAN, STATUS_ASN, UNIT_KERJA_1\n";
                $errorMessage .= "4. Periksa: Header harus EXACTLY sesuai template\n";
                $errorMessage .= "5. Upload kembali";


                return redirect()->back()
                    ->with('error', $errorMessage)
                    ->withInput();
            }

            return redirect()->route('pegawai.index')
                ->with('success', '✅ Import berhasil! Data pegawai telah ditambahkan ke database.');

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Catch validation exception if thrown
            $failures = $e->failures();
            $errorDetails = [];

            foreach ($failures as $failure) {
                $rowNum = $failure->row();
                $errors = $failure->errors();
                $errorDetails[] = "Baris $rowNum: " . implode(", ", $errors);
            }

            $errorMessage = "❌ VALIDASI GAGAL pada " . count($failures) . " baris\n\n";
            $errorMessage .= implode("\n", $errorDetails);

            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();

        } catch (\Exception $e) {
            // General exception handler
            $errorMessage = "❌ GAGAL IMPORT\n\n";
            $errorMessage .= "Error: " . $e->getMessage() . "\n\n";

            $errorMessage .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            $errorMessage .= "KEMUNGKINAN PENYEBAB:\n";

            if (strpos($e->getMessage(), 'SQLSTATE') !== false || strpos($e->getMessage(), 'Duplicate') !== false) {
                $errorMessage .= "❌ NIP sudah terdaftar (NIP harus UNIK)\n";
                $errorMessage .= "   Cek apakah ada data dengan NIP yang sama di database";
            } elseif (strpos($e->getMessage(), 'Undefined') !== false || strpos($e->getMessage(), 'array key') !== false) {
                $errorMessage .= "❌ Header Excel tidak sesuai\n";
                $errorMessage .= "   Header harus: NIP, NAMA_LENGKAP, TGL_LAHIR, Pensiun, BUP, GOL, TMT_GOL, JABATAN, TMT_JABATAN, ESL, TMT_CPNS, PENDIDIKAN, THN_LULUS, STATUS_ASN, FORMASI_JABATAN, UNIT_KERJA_1, UNIT_KERJA_2, UNIT_KERJA_3\n";
                $errorMessage .= "   Download template untuk format yang benar";
            } else {
                $errorMessage .= "❌ Error sistem: " . $e->getMessage();
            }

            $errorMessage .= "\n\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            $errorMessage .= "SOLUSI:\n";
            $errorMessage .= "1. Download template dari tombol 'Download Template Excel'\n";
            $errorMessage .= "2. Copy data Anda ke template (sesuaikan header)\n";
            $errorMessage .= "3. Cek format tanggal: DD-MM-YYYY atau DD/MM/YYYY\n";
            $errorMessage .= "4. Pastikan NIP unik (belum ada di database)\n";
            $errorMessage .= "5. Upload kembali";

            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
    }

    /**
     * Download template Excel
     */
    public function downloadTemplate()
    {
        return Excel::download(new PegawaiTemplate(), 'Template_Import_Pegawai.xlsx');
    }

    /**
     * Get children unit kerja by parent_id
     */
    public function getUnitKerjaChildren($parentId)
    {
        $children = UnitKerja::where('parent_id', $parentId)
            ->orderBy('nama')
            ->get(['id', 'nama', 'parent_id', 'level']);

        return response()->json($children);
    }

    /**
     * Get all level 1 unit kerja
     */
    public function getUnitKerjaLevel1()
    {
        $level1 = UnitKerja::where('level', 1)
            ->orderBy('nama')
            ->get(['id', 'nama', 'level']);

        return response()->json($level1);
    }
}


