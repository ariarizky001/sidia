<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    protected $table = 'rombels';

    protected $fillable = [
        'jumlah_rombel',
        'unit_kerja_parent_id',
        'unit_kerja_id',
        'keterangan',
    ];

    /**
     * Relasi ke Unit Kerja Parent (Koordinator Wilayah Kecamatan - Level 2)
     */
    public function unitKerjaParent()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_parent_id');
    }

    /**
     * Relasi ke Unit Kerja (Sekolah Dasar - Level 3)
     */
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'unit_kerja_id');
    }
}
