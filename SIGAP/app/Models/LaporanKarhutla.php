<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKarhutla extends Model
{
    protected $table = 'laporan_karhutla';

    protected $fillable = [
        'kode_laporan',
        'lokasi',
        'waktu_kejadian',
        'deskripsi',
        'foto',
        'status',
    ];

    protected $casts = [
        'waktu_kejadian' => 'datetime',
    ];
}
