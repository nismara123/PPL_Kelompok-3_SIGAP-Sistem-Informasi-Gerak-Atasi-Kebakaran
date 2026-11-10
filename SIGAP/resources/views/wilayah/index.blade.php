
@extends('layouts.app')

@section('title', 'Data Wilayah Karhutla - SIGAP')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Data Wilayah Karhutla</h2>
        <p class="text-muted mb-0">
            Pengelolaan data wilayah terdampak karhutla Kabupaten Banyumas
        </p>
    </div>

    <a href="{{ route('wilayah.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Wilayah
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kode Wilayah</th>
                        <th>Kabupaten</th>
                        <th>Kecamatan</th>
                        <th>Desa/Kelurahan</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($wilayah as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item->kode_wilayah }}</td>

                            <td>
                                {{ $item->kabupaten }}
                                <br>
                                <small class="text-muted">
                                    Kode: {{ $item->kode_kabupaten }}
                                </small>
                            </td>

                            <td>
                                {{ $item->kecamatan }}
                                <br>
                                <small class="text-muted">
                                    Kode: {{ $item->kode_kecamatan }}
                                </small>
                            </td>

                            <td>
                                {{ $item->desa_kelurahan }}
                                <br>
                                <small class="text-muted">
                                    Kode: {{ $item->kode_desa }}
                                </small>
                            </td>

                            <td>{{ $item->latitude ?? '-' }}</td>
                            <td>{{ $item->longitude ?? '-' }}</td>

                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('wilayah.show', $item->id) }}"
                                       class="btn btn-info btn-sm text-white">
                                        Detail
                                    </a>

                                    <a href="{{ route('wilayah.edit', $item->id) }}"
                                       class="btn btn-warning btn-sm">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Belum ada data wilayah karhutla yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
