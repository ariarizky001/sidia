<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisUnit extends Model
{
    protected $table = 'jenis_units';

    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'level',
        'is_sekolah',
    ];

    protected $casts = [
        'is_sekolah' => 'boolean',
    ];

    /**
     * Relasi ke UnitKerja
     */
    public function unitKerjas()
    {
        return $this->hasMany(UnitKerja::class, 'jenis_unit_id');
    }

    /**
     * Scope untuk mendapatkan jenis yang merupakan sekolah
     */
    public function scopeSekolah($query)
    {
        return $query->where('is_sekolah', true);
    }

    /**
     * Scope untuk mendapatkan jenis non-sekolah
     */
    public function scopeNonSekolah($query)
    {
        return $query->where('is_sekolah', false);
    }

    /**
     * Get jenis by kode
     */
    public static function getByKode($kode)
    {
        return self::where('kode', $kode)->first();
    }
}
