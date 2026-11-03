<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eselon extends Model
{
    protected $table = 'eselons';

    protected $fillable = [
        'kode',
        'nama_eselon',
        'deskripsi',
        'status',
    ];
}
