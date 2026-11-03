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
        'jenis_unit_id',
    ];

    /**
     * Relasi ke parent unit kerja (self-referencing)
     */
    public function parent()
    {
        return $this->belongsTo(UnitKerja::class, 'parent_id');
    }

    /**
     * Relasi ke JenisUnit
     */
    public function jenisUnit()
    {
        return $this->belongsTo(JenisUnit::class, 'jenis_unit_id');
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
     * Scope untuk mendapatkan sekolah SD
     */
    public function scopeSekolahSD($query)
    {
        return $query->whereHas('jenisUnit', function($q) {
            $q->where('kode', 'sekolah_sd');
        });
    }

    /**
     * Scope untuk mendapatkan sekolah SMP
     */
    public function scopeSekolahSMP($query)
    {
        return $query->whereHas('jenisUnit', function($q) {
            $q->where('kode', 'sekolah_smp');
        });
    }

    /**
     * Scope untuk mendapatkan sekolah TK
     */
    public function scopeSekolahTK($query)
    {
        return $query->whereHas('jenisUnit', function($q) {
            $q->where('kode', 'sekolah_tk');
        });
    }

    /**
     * Scope untuk mendapatkan koordinator wilayah
     */
    public function scopeKoordinatorWilayah($query)
    {
        return $query->whereHas('jenisUnit', function($q) {
            $q->where('kode', 'koordinator_wilayah');
        });
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
     * Relasi ke Pegawai (guru) khusus untuk sekolah (level 3)
     * Digunakan untuk eager loading agar tidak salah ambil unit_kerja_1_id
     */
    public function pegawaisSekolah()
    {
        return $this->hasMany(Pegawai::class, 'unit_kerja_3_id');
    }

    /**
     * Relasi ke Pegawai (guru)
     * Untuk sekolah (level 3): gunakan unit_kerja_3_id
     */
    public function pegawais()
    {
        // Unit kerja level 3 adalah sekolah, guru tersimpan di unit_kerja_3_id
        if ($this->level === 3) {
            return $this->hasMany(Pegawai::class, 'unit_kerja_3_id');
        }
        // Untuk level lain, gunakan unit_kerja_1_id
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

    /**
     * Helper method untuk cek apakah unit ini adalah sekolah
     */
    public function isSekolah(): bool
    {
        return $this->jenisUnit && $this->jenisUnit->is_sekolah;
    }

    /**
     * Get label jenis sekolah
     */
    public function getJenisSekolahLabel(): ?string
    {
        if (!$this->jenisUnit) {
            return null;
        }

        return match($this->jenisUnit->kode) {
            'sekolah_sd' => 'SD',
            'sekolah_smp' => 'SMP',
            'sekolah_tk' => 'TK',
            default => null,
        };
    }
}
