@extends('layouts.app')

@section('title', 'Edit Kerusakan Lahan - SIGAP')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/fsi02.css') }}?v={{ @filemtime(public_path('css/fsi02.css')) }}">
@endpush

@section('content')

<div class="kl-header">
    <div class="kl-title">
        <div class="ic"><i class="bi bi-pencil-square"></i></div>
        <div>
            <h2>Edit Data Kerusakan Lahan</h2>
            <p>Perbarui informasi kerusakan lahan sesuai kondisi terbaru</p>
        </div>
    </div>
    <a href="{{ route('kerusakan-lahan.index') }}" class="btn-sg-outline">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="kl-card">
            <div class="kl-head"><i class="bi bi-ui-checks"></i> Formulir Kerusakan Lahan</div>
            <div class="kl-body">
                <form action="{{ route('kerusakan-lahan.update', $item) }}" method="POST">
                    @method('PUT')
                    @include('kerusakan_lahan._form')

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-sg"><i class="bi bi-check2-circle me-1"></i> Simpan Perubahan</button>
                        <a href="{{ route('kerusakan-lahan.index') }}" class="btn-sg-outline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        @include('kerusakan_lahan._tips')
    </div>
</div>

@endsection
