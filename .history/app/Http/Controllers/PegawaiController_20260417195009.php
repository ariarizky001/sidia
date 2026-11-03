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
            'file.mimes' => 'File harus format Excel atau CSV',
            'file.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            $import = new PegawaiImport();
            Excel::import($import, $validated['file']);

            // Jika ada error validasi, tampilkan
            if ($import->failures()) {
                $failures = $import->failures();
                $errorMessage = 'Import gagal pada baris: ' . implode(', ', array_map(function($failure) {
                    return 'Baris ' . $failure->row() . ': ' . implode('; ', $failure->errors());
                }, $failures));

                return redirect()->back()
                    ->with('error', $errorMessage)
                    ->withInput();
            }

            return redirect()->route('pegawai.index')
                ->with('success', 'Import berhasil! Data pegawai telah ditambahkan ke database.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = 'Baris ' . $failure->row() . ': ' . implode('; ', $failure->errors());
            }

            return redirect()->back()
                ->with('error', 'Validasi gagal: ' . implode(' | ', $errors))
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal import: ' . $e->getMessage())
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


