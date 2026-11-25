@extends('layouts.app')

@php $isVerifikasi = ($mode ?? 'daftar') === 'verifikasi'; @endphp

@section('title', ($isVerifikasi ? 'Verifikasi Laporan Karhutla' : 'Daftar Laporan Karhutla') . ' - SIGAP')

@section('content')
@php
    $selectedStatus = $statusFilter ?? request('status');
    $canVerify = auth()->check() && auth()->user()->role === 'pusdalops';

    $iconFolder = 'M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z';
    $iconClock = 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
    $iconCheck = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
    $iconX = 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z';

    if ($isVerifikasi) {
        $cards = [
            ['label' => 'MENUNGGU VERIFIKASI', 'val' => $ringkasan['menunggu'], 'sub' => 'Prioritas tindakan petugas', 'bg' => 'bg-amber-50 text-amber-600', 'num' => 'text-amber-600', 'icon' => $iconClock, 'status' => 'Menunggu', 'ring' => 'border-amber-300 ring-1 ring-amber-200'],
            ['label' => 'TERVERIFIKASI VALID', 'val' => $ringkasan['disetujui'], 'sub' => 'Laporan sah / diteruskan', 'bg' => 'bg-emerald-50 text-emerald-600', 'num' => 'text-emerald-600', 'icon' => $iconCheck, 'status' => 'Terverifikasi', 'ring' => ''],
            ['label' => 'DITOLAK / TIDAK VALID', 'val' => $ringkasan['ditolak'], 'sub' => 'Laporan berulang / hoax', 'bg' => 'bg-rose-50 text-rose-600', 'num' => 'text-rose-600', 'icon' => $iconX, 'status' => 'Ditolak', 'ring' => ''],
        ];
    } else {
        $cards = [
            ['label' => 'TOTAL LAPORAN', 'val' => $ringkasan['total'], 'bg' => 'bg-blue-50 text-blue-600', 'icon' => $iconFolder],
            ['label' => 'MENUNGGU', 'val' => $ringkasan['menunggu'], 'bg' => 'bg-amber-50 text-amber-600', 'icon' => $iconClock],
            ['label' => 'DISETUJUI', 'val' => $ringkasan['disetujui'], 'bg' => 'bg-emerald-50 text-emerald-600', 'icon' => $iconCheck],
            ['label' => 'DITOLAK', 'val' => $ringkasan['ditolak'], 'bg' => 'bg-rose-50 text-rose-600', 'icon' => $iconX],
        ];
    }
@endphp

