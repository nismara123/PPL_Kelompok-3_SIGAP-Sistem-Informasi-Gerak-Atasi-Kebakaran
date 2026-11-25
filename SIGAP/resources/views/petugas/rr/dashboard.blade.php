@extends('layouts.app')

@section('title', 'Dashboard Divisi RR — SIGAP')

@section('content')
<main class="p-4 sm:p-7 max-w-[1200px] w-full mx-auto space-y-6">

  @include('petugas.partials.hero', [
      'badge' => 'Divisi Rehabilitasi dan Rekonstruksi',
      'judul' => 'Selamat Datang, ' . (auth()->user()->name ?? 'Petugas Divisi RR') . '!',
      'deskripsi' => 'Sistem Informasi Gerak Atasi Kebakaran (SIGAP) Kabupaten Banyumas. Kelola data kerusakan lahan terdampak karhutla, dokumentasikan rehabilitasi lahan, dan pantau persebaran wilayah terdampak.',
      'gradient' => 'linear-gradient(105deg, #0f4a2a 0%, #166534 52%, #1f8a4c 100%)',
  ])

  <!-- KPI Cards -->
  <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
    @php
      $cards = [
        ['label' => 'TOTAL DATA KERUSAKAN', 'val' => number_format($ringkasan['total']), 'sub' => 'Lahan terdampak tercatat', 'bg' => 'bg-blue-50 text-blue-600', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ['label' => 'TOTAL LUAS (HA)', 'val' => number_format($ringkasan['luas'], 1, ',', '.'), 'sub' => 'Luas lahan terdampak', 'bg' => 'bg-amber-50 text-amber-600', 'icon' => 'M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4'],
        ['label' => 'WILAYAH TERDAMPAK', 'val' => number_format($ringkasan['wilayah']), 'sub' => 'Wilayah pantauan', 'bg' => 'bg-emerald-50 text-emerald-600', 'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z'],
        ['label' => 'JENIS KERUSAKAN', 'val' => number_format($ringkasan['jenis']), 'sub' => 'Kategori lahan', 'bg' => 'bg-rose-50 text-rose-600', 'icon' => 'M12 3c2.5 3.2 5 5.6 5 9.2a5 5 0 11-10 0c0-1.6.7-3.2 1.8-4.7.3 1.4 1.2 2.2 2.2 2.5-.4-2.3.1-4.8 1-7z'],
      ];
    @endphp
    @foreach($cards as $c)
      <a href="{{ route('kerusakan-lahan.index') }}" class="bg-white rounded-2xl border border-slate-200/80 px-4 py-3.5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] hover:border-emerald-200 transition flex items-center gap-3.5">
        <div class="w-11 h-11 rounded-xl {{ $c['bg'] }} flex items-center justify-center shrink-0">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $c['icon'] }}" /></svg>
        </div>
        <div class="min-w-0">
          <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase truncate">{{ $c['label'] }}</div>
          <div class="text-xl font-extrabold text-slate-900 mt-0.5 tabular-nums leading-tight">{{ $c['val'] }}</div>
          <div class="text-xs font-medium text-slate-500 mt-0.5 truncate">{{ $c['sub'] }}</div>
        </div>
      </a>
    @endforeach
  </section>

  <section class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
    <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] overflow-hidden">
      <div class="px-5 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
          <h2 class="text-sm sm:text-base font-bold text-slate-900 leading-snug">Data Kerusakan Lahan Terbaru</h2>
          <p class="text-xs text-slate-500 mt-0.5">Pencatatan kondisi lahan terdampak sebagai dasar rehabilitasi</p>
        </div>
        <a href="{{ route('kerusakan-lahan.index') }}" class="self-start sm:self-center inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition shrink-0">
          <span>Lihat Semua</span><span aria-hidden="true">&rarr;</span>
        </a>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/50">
              <th class="py-3 px-4">Lokasi</th>
              <th class="py-3 px-4">Jenis Kerusakan</th>
              <th class="py-3 px-4">Luas</th>
              <th class="py-3 px-4">Tanggal</th>
              <th class="py-3 px-4 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-xs">
            @forelse($dataTerbaru as $d)
              <tr class="hover:bg-slate-50/60">
                <td class="py-3.5 px-4 font-semibold text-slate-800">{{ $d->lokasi }}</td>
                <td class="py-3.5 px-4"><span class="px-2.5 py-1 rounded-full text-[11px] font-bold text-white" style="background: {{ $d->warna }}">{{ $d->jenis_kerusakan }}</span></td>
                <td class="py-3.5 px-4 tabular-nums text-slate-600">{{ $d->luas_ha !== null ? number_format($d->luas_ha, 1, ',', '.') . ' Ha' : '-' }}</td>
                <td class="py-3.5 px-4 text-slate-500">{{ $d->tanggal_pencatatan?->format('d M Y') ?? '-' }}</td>
                <td class="py-3.5 px-4 text-right">
                  <a href="{{ route('kerusakan-lahan.show', $d->id) }}" class="inline-block px-3 py-1.5 rounded-lg bg-slate-900 text-white text-[11px] font-semibold hover:bg-slate-700 transition">Buka</a>
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="py-10 text-center text-slate-500">Belum ada data kerusakan lahan.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-5">
      <div class="flex items-center gap-2 mb-4">
        <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" /></svg>
        <h2 class="text-sm sm:text-base font-bold text-slate-900">Aksi Cepat Divisi RR</h2>
      </div>
      <div class="space-y-3">
        <a href="{{ route('kerusakan-lahan.create') }}" class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200/80 hover:bg-slate-50 transition">
          <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
          </div>
          <div class="min-w-0 flex-1">
            <div class="text-xs font-bold text-slate-900">Tambah Data Kerusakan</div>
            <div class="text-[11px] text-slate-500 truncate">Catat lahan terdampak baru</div>
          </div>
          <span class="text-slate-300">&rsaquo;</span>
        </a>
        <a href="{{ route('kerusakan-lahan.index') }}" class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200/80 hover:bg-slate-50 transition">
          <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
          </div>
          <div class="min-w-0 flex-1">
            <div class="text-xs font-bold text-slate-900">Daftar Kerusakan Lahan</div>
            <div class="text-[11px] text-slate-500 truncate">Lihat, ubah, dan kelola data</div>
          </div>
          <span class="text-slate-300">&rsaquo;</span>
        </a>
      </div>
    </div>
  </section>
</main>
@endsection
