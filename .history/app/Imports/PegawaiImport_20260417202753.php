<?php

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\Golongan;
use App\Models\StatusAsn;
use App\Models\JenjangPendidikan;
use App\Models\UnitKerja;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Log;

class PegawaiImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    private $failures = [];
    private $rowCount = 0;
    private $headerKeysLogged = false;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Log header keys on first row
        if (!$this->headerKeysLogged) {
            Log::debug('Excel Header Keys Found:', array_keys($row));
            Log::debug('Excel First Row Data:', $row);
            $this->headerKeysLogged = true;
        }

        $this->rowCount++;

        // Get kode/nama from Excel
        $golKode = $row['gol'] ?? $row['GOL'] ?? null;
        $statusAsnValue = $row['status_asn'] ?? $row['STATUS_ASN'] ?? null;
        $pendidikanValue = $row['pendidikan'] ?? $row['PENDIDIKAN'] ?? null;
        $unitKerja1Value = $row['unit_kerja_1'] ?? $row['UNIT_KERJA_1'] ?? $row['unit_kerja_satu'] ?? $row['UNIT_KERJA_SATU'] ?? null;
        $unitKerja2Value = $row['unit_kerja_2'] ?? $row['UNIT_KERJA_2'] ?? null;
        $unitKerja3Value = $row['unit_kerja_3'] ?? $row['UNIT_KERJA_3'] ?? null;

        // Lookup master data and get IDs
        $golonganId = $this->lookupGolongan($golKode);
        $statusAsnId = $this->lookupStatusAsn($statusAsnValue);
        $jenjangPendidikanId = $this->lookupJenjangPendidikan($pendidikanValue);
        $unitKerja1Id = $this->lookupUnitKerja($unitKerja1Value);
        $unitKerja2Id = $this->lookupUnitKerja($unitKerja2Value);
        $unitKerja3Id = $this->lookupUnitKerja($unitKerja3Value);

        return new Pegawai([
            'nip'                    => !empty($row['nip']) ? (int)$row['nip'] : null,
            'nama_lengkap'           => $row['nama_lengkap'] ?? null,
            'tgl_lahir'              => $this->parseDate($row['tgl_lahir'] ?? null),
            'pensiun'                => $this->parseDate($row['pensiun'] ?? null),
            'bup'                    => !empty($row['bup']) ? (int)$row['bup'] : null,
            'golongan_id'            => $golonganId,
            'golongan'               => $golKode,  // Keep for reference
            'tmt_golongan'           => $this->parseDate($row['tmt_gol'] ?? $row['TMT_GOL'] ?? null),
            'jabatan'                => $row['jabatan'] ?? $row['JABATAN'] ?? null,
            'tmt_jabatan'            => $this->parseDate($row['tmt_jabatan'] ?? $row['TMT_JABATAN'] ?? null),
            'esl'                    => $row['esl'] ?? $row['ESL'] ?? null,
            'tmt_cpns'               => $this->parseDate($row['tmt_cpns'] ?? $row['TMT_CPNS'] ?? null),
            'jenjang_pendidikan_id'  => $jenjangPendidikanId,
            'pendidikan'             => $pendidikanValue,  // Keep for reference
            'thn_lulus'              => !empty($row['thn_lulus'] ?? $row['THN_LULUS'] ?? null) ? (int)($row['thn_lulus'] ?? $row['THN_LULUS']) : null,
            'status_asn_id'          => $statusAsnId,
            'status_asn'             => $statusAsnValue,  // Keep for reference
            'status_aktif'           => $row['status_aktif'] ?? $row['STATUS_AKTIF'] ?? 'aktif',
            'formasi_jabatan'        => $row['formasi_jabatan'] ?? $row['FORMASI_JABATAN'] ?? null,
            'unit_kerja_satu_id'     => $unitKerja1Id,
            'unit_kerja_satu'        => $unitKerja1Value,  // Keep for reference
            'unit_kerja_2_id'        => $unitKerja2Id,
            'unit_kerja_2'           => $unitKerja2Value,  // Keep for reference
            'unit_kerja_3_id'        => $unitKerja3Id,
            'unit_kerja_3'           => $unitKerja3Value,  // Keep for reference
        ]);
    }

    /**
     * Lookup Golongan by kode
     */
    private function lookupGolongan($kode)
    {
        if (empty($kode)) {
            return null;
        }

        // Normalize kode (e.g., "iii/d" -> "III/d")
        $kodeNormalized = strtoupper(substr($kode, 0, 1)) . substr($kode, 1);

        $golongan = Golongan::where('kode', $kodeNormalized)
            ->orWhere('kode', $kode)
            ->first();

        return $golongan?->id;
    }

    /**
     * Lookup Status ASN by kode or nama
     */
    private function lookupStatusAsn($value)
    {
        if (empty($value)) {
            return null;
        }

        $statusAsn = StatusAsn::where('kode', $value)
            ->orWhere('nama', $value)
            ->first();

        return $statusAsn?->id;
    }

    /**
     * Lookup Jenjang Pendidikan by kode or nama_jenjang
     */
    private function lookupJenjangPendidikan($value)
    {
        if (empty($value)) {
            return null;
        }

        $jenjang = JenjangPendidikan::where('kode', $value)
            ->orWhere('nama_jenjang', 'like', '%' . $value . '%')
            ->first();

        return $jenjang?->id;
    }

    /**
     * Lookup Unit Kerja by nama
     */
    private function lookupUnitKerja($nama)
    {
        if (empty($nama)) {
            return null;
        }

        $unitKerja = UnitKerja::where('nama', $nama)
            ->orWhere('nama', 'like', '%' . $nama . '%')
            ->first();

        return $unitKerja?->id;
    }

    /**
     * Parse date from Excel format
     * Support: DD-MM-YYYY, DD/MM/YYYY, YYYY-MM-DD, Excel serial dates
     */
    private function parseDate($date)
    {
        if (empty($date) || $date === '' || $date === 0) {
            return null;
        }

        // If already YYYY-MM-DD format
        if (is_string($date) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $date;
        }

        // If DD-MM-YYYY format (16-01-1984)
        if (is_string($date) && preg_match('/^(\d{1,2})-(\d{1,2})-(\d{4})$/', $date, $matches)) {
            return $matches[3] . '-' . str_pad($matches[2], 2, '0', STR_PAD_LEFT) . '-' . str_pad($matches[1], 2, '0', STR_PAD_LEFT);
        }

        // If DD/MM/YYYY format (01/02/2042)
        if (is_string($date) && preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $date, $matches)) {
            return $matches[3] . '-' . str_pad($matches[2], 2, '0', STR_PAD_LEFT) . '-' . str_pad($matches[1], 2, '0', STR_PAD_LEFT);
        }

        // If Excel serial date (numeric)
        if (is_numeric($date) && $date > 0) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'nip' => 'required|numeric|unique:pegawais,nip',
            'nama_lengkap' => 'required|string|max:100',
            'tgl_lahir' => 'required|string',
            'gol' => 'required|string|max:10',
            'jabatan' => 'required|string|max:100',
            'pendidikan' => 'required|string|max:50',
            'status_asn' => 'required|string|max:50',
            'unit_kerja_1' => 'required|string|max:100',
        ];
    }

    /**
     * Custom error messages for validation
     */
    public function messages()
    {
        return [
            'nip.required' => 'NIP wajib diisi',
            'nip.numeric' => 'NIP harus berupa angka',
            'nip.unique' => 'NIP sudah terdaftar - NIP harus UNIK',
            'gol.required' => 'Golongan (GOL) wajib diisi - Format: I/a, I/b, II/a, III/d, IV/a, dll',
            'status_asn.required' => 'Status ASN wajib diisi',
            'unit_kerja_1.required' => 'Unit Kerja 1 wajib diisi',
            'pendidikan.required' => 'Pendidikan/Jenjang wajib diisi',
        ];
    }

    /**
     * Custom error messages
     */
    public function customValidationMessages()
    {
        return [
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah terdaftar',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'tgl_lahir.required' => 'Tanggal lahir wajib diisi',
            'gol.required' => 'Golongan (GOL) wajib diisi',
            'jabatan.required' => 'Jabatan wajib diisi',
            'pendidikan.required' => 'Pendidikan wajib diisi',
            'status_asn.required' => 'Status ASN wajib diisi',
            'unit_kerja_1.required' => 'Unit Kerja 1 wajib diisi',
        ];
    }

    /**
     * Handle failures
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->failures[] = $failure;
        }
    }

    /**
     * Get failures
     */
    public function failures()
    {
        return $this->failures;
    }

    /**
     * Helper method to get value from row with multiple possible keys
     */
    private function getValue(array $row, array $possibleKeys)
    {
        foreach ($possibleKeys as $key) {
            if (isset($row[$key]) && !empty($row[$key])) {
                return $row[$key];
            }
        }
        return null;
    }
}