<main class="p-4 sm:p-7 max-w-[1200px] w-full mx-auto space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-[28px] font-extrabold tracking-tight text-[#7a1b10] flex items-center gap-2.5">
        <svg class="w-6 h-6 {{ $isVerifikasi ? 'text-emerald-600' : 'text-[#e03c22]' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="{{ $isVerifikasi ? $iconCheck : 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z' }}" />
        </svg>
        {{ $isVerifikasi ? 'Verifikasi Laporan Karhutla' : 'Daftar Laporan Karhutla' }}
      </h1>
      <p class="text-sm text-slate-500 mt-1.5">
        {{ $isVerifikasi
            ? 'Pusat validasi dan verifikasi laporan kejadian kebakaran hutan dan lahan dari masyarakat oleh Petugas Pusdalops.'
            : 'Data seluruh laporan kejadian kebakaran hutan dan lahan yang masuk ke sistem SIGAP.' }}
      </p>
    </div>

    @if($isVerifikasi)
      @if($ringkasan['menunggu'] > 0)
        <span class="self-start inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-amber-200 bg-amber-50 text-xs font-semibold text-amber-800">
          <span class="w-2 h-2 rounded-full bg-amber-500"></span>{{ $ringkasan['menunggu'] }} Laporan Butuh Verifikasi
        </span>
      @endif
    @else
      <a href="{{ route('laporan.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#e03c22] hover:bg-[#c8321b] text-white text-xs font-bold shadow-sm transition self-start">
        <span class="text-base leading-none">+</span> Form Pelaporan Baru
      </a>
    @endif
  </div>

  @if(session('success'))
    <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm">{{ session('success') }}</div>
  @endif

  {{-- Kartu ringkasan --}}
  <section class="grid grid-cols-1 sm:grid-cols-2 {{ $isVerifikasi ? 'xl:grid-cols-3' : 'xl:grid-cols-4' }} gap-4">
    @foreach($cards as $c)
      @if($isVerifikasi)
        <a href="{{ route('laporan.index', ['mode' => 'verifikasi', 'status' => $c['status']]) }}"
           class="bg-white rounded-2xl border {{ $c['ring'] ?: 'border-slate-200/80' }} px-4 py-3.5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex items-center gap-3.5 hover:shadow-md transition">
          <div class="w-11 h-11 rounded-xl {{ $c['bg'] }} flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $c['icon'] }}" /></svg>
          </div>
          <div class="min-w-0">
            <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">{{ $c['label'] }}</div>
            <div class="text-xl font-extrabold {{ $c['num'] }} mt-0.5 tabular-nums leading-tight">{{ number_format($c['val']) }}</div>
            <div class="text-[11px] text-slate-500 mt-0.5">{{ $c['sub'] }}</div>
          </div>
        </a>
      @else
        <div class="bg-white rounded-2xl border border-slate-200/80 px-4 py-3.5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex items-center gap-3.5">
          <div class="w-11 h-11 rounded-xl {{ $c['bg'] }} flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $c['icon'] }}" /></svg>
          </div>
          <div class="min-w-0">
            <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">{{ $c['label'] }}</div>
            <div class="text-xl font-extrabold text-slate-900 mt-0.5 tabular-nums leading-tight">{{ number_format($c['val']) }}</div>
          </div>
        </div>
      @endif
    @endforeach
  </section>

  {{-- Pencarian & filter --}}
  <form method="GET" action="{{ route('laporan.index') }}" class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-4 flex flex-col sm:flex-row gap-3">
    @if($isVerifikasi)<input type="hidden" name="mode" value="verifikasi">@endif
    <div class="relative flex-1">
      <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
      <input type="text" name="q" value="{{ request('q') }}"
             placeholder="{{ $isVerifikasi ? 'Cari kode laporan, lokasi, atau keterangan pelapor...' : 'Cari kode laporan, lokasi, atau deskripsi...' }}"
             class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-[#e03c22]">
    </div>
    <select name="status" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-[#e03c22]">
      @if($isVerifikasi)
        <option value="Menunggu" {{ $selectedStatus === 'Menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
        <option value="Terverifikasi" {{ in_array($selectedStatus, ['Terverifikasi','Disetujui']) ? 'selected' : '' }}>Terverifikasi</option>
        <option value="Ditolak" {{ $selectedStatus === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
        <option value="semua" {{ $selectedStatus === 'semua' ? 'selected' : '' }}>-- Semua Status --</option>
      @else
        <option value="semua">-- Semua Status --</option>
        <option value="Menunggu" {{ $selectedStatus === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
        <option value="Disetujui" {{ in_array($selectedStatus, ['Terverifikasi','Disetujui']) ? 'selected' : '' }}>Disetujui</option>
        <option value="Ditolak" {{ $selectedStatus === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
      @endif
    </select>
    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#5b1a10] hover:bg-[#46130b] text-white text-sm font-bold transition">Filter</button>
  </form>

  {{-- Tabel --}}
  <section class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
      <div>
        <h2 class="text-base font-bold text-slate-900">{{ $isVerifikasi ? 'Antrean & Hasil Verifikasi Laporan' : 'Data Laporan Masuk' }}</h2>
        @if($isVerifikasi)
          <p class="text-xs text-slate-500 mt-0.5">Tentukan keabsahan data laporan masyarakat langsung dari tabel atau buka detail untuk penelaahan mendalam.</p>
        @endif
      </div>
      <span class="self-start px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-medium">
        Menampilkan {{ $laporans->count() }} dari {{ $laporans->total() }} laporan
      </span>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-50/60 border-b border-slate-100 text-xs font-bold text-slate-800">
            <th class="py-3.5 px-4">No</th>
            <th class="py-3.5 px-4">Kode Laporan</th>
            <th class="py-3.5 px-4">{{ $isVerifikasi ? 'Lokasi & Deskripsi' : 'Lokasi Kejadian' }}</th>
            <th class="py-3.5 px-4">Waktu Kejadian</th>
            <th class="py-3.5 px-4">Foto</th>
            <th class="py-3.5 px-4">{{ $isVerifikasi ? 'Status Verifikasi' : 'Status' }}</th>
            <th class="py-3.5 px-4 text-center">{{ $isVerifikasi ? 'Aksi Verifikasi' : 'Aksi' }}</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm">
          @forelse($laporans as $i => $item)
            @php
              $isVerified = in_array($item->status, ['Terverifikasi', 'Disetujui']);
              $waktu = \Carbon\Carbon::parse($item->waktu_kejadian ?? $item->created_at);
            @endphp
            <tr class="hover:bg-slate-50/60 align-middle">
              <td class="py-4 px-4 text-slate-600">{{ $laporans->firstItem() + $i }}</td>

              <td class="py-4 px-4">
                <a href="{{ route('laporan.show', $item->id) }}" class="font-mono text-xs font-bold text-blue-700 hover:underline whitespace-nowrap">{{ $item->kode_laporan }}</a>
                @if($isVerifikasi)
                  <div class="text-[11px] text-slate-400 mt-0.5">{{ $item->created_at?->diffForHumans() }}</div>
                @endif
              </td>

              <td class="py-4 px-4 max-w-[340px]">
                <div class="font-bold text-slate-900">{{ $item->lokasi }}</div>
                <div class="text-xs text-slate-500 mt-0.5 truncate">{{ $item->deskripsi }}</div>
              </td>

              <td class="py-4 px-4 text-xs tabular-nums whitespace-nowrap">
                <div class="text-slate-700">{{ $waktu->format('d M Y') }}</div>
                <div class="text-slate-400 mt-0.5">{{ $waktu->format('H:i') }} WIB</div>
              </td>

              <td class="py-4 px-4">
                @if($item->foto)
                  <a href="{{ asset('storage/' . $item->foto) }}" target="_blank">
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto" class="w-10 h-10 rounded-lg object-cover border border-slate-200">
                  </a>
                @else
                  <span class="text-slate-300">-</span>
                @endif
              </td>

              <td class="py-4 px-4 whitespace-nowrap">
                @if($isVerified)
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">✓ {{ $isVerifikasi ? 'Terverifikasi' : 'Disetujui' }}</span>
                @elseif($item->status === 'Ditolak')
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">✕ Ditolak</span>
                @else
                  <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">⏳ Menunggu</span>
                @endif
              </td>

              <td class="py-4 px-4 text-center whitespace-nowrap">
                @if($isVerifikasi)
                  <div class="inline-flex items-center gap-1.5">
                    <a href="{{ route('laporan.show', $item->id) }}" class="px-3 py-1.5 rounded-lg border border-blue-300 text-blue-700 hover:bg-blue-50 text-xs font-semibold transition">Rincian</a>
                    @if($canVerify && !$isVerified)
                      <form action="{{ route('laporan.setujui', $item->id) }}" method="POST" class="inline m-0">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition">Setujui</button>
                      </form>
                    @endif
                    @if($canVerify && $item->status !== 'Ditolak')
                      <form action="{{ route('laporan.tolak', $item->id) }}" method="POST" class="inline m-0"
                            onsubmit="var a = prompt('Masukkan alasan penolakan laporan:'); if (a === null || a.trim() === '') { return false; } this.alasan_penolakan.value = a;">
                        @csrf
                        <input type="hidden" name="alasan_penolakan" value="">
                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold transition">Tolak</button>
                      </form>
                    @endif
                  </div>
                @else
                  <a href="{{ route('laporan.show', $item->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg border border-blue-300 text-blue-700 hover:bg-blue-50 text-xs font-semibold transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    Lihat Detail
                  </a>
                @endif
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="py-12 text-center text-slate-400 text-sm">Tidak ada laporan yang sesuai.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($laporans->hasPages())
      <div class="p-4 border-t border-slate-100">{{ $laporans->links() }}</div>
    @endif
  </section>
</main>
@endsection
