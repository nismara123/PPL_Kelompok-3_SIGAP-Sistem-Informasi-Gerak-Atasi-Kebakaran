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
        'tingkat_risiko',
        'prioritas_penanganan',
        'estimasi_luas_terdampak',
        'potensi_bahaya',
        'catatan_penilaian',
        'dinilai_oleh',
        'dinilai_pada',
        'riwayat_penilaian',
    ];

    protected $casts = [
        'waktu_kejadian' => 'datetime',
        'diubah_pada' => 'datetime',
        'dinilai_pada' => 'datetime',
        'riwayat_status' => 'array',
        'riwayat_penilaian' => 'array',
    ];

    /**
     * Helper untuk menentukan badge warna tingkat risiko
     */
    public function getBadgeTingkatRisikoAttribute(): string
    {
        return match ($this->tingkat_risiko) {
            'Kritis' => 'bg-danger text-white',
            'Tinggi' => 'bg-warning text-dark',
            'Sedang' => 'bg-info text-dark',
            'Rendah' => 'bg-success text-white',
            default => 'bg-secondary text-white',
        };
    }

    /**
     * Helper untuk menentukan badge warna prioritas
     */
    public function getBadgePrioritasAttribute(): string
    {
        return match ($this->prioritas_penanganan) {
            'Darurat' => 'bg-danger text-white',
            'Tinggi' => 'bg-warning text-dark',
            'Sedang' => 'bg-info text-dark',
            'Rendah' => 'bg-success text-white',
            default => 'bg-secondary text-white',
        };
    }
}
