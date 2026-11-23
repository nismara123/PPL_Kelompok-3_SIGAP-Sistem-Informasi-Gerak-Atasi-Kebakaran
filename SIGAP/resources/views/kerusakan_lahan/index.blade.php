@extends('layouts.app')

@section('title', 'Data Kerusakan Lahan - SIGAP')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/fsi02.css') }}?v={{ @filemtime(public_path('css/fsi02.css')) }}">
@endpush

@section('content')

<div class="kl-header">
    <div class="kl-title">
        <div class="ic"><i class="bi bi-tree"></i></div>
        <div>
            <h2>Data Kerusakan Lahan Terdampak</h2>
            <p>Pencatatan kondisi lahan terdampak karhutla sebagai dasar perencanaan rehabilitasi</p>
        </div>
    </div>

    @if($bisaKelola)
        <a href="{{ route('kerusakan-lahan.create') }}" class="btn btn-sg">
            <i class="bi bi-plus-circle me-1"></i> Tambah Data
        </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat">
            <div class="si si-a"><i class="bi bi-clipboard2-data"></i></div>
            <div>
                <div class="num">{{ number_format($stat['total'], 0, ',', '.') }}</div>
                <div class="lbl">Total data tercatat</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat">
            <div class="si si-b"><i class="bi bi-fire"></i></div>
            <div>
                <div class="num">{{ number_format($stat['luas'], 2, ',', '.') }} <small class="fs-6 fw-normal">ha</small></div>
                <div class="lbl">Total luas terdampak</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat">
            <div class="si si-c"><i class="bi bi-geo-alt"></i></div>
            <div>
                <div class="num">{{ number_format($stat['wilayah'], 0, ',', '.') }}</div>
                <div class="lbl">Wilayah terdampak</div>
            </div>
        </div>
    </div>
</div>

<div class="kl-card">
    <div class="kl-body">
        <form method="GET" action="{{ route('kerusakan-lahan.index') }}" class="row g-2">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control" placeholder="Cari lokasi..." value="{{ request('q') }}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-funnel"></i></span>
                    <select name="kecamatan" class="form-select">
                        <option value="">Semua kecamatan</option>
                        @foreach($kecamatanList as $kec)
                            <option value="{{ $kec }}" @selected(request('kecamatan') == $kec)>{{ $kec }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-sg flex-fill">Filter</button>
                <a href="{{ route('kerusakan-lahan.index') }}" class="btn-sg-outline">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="kl-card">
    <div class="table-responsive">
        <table class="kl-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Wilayah</th>
                    <th>Lokasi</th>
                    <th>Jenis Kerusakan</th>
                    <th>Luas</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $item)
                    <tr>
                        <td>{{ $data->firstItem() + $loop->index }}</td>

                        <td>
                            <div class="wil-title">{{ $item->wilayah->kecamatan ?? '-' }}</div>
                            <div class="wil-sub"><i class="bi bi-geo-alt"></i> {{ $item->wilayah->desa_kelurahan ?? '-' }}</div>
                        </td>

                        <td>{{ $item->lokasi }}</td>

                        <td>
                            <span class="jenis jenis-{{ Str::slug($item->jenis_kerusakan) }}">{{ $item->jenis_kerusakan }}</span>
                        </td>

                        <td class="fw-semibold">
                            @if($item->luas_ha !== null)
                                {{ number_format($item->luas_ha, 2, ',', '.') }} ha
                            @else
                                -
                            @endif
                        </td>

                        <td class="text-nowrap">{{ $item->tanggal_pencatatan->format('d/m/Y') }}</td>

                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('kerusakan-lahan.show', $item) }}" class="ibtn" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if($bisaKelola)
                                    <a href="{{ route('kerusakan-lahan.edit', $item) }}" class="ibtn edit" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('kerusakan-lahan.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Hapus data kerusakan lahan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ibtn del" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty">
                                <i class="bi bi-tree"></i>
                                <div class="fw-semibold">Data kerusakan lahan belum tersedia.</div>
                                @if($bisaKelola)
                                    <a href="{{ route('kerusakan-lahan.create') }}" class="btn btn-sg mt-3">
                                        <i class="bi bi-plus-circle me-1"></i> Tambah Data Pertama
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($data->hasPages())
        <div class="px-3 pt-3">
            {{ $data->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection
