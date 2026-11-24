@extends('layouts.app')

@section('title', 'Dashboard BPBD Divisi RR - SIGAP')

@section('content')
<div class="p-6 sm:p-8 max-w-[1200px] w-full">
    <!-- Page Header (Identik Gambar BPBD Divisi RR) -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Dashboard BPBD Divisi RR</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Sistem Informasi Gerak Atasi Kebakaran (SIGAP)
        </p>
    </div>

    <!-- Welcome Card (Identik Gambar BPBD Divisi RR) -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-6 sm:p-7 max-w-4xl space-y-3">
        <h2 class="text-base sm:text-lg font-bold text-slate-900">
            Selamat Datang di Dashboard SIGAP!
        </h2>

        <p class="text-xs sm:text-sm text-slate-700">
            Anda berhasil masuk sebagai <strong class="font-bold text-slate-900">Petugas BPBD Divisi Rehabilitasi dan Rekonstruksi (RR)</strong>.
        </p>

        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
            Melalui dashboard ini, Petugas BPBD Divisi RR dapat mengelola data kerusakan lahan terdampak karhutla, mendokumentasikan kegiatan rehabilitasi lahan, serta memantau persebaran wilayah terdampak kebakaran hutan dan lahan di Kabupaten Banyumas.
        </p>
    </div>
</div>
@endsection
