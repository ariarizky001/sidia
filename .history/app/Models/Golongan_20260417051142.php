<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    protected $table = 'golongans';

    protected $fillable = [
        'kode',
        'nama_golongan',
        'urutan',
        'deskripsi',
        'status',
    ];
}
