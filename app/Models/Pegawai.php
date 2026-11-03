<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'pegawais';

    protected $fillable = [
        'nip',
        'nama_lengkap',
        'tgl_lahir',
        'pensiun',
        'bup',
        'golongan_id',
        'tmt_golongan',
        'jabatan_id',
        'tmt_jabatan',
        'eselon_id',
        'tmt_cpns',
        'jenjang_pendidikan_id',
        'thn_lulus',
        'status_asn_id',
        'status_aktif',
        'formasi_jabatan_id',
        'unit_kerja_1_id',
        'unit_kerja_2_id',
        'unit_kerja_3_id',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'pensiun' => 'date',
        'bup' => 'integer',  // Fixed: BUP is age/usia, not date
        'tmt_golongan' => 'date',
        'tmt_jabatan' => 'date',
        'tmt_cpns' => 'date',
    ];

    /**
     * Relationship: Golongan
     */
    public function golonganData()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id');
    }

    /**
     * Relationship: Eselon
     */
    public function eselonData()
    {
        return $this->belongsTo(Eselon::class, 'eselon_id');
    }

    /**
     * Relationship: Status ASN
     */
    public function statusAsnData()
    {
        return $this->belongsTo(StatusAsn::class, 'status_asn_id');
    }

    /**
     * Relationship: Jabatan
     */
    public function jabatanData()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    /**
     * Relationship: Formasi Jabatan
     */
    public function formasiJabatanData()
    {
        return $this->belongsTo(FormasiJabatan::class, 'formasi_jabatan_id');
    }

    /**
     * Relationship: Jenjang Pendidikan
     */
    public function jenjangPendidikanData()
    {
        return $this->belongsTo(JenjangPendidikan::class, 'jenjang_pendidikan_id');
    }

    /**
     * Relationship: Unit Kerja 1
     */
    public function unitKerja1()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_1_id');
    }

    /**
     * Relationship: Unit Kerja 2
     */
    public function unitKerja2()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_2_id');
    }

    /**
     * Relationship: Unit Kerja 3
     */
    public function unitKerja3()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_3_id');
    }

    /**
     * Relationship: Unit Kerja (untuk mapping guru)
     * Ambil dari unit_kerja_1_id sebagai unit kerja aktif
     */
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_1_id');
    }
}
