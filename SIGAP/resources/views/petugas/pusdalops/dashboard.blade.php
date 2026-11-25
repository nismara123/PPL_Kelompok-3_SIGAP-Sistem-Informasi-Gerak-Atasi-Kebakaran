
@extends('layouts.app')

@section('title', 'SIGAP — Sistem Penanganan Karhutla | BPBD Kabupaten Banyumas')

@push('styles')
<style>

    /* =========================================================
       PENYESUAIAN VISUAL DASHBOARD — MENGIKUTI GAMBAR REFERENSI
       Seluruh komponen tetap berada pada satu halaman dashboard.
       ========================================================= */

    #view-dashboard {
        width: 100%;
        max-width: 1600px;
        margin: 0 auto;
        padding: 28px 28px 32px;
        display: flex;
        flex-direction: column;
        gap: 24px;
        box-sizing: border-box;
        color: #172033;
    }

    /* Banner sambutan */
    #view-dashboard .sigap-hero-banner {
        min-height: 190px;
        padding: 28px 32px;
        border-radius: 16px;
        background: linear-gradient(105deg, #861d13 0%, #a92719 48%, #cc351d 100%);
        box-sizing: border-box;
    }

    #view-dashboard .sigap-hero-banner > div {
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 28px;
    }

    #view-dashboard .sigap-hero-banner > div > div:first-child {
        max-width: 760px;
        gap: 12px;
    }

    #view-dashboard .sigap-hero-banner h1 {
        margin: 0;
        color: #fff;
        font-size: 28px;
        line-height: 1.25;
        font-weight: 800;
        letter-spacing: -0.55px;
    }

    #view-dashboard .sigap-hero-banner p {
        max-width: 720px;
        margin-top: 8px;
        color: #ffe8e3;
        font-size: 14px;
        line-height: 1.55;
    }

    #view-dashboard .sigap-hero-banner > div > div:first-child > div:first-child {
        width: fit-content;
        padding: 6px 14px;
        font-size: 11px;
    }

    #view-dashboard .sigap-hero-banner > div > div:last-child {
        min-width: 286px;
        padding: 17px 20px;
        border-radius: 15px;
        background: rgba(18, 18, 22, 0.88);
        box-sizing: border-box;
    }

    #view-dashboard .sigap-hero-banner > div > div:last-child > div:first-child {
        margin-bottom: 9px;
        font-size: 10px;
    }

    #view-dashboard .sigap-hero-banner > div > div:last-child span {
        font-size: 11px;
    }

    /* Kartu statistik */
    #view-dashboard #dashboardKpiGrid {
        display: grid;
        width: 100%;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    #view-dashboard #dashboardKpiGrid > a {
        min-width: 0;
        min-height: 109px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid #e8edf2;
        border-radius: 17px;
        background: #fff;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.035);
        box-sizing: border-box;
    }

    #view-dashboard #dashboardKpiGrid > a > div:first-child {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 13px;
    }

    #view-dashboard #dashboardKpiGrid > a > div:first-child i {
        font-size: 22px;
    }

    #view-dashboard #dashboardKpiGrid > a > div:last-child {
        min-width: 0;
    }

    #view-dashboard #dashboardKpiGrid > a > div:last-child > div:first-child {
        color: #94a3b8;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 0.5px;
        line-height: 1.35;
    }

    #view-dashboard #dashboardKpiGrid > a > div:last-child > div:nth-child(2) {
        margin-top: 3px;
        color: #172033;
        font-size: 26px;
        font-weight: 800;
        line-height: 1.1;
    }

    #view-dashboard #dashboardKpiGrid > a > div:last-child > div:last-child {
        margin-top: 4px;
        font-size: 12px;
        line-height: 1.35;
    }

    /* Dua panel bawah dalam satu baris */
    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 {
        width: 100%;
        display: grid;
        grid-template-columns: minmax(0, 2.05fr) minmax(360px, 1fr);
        align-items: start;
        gap: 24px;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-8,
    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-4 {
        grid-column: auto;
        min-width: 0;
    }

    /* Panel tabel */
    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-8 {
        border-radius: 20px;
        overflow: hidden;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-8 > div:first-child {
        min-height: 90px;
        padding: 20px 24px;
        gap: 14px;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-8 > div:first-child h2 {
        font-size: 20px;
        line-height: 1.3;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-8 > div:first-child p {
        margin-top: 5px;
        font-size: 13px;
        line-height: 1.4;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-8 > div:first-child > a {
        padding: 9px 15px;
        font-size: 12px;
        white-space: nowrap;
    }

    #view-dashboard table {
        width: 100%;
        min-width: 790px;
        border-collapse: collapse;
        table-layout: auto;
    }

    #view-dashboard thead tr {
        height: 48px;
    }

    #view-dashboard th {
        padding: 14px 18px;
        white-space: nowrap;
        font-size: 11px;
        letter-spacing: 0.45px;
    }

    #view-dashboard tbody tr {
        height: 76px;
        border-bottom: 1px solid #edf0f3;
    }

    #view-dashboard tbody tr:last-child {
        border-bottom: 0;
    }

    #view-dashboard td {
        padding: 14px 18px;
        vertical-align: middle;
        font-size: 13px;
    }

    #view-dashboard td:nth-child(1) > div:first-child {
        font-size: 14px;
        font-weight: 800;
        color: #3568c8;
    }

    #view-dashboard td:nth-child(1) > div:last-child,
    #view-dashboard td:nth-child(2) > div:last-child {
        margin-top: 5px;
        font-size: 12px;
        color: #94a3b8;
    }

    #view-dashboard td:nth-child(2) > div:first-child {
        max-width: 190px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 13px;
        font-weight: 700;
    }

    #view-dashboard td:nth-child(2) > div:last-child {
        max-width: 190px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #64748b;
    }

    #view-dashboard td > span {
        font-size: 12px;
    }

    #view-dashboard td:last-child {
        text-align: right;
    }

    #view-dashboard td:last-child > div {
        display: inline-flex;
        align-items: center;
        justify-content: flex-end;
        gap: 7px;
    }

    #view-dashboard td:last-child button,
    #view-dashboard td:last-child a {
        min-height: 36px;
        padding: 8px 13px;
        border-radius: 10px;
        font-size: 12px;
        line-height: 1;
        white-space: nowrap;
    }

    /* Panel aksi cepat */
    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-4 {
        padding: 24px 25px;
        border-radius: 20px;
        box-sizing: border-box;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-4 > div:first-child {
        margin-bottom: 20px;
        gap: 10px;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-4 > div:first-child h2 {
        font-size: 20px;
        line-height: 1.3;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-4 > div:nth-child(2) {
        display: flex;
        flex-direction: column;
        gap: 13px;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-4 > div:nth-child(2) > a {
        min-height: 84px;
        padding: 14px 16px;
        border-radius: 15px;
        box-sizing: border-box;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-4 > div:nth-child(2) > a > div:first-child {
        gap: 13px;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-4 > div:nth-child(2) > a > div:first-child > div:first-child {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 14px;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-4 > div:nth-child(2) > a > div:first-child > div:first-child i {
        font-size: 20px;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-4 > div:nth-child(2) > a > div:first-child > div:last-child > div:first-child {
        font-size: 13px;
        line-height: 1.35;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-4 > div:nth-child(2) > a > div:first-child > div:last-child > div:last-child {
        margin-top: 4px;
        font-size: 12px;
        line-height: 1.35;
        color: #64748b;
    }

    #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-4 > div:nth-child(2) > a > i {
        flex-shrink: 0;
        font-size: 14px;
    }

    /* Modal tetap di atas seluruh dashboard */
    #detailModalBackdrop {
        z-index: 60;
    }

    /* Tablet dan layar lebih kecil */
    @media (max-width: 1100px) {
        #view-dashboard {
            padding: 20px;
            gap: 20px;
        }

        #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 {
            grid-template-columns: minmax(0, 1.6fr) minmax(300px, 1fr);
            gap: 16px;
        }

        #view-dashboard #dashboardKpiGrid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        #view-dashboard .sigap-hero-banner h1 {
            font-size: 24px;
        }

        #view-dashboard .sigap-hero-banner > div > div:last-child {
            min-width: 240px;
        }
    }

    @media (max-width: 768px) {
        #view-dashboard {
            padding: 14px;
            gap: 16px;
        }

        #view-dashboard .sigap-hero-banner {
            min-height: auto;
            padding: 20px;
        }

        #view-dashboard .sigap-hero-banner > div {
            flex-direction: column;
            align-items: stretch;
        }

        #view-dashboard .sigap-hero-banner h1 {
            font-size: 21px;
        }

        #view-dashboard .sigap-hero-banner p {
            font-size: 12px;
        }

        #view-dashboard .sigap-hero-banner > div > div:last-child {
            width: 100%;
            min-width: 0;
        }

        #view-dashboard #dashboardKpiGrid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        #view-dashboard #dashboardKpiGrid > a {
            min-height: 88px;
            padding: 12px;
            gap: 10px;
        }

        #view-dashboard #dashboardKpiGrid > a > div:first-child {
            width: 38px;
            height: 38px;
            min-width: 38px;
        }

        #view-dashboard #dashboardKpiGrid > a > div:last-child > div:nth-child(2) {
            font-size: 21px;
        }

        #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 {
            grid-template-columns: 1fr;
        }

        #view-dashboard > section.grid.grid-cols-1.lg\:grid-cols-12 > .lg\:col-span-4 {
            padding: 20px;
        }
    }

    @media (max-width: 420px) {
        #view-dashboard #dashboardKpiGrid {
            grid-template-columns: 1fr;
        }
    }

