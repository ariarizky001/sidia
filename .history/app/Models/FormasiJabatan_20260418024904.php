<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormasiJabatan extends Model
{
    protected $table = 'formasi_jabatans';

    protected $fillable = [
        'nama_formasi',
        'jenis_jabatan',
        'kategori',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope untuk formasi aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mendapatkan formasi berdasarkan jenis
     */
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis_jabatan', $jenis);
    }

    /**
     * Scope untuk mendapatkan formasi berdasarkan kategori
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
