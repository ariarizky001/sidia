<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusAsn extends Model
{
    protected $table = 'status_asns';

    protected $fillable = [
        'nama_status',
        'deskripsi',
        'status',
    ];
}
