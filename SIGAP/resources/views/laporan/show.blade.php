@extends('layouts.app')

@section('title', 'Detail Laporan ' . $laporan->kode_laporan . ' - SIGAP')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <div class="mb-2">
                <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Laporan
                </a>
            </div>
            <h2 class="fw-bold mb-1" style="color: #64271D;">
                Detail Laporan Kejadian Karhutla
            </h2>
            <p class="text-muted mb-0">
                Rincian informasi lengkap mengenai laporan kebakaran hutan dan lahan.
            </p>
        </div>

        <div>
            @if($laporan->status === 'Disetujui')
                <span class="badge bg-success-subtle text-success border border-success-subtle px-4 py-2 rounded-pill fs-6">
                    <i class="bi bi-check-circle-fill me-1"></i> Disetujui
                </span>
            @elseif($laporan->status === 'Ditolak')
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-4 py-2 rounded-pill fs-6">
                    <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                </span>
            @else
                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-4 py-2 rounded-pill fs-6">
                    <i class="bi bi-hourglass-split me-1"></i> Menunggu Verifikasi
                </span>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center gap-2 mb-4">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <div class="row g-4">
        {{-- Kolom Data Kejadian --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle text-primary"></i> Data Rincian Laporan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <table class="table table-bordered align-middle">
                        <tbody>
                            <tr>
                                <th class="table-light text-muted" style="width: 35%;">Kode Laporan</th>
                                <td>
                                    <span class="fw-bold font-monospace fs-6 text-primary">
                                        {{ $laporan->kode_laporan }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light text-muted">Status Saat Ini</th>
                                <td>
                                    @if($laporan->status === 'Disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($laporan->status === 'Ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light text-muted">Lokasi Kejadian</th>
                                <td class="fw-semibold text-dark">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                    {{ $laporan->lokasi }}
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light text-muted">Waktu Kejadian</th>
                                <td>
                                    <i class="bi bi-calendar-event me-1 text-muted"></i>
                                    {{ \Carbon\Carbon::parse($laporan->waktu_kejadian)->format('d-m-Y H:i') }} WIB
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light text-muted">Waktu Laporan Dibuat</th>
                                <td class="text-muted small">
                                    {{ $laporan->created_at ? $laporan->created_at->format('d-m-Y H:i:s') . ' WIB' : '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light text-muted align-top">Deskripsi Lengkap</th>
                                <td class="text-secondary" style="white-space: pre-line; line-height: 1.6;">
                                    {{ $laporan->deskripsi }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Kolom Foto Dokumentasi --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-camera text-primary"></i> Foto Dokumentasi
                    </h5>
                </div>
                <div class="card-body p-4 text-center d-flex flex-column justify-content-center align-items-center">
                    @if($laporan->foto)
                        <div class="w-100 mb-3">
                            <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Kejadian" class="img-fluid rounded-3 border shadow-sm" style="max-height: 360px; object-fit: contain; width: 100%;">
                        </div>
                        <a href="{{ asset('storage/' . $laporan->foto) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrows-fullscreen me-1"></i> Buka Gambar Ukuran Penuh
                        </a>
                    @else
                        <div class="py-5 text-muted">
                            <i class="bi bi-image fs-1 d-block mb-2 text-secondary opacity-50"></i>
                            <div class="fw-semibold">Tidak Ada Foto Dokumentasi</div>
                            <small class="text-secondary">Pelapor tidak melampirkan foto pada saat pengiriman laporan.</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian Aksi Verifikasi: Hanya Muncul untuk Petugas BPBD Pusdalops --}}
    @if($bisaVerifikasi)
        <div class="card border-0 shadow-sm rounded-3 mt-4 border-start border-4 border-warning">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div>
                        <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                            <i class="bi bi-shield-check text-primary"></i>
                            Verifikasi Laporan (Hak Akses Petugas BPBD Pusdalops)
                        </h5>
                        <p class="text-muted mb-0 small">
                            Tentukan kelayakan laporan ini. Klik <strong>Setujui</strong> jika informasi valid untuk diteruskan ke tim penanganan, atau <strong>Tolak</strong> jika tidak valid.
                        </p>
                    </div>

                    <div class="d-flex gap-2">
                        {{-- Tombol Setujui --}}
                        <form action="{{ route('laporan.setujui', $laporan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI laporan ini?')">
                            @csrf
                            <button type="submit" class="btn btn-success fw-semibold px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm" {{ $laporan->status === 'Disetujui' ? 'disabled' : '' }}>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Setujui</span>
                            </button>
                        </form>

                        {{-- Tombol Tolak --}}
                        <form action="{{ route('laporan.tolak', $laporan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENOLAK laporan ini?')">
                            @csrf
                            <button type="submit" class="btn btn-danger fw-semibold px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm" {{ $laporan->status === 'Ditolak' ? 'disabled' : '' }}>
                                <i class="bi bi-x-circle-fill"></i>
                                <span>Tolak</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
@endsection
