<?php

namespace App\Imports;

use App\Models\Pegawai;
use App\Models\Golongan;
use App\Models\StatusAsn;
use App\Models\JenjangPendidikan;
use App\Models\UnitKerja;
use App\Models\Jabatan;
use App\Models\Eselon;
use App\Models\FormasiJabatan;
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

        // Get kode/nama from Excel and convert to string (Excel might store as numeric)
        $golKode = $this->toString($row['gol'] ?? $row['GOL'] ?? null);
        $statusAsnValue = $this->toString($row['status_asn'] ?? $row['STATUS_ASN'] ?? null);
        $pendidikanValue = $this->toString($row['pendidikan'] ?? $row['PENDIDIKAN'] ?? null);
        $unitKerja1Value = $this->toString($row['unit_kerja_1'] ?? $row['UNIT_KERJA_1'] ?? null);
        $unitKerja2Value = $this->toString($row['unit_kerja_2'] ?? $row['UNIT_KERJA_2'] ?? null);
        $unitKerja3Value = $this->toString($row['unit_kerja_3'] ?? $row['UNIT_KERJA_3'] ?? null);
        $jabatanValue = $this->toString($row['jabatan'] ?? $row['JABATAN'] ?? null);
        $eselonValue = $this->toString($row['esl'] ?? $row['ESL'] ?? null);
        $formasiJabatanValue = $this->toString($row['formasi_jabatan'] ?? $row['FORMASI_JABATAN'] ?? null);

        // Lookup master data and get IDs
        $golonganId = $this->lookupGolongan($golKode);
        $statusAsnId = $this->lookupStatusAsn($statusAsnValue);
        $jenjangPendidikanId = $this->lookupJenjangPendidikan($pendidikanValue);
        $unitKerja1Id = $this->lookupUnitKerja($unitKerja1Value);
        $unitKerja2Id = $this->lookupUnitKerja($unitKerja2Value);
        $unitKerja3Id = $this->lookupUnitKerja($unitKerja3Value);
        $jabatanId = $this->lookupJabatan($jabatanValue);
        $eselonId = $this->lookupEselon($eselonValue);
        $formasiJabatanId = $this->lookupFormasiJabatan($formasiJabatanValue);

        // Log lookup results for debugging
        if ($this->rowCount <= 3) {
            Log::debug("Row {$this->rowCount} Lookup Results:", [
                'gol' => $golKode . ' -> ID: ' . $golonganId,
                'jabatan' => $jabatanValue . ' -> ID: ' . $jabatanId,
                'esl' => $eselonValue . ' -> ID: ' . $eselonId,
                'pendidikan' => $pendidikanValue . ' -> ID: ' . $jenjangPendidikanId,
                'status_asn' => $statusAsnValue . ' -> ID: ' . $statusAsnId,
                'formasi_jabatan' => $formasiJabatanValue . ' -> ID: ' . $formasiJabatanId,
                'unit_kerja_1' => $unitKerja1Value . ' -> ID: ' . $unitKerja1Id,
            ]);
        }

        return new Pegawai([
            'nip'                    => !empty($row['nip']) ? (int)$row['nip'] : null,
            'nama_lengkap'           => $row['nama_lengkap'] ?? null,
            'tgl_lahir'              => $this->parseDate($row['tgl_lahir'] ?? null),
            'pensiun'                => $this->parseDate($row['pensiun'] ?? null),
            'bup'                    => !empty($row['bup']) ? (int)$row['bup'] : null,
            'golongan_id'            => $golonganId,
            'tmt_golongan'           => $this->parseDate($row['tmt_gol'] ?? $row['TMT_GOL'] ?? null),
            'jabatan_id'             => $jabatanId,
            'tmt_jabatan'            => $this->parseDate($row['tmt_jabatan'] ?? $row['TMT_JABATAN'] ?? null),
            'eselon_id'              => $eselonId,
            'tmt_cpns'               => $this->parseDate($row['tmt_cpns'] ?? $row['TMT_CPNS'] ?? null),
            'jenjang_pendidikan_id'  => $jenjangPendidikanId,
            'thn_lulus'              => !empty($row['thn_lulus'] ?? $row['THN_LULUS'] ?? null) ? (int)($row['thn_lulus'] ?? $row['THN_LULUS']) : null,
            'status_asn_id'          => $statusAsnId,
            'status_aktif'           => $row['status_aktif'] ?? $row['STATUS_AKTIF'] ?? 'aktif',
            'formasi_jabatan_id'     => $formasiJabatanId,
            'unit_kerja_1_id'        => $unitKerja1Id,
            'unit_kerja_2_id'        => $unitKerja2Id,
            'unit_kerja_3_id'        => $unitKerja3Id,
        ]);
    }

    /**
     * Lookup Golongan by ID or kode
     */
    private function lookupGolongan($value)
    {
        if (empty($value)) {
            return null;
        }

        // If numeric, treat as ID
        if (is_numeric($value)) {
            $golongan = Golongan::find($value);
            return $golongan?->id;
        }

        // If string, search by kode
        // Normalize kode (e.g., "iii/d" -> "III/d")
        $kodeNormalized = strtoupper(substr($value, 0, 1)) . substr($value, 1);

        $golongan = Golongan::where('kode', $kodeNormalized)
            ->orWhere('kode', $value)
            ->first();

        return $golongan?->id;
    }

    /**
     * Lookup Status ASN by ID, kode or nama
     */
    private function lookupStatusAsn($value)
    {
        if (empty($value)) {
            return null;
        }

        // If numeric, treat as ID
        if (is_numeric($value)) {
            $statusAsn = StatusAsn::find($value);
            return $statusAsn?->id;
        }

        // If string, search by kode or nama
        $statusAsn = StatusAsn::where('kode', $value)
            ->orWhere('nama', $value)
            ->first();

        return $statusAsn?->id;
    }

    /**
     * Lookup Jenjang Pendidikan by ID, kode or nama_jenjang
     */
    private function lookupJenjangPendidikan($value)
    {
        if (empty($value)) {
            return null;
        }

        // If numeric, treat as ID
        if (is_numeric($value)) {
            $jenjang = JenjangPendidikan::find($value);
            return $jenjang?->id;
        }

        // If string, search by kode or nama_jenjang
        $jenjang = JenjangPendidikan::where('kode', $value)
            ->orWhere('nama_jenjang', 'like', '%' . $value . '%')
            ->first();

        return $jenjang?->id;
    }

    /**
     * Lookup Unit Kerja by ID or nama
     */
    private function lookupUnitKerja($nama)
    {
        if (empty($nama)) {
            return null;
        }

        // If numeric, treat as ID
        if (is_numeric($nama)) {
            $unitKerja = UnitKerja::find($nama);
            return $unitKerja?->id;
        }

        // If string, search by nama
        $unitKerja = UnitKerja::where('nama', $nama)
            ->orWhere('nama', 'like', '%' . $nama . '%')
            ->first();

        return $unitKerja?->id;
    }

    /**
     * Lookup Jabatan by ID or nama
     */
    private function lookupJabatan($value)
    {
        if (empty($value)) {
            return null;
        }

        // If numeric, treat as ID
        if (is_numeric($value)) {
            $jabatan = Jabatan::find($value);
            return $jabatan?->id;
        }

        // If string, search by nama_jabatan
        $jabatan = Jabatan::where('nama_jabatan', $value)
            ->orWhere('nama_jabatan', 'like', '%' . $value . '%')
            ->first();

        return $jabatan?->id;
    }

    /**
     * Lookup Eselon by ID, kode or nama
     */
    private function lookupEselon($value)
    {
        if (empty($value)) {
            return null;
        }

        // If numeric, treat as ID
        if (is_numeric($value)) {
            $eselon = Eselon::find($value);
            return $eselon?->id;
        }

        // If string, search by kode or nama_eselon
        $eselon = Eselon::where('kode', $value)
            ->orWhere('nama_eselon', 'like', '%' . $value . '%')
            ->first();

        return $eselon?->id;
    }

    /**
     * Lookup Formasi Jabatan by ID or nama
     */
    private function lookupFormasiJabatan($value)
    {
        if (empty($value)) {
            return null;
        }

        // If numeric, treat as ID
        if (is_numeric($value)) {
            $formasiJabatan = FormasiJabatan::find($value);
            return $formasiJabatan?->id;
        }

        // If string, search by nama_formasi
        $formasiJabatan = FormasiJabatan::where('nama_formasi', $value)
            ->orWhere('nama_formasi', 'like', '%' . $value . '%')
            ->first();

        return $formasiJabatan?->id;
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
     * Convert any value to string (handle numeric values from Excel)
     */
    private function toString($value)
    {
        if (is_null($value) || $value === '') {
            return null;
        }
        return (string) $value;
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'nip' => 'nullable|numeric|unique:pegawais,nip',
            'nama_lengkap' => 'nullable',
            'tgl_lahir' => 'nullable',
            'gol' => 'nullable',
            'jabatan' => 'nullable',
            'esl' => 'nullable',
            'pendidikan' => 'nullable',
            'status_asn' => 'nullable',
            'formasi_jabatan' => 'nullable',
            'unit_kerja_1' => 'nullable',
        ];
    }

    /**
     * Custom error messages for validation
     */
    public function messages()
    {
        return [
            'nip.numeric' => 'NIP harus berupa angka',
            'nip.unique' => 'NIP sudah terdaftar - NIP harus UNIK',
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

    /**
     * Validate master data references
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // This runs after standard validation
            // Additional custom validation can be added here if needed
        });
    }
}
