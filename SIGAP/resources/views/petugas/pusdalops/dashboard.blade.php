@extends('layouts.app')

@section('title', 'SIGAP — Sistem Penanganan Karhutla | BPBD Kabupaten Banyumas')

@section('content')
<main id="view-dashboard" class="p-4 sm:p-7 max-w-[1380px] w-full mx-auto space-y-6">

  <!-- Hero Banner -->
  <section class="sigap-hero-banner rounded-2xl p-6 sm:p-8 text-white shadow-2xs">
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
      <div class="max-w-2xl space-y-3">
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white text-slate-800 text-[11px] font-semibold shadow-2xs">
          <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944z" clip-rule="evenodd" />
          </svg>
          <span>Pusat Pengendalian Operasi Penanggulangan Bencana</span>
        </div>

        <h1 class="text-2xl sm:text-[28px] font-extrabold tracking-tight leading-tight">
          Selamat Datang, {{ auth()->user()->name ?? 'Petugas Pusdalops' }}!
        </h1>

        <p class="text-xs sm:text-sm text-red-100/95 leading-relaxed">
          Sistem Informasi Gerak Atasi Kebakaran (SIGAP) Kabupaten Banyumas. Pantau laporan masyarakat, lakukan verifikasi data kejadian, dan tetapkan penilaian risiko serta prioritas penanganan.
        </p>
      </div>

      <!-- Status Kesiapsiagaan Card -->
      <div class="self-start lg:self-center bg-[#0d1117]/85 border border-white/10 rounded-2xl px-5 py-4 shrink-0">
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase mb-2">
          STATUS KESIAPSIAGAAN
        </div>
        <div class="flex items-center gap-2.5">
          <span class="px-2.5 py-1 rounded-full bg-[#e11d48] text-white text-[11px] font-extrabold tracking-wide">
            SIAGA KARHUTLA
          </span>
          <span class="text-xs font-semibold text-white">Wilayah Banyumas</span>
        </div>
      </div>
    </div>
  </section>

  <!-- 4 KPI Summary Cards -->
  <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4" id="dashboardKpiGrid">
    <!-- Card 1: Total Laporan -->
    <a href="{{ route('penilaian-risiko.index') }}" class="cursor-pointer bg-white rounded-2xl border border-slate-200/80 p-5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] hover:border-blue-200 transition flex items-center gap-4 text-decoration-none">
      <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
      </div>
      <div class="min-w-0">
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">TOTAL LAPORAN</div>
        <div class="text-2xl font-extrabold text-slate-900 mt-0.5 tabular-nums">{{ number_format($ringkasan['total'] ?? 0) }}</div>
        <div class="text-xs font-medium text-slate-500 mt-0.5">Kejadian terdata</div>
      </div>
    </a>

    <!-- Card 2: Menunggu Verifikasi -->
    <a href="{{ route('laporan.index', ['status' => 'Menunggu']) }}" class="cursor-pointer bg-white rounded-2xl border border-slate-200/80 p-5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] hover:border-amber-200 transition flex items-center gap-4 text-decoration-none">
      <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div class="min-w-0">
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">MENUNGGU VERIFIKASI</div>
        <div class="text-2xl font-extrabold text-slate-900 mt-0.5 tabular-nums">{{ number_format($ringkasan['menunggu'] ?? 0) }}</div>
        <div class="text-xs font-semibold text-[#e03c22] mt-0.5">{{ ($ringkasan['menunggu'] ?? 0) > 0 ? 'Perlu tindakan' : 'Semua terverifikasi' }} &rarr;</div>
      </div>
    </a>

    <!-- Card 3: Butuh Nilai Risiko -->
    <a href="{{ route('penilaian-risiko.index', ['tab' => 'perlu_dinilai']) }}" class="cursor-pointer bg-white rounded-2xl border border-slate-200/80 p-5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] hover:border-rose-200 transition flex items-center gap-4 text-decoration-none">
      <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
      </div>
      <div class="min-w-0">
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">BUTUH NILAI RISIKO</div>
        <div class="text-2xl font-extrabold text-slate-900 mt-0.5 tabular-nums">{{ number_format($ringkasan['perlu_penilaian'] ?? 0) }}</div>
        <div class="text-xs font-semibold text-[#e03c22] mt-0.5">Tentukan prioritas &rarr;</div>
      </div>
    </a>

    <!-- Card 4: Wilayah Pantauan -->
    <a href="{{ route('wilayah.index') }}" class="cursor-pointer bg-white rounded-2xl border border-slate-200/80 p-5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] hover:border-emerald-200 transition flex items-center gap-4 text-decoration-none">
      <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      </div>
      <div class="min-w-0">
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">WILAYAH PANTAUAN</div>
        <div class="text-2xl font-extrabold text-slate-900 mt-0.5 tabular-nums">{{ number_format($ringkasan['total_wilayah'] ?? 0) }}</div>
        <div class="text-xs font-semibold text-slate-600 mt-0.5">Master data &rarr;</div>
      </div>
    </a>
  </section>

  <!-- Bottom Split Section: Kejadian Karhutla Terbaru (Left) & Aksi Cepat Pusdalops (Right) -->
  <section class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

    <!-- Left 8 Columns: Kejadian Karhutla Terbaru -->
    <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] overflow-hidden">
      <div class="px-5 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-start gap-2.5">
          <svg class="w-4 h-4 text-[#e03c22] mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
          </svg>
          <div>
            <h2 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">Kejadian Karhutla Terbaru</h2>
            <p class="text-xs text-slate-500 mt-0.5">Daftar laporan kejadian dan hasil penilaian risiko serta prioritas penanganan</p>
          </div>
        </div>

        <a
          href="{{ route('penilaian-risiko.index') }}"
          class="self-start sm:self-center inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition shrink-0"
        >
          <span>Lihat Semua</span>
          <span aria-hidden="true">&rarr;</span>
        </a>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/50">
              <th class="py-3 px-4">KODE LAPORAN</th>
              <th class="py-3 px-4">LOKASI KEJADIAN</th>
              <th class="py-3 px-4">STATUS</th>
              <th class="py-3 px-4">TINGKAT RISIKO</th>
              <th class="py-3 px-4">PRIORITAS</th>
              <th class="py-3 px-4 text-center">AKSI</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-xs">
            @forelse($laporanTerbaru as $item)
              <tr class="hover:bg-slate-50/80 transition">
                <td class="py-3.5 px-4 align-middle whitespace-nowrap">
                  <div class="font-bold text-blue-600">{{ $item->kode_laporan }}</div>
                  <div class="text-[11px] text-slate-400 mt-0.5">
                    {{ \Carbon\Carbon::parse($item->waktu_kejadian ?? $item->created_at)->diffForHumans() }}
                  </div>
                </td>
                <td class="py-3.5 px-4 align-middle">
                  <div class="font-semibold text-slate-900 line-clamp-1">{{ $item->lokasi }}</div>
                  <div class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">{{ $item->deskripsi }}</div>
                </td>
                <td class="py-3.5 px-4 align-middle whitespace-nowrap">
                  @if($item->status === 'Terverifikasi' || $item->status === 'Disetujui')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">
                      Terverifikasi
                    </span>
                  @elseif($item->status === 'Ditolak')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-100 text-rose-700">
                      Ditolak
                    </span>
                  @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800">
                      Menunggu
                    </span>
                  @endif
                </td>
                <td class="py-3.5 px-4 align-middle whitespace-nowrap">
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
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold {{ $riskStyle }}">
                      {{ $item->tingkat_risiko }}
                    </span>
                  @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                      Belum Dinilai
                    </span>
                  @endif
                </td>
                <td class="py-3.5 px-4 align-middle whitespace-nowrap">
                  @if($item->prioritas_penanganan)
                    @php
                      $prioVal = (string)$item->prioritas_penanganan;
                      $prioLabel = match($prioVal) {
                        '1', 'Darurat', 'Prioritas 1' => 'Prioritas 1',
                        '2', 'Tinggi', 'Prioritas 2' => 'Prioritas 2',
                        '3', 'Sedang', 'Prioritas 3' => 'Prioritas 3',
                        '4', 'Rendah', 'Prioritas 4' => 'Prioritas 4',
                        default => 'Prioritas ' . $prioVal
                      };
                      $prioCls = match($prioLabel) {
                        'Prioritas 1' => 'bg-[#dc2626] text-white',
                        'Prioritas 2' => 'bg-[#f59e0b] text-white',
                        'Prioritas 3' => 'bg-[#2563eb] text-white',
                        'Prioritas 4' => 'bg-[#334155] text-white',
                        default => 'bg-slate-700 text-white'
                      };
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $prioCls }}">
                      {{ $prioLabel }}
                    </span>
                  @else
                    <span class="text-[11px] font-medium text-slate-400">Menunggu</span>
                  @endif
                </td>
                <td class="py-3.5 px-4 align-middle text-center whitespace-nowrap">
                  <div class="inline-flex items-center justify-center gap-1.5">
                    <button
                      type="button"
                      onclick="showIncidentDetail({{ json_encode($item) }})"
                      class="px-3 py-1.5 rounded-lg border border-blue-200 bg-white hover:bg-blue-50 text-[11px] font-semibold text-blue-600 transition"
                    >
                      Buka
                    </button>
                    @if($item->tingkat_risiko)
                      <a
                        href="{{ route('penilaian-risiko.edit', $item->id) }}"
                        class="px-3.5 py-1.5 rounded-lg bg-[#1e293b] hover:bg-[#0f172a] text-white text-[11px] font-semibold transition"
                      >
                        Ubah
                      </a>
                    @else
                      <a
                        href="{{ route('penilaian-risiko.create', $item->id) }}"
                        class="px-3.5 py-1.5 rounded-lg bg-[#dc2626] hover:bg-[#b91c1c] text-white text-[11px] font-semibold transition"
                      >
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

    <!-- Right 4 Columns: Aksi Cepat Pusdalops -->
    <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-5 space-y-4">
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
        </svg>
        <h2 class="text-sm sm:text-base font-bold text-slate-900">Aksi Cepat Pusdalops</h2>
      </div>

      <div class="space-y-2.5">
        <!-- Quick Action 1: Catat Penilaian Risiko -->
        @php
          $firstUnassessed = $laporanTerbaru->firstWhere('tingkat_risiko', null);
          $formCreateUrl = $firstUnassessed ? route('penilaian-risiko.create', $firstUnassessed->id) : route('penilaian-risiko.index', ['tab' => 'perlu_dinilai']);
        @endphp
        <a
          href="{{ $formCreateUrl }}"
          class="w-full text-left p-3.5 rounded-xl border border-slate-200/90 hover:border-[#e03c22]/40 hover:bg-[#fff8f6] transition flex items-center justify-between gap-3 group text-decoration-none"
        >
          <div class="flex items-center gap-3 min-w-0">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-[#e03c22] flex items-center justify-center shrink-0">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
              </svg>
            </div>
            <div class="min-w-0">
              <div class="text-xs font-bold text-slate-900 group-hover:text-[#e03c22] transition">Catat Penilaian Risiko</div>
              <div class="text-[11px] text-slate-500 mt-0.5 truncate">Input nilai risiko kejadian baru</div>
            </div>
          </div>
          <svg class="w-4 h-4 text-slate-400 group-hover:text-[#e03c22] shrink-0 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </a>

        <!-- Quick Action 2: Perbarui Penilaian Risiko -->
        <a
          href="{{ route('penilaian-risiko.index', ['tab' => 'sudah_dinilai']) }}"
          class="w-full text-left p-3.5 rounded-xl border border-slate-200/90 hover:border-amber-300 hover:bg-amber-50/40 transition flex items-center justify-between gap-3 group text-decoration-none"
        >
          <div class="flex items-center gap-3 min-w-0">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
              </svg>
            </div>
            <div class="min-w-0">
              <div class="text-xs font-bold text-slate-900 group-hover:text-amber-600 transition">Perbarui Penilaian Risiko</div>
              <div class="text-[11px] text-slate-500 mt-0.5 truncate">Ubah hasil penilaian sesuai kondisi terbaru</div>
            </div>
          </div>
          <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </a>

        <!-- Quick Action 3: Kelola & Verifikasi Laporan -->
        <a
          href="{{ route('laporan.index') }}"
          class="w-full text-left p-3.5 rounded-xl border border-slate-200/90 hover:border-blue-200 hover:bg-blue-50/30 transition flex items-center justify-between gap-3 group text-decoration-none"
        >
          <div class="flex items-center gap-3 min-w-0">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
            <div class="min-w-0">
              <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 transition">Kelola & Verifikasi Laporan</div>
              <div class="text-[11px] text-slate-500 mt-0.5 truncate">Periksa kebenaran laporan masuk</div>
            </div>
          </div>
          <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </a>

        <!-- Quick Action 4: Daftar Prioritas Penanganan -->
        <a
          href="{{ route('penilaian-risiko.index') }}"
          class="w-full text-left p-3.5 rounded-xl border border-slate-200/90 hover:border-emerald-200 hover:bg-emerald-50/30 transition flex items-center justify-between gap-3 group text-decoration-none"
        >
          <div class="flex items-center gap-3 min-w-0">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
              </svg>
            </div>
            <div class="min-w-0">
              <div class="text-xs font-bold text-slate-900 group-hover:text-emerald-600 transition">Daftar Prioritas Penanganan</div>
              <div class="text-[11px] text-slate-500 mt-0.5 truncate">Urutan kejadian berdasarkan prioritas penanganan</div>
            </div>
          </div>
          <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </a>
      </div>
    </div>

  </section>
</main>

<!-- ==================== DETAIL KEJADIAN MODAL ==================== -->
<div id="detailModalBackdrop" onclick="closeDetailModal()" class="fixed inset-0 z-50 bg-slate-900/45 backdrop-blur-[1px] hidden items-center justify-center p-4">
  <div onclick="event.stopPropagation()" class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between gap-3">
      <div>
        <div id="detailModalCode" class="text-[11px] font-bold text-blue-600 uppercase tracking-wide">KARHUTLA-BMS001</div>
        <h3 id="detailModalTitle" class="text-sm sm:text-base font-bold text-slate-900">Detail Kejadian & Hasil Penilaian</h3>
      </div>
      <button type="button" onclick="closeDetailModal()" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" aria-label="Tutup">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <div id="detailModalBody" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto"></div>
  </div>
</div>

<script>
  function showIncidentDetail(item) {
    const backdrop = document.getElementById('detailModalBackdrop');
    const body = document.getElementById('detailModalBody');
    if (!item || !backdrop || !body) return;

    document.getElementById('detailModalCode').textContent = `${item.kode_laporan} • Banyumas`;
    document.getElementById('detailModalTitle').textContent = item.lokasi;

    const riskCls = {
      'Sangat Tinggi': 'bg-red-100 text-red-700',
      'Kritis': 'bg-red-100 text-red-700',
      'Tinggi': 'bg-amber-100 text-amber-800',
      'Sedang': 'bg-blue-100 text-blue-700',
      'Rendah': 'bg-emerald-100 text-emerald-700'
    }[item.tingkat_risiko] || 'bg-slate-100 text-slate-600';

    const prioLabel = item.prioritas_penanganan ? ('Prioritas ' + item.prioritas_penanganan).replace('Prioritas Prioritas', 'Prioritas') : 'Menunggu';
    const prioCls = {
      'Prioritas 1': 'bg-red-600 text-white',
      'Prioritas Darurat': 'bg-red-600 text-white',
      'Prioritas 2': 'bg-amber-500 text-white',
      'Prioritas Tinggi': 'bg-amber-500 text-white',
      'Prioritas 3': 'bg-blue-600 text-white',
      'Prioritas Sedang': 'bg-blue-600 text-white',
    }[prioLabel] || 'bg-slate-600 text-white';

    const actionUrl = item.tingkat_risiko 
      ? `/penilaian-risiko/${item.id}/edit` 
      : `/penilaian-risiko/${item.id}/create`;

    body.innerHTML = `
      <div class="grid grid-cols-2 gap-3">
        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
          <div class="text-[10px] font-bold text-slate-400 uppercase">Tingkat Risiko</div>
          <div class="mt-2">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold ${riskCls}">
              ${item.tingkat_risiko || 'Belum Dinilai'}
            </span>
          </div>
        </div>
        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
          <div class="text-[10px] font-bold text-slate-400 uppercase">Prioritas Penanganan</div>
          <div class="mt-2">
            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold ${prioCls}">
              ${prioLabel}
            </span>
          </div>
        </div>
      </div>

      <div class="rounded-xl border border-slate-200 divide-y divide-slate-100 text-xs">
        <div class="px-4 py-3 flex justify-between gap-4">
          <span class="text-slate-500">Lokasi Kejadian</span>
          <span class="font-semibold text-slate-900 text-right">${item.lokasi}</span>
        </div>
        <div class="px-4 py-3 flex justify-between gap-4">
          <span class="text-slate-500">Estimasi Luas</span>
          <span class="font-semibold text-slate-900">${item.estimasi_luas_terdampak || '-'}</span>
        </div>
        <div class="px-4 py-3 flex justify-between gap-4">
          <span class="text-slate-500">Status Verifikasi</span>
          <span class="font-semibold text-emerald-700">${item.status}</span>
        </div>
        <div class="px-4 py-3 flex justify-between gap-4">
          <span class="text-slate-500">Penilai</span>
          <span class="font-medium text-slate-700">${item.dinilai_oleh || '-'}</span>
        </div>
      </div>

      <div class="space-y-1.5">
        <div class="text-xs font-bold text-slate-800">Catatan & Rekomendasi Penanganan</div>
        <p class="text-xs text-slate-700 leading-relaxed bg-amber-50/70 p-3.5 rounded-xl border border-amber-200/70">
          ${item.catatan_penilaian || item.deskripsi || 'Belum ada catatan penilaian risiko untuk kejadian ini.'}
        </p>
      </div>

      <div class="pt-2 flex items-center justify-end gap-2.5">
        <button type="button" onclick="closeDetailModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
          Tutup
        </button>
        <a href="${actionUrl}" class="px-4 py-2 rounded-xl bg-[#e03c22] hover:bg-[#c53019] text-xs font-bold text-white transition">
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

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeDetailModal();
    }
  });
</script>
@endsection
