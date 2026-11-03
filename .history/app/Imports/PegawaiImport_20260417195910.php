<?php

namespace App\Imports;

use App\Models\Pegawai;
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
            $this->headerKeysLogged = true;
        }

        $this->rowCount++;

        return new Pegawai([
            'nip'                => $row['nip'] ?? null,
            'nama_lengkap'       => $row['nama_lengkap'] ?? null,
            'tgl_lahir'          => $this->parseDate($row['tgl_lahir'] ?? null),
            'pensiun'            => $this->parseDate($row['pensiun'] ?? null),
            'bup'                => !empty($row['bup']) ? (int)$row['bup'] : null,
            'golongan'           => $row['gol'] ?? null,
            'tmt_golongan'       => $this->parseDate($row['tmt_gol'] ?? null),
            'jabatan'            => $row['jabatan'] ?? null,
            'tmt_jabatan'        => $this->parseDate($row['tmt_jabatan'] ?? null),
            'esl'                => $row['esl'] ?? null,
            'tmt_cpns'           => $this->parseDate($row['tmt_cpns'] ?? null),
            'pendidikan'         => $row['pendidikan'] ?? null,
            'thn_lulus'          => !empty($row['thn_lulus']) ? (int)$row['thn_lulus'] : null,
            'status_asn'         => $row['status_asn'] ?? null,
            'status_aktif'       => $row['status_aktif'] ?? 'aktif',
            'formasi_jabatan'    => $row['formasi_jabatan'] ?? null,
            'unit_kerja_satu'    => $row['unit_kerja_1'] ?? null,
            'unit_kerja_2'       => $row['unit_kerja_2'] ?? null,
            'unit_kerja_3'       => $row['unit_kerja_3'] ?? null,
        ]);
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
            'nip' => 'required|string|max:50|unique:pegawais,nip',
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
}
