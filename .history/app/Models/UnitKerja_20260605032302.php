<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    protected $table = 'unit_kerjas';

    protected $fillable = [
        'nama',
        'parent_id',
        'level',
    ];

    /**
     * Relasi ke parent unit kerja (self-referencing)
     */
    public function parent()
    {
        return $this->belongsTo(UnitKerja::class, 'parent_id');
    }

    /**
     * Relasi ke child unit kerja (self-referencing)
     */
    public function children()
    {
        return $this->hasMany(UnitKerja::class, 'parent_id');
    }

    /**
     * Get all descendants recursively
     */
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    /**
     * Scope untuk mendapatkan unit kerja berdasarkan level
     */
    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    /**
     * Scope untuk mendapatkan parent dari level tertentu
     */
    public function scopeParentOnly($query, $level)
    {
        return $query->where('level', $level)->whereNull('parent_id');
    }

    /**
     * Get semua child dari parent tertentu
     */
    public static function getChildrenByParent($parentId, $level)
    {
        return self::where('parent_id', $parentId)
            ->where('level', $level)
            ->orderBy('nama')
            ->get();
    }

    /**
     * Get semua parent dari level tertentu
     */
    public static function getParentsByLevel($level)
    {
        return self::byLevel($level)
            ->whereNull('parent_id')
            ->orderBy('nama')
            ->get();
    }

    /**
     * Relasi ke Rombel
     */
    public function rombels()
    {
        return $this->hasMany(Rombel::class, 'unit_kerja_id');
    }

    /**
     * Relasi ke Pegawai (guru)
     * Menggunakan unit_kerja_1_id sebagai unit kerja aktif
     */
    public function pegawais()
    {
        return $this->hasMany(Pegawai::class, 'unit_kerja_1_id');
    }

    /**
     * Get full hierarchy path
     */
    public function getFullPath()
    {
        $path = [];
        $unit = $this;

        while ($unit) {
            array_unshift($path, $unit->nama);
            $unit = $unit->parent;
        }

        return implode(' > ', $path);
    }
}
