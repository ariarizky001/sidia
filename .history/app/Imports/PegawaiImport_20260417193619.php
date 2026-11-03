<?php

namespace App\Imports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PegawaiImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Pegawai([
            'nip'                => $row['nip'] ?? null,
            'nama_lengkap'       => $row['nama_lengkap'] ?? null,
            'tgl_lahir'          => $this->parseDate($row['tgl_lahir'] ?? null),
            'pensiun'            => $this->parseDate($row['pensiun'] ?? null),
            'bup'                => $this->parseDate($row['bup'] ?? null),
            'golongan'           => $row['golongan'] ?? null,
            'tmt_golongan'       => $this->parseDate($row['tmt_golongan'] ?? null),
            'jabatan'            => $row['jabatan'] ?? null,
            'tmt_jabatan'        => $this->parseDate($row['tmt_jabatan'] ?? null),
            'pendidikan'         => $row['pendidikan'] ?? null,
            'thn_lulus'          => $row['thn_lulus'] ?? null,
            'status_asn'         => $row['status_asn'] ?? null,
            'status_aktif'       => $row['status_aktif'] ?? 'aktif',
            'formasi_jabatan'    => $row['formasi_jabatan'] ?? null,
            'unit_kerja_satu'    => $row['unit_kerja_satu'] ?? null,
            'unit_kerja_2'       => $row['unit_kerja_2'] ?? null,
            'unit_kerja_3'       => $row['unit_kerja_3'] ?? null,
        ]);
    }

    /**
     * Parse date from Excel format
     */
    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        // If it's already a date string in format YYYY-MM-DD
        if (is_string($date) && strtotime($date)) {
            return $date;
        }

        // If it's a number (Excel serial date)
        if (is_numeric($date)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
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
            'tgl_lahir' => 'required|date_format:Y-m-d,d/m/Y',
            'golongan' => 'required|string|max:10',
            'jabatan' => 'required|string|max:100',
            'pendidikan' => 'required|string|max:50',
            'status_asn' => 'required|string|max:50',
            'unit_kerja_satu' => 'required|string|max:100',
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
            'golongan.required' => 'Golongan wajib diisi',
            'jabatan.required' => 'Jabatan wajib diisi',
            'pendidikan.required' => 'Pendidikan wajib diisi',
            'status_asn.required' => 'Status ASN wajib diisi',
            'unit_kerja_satu.required' => 'Unit kerja wajib diisi',
        ];
    }
}
