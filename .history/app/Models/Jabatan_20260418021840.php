<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatans';

    protected $fillable = [
        'nama_jabatan',
        'jenis_jabatan',
        'eselon_id',
        'parent_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke Eselon
     */
    public function eselon()
    {
        return $this->belongsTo(Eselon::class);
    }

    /**
     * Relasi ke parent jabatan (self-referencing)
     */
    public function parent()
    {
        return $this->belongsTo(Jabatan::class, 'parent_id');
    }

    /**
     * Relasi ke child jabatan (self-referencing)
     */
    public function children()
    {
        return $this->hasMany(Jabatan::class, 'parent_id');
    }

    /**
     * Get all descendants recursively
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Scope untuk jabatan aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mendapatkan jabatan berdasarkan jenis
     */
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis_jabatan', $jenis);
    }

    /**
     * Scope untuk mendapatkan jabatan berdasarkan eselon
     */
    public function scopeByEselon($query, $eselonId)
    {
        return $query->where('eselon_id', $eselonId);
    }
}
