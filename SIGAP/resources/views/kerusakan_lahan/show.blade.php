@extends('layouts.app')

@section('title', 'Detail Kerusakan Lahan - SIGAP')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/fsi02.css') }}?v={{ @filemtime(public_path('css/fsi02.css')) }}">
@endpush

@section('content')

<div class="kl-header">
    <div class="kl-title">
        <div class="ic"><i class="bi bi-clipboard2-data"></i></div>
        <div>
            <h2>Detail Kerusakan Lahan</h2>
            <p>
                <span class="jenis jenis-{{ Str::slug($item->jenis_kerusakan) }}">{{ $item->jenis_kerusakan }}</span>
                &nbsp;{{ $item->wilayah->kecamatan ?? '-' }}, {{ $item->wilayah->desa_kelurahan ?? '-' }}
            </p>
        </div>
    </div>

    <div class="d-flex gap-2">
        @if($bisaKelola)
            <a href="{{ route('kerusakan-lahan.edit', $item) }}" class="btn btn-sg">
                <i class="bi bi-pencil me-1"></i> Edit Data
            </a>
        @endif
        <a href="{{ route('kerusakan-lahan.index') }}" class="btn-sg-outline">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">

        <div class="kl-card">
            <div class="kl-head"><i class="bi bi-info-circle"></i> Informasi Kerusakan</div>
            <div class="kl-body">
                <div class="info-row"><div class="k">Kecamatan</div><div class="v">{{ $item->wilayah->kecamatan ?? '-' }}</div></div>
                <div class="info-row"><div class="k">Desa/Kelurahan</div><div class="v">{{ $item->wilayah->desa_kelurahan ?? '-' }}</div></div>
                <div class="info-row"><div class="k">Lokasi</div><div class="v">{{ $item->lokasi }}</div></div>
                <div class="info-row">
                    <div class="k">Jenis Kerusakan</div>
                    <div class="v"><span class="jenis jenis-{{ Str::slug($item->jenis_kerusakan) }}">{{ $item->jenis_kerusakan }}</span></div>
                </div>
                <div class="info-row"><div class="k">Tanggal Pencatatan</div><div class="v">{{ $item->tanggal_pencatatan->format('d/m/Y') }}</div></div>
                <div class="info-row"><div class="k">Keterangan</div><div class="v fw-normal">{{ $item->keterangan ?? '-' }}</div></div>
            </div>
        </div>

        {{-- Muncul otomatis setelah FSI-10 (Rehabilitasi Lahan) dipasang --}}
        @if(Route::has('rehabilitasi.show'))
            <div class="kl-card">
                <div class="kl-head"><i class="bi bi-flower1"></i> Kegiatan Rehabilitasi</div>
                <div class="kl-body">
                    @forelse($item->rehabilitasi as $r)
                        <a href="{{ route('rehabilitasi.show', $r) }}" class="reh">
                            <div>
                                <div class="fw-semibold">{{ $r->jenis_kegiatan }}</div>
                                <small class="text-muted">{{ $r->status }}</small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <div class="pbar"><i style="width: {{ $r->progres_persen }}%"></i></div>
                                <small class="fw-semibold">{{ $r->progres_persen }}%</small>
                            </div>
                        </a>
                    @empty
                        <div class="text-muted">Belum ada kegiatan rehabilitasi.</div>
                    @endforelse
                </div>
            </div>
        @endif

    </div>

    <div class="col-lg-4">
        <div class="hl">
            <small>Luas terdampak</small>
            <div class="big">
                @if($item->luas_ha !== null)
                    {{ number_format($item->luas_ha, 2, ',', '.') }} <span>ha</span>
                @else
                    -
                @endif
            </div>
        </div>

        <div class="kl-card">
            <div class="kl-head"><i class="bi bi-clock-history"></i> Riwayat Data</div>
            <div class="kl-body">
                <div class="info-row"><div class="k">Dicatat oleh</div><div class="v">{{ $item->user->name ?? '-' }}</div></div>
                <div class="info-row"><div class="k">Dibuat</div><div class="v fw-normal">{{ $item->created_at->format('d/m/Y H:i') }}</div></div>
                <div class="info-row"><div class="k">Diperbarui</div><div class="v fw-normal">{{ $item->updated_at->format('d/m/Y H:i') }}</div></div>
            </div>
        </div>
    </div>
</div>

@endsection
