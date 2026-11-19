
@extends('layouts.app')

@section('content')
<div class="px-4 py-4 container-fluid">

    <h2 class="mb-2 fw-bold">Dashboard Pusdalops</h2>

    <p class="mb-4 text-muted">
        Sistem Informasi Gerak Atasi Kebakaran (SIGAP)
    </p>

    <div class="border-0 shadow-sm card rounded-3">
        <div class="p-4 card-body">
            <h4 class="mb-3 fw-semibold">
                Selamat Datang di Dashboard SIGAP!
            </h4>

            <p class="mb-2">
                Anda berhasil masuk sebagai
                <strong>Petugas BPBD Pusdalops</strong>.
            </p>

            <p class="mb-3 text-muted">
                Melalui dashboard ini, Petugas Pusdalops dapat
                mengelola data wilayah karhutla, memantau laporan
                kejadian, melakukan verifikasi laporan, menilai
                risiko kejadian, serta mengoordinasikan penanganan
                kebakaran hutan dan lahan di Kabupaten Banyumas.
            </p>

            <div class="d-flex gap-2">
                <a href="{{ route('laporan.index') }}" class="btn text-white fw-semibold" style="background-color: #f4512c;">
                    <i class="bi bi-file-earmark-text me-1"></i> Kelola & Verifikasi Laporan Masuk
                </a>
                <a href="{{ route('wilayah.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-geo-alt me-1"></i> Data Wilayah Karhutla
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
