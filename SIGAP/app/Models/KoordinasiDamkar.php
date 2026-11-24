<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KoordinasiDamkar extends Model
{
    protected $table = 'koordinasi_damkar';

    protected $fillable = [
        'laporan_karhutla_id',
        'petugas_damkar_id',
        'bpbd_user_id',
        'metode_komunikasi',
        'waktu_koordinasi',
        'prioritas',
        'status',
        'catatan',
        'tim_ditugaskan',
        'waktu_konfirmasi',
        'catatan_konfirmasi',
    ];

    protected function casts(): array
    {
        return [
            'waktu_koordinasi' => 'datetime',
            'waktu_konfirmasi' => 'datetime',
        ];
    }

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(
            LaporanKarhutla::class,
            'laporan_karhutla_id'
        );
    }

    public function petugasDamkar(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'petugas_damkar_id'
        );
    }

    public function petugasBpbd(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'bpbd_user_id'
        );
    }
}
