@extends('layouts.app')

@section('title', 'Daftar Laporan Karhutla - SIGAP')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: #64271D;">
                <i class="bi bi-file-earmark-text me-2"></i>Daftar Laporan Karhutla
            </h2>
            <p class="text-muted mb-0">
                Data seluruh laporan kejadian kebakaran hutan dan lahan yang masuk ke sistem SIGAP.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('laporan.create') }}" target="_blank" class="btn text-white fw-semibold shadow-sm" style="background-color: #f4512c;">
                <i class="bi bi-plus-circle me-1"></i> Form Pelaporan Baru
            </a>
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

    {{-- Ringkasan Statistik Laporan --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 text-primary bg-primary bg-opacity-10 fs-3">
                        <i class="bi bi-folder2-open"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Total Laporan</div>
                        <div class="fs-4 fw-bold text-dark">{{ number_format($ringkasan['total'] ?? 0) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 text-warning bg-warning bg-opacity-10 fs-3">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Menunggu</div>
                        <div class="fs-4 fw-bold text-dark">{{ number_format($ringkasan['menunggu'] ?? 0) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 text-success bg-success bg-opacity-10 fs-3">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Disetujui</div>
                        <div class="fs-4 fw-bold text-dark">{{ number_format($ringkasan['disetujui'] ?? 0) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 text-danger bg-danger bg-opacity-10 fs-3">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-semibold">Ditolak</div>
                        <div class="fs-4 fw-bold text-dark">{{ number_format($ringkasan['ditolak'] ?? 0) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter & Pencarian --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('laporan.index') }}" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0" placeholder="Cari kode laporan, lokasi, atau deskripsi...">
                    </div>
                </div>

                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>-- Semua Status --</option>
                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn text-white fw-semibold w-100" style="background-color: #64271D;">
                        Filter
                    </button>
                    @if(request('q') || (request('status') && request('status') !== 'semua'))
                        <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Laporan --}}
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold text-dark">Data Laporan Masuk</h5>
            <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">
                Menampilkan {{ $laporans->count() }} dari {{ $laporans->total() }} laporan
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 60px;">No</th>
                        <th>Kode Laporan</th>
                        <th>Lokasi Kejadian</th>
                        <th>Waktu Kejadian</th>
                        <th>Foto</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $index => $item)
                        <tr>
                            <td class="text-center text-muted">
                                {{ $laporans->firstItem() + $index }}
                            </td>
                            <td>
                                <span class="fw-bold font-monospace text-primary">
                                    {{ $item->kode_laporan }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $item->lokasi }}</div>
                                <small class="text-muted d-block text-truncate" style="max-width: 250px;">
                                    {{ $item->deskripsi }}
                                </small>
                            </td>
                            <td>
                                <div><i class="bi bi-calendar-event me-1 text-muted"></i>{{ \Carbon\Carbon::parse($item->waktu_kejadian)->format('d M Y') }}</div>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ \Carbon\Carbon::parse($item->waktu_kejadian)->format('H:i') }} WIB</small>
                            </td>
                            <td>
                                @if($item->foto)
                                    <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">
                                        <i class="bi bi-image me-1"></i> Ada Foto
                                    </span>
                                @else
                                    <span class="text-muted small">
                                        <i class="bi bi-dash"></i>
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->status === 'Disetujui')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                        <i class="bi bi-check-circle-fill me-1"></i> Disetujui
                                    </span>
                                @elseif($item->status === 'Ditolak')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill">
                                        <i class="bi bi-x-circle-fill me-1"></i> Ditolak
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2 rounded-pill">
                                        <i class="bi bi-hourglass-split me-1"></i> Menunggu
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('laporan.show', $item->id) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1 shadow-sm">
                                    <i class="bi bi-eye"></i>
                                    <span>Lihat Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                <div class="fw-semibold">Belum ada laporan karhutla yang masuk.</div>
                                <small>Laporan dari masyarakat akan muncul di tabel ini.</small>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($laporans->hasPages())
            <div class="card-footer bg-white py-3 border-top d-flex justify-content-end">
                {{ $laporans->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
