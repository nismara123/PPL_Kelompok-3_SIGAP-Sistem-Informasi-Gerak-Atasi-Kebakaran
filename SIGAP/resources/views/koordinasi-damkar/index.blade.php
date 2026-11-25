@extends('layouts.app')

@section('title', 'Koordinasi Damkar — SIGAP')

@section('content')
@php
    $isPusdalops = auth()->user()->role === 'pusdalops';
    $statCards = [
        ['label' => 'TOTAL PERMINTAAN', 'val' => $ringkasan['total'], 'bg' => 'bg-blue-50 text-blue-600', 'icon' => 'M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z'],
        ['label' => 'MENUNGGU KONFIRMASI', 'val' => $ringkasan['menunggu'], 'bg' => 'bg-amber-50 text-amber-600', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'DITERIMA', 'val' => $ringkasan['diterima'], 'bg' => 'bg-emerald-50 text-emerald-600', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'DITOLAK', 'val' => $ringkasan['ditolak'], 'bg' => 'bg-rose-50 text-rose-600', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
    ];
@endphp

<main class="p-4 sm:p-7 max-w-[1200px] w-full mx-auto space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-[28px] font-extrabold tracking-tight text-[#7a1b10] flex items-center gap-2.5">
        <svg class="w-6 h-6 text-[#e03c22]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
        Koordinasi Damkar
      </h1>
      <p class="text-sm text-slate-500 mt-1.5">
        {{ $isPusdalops ? 'Pantau respons Damkar (menunggu konfirmasi, diterima, atau ditolak) atas permintaan penanganan yang Anda kirim.' : 'Permintaan penanganan dari BPBD yang ditujukan kepada Anda. Tanggapi dengan memilih Diterima atau Ditolak.' }}
      </p>
    </div>

    @if($isPusdalops)
      <a href="{{ route('koordinasi-damkar.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#e03c22] hover:bg-[#c8321b] text-white text-xs font-bold shadow-sm transition self-start">
        <span class="text-base leading-none">+</span> Kirim Permintaan
      </a>
    @endif
  </div>

  {{-- Notifikasi --}}
  @if(session('success'))
    <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">{{ session('error') }}</div>
  @endif
  @if($errors->any())
    <div class="p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm space-y-1">
      @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
  @endif

  {{-- Kartu statistik --}}
  <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
    @foreach($statCards as $c)
      <div class="bg-white rounded-2xl border border-slate-200/80 px-4 py-3.5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex items-center gap-3.5">
        <div class="w-11 h-11 rounded-xl {{ $c['bg'] }} flex items-center justify-center shrink-0">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $c['icon'] }}" /></svg>
        </div>
        <div>
          <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">{{ $c['label'] }}</div>
          <div class="text-xl font-extrabold text-slate-900 mt-0.5 tabular-nums leading-tight">{{ number_format($c['val']) }}</div>
        </div>
      </div>
    @endforeach
  </section>

  {{-- Pencarian & filter --}}
  <form method="GET" action="{{ route('koordinasi-damkar.index') }}" class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-4 flex flex-col sm:flex-row gap-3">
    <div class="relative flex-1">
      <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
      <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode laporan, lokasi, atau petugas Damkar..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-[#e03c22]">
    </div>
    <select name="status" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-[#e03c22]">
      <option value="semua">-- Semua Status --</option>
      @foreach(['Menunggu Konfirmasi', 'Diterima', 'Ditolak'] as $opt)
        <option value="{{ $opt }}" {{ request('status') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
      @endforeach
    </select>
    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#5b1a10] hover:bg-[#46130b] text-white text-sm font-bold transition">Filter</button>
  </form>

  {{-- Tabel koordinasi --}}
  <section class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] overflow-hidden">
    <div class="px-5 py-4 flex items-center justify-between gap-3 border-b border-slate-100">
      <h2 class="text-base font-bold text-slate-900">Data Permintaan Koordinasi</h2>
      <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-medium">
        Menampilkan {{ $koordinasi->count() }} dari {{ $koordinasi->total() }} permintaan
      </span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50/60 border-b border-slate-100 text-xs font-bold text-slate-800">
            <th class="py-3.5 px-4">No</th>
            <th class="py-3.5 px-4">Kode Laporan</th>
            <th class="py-3.5 px-4">Petugas Damkar</th>
            <th class="py-3.5 px-4">Metode Komunikasi</th>
            <th class="py-3.5 px-4">Waktu Koordinasi</th>
            <th class="py-3.5 px-4">Prioritas</th>
            <th class="py-3.5 px-4">Status</th>
            <th class="py-3.5 px-4 text-center">{{ $isPusdalops ? 'Respons Damkar' : 'Aksi' }}</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm">
          @forelse($koordinasi as $index => $item)
            @php
              $prioClass = match($item->prioritas) {
                  'Tinggi' => 'bg-amber-100 text-amber-800',
                  'Sedang' => 'bg-blue-100 text-blue-700',
                  default => 'bg-emerald-100 text-emerald-700',
              };
              $statusClass = match($item->status) {
                  'Diterima' => 'bg-emerald-100 text-emerald-700',
                  'Ditolak' => 'bg-rose-100 text-rose-700',
                  default => 'bg-amber-100 text-amber-800',
              };
              $statusIcon = match($item->status) {
                  'Diterima' => '✓',
                  'Ditolak' => '✕',
                  default => '⏳',
              };
            @endphp
            <tr class="hover:bg-slate-50/60 align-middle">
              <td class="py-4 px-4 text-slate-600">{{ $koordinasi->firstItem() + $index }}</td>

              <td class="py-4 px-4">
                <a href="{{ route('koordinasi-damkar.show', $item->id) }}" class="font-mono text-xs font-bold text-blue-700 hover:underline">{{ $item->laporan->kode_laporan ?? '-' }}</a>
                <div class="text-xs text-slate-500 mt-0.5 max-w-[220px] truncate">{{ $item->laporan->lokasi ?? '' }}</div>
              </td>

              <td class="py-4 px-4 font-semibold text-slate-800">{{ $item->petugasDamkar->name ?? '-' }}</td>

              <td class="py-4 px-4 text-slate-600">{{ $item->metode_komunikasi }}</td>

              <td class="py-4 px-4 text-slate-600 text-xs tabular-nums">
                @if($item->waktu_koordinasi)
                  <div>{{ $item->waktu_koordinasi->format('d M Y') }}</div>
                  <div class="text-slate-400 mt-0.5">{{ $item->waktu_koordinasi->format('H:i') }} WIB</div>
                @else
                  -
                @endif
              </td>

              <td class="py-4 px-4"><span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $prioClass }}">{{ $item->prioritas }}</span></td>

              <td class="py-4 px-4"><span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">{{ $statusIcon }} {{ $item->status }}</span></td>

              {{-- Aksi / Respons --}}
              <td class="py-4 px-4 text-center">
                @if($isPusdalops)
                  {{-- Pusdalops hanya memantau respons Damkar (tanpa mengubah status) --}}
                  @if(in_array($item->status, ['Menunggu Konfirmasi', 'Terkirim']))
                    <span class="inline-flex items-center gap-1.5 text-xs text-amber-700">
                      <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu respons Damkar
                    </span>
                  @elseif($item->status === 'Diterima')
                    <div class="text-xs text-left inline-block max-w-[200px]">
                      <div class="font-semibold text-emerald-700">Diterima Damkar</div>
                      <div class="text-slate-500 truncate" title="{{ $item->tim_ditugaskan }}">Tim: {{ $item->tim_ditugaskan ?: '-' }}</div>
                      @if($item->waktu_konfirmasi)
                        <div class="text-slate-400">{{ $item->waktu_konfirmasi->format('d M Y, H:i') }} WIB</div>
                      @endif
                    </div>
                  @else
                    <div class="text-xs text-left inline-block max-w-[200px]">
                      <div class="font-semibold text-rose-700">Ditolak Damkar</div>
                      <div class="text-slate-500 truncate" title="{{ $item->catatan_konfirmasi }}">Alasan: {{ $item->catatan_konfirmasi ?: '-' }}</div>
                      @if($item->waktu_konfirmasi)
                        <div class="text-slate-400">{{ $item->waktu_konfirmasi->format('d M Y, H:i') }} WIB</div>
                      @endif
                    </div>
                  @endif
                @else
                  {{-- Damkar memberi keputusan Diterima / Ditolak lewat halaman detail --}}
                  @if(in_array($item->status, ['Menunggu Konfirmasi', 'Terkirim']))
                    <a href="{{ route('koordinasi-damkar.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-[#e03c22] hover:bg-[#c8321b] text-white text-xs font-semibold transition whitespace-nowrap">
                      Tanggapi
                    </a>
                  @else
                    <a href="{{ route('koordinasi-damkar.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg border border-blue-300 text-blue-700 hover:bg-blue-50 text-xs font-semibold transition whitespace-nowrap">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                      Lihat Detail
                    </a>
                  @endif
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="py-12 text-center text-slate-500 text-sm">Belum ada permintaan koordinasi Damkar.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($koordinasi->hasPages())
      <div class="p-4 border-t border-slate-100">{{ $koordinasi->links() }}</div>
    @endif
  </section>
</main>
@endsection
