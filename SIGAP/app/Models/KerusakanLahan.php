<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KerusakanLahan extends Model
{
    protected $table = 'kerusakan_lahan';

    public const JENIS = ['Lahan gambut', 'Hutan', 'Semak belukar', 'Lahan pertanian', 'Perkebunan'];

    // Warna badge per jenis kerusakan (tampilan)
    public const WARNA = [
        'Lahan gambut' => '#6B4F3A',
        'Hutan' => '#2F6F4E',
        'Semak belukar' => '#7F8F2F',
        'Lahan pertanian' => '#B9892D',
        'Perkebunan' => '#3A7D8A',
    ];

    protected $fillable = [
        'wilayah_id',
        'lokasi',
        'jenis_kerusakan',
        'luas_ha',
        'tanggal_pencatatan',
        'keterangan',
        'user_id',
    ];

    protected $casts = [
        'tanggal_pencatatan' => 'date',
    ];

    public function getWarnaAttribute(): string
    {
        return self::WARNA[$this->jenis_kerusakan] ?? '#6C757D';
    }

    public function wilayah()
    {
        return $this->belongsTo(WilayahKarhutla::class, 'wilayah_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Dipakai FSI-10 (Rehabilitasi Lahan). Aman dibiarkan sebelum FSI-10 dipasang.
    public function rehabilitasi()
    {
        return $this->hasMany(Rehabilitasi::class);
    }
}
