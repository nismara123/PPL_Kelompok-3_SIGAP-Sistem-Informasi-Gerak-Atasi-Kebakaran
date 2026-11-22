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
        'alasan_penolakan',
        'riwayat_status',
        'diubah_oleh',
        'diubah_pada',
    ];

    protected $casts = [
        'waktu_kejadian' => 'datetime',
        'diubah_pada' => 'datetime',
        'riwayat_status' => 'array',
    ];
}