</style>
@endpush

@section('content')

<main id="view-dashboard" class="w-full space-y-6">

    {{-- BANNER SAMBUTAN --}}
    <section class="sigap-hero-banner rounded-2xl p-6 sm:p-8 text-white">

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">

            <div class="max-w-2xl space-y-3">

                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white text-slate-800 text-[11px] font-semibold shadow-sm">

                    <i class="bi bi-shield-check text-amber-500"></i>

                    <span>Pusat Pengendalian Operasi Penanggulangan Bencana</span>

                </div>

                <h1 class="text-2xl sm:text-[28px] font-extrabold tracking-tight leading-tight">
                    Selamat Datang, {{ auth()->user()->name ?? 'Petugas Pusdalops' }}!
                </h1>

                <p class="text-xs sm:text-sm text-red-100 leading-relaxed">
                    Sistem Informasi Gerak Atasi Kebakaran (SIGAP) Kabupaten Banyumas.
                    Pantau laporan masyarakat, lakukan verifikasi data kejadian,
                    dan tetapkan penilaian risiko serta prioritas penanganan.
                </p>

            </div>

            {{-- STATUS KESIAPSIAGAAN --}}
            <div class="self-start lg:self-center bg-[#0d1117]/85 border border-white/10 rounded-2xl px-5 py-4 shrink-0">

                <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase mb-2">
                    STATUS KESIAPSIAGAAN
                </div>

                <div class="flex items-center gap-2.5">

                    <span class="px-2.5 py-1 rounded-full bg-[#e11d48] text-white text-[11px] font-extrabold tracking-wide">
                        SIAGA KARHUTLA
                    </span>

                    <span class="text-xs font-semibold text-white">
                        Wilayah Banyumas
                    </span>

                </div>

            </div>

        </div>
    </section>

    {{-- RINGKASAN STATISTIK --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4"
             id="dashboardKpiGrid">

        {{-- TOTAL LAPORAN --}}
        <a href="{{ route('penilaian-risiko.index') }}"
           class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:border-blue-200 flex items-center gap-4 no-underline">

            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <i class="bi bi-file-earmark-text text-2xl"></i>
            </div>

            <div class="min-w-0">
                <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                    TOTAL LAPORAN
                </div>

                <div class="text-2xl font-extrabold text-slate-900 mt-0.5">
                    {{ number_format($ringkasan['total'] ?? 0) }}
                </div>

                <div class="text-xs font-medium text-slate-500 mt-0.5">
                    Kejadian terdata
                </div>
            </div>
        </a>

        {{-- MENUNGGU VERIFIKASI --}}
        <a href="{{ route('laporan.index', ['status' => 'Menunggu']) }}"
           class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:border-amber-200 flex items-center gap-4 no-underline">

            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <i class="bi bi-clock-history text-2xl"></i>
            </div>

            <div class="min-w-0">
                <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                    MENUNGGU VERIFIKASI
                </div>

                <div class="text-2xl font-extrabold text-slate-900 mt-0.5">
                    {{ number_format($ringkasan['menunggu'] ?? 0) }}
                </div>

                <div class="text-xs font-semibold text-[#e03c22] mt-0.5">
                    {{ ($ringkasan['menunggu'] ?? 0) > 0 ? 'Perlu tindakan' : 'Semua terverifikasi' }} →
                </div>
            </div>
        </a>

        {{-- BUTUH NILAI RISIKO --}}
        <a href="{{ route('penilaian-risiko.index', ['tab' => 'perlu_dinilai']) }}"
           class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:border-rose-200 flex items-center gap-4 no-underline">

            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <i class="bi bi-exclamation-triangle text-2xl"></i>
            </div>

            <div class="min-w-0">
                <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                    BUTUH NILAI RISIKO
                </div>

                <div class="text-2xl font-extrabold text-slate-900 mt-0.5">
                    {{ number_format($ringkasan['perlu_penilaian'] ?? 0) }}
                </div>

                <div class="text-xs font-semibold text-[#e03c22] mt-0.5">
                    {{ ($ringkasan['perlu_penilaian'] ?? 0) > 0 ? 'Isi form penilaian' : 'Semua sudah dinilai' }} →
                </div>
            </div>
        </a>

        {{-- WILAYAH PANTAUAN --}}
        <a href="{{ route('wilayah.index') }}"
           class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm hover:border-emerald-200 flex items-center gap-4 no-underline">

            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i class="bi bi-geo-alt text-2xl"></i>
            </div>

            <div class="min-w-0">
                <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                    WILAYAH PANTAUAN
                </div>

                <div class="text-2xl font-extrabold text-slate-900 mt-0.5">
                    {{ number_format($ringkasan['total_wilayah'] ?? 0) }}
                </div>

                <div class="text-xs font-semibold text-slate-600 mt-0.5">
                    Master data →
                </div>
            </div>
        </a>

    </section>

    {{-- TABEL DAN AKSI CEPAT --}}
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

        {{-- KEJADIAN TERBARU --}}
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">

            <div class="px-5 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">

                <div class="flex items-start gap-2.5">

                    <i class="bi bi-lightning-charge-fill text-[#e03c22]"></i>

                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-slate-900">
                            Kejadian Karhutla Terbaru
                        </h2>

                        <p class="text-xs text-slate-500 mt-0.5">
                            Daftar laporan kejadian dan hasil penilaian risiko serta prioritas penanganan
                        </p>
                    </div>

                </div>

                <a href="{{ route('penilaian-risiko.index') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 no-underline">

                    Lihat Semua →
                </a>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-left">

                    <thead>
                        <tr class="border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50">

                            <th class="py-3 px-4">Kode Laporan</th>
                            <th class="py-3 px-4">Lokasi Kejadian</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Tingkat Risiko</th>
                            <th class="py-3 px-4">Prioritas</th>
                            <th class="py-3 px-4 text-right">Aksi</th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 text-xs">

                        @forelse($laporanTerbaru as $item)

                            <tr class="hover:bg-slate-50 transition">

                                <td class="py-3.5 px-4 align-top whitespace-nowrap">

                                    <div class="font-bold text-blue-600">
                                        {{ $item->kode_laporan }}
                                    </div>

                                    <div class="text-[11px] text-slate-400 mt-0.5">
                                        {{ \Carbon\Carbon::parse($item->waktu_kejadian ?? $item->created_at)->diffForHumans() }}
                                    </div>

                                </td>

                                <td class="py-3.5 px-4 align-top">

                                    <div class="font-semibold text-slate-900">
                                        {{ $item->lokasi }}
                                    </div>

                                    <div class="text-[11px] text-slate-500 mt-0.5">
                                        {{ $item->deskripsi }}
                                    </div>

                                </td>

                                <td class="py-3.5 px-4 align-top whitespace-nowrap">

                                    @if($item->status === 'Terverifikasi' || $item->status === 'Disetujui')

                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">
                                            Terverifikasi
                                        </span>

                                    @elseif($item->status === 'Ditolak')

                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-100 text-rose-700">
                                            Ditolak
                                        </span>

                                    @else

                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800">
                                            Menunggu
                                        </span>

                                    @endif

                                </td>

                                <td class="py-3.5 px-4 align-top whitespace-nowrap">

                                    @if($item->tingkat_risiko)

                                        @php
                                            $riskStyle = match($item->tingkat_risiko) {
                                                'Sangat Tinggi', 'Kritis' => 'bg-red-100 text-red-700',
                                                'Tinggi' => 'bg-amber-100 text-amber-800',
                                                'Sedang' => 'bg-blue-100 text-blue-700',
                                                'Rendah' => 'bg-emerald-100 text-emerald-700',
                                                default => 'bg-slate-100 text-slate-700'
                                            };
                                        @endphp

                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-bold {{ $riskStyle }}">
                                            {{ $item->tingkat_risiko }}
                                        </span>

                                    @else

                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                                            Belum Dinilai
                                        </span>

                                    @endif

                                </td>

                                <td class="py-3.5 px-4 align-top whitespace-nowrap">

                                    @if($item->prioritas_penanganan)

                                        @php
                                            $prioVal = (string) $item->prioritas_penanganan;

                                            $prioLabel = match($prioVal) {
                                                '1', 'Darurat', 'Prioritas 1' => 'Prioritas 1',
                                                '2', 'Tinggi', 'Prioritas 2' => 'Prioritas 2',
                                                '3', 'Sedang', 'Prioritas 3' => 'Prioritas 3',
                                                '4', 'Rendah', 'Prioritas 4' => 'Prioritas 4',
                                                default => 'Prioritas ' . $prioVal
                                            };

                                            $prioCls = match($prioLabel) {
                                                'Prioritas 1' => 'bg-red-600 text-white',
                                                'Prioritas 2' => 'bg-amber-500 text-white',
                                                'Prioritas 3' => 'bg-blue-600 text-white',
                                                default => 'bg-slate-600 text-white'
                                            };
                                        @endphp

                                        <span class="inline-flex px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $prioCls }}">
                                            {{ $prioLabel }}
                                        </span>

                                    @else

                                        <span class="text-[11px] font-medium text-slate-400">
                                            Menunggu
                                        </span>

                                    @endif

                                </td>

                                <td class="py-3.5 px-4 align-top text-right whitespace-nowrap">

                                    <div class="inline-flex items-center gap-1.5">

                                        <button
                                            type="button"
                                            onclick="showIncidentDetail({{ json_encode($item) }})"
                                            class="px-3 py-1.5 rounded-lg border border-blue-200 bg-white hover:bg-blue-50 text-[11px] font-semibold text-blue-600">

                                            Buka
                                        </button>

                                        @if($item->tingkat_risiko)

                                            <a href="{{ route('penilaian-risiko.edit', $item->id) }}"
                                               class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-[11px] font-semibold no-underline">

                                                Ubah
                                            </a>

                                        @else

                                            <a href="{{ route('penilaian-risiko.create', $item->id) }}"
                                               class="px-3 py-1.5 rounded-lg bg-[#e03c22] hover:bg-[#c53019] text-white text-[11px] font-semibold no-underline">

                                                Nilai
                                            </a>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400">
                                    Belum ada data laporan karhutla yang masuk.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- AKSI CEPAT --}}
        <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5 space-y-4">

            <div class="flex items-center gap-2">

                <i class="bi bi-lightning-charge-fill text-amber-500"></i>

                <h2 class="text-sm sm:text-base font-bold text-slate-900">
                    Aksi Cepat Pusdalops
                </h2>

            </div>

            <div class="space-y-2.5">

                @php
                    $firstUnassessed = $laporanTerbaru->firstWhere('tingkat_risiko', null);

                    $formCreateUrl = $firstUnassessed
                        ? route('penilaian-risiko.create', $firstUnassessed->id)
                        : route('penilaian-risiko.index', ['tab' => 'perlu_dinilai']);
                @endphp

                {{-- FORM PENILAIAN BARU --}}
                <a href="{{ $formCreateUrl }}"
                   class="w-full p-3.5 rounded-xl border border-slate-200 hover:border-red-200 hover:bg-red-50/50 flex items-center justify-between gap-3 group no-underline">

                    <div class="flex items-center gap-3 min-w-0">

                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-[#e03c22] flex items-center justify-center shrink-0">
                            <i class="bi bi-clipboard-check text-xl"></i>
                        </div>

                        <div class="min-w-0">
                            <div class="text-xs font-bold text-slate-900 group-hover:text-[#e03c22]">
                                Catat Penilaian Risiko
                            </div>

                            <div class="text-[11px] text-slate-500 mt-0.5">
                                Input nilai risiko kejadian baru
                            </div>
                        </div>

                    </div>

                    <i class="bi bi-chevron-right text-slate-400"></i>

                </a>

                {{-- PERBARUI PENILAIAN --}}
                <a href="{{ route('penilaian-risiko.index', ['tab' => 'sudah_dinilai']) }}"
                   class="w-full p-3.5 rounded-xl border border-slate-200 hover:border-amber-300 hover:bg-amber-50/40 flex items-center justify-between gap-3 group no-underline">

                    <div class="flex items-center gap-3 min-w-0">

                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                            <i class="bi bi-pencil-square text-xl"></i>
                        </div>

                        <div class="min-w-0">
                            <div class="text-xs font-bold text-slate-900">
                                Perbarui Penilaian Risiko
                            </div>

                            <div class="text-[11px] text-slate-500 mt-0.5">
                                Ubah penilaian sesuai kondisi terbaru
                            </div>
                        </div>

                    </div>

                    <i class="bi bi-chevron-right text-slate-400"></i>

                </a>

                {{-- VERIFIKASI LAPORAN --}}
                <a href="{{ route('laporan.index') }}"
                   class="w-full p-3.5 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50/30 flex items-center justify-between gap-3 group no-underline">

                    <div class="flex items-center gap-3 min-w-0">

                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <i class="bi bi-file-earmark-check text-xl"></i>
                        </div>

                        <div class="min-w-0">
                            <div class="text-xs font-bold text-slate-900">
                                Kelola & Verifikasi Laporan
                            </div>

                            <div class="text-[11px] text-slate-500 mt-0.5">
                                Periksa kebenaran laporan masuk
                            </div>
                        </div>

                    </div>

                    <i class="bi bi-chevron-right text-slate-400"></i>

                </a>

                {{-- RISIKO DAN PRIORITAS --}}
                <a href="{{ route('penilaian-risiko.index') }}"
                   class="w-full p-3.5 rounded-xl border border-slate-200 hover:border-emerald-200 hover:bg-emerald-50/30 flex items-center justify-between gap-3 group no-underline">

                    <div class="flex items-center gap-3 min-w-0">

                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <i class="bi bi-bar-chart-line text-xl"></i>
                        </div>

                        <div class="min-w-0">
                            <div class="text-xs font-bold text-slate-900">
                                Daftar Prioritas Penanganan
                            </div>

                            <div class="text-[11px] text-slate-500 mt-0.5">
                                Urutan kejadian berdasarkan prioritas penanganan
                            </div>
                        </div>

                    </div>

                    <i class="bi bi-chevron-right text-slate-400"></i>

                </a>

            </div>

        </div>

    </section>

</main>

{{-- MODAL DETAIL KEJADIAN --}}
<div id="detailModalBackdrop"
     onclick="closeDetailModal()"
     class="fixed inset-0 z-50 bg-slate-900/45 backdrop-blur-[1px] hidden items-center justify-center p-4">

    <div onclick="event.stopPropagation()"
         class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-lg overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between gap-3">

            <div>
                <div id="detailModalCode" class="text-[11px] font-bold text-blue-600 uppercase tracking-wide">
                    KARHUTLA-BMS001
                </div>

                <h3 id="detailModalTitle" class="text-sm sm:text-base font-bold text-slate-900">
                    Detail Kejadian & Hasil Penilaian
                </h3>
            </div>

            <button type="button"
                    onclick="closeDetailModal()"
                    class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100"
                    aria-label="Tutup">

                <i class="bi bi-x-lg"></i>
            </button>

        </div>

        <div id="detailModalBody"
             class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
        </div>

    </div>
</div>

<script>
    function showIncidentDetail(item) {

        const backdrop = document.getElementById('detailModalBackdrop');
        const body = document.getElementById('detailModalBody');

        if (!item || !backdrop || !body) return;

        document.getElementById('detailModalCode').textContent =
            `${item.kode_laporan} • Banyumas`;

        document.getElementById('detailModalTitle').textContent =
            item.lokasi;

        const riskCls = {
            'Sangat Tinggi': 'bg-red-100 text-red-700',
            'Kritis': 'bg-red-100 text-red-700',
            'Tinggi': 'bg-amber-100 text-amber-800',
            'Sedang': 'bg-blue-100 text-blue-700',
            'Rendah': 'bg-emerald-100 text-emerald-700'
        }[item.tingkat_risiko] || 'bg-slate-100 text-slate-600';

        const prioLabel = item.prioritas_penanganan
            ? ('Prioritas ' + item.prioritas_penanganan).replace('Prioritas Prioritas', 'Prioritas')
            : 'Menunggu';

        const prioCls = {
            'Prioritas 1': 'bg-red-600 text-white',
            'Prioritas Darurat': 'bg-red-600 text-white',
            'Prioritas 2': 'bg-amber-500 text-white',
            'Prioritas Tinggi': 'bg-amber-500 text-white',
            'Prioritas 3': 'bg-blue-600 text-white',
            'Prioritas Sedang': 'bg-blue-600 text-white'
        }[prioLabel] || 'bg-slate-600 text-white';

        const actionUrl = item.tingkat_risiko
            ? `/penilaian-risiko/${item.id}/edit`
            : `/penilaian-risiko/${item.id}/create`;

        body.innerHTML = `
            <div class="grid grid-cols-2 gap-3">

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="text-[10px] font-bold text-slate-400 uppercase">
                        Tingkat Risiko
                    </div>

                    <div class="mt-2">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-bold ${riskCls}">
                            ${item.tingkat_risiko || 'Belum Dinilai'}
                        </span>
                    </div>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="text-[10px] font-bold text-slate-400 uppercase">
                        Prioritas Penanganan
                    </div>

                    <div class="mt-2">
                        <span class="inline-flex px-2.5 py-1 rounded-lg text-[11px] font-bold ${prioCls}">
                            ${prioLabel}
                        </span>
                    </div>
                </div>

            </div>

            <div class="rounded-xl border border-slate-200 divide-y divide-slate-100 text-xs">

                <div class="px-4 py-3 flex justify-between gap-4">
                    <span class="text-slate-500">Lokasi Kejadian</span>
                    <span class="font-semibold text-slate-900 text-right">${item.lokasi || '-'}</span>
                </div>

                <div class="px-4 py-3 flex justify-between gap-4">
                    <span class="text-slate-500">Estimasi Luas</span>
                    <span class="font-semibold text-slate-900">${item.estimasi_luas_terdampak || '-'}</span>
                </div>

                <div class="px-4 py-3 flex justify-between gap-4">
                    <span class="text-slate-500">Status Verifikasi</span>
                    <span class="font-semibold text-emerald-700">${item.status || '-'}</span>
                </div>

                <div class="px-4 py-3 flex justify-between gap-4">
                    <span class="text-slate-500">Penilai</span>
                    <span class="font-medium text-slate-700">${item.dinilai_oleh || '-'}</span>
                </div>

            </div>

            <div class="space-y-1.5">

                <div class="text-xs font-bold text-slate-800">
                    Catatan & Rekomendasi Penanganan
                </div>

                <p class="text-xs text-slate-700 leading-relaxed bg-amber-50 p-3.5 rounded-xl border border-amber-200">
                    ${item.catatan_penilaian || item.deskripsi || 'Belum ada catatan penilaian risiko untuk kejadian ini.'}
                </p>

            </div>

            <div class="pt-2 flex items-center justify-end gap-2.5">

                <button type="button"
                        onclick="closeDetailModal()"
                        class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    Tutup
                </button>

                <a href="${actionUrl}"
                   class="px-4 py-2 rounded-xl bg-[#e03c22] hover:bg-[#c53019] text-xs font-bold text-white no-underline">
                    ${item.tingkat_risiko ? 'Buka Form Pembaruan' : 'Buka Form Penilaian'}
                </a>

            </div>
        `;

        backdrop.classList.remove('hidden');
        backdrop.classList.add('flex');
    }

    function closeDetailModal() {

        const backdrop = document.getElementById('detailModalBackdrop');

        if (backdrop) {
            backdrop.classList.add('hidden');
            backdrop.classList.remove('flex');
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDetailModal();
        }
    });
</script>

@endsection
