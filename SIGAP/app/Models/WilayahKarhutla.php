<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WilayahKarhutla extends Model
{
    protected $table = 'wilayah_karhutla';

    protected $fillable = [
        'kode_wilayah',
        'kode_kabupaten',
        'kabupaten',
        'kode_kecamatan',
        'kecamatan',
        'kode_desa',
        'desa_kelurahan',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];
}
