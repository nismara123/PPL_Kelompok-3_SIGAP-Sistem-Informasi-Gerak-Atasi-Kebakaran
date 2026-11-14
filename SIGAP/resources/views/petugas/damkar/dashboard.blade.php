@extends('layouts.app')

@section('content')
<div class="px-4 py-4 container-fluid">
    <h2 class="mb-2 fw-bold">Dashboard Damkar</h2>

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
                <strong>Petugas Damkar</strong>.
            </p>

            <p class="mb-0 text-muted">
                Melalui dashboard ini, Petugas Damkar dapat melihat
                tugas penanganan kebakaran, memperbarui status
                penanganan, serta mencatat hasil penanganan
                kebakaran hutan dan lahan di Kabupaten Banyumas.
            </p>
        </div>
    </div>
</div>
@endsection