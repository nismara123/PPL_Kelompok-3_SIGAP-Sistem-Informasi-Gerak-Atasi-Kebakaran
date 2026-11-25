@extends('layouts.app')

@section('title', 'Dashboard Damkar — SIGAP')

@section('content')
<main class="p-4 sm:p-7 max-w-[1200px] w-full mx-auto space-y-6">

  @include('petugas.partials.hero', [
      'badge' => 'Unit Pemadam Kebakaran',
      'judul' => 'Selamat Datang, ' . (auth()->user()->name ?? 'Petugas Damkar') . '!',
      'deskripsi' => 'Sistem Informasi Gerak Atasi Kebakaran (SIGAP) Kabupaten Banyumas. Terima permintaan penanganan dari BPBD, tentukan tim yang ditugaskan, dan pantau tindak lanjut kejadian kebakaran hutan dan lahan.',
      'gradient' => 'linear-gradient(105deg, #5c0f12 0%, #8f1717 52%, #c81e1e 100%)',
  ])

  <!-- KPI Cards -->
  <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
    <a href="{{ route('koordinasi-damkar.index') }}" class="bg-white rounded-2xl border border-slate-200/80 px-4 py-3.5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] hover:border-blue-200 transition flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
      </div>
      <div class="min-w-0">
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase truncate">TOTAL PERMINTAAN</div>
        <div class="text-xl font-extrabold text-slate-900 mt-0.5 tabular-nums leading-tight">{{ number_format($ringkasan['total']) }}</div>
        <div class="text-xs font-medium text-slate-500 mt-0.5 truncate">Penugasan dari BPBD</div>
      </div>
    </a>

    <a href="{{ route('koordinasi-damkar.index', ['status' => 'Menunggu Konfirmasi']) }}" class="bg-white rounded-2xl border border-slate-200/80 px-4 py-3.5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] hover:border-amber-200 transition flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
      </div>
      <div class="min-w-0">
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase truncate">MENUNGGU KONFIRMASI</div>
        <div class="text-xl font-extrabold text-slate-900 mt-0.5 tabular-nums leading-tight">{{ number_format($ringkasan['menunggu']) }}</div>
        <div class="text-xs font-semibold text-[#c81e1e] mt-0.5 truncate">{{ $ringkasan['menunggu'] > 0 ? 'Perlu tindakan' : 'Tidak ada antrean' }} &rarr;</div>
      </div>
    </a>

    <a href="{{ route('koordinasi-damkar.index', ['status' => 'Diterima']) }}" class="bg-white rounded-2xl border border-slate-200/80 px-4 py-3.5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] hover:border-emerald-200 transition flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
      </div>
      <div class="min-w-0">
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase truncate">DITERIMA</div>
        <div class="text-xl font-extrabold text-slate-900 mt-0.5 tabular-nums leading-tight">{{ number_format($ringkasan['diterima']) }}</div>
        <div class="text-xs font-medium text-slate-500 mt-0.5 truncate">Tim sudah ditugaskan</div>
      </div>
    </a>

    <a href="{{ route('koordinasi-damkar.index') }}" class="bg-white rounded-2xl border border-slate-200/80 px-4 py-3.5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] hover:border-rose-200 transition flex items-center gap-3.5">
      <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
      </div>
      <div class="min-w-0">
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase truncate">PRIORITAS TINGGI</div>
        <div class="text-xl font-extrabold text-slate-900 mt-0.5 tabular-nums leading-tight">{{ number_format($ringkasan['prioritas_tinggi']) }}</div>
        <div class="text-xs font-semibold text-slate-600 mt-0.5 truncate">Utamakan penanganan</div>
      </div>
    </a>
  </section>

  <section class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
    <!-- Permintaan terbaru -->
    <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] overflow-hidden">
      <div class="px-5 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-start gap-2.5">
          <svg class="w-4 h-4 text-[#c81e1e] mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
          <div>
            <h2 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">Permintaan Penanganan Terbaru</h2>
            <p class="text-xs text-slate-500 mt-0.5">Daftar permintaan koordinasi dari BPBD beserta prioritas dan status konfirmasi</p>
          </div>
        </div>
        <a href="{{ route('koordinasi-damkar.index') }}" class="self-start sm:self-center inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition shrink-0">
          <span>Lihat Semua</span><span aria-hidden="true">&rarr;</span>
        </a>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/50">
              <th class="py-3 px-4">Kode Laporan</th>
              <th class="py-3 px-4">Lokasi Kejadian</th>
              <th class="py-3 px-4">Prioritas</th>
              <th class="py-3 px-4">Status</th>
              <th class="py-3 px-4 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-xs">
            @forelse($koordinasiTerbaru as $item)
              @php
                $prio = match($item->prioritas) {
                    'Tinggi' => 'bg-amber-100 text-amber-800',
                    'Sedang' => 'bg-blue-100 text-blue-700',
                    default => 'bg-emerald-100 text-emerald-700',
                };
                $st = match($item->status) {
                    'Diterima' => 'bg-emerald-100 text-emerald-700',
                    'Ditolak' => 'bg-rose-100 text-rose-700',
                    default => 'bg-amber-100 text-amber-800',
                };
              @endphp
              <tr class="hover:bg-slate-50/60">
                <td class="py-3.5 px-4">
                  <div class="font-bold text-blue-700">{{ $item->laporan->kode_laporan ?? '-' }}</div>
                  <div class="text-[11px] text-slate-400 mt-0.5">{{ $item->created_at?->diffForHumans() }}</div>
                </td>
                <td class="py-3.5 px-4 max-w-[220px]">
                  <div class="font-semibold text-slate-800 truncate">{{ $item->laporan->lokasi ?? '-' }}</div>
                  <div class="text-[11px] text-slate-500 truncate">{{ $item->metode_komunikasi }} • {{ $item->petugasBpbd->name ?? 'BPBD' }}</div>
                </td>
                <td class="py-3.5 px-4"><span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $prio }}">{{ $item->prioritas }}</span></td>
                <td class="py-3.5 px-4"><span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $st }}">{{ $item->status }}</span></td>
                <td class="py-3.5 px-4 text-right">
                  <a href="{{ route('koordinasi-damkar.show', $item->id) }}" class="inline-block px-3 py-1.5 rounded-lg bg-slate-900 text-white text-[11px] font-semibold hover:bg-slate-700 transition">Buka</a>
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="py-10 text-center text-slate-500">Belum ada permintaan penanganan untuk Anda.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Aksi cepat -->
    <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-5">
      <div class="flex items-center gap-2 mb-4">
        <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" /></svg>
        <h2 class="text-sm sm:text-base font-bold text-slate-900">Aksi Cepat Damkar</h2>
      </div>
      <div class="space-y-3">
        <a href="{{ route('koordinasi-damkar.index', ['status' => 'Menunggu Konfirmasi']) }}" class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200/80 hover:bg-slate-50 transition">
          <div class="w-10 h-10 rounded-xl bg-red-50 text-[#c81e1e] flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
          </div>
          <div class="min-w-0 flex-1">
            <div class="text-xs font-bold text-slate-900">Konfirmasi Permintaan</div>
            <div class="text-[11px] text-slate-500 truncate">Terima & tentukan tim yang bertugas</div>
          </div>
          <span class="text-slate-300">&rsaquo;</span>
        </a>
        <a href="{{ route('koordinasi-damkar.index') }}" class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200/80 hover:bg-slate-50 transition">
          <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
          </div>
          <div class="min-w-0 flex-1">
            <div class="text-xs font-bold text-slate-900">Daftar Koordinasi Damkar</div>
            <div class="text-[11px] text-slate-500 truncate">Lihat seluruh permintaan penanganan</div>
          </div>
          <span class="text-slate-300">&rsaquo;</span>
        </a>
      </div>
    </div>
  </section>
</main>
@endsection
