@extends('layouts.app')

@section('title', 'Detail Laporan ' . $laporan->kode_laporan . ' - SIGAP')

@section('content')
<div class="container-fluid px-0">

    {{-- Header Halaman --}}
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
            @if($laporan->status === 'Terverifikasi' || $laporan->status === 'Disetujui')
                <span class="badge bg-success-subtle text-success border border-success-subtle px-4 py-2 rounded-pill fs-6">
                    <i class="bi bi-check-circle-fill me-1"></i> Terverifikasi
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

    {{-- Pesan Notifikasi Sukses / Error --}}
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

    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Gagal Menyimpan:</h6>
            <ul class="mb-0 ps-3 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        {{-- Kolom Kiri: Rincian Data Laporan --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle text-primary"></i> Data Rincian Laporan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <table class="table table-bordered align-middle mb-0">
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
                                    @if($laporan->status === 'Terverifikasi' || $laporan->status === 'Disetujui')
                                        <span class="badge bg-success">Terverifikasi</span>
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

                    {{-- Kotak Alasan Penolakan Jika Status Ditolak (PBI-011 & PBI-012) --}}
                    @if($laporan->status === 'Ditolak' && $laporan->alasan_penolakan)
                        <div class="alert alert-danger border-danger-subtle mt-4 p-3 rounded-3 shadow-sm">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold text-danger mb-1 d-flex align-items-center gap-1">
                                        <i class="bi bi-exclamation-circle-fill"></i> Alasan Penolakan Laporan:
                                    </h6>
                                    <p class="text-dark mb-2 mt-2 fst-italic fs-6" style="white-space: pre-line;">"{{ $laporan->alasan_penolakan }}"</p>
                                    <small class="text-muted">
                                        Ditolak oleh: <strong>{{ $laporan->diubah_oleh ?? 'Petugas Pusdalops' }}</strong> 
                                        @if($laporan->diubah_pada)
                                            ({{ \Carbon\Carbon::parse($laporan->diubah_pada)->format('d-m-Y H:i') }} WIB)
                                        @endif
                                    </small>
                                </div>
                                @if($bisaVerifikasi)
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalEditAlasan">
                                        <i class="bi bi-pencil-square me-1"></i> Edit Alasan
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Riwayat Perubahan Status (PBI-012) --}}
            <div class="card border-0 shadow-sm rounded-3 mt-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-primary"></i> Riwayat Perubahan Status Laporan
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if(!empty($laporan->riwayat_status) && count($laporan->riwayat_status) > 0)
                        <div class="position-relative ps-3" style="border-left: 2px solid #0d6efd;">
                            @foreach(array_reverse($laporan->riwayat_status) as $item)
                                <div class="mb-3 position-relative">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="badge {{ str_contains($item['status_baru'] ?? '', 'Ditolak') ? 'bg-danger' : 'bg-success' }}">
                                            {{ $item['status_baru'] ?? '-' }}
                                        </span>
                                        <small class="text-muted">{{ $item['waktu'] ?? '-' }}</small>
                                    </div>
                                    <div class="small text-secondary">
                                        Diproses oleh: <strong>{{ $item['diubah_oleh'] ?? 'Petugas' }}</strong>
                                    </div>
                                    @if(!empty($item['alasan_penolakan']))
                                        <div class="mt-2 p-2 bg-light border-start border-danger border-3 rounded text-danger small">
                                            <strong>Alasan:</strong> {{ $item['alasan_penolakan'] }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted fst-italic mb-0 small">Belum ada riwayat perubahan status pada laporan ini.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Foto Dokumentasi --}}
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

    {{-- Bagian Aksi Verifikasi: Khusus Petugas BPBD Pusdalops --}}
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
                            Tentukan status laporan. Klik <strong>Setujui</strong> untuk verifikasi, atau <strong>Tolak</strong> untuk menolak laporan dengan alasan penolakan.
                        </p>
                    </div>

                    <div class="d-flex gap-2">
                        {{-- Tombol Setujui --}}
                        <form action="{{ route('laporan.setujui', $laporan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI laporan ini?')">
                            @csrf
                            <button type="submit" class="btn btn-success fw-semibold px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm" {{ in_array($laporan->status, ['Terverifikasi', 'Disetujui']) ? 'disabled' : '' }}>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Setujui</span>
                            </button>
                        </form>

                        {{-- Tombol Tolak (Membuka Modal Pop-up Input Alasan) --}}
                        <button type="button" class="btn btn-danger fw-semibold px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTolak" onclick="bukaModalTolak()">
                            <i class="bi bi-x-circle-fill"></i>
                            <span>Tolak</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>

<!-- Modal Tolak Laporan (Wajib Isi Alasan Penolakan - PBI-011 & PBI-012) -->
<div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="modalTolakLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi Penolakan Laporan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" onclick="tutupModalTolak()" aria-label="Close"></button>
            </div>
            <form action="{{ route('laporan.tolak', $laporan->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">
                        Laporan dengan kode <strong class="text-dark">{{ $laporan->kode_laporan }}</strong> akan ditolak. Berikan alasan penolakan secara jelas agar terdokumentasi dan dapat ditelusuri.
                    </p>

                    <div class="mb-3">
                        <label for="alasan_penolakan" class="form-label fw-semibold text-dark">
                            Alasan Penolakan <span class="text-danger">* (Wajib diisi)</span>:
                        </label>
                        <textarea name="alasan_penolakan" id="alasan_penolakan" rows="4" class="form-control" placeholder="Contoh: Lokasi tidak sesuai / Titik api sudah padam / Laporan tidak valid..." required>{{ old('alasan_penolakan') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal" onclick="tutupModalTolak()">Batal</button>
                    <button type="submit" class="btn btn-danger px-4 fw-semibold">
                        <i class="bi bi-x-circle me-1"></i> Simpan Penolakan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Alasan Penolakan (PBI-012 AC 3) -->
@if($laporan->status === 'Ditolak')
<div class="modal fade" id="modalEditAlasan" tabindex="-1" aria-labelledby="modalEditAlasanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title fw-bold" id="modalEditAlasanLabel">
                    <i class="bi bi-pencil-square me-2"></i> Perbarui Alasan Penolakan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" onclick="tutupModalEdit()" aria-label="Close"></button>
            </div>
            <form action="{{ route('laporan.perbaruiAlasan', $laporan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="edit_alasan_penolakan" class="form-label fw-semibold text-dark">
                            Alasan Penolakan Baru <span class="text-danger">*</span>:
                        </label>
                        <textarea name="alasan_penolakan" id="edit_alasan_penolakan" rows="4" class="form-control" required>{{ old('alasan_penolakan', $laporan->alasan_penolakan) }}</textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal" onclick="tutupModalEdit()">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- Script Bootstrap & Fallback agar Modal 100% Muncul --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function bukaModalTolak() {
    const el = document.getElementById('modalTolak');
    if (window.bootstrap && window.bootstrap.Modal) {
        new bootstrap.Modal(el).show();
    } else {
        el.style.display = 'block';
        el.classList.add('show');
    }
}
function tutupModalTolak() {
    const el = document.getElementById('modalTolak');
    el.style.display = 'none';
    el.classList.remove('show');
}
function tutupModalEdit() {
    const el = document.getElementById('modalEditAlasan');
    if (el) {
        el.style.display = 'none';
        el.classList.remove('show');
    }
}
</script>
@endsection