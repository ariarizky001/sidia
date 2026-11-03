<?php

namespace App\Http\Controllers;

use App\Exports\PegawaiTemplate;
use App\Imports\PegawaiImport;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = Pegawai::all();

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
        return view('pegawai.create', [
            'title' => 'Tambah Pegawai'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'nip' => 'required|unique:pegawais|max:50',
            'nama_lengkap' => 'required|max:100',
            'tgl_lahir' => 'required|date',
            'pensiun' => 'nullable|date',
            'bup' => 'nullable|date',
            'golongan' => 'required|max:10',
            'tmt_golongan' => 'nullable|date',
            'jabatan' => 'required|max:100',
            'tmt_jabatan' => 'nullable|date',
            'pendidikan' => 'required|max:50',
            'thn_lulus' => 'nullable|integer|min:1950|max:2100',
            'status_asn' => 'required|max:50',
            'formasi_jabatan' => 'nullable|max:100',
            'unit_kerja_satu' => 'required|max:100',
            'unit_kerja_2' => 'nullable|max:100',
            'unit_kerja_3' => 'nullable|max:100',
        ]);

        Pegawai::create($validated);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

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
        $pegawai = Pegawai::findOrFail($id);

        return view('pegawai.edit', [
            'pegawai' => $pegawai,
            'title' => 'Edit Pegawai'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi
        $validated = $request->validate([
            'nip' => 'required|max:50',
            'nama_lengkap' => 'required|max:100',
            'tgl_lahir' => 'required|date',
            'pensiun' => 'nullable|date',
            'bup' => 'nullable|date',
            'golongan' => 'required|max:10',
            'tmt_golongan' => 'nullable|date',
            'jabatan' => 'required|max:100',
            'tmt_jabatan' => 'nullable|date',
            'pendidikan' => 'required|max:50',
            'thn_lulus' => 'nullable|integer|min:1950|max:2100',
            'status_asn' => 'required|max:50',
            'formasi_jabatan' => 'nullable|max:100',
            'unit_kerja_satu' => 'required|max:100',
            'unit_kerja_2' => 'nullable|max:100',
            'unit_kerja_3' => 'nullable|max:100',
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
                
                $errorMessage = "❌ Import gagal pada " . count($failures) . " baris:\n\n" . implode("\n\n", $errorDetails);
                
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
            
            $errorMessage = "❌ Validasi gagal pada " . count($failures) . " baris:\n\n" . implode("\n\n", $errorDetails);
            
            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
                
        } catch (\Exception $e) {
            // General exception handler
            $errorMessage = "❌ Gagal import: " . $e->getMessage();
            
            // Add more details if it's a specific error
            if (strpos($e->getMessage(), 'SQLSTATE') !== false) {
                $errorMessage .= "\n\nMungkin ada masalah dengan data Anda. Pastikan:\n";
                $errorMessage .= "- NIP belum terdaftar (NIP harus unik)\n";
                $errorMessage .= "- Semua kolom wajib terisi\n";
                $errorMessage .= "- Format tanggal benar (DD-MM-YYYY atau DD/MM/YYYY)";
            }
            
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
}


