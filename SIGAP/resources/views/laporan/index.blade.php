@extends('layouts.app')

@section('title', 'Daftar Laporan Karhutla - SIGAP')

@section('content')
<main id="view-laporan" class="p-4 sm:p-7 max-w-[1380px] w-full mx-auto space-y-6">

  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2.5">
        <svg class="w-6 h-6 text-[#6b1e17] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h1 class="text-xl sm:text-2xl font-extrabold text-[#6b1e17] tracking-tight">
          Daftar Laporan Karhutla
        </h1>
      </div>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Data seluruh laporan kejadian kebakaran hutan dan lahan yang masuk ke sistem SIGAP.
      </p>
    </div>

    <!-- Tombol Form Pelaporan Baru -->
    <a
      href="{{ route('laporan.create') }}"
      class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#e03c22] hover:bg-[#c53019] text-white text-xs font-bold shadow-2xs transition shrink-0 self-start sm:self-center"
    >
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
      </svg>
      <span>Form Pelaporan Baru</span>
    </a>
  </div>

  @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-semibold text-emerald-800 flex items-center justify-between gap-2 shadow-2xs">
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('success') }}</span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold text-sm leading-none">&times;</button>
    </div>
  @endif

  <!-- 4 Summary Cards Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Laporan -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
        </svg>
      </div>
      <div>
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">TOTAL LAPORAN</div>
        <div class="text-2xl font-extrabold text-slate-900 mt-0.5 tabular-nums">{{ $ringkasan['total'] ?? $laporans->total() }}</div>
      </div>
    </div>

    <!-- Menunggu -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center shrink-0">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div>
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">MENUNGGU</div>
        <div class="text-2xl font-extrabold text-slate-900 mt-0.5 tabular-nums">{{ $ringkasan['menunggu'] ?? 0 }}</div>
      </div>
    </div>

    <!-- Disetujui -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div>
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">DISETUJUI</div>
        <div class="text-2xl font-extrabold text-slate-900 mt-0.5 tabular-nums">{{ $ringkasan['disetujui'] ?? 0 }}</div>
      </div>
    </div>

    <!-- Ditolak -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center shrink-0">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div>
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">DITOLAK</div>
        <div class="text-2xl font-extrabold text-slate-900 mt-0.5 tabular-nums">{{ $ringkasan['ditolak'] ?? 0 }}</div>
      </div>
    </div>
  </div>

  <!-- Search & Filter Bar -->
  <form method="GET" action="{{ route('laporan.index') }}" class="bg-white rounded-2xl border border-slate-200/80 p-3.5 sm:p-4 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex flex-col md:flex-row items-center gap-3">
    <!-- Input Pencarian -->
    <div class="relative flex-1 w-full">
      <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
      <input
        type="text"
        name="q"
        value="{{ request('q') }}"
        placeholder="Cari kode laporan, lokasi, atau deskripsi..."
        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#e03c22]/20 focus:border-[#e03c22] outline-none transition"
      >
    </div>

    <!-- Dropdown Status -->
    <div class="w-full md:w-56">
      <select
        name="status"
        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white text-slate-700 focus:ring-2 focus:ring-[#e03c22]/20 focus:border-[#e03c22] outline-none transition cursor-pointer"
      >
        <option value="">-- Semua Status --</option>
        <option value="Menunggu" {{ request('status') === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
        <option value="Disetujui" {{ request('status') === 'Disetujui' || request('status') === 'Terverifikasi' ? 'selected' : '' }}>Disetujui</option>
        <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
      </select>
    </div>

    <!-- Tombol Filter -->
    <button
      type="submit"
      class="w-full md:w-auto px-7 py-2.5 rounded-xl bg-[#541c15] hover:bg-[#3f130e] text-white text-xs font-bold shadow-2xs transition"
    >
      Filter
    </button>
  </form>

  <!-- Table Card: Data Laporan Masuk -->
  <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] overflow-hidden">
    <!-- Card Header -->
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between gap-3">
      <h2 class="text-sm sm:text-base font-bold text-slate-900">
        Data Laporan Masuk
      </h2>
      <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-medium">
        Menampilkan {{ $laporans->count() }} dari {{ $laporans->total() }} laporan
      </span>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-slate-100 text-xs font-bold text-slate-900 bg-slate-50/60">
            <th class="py-3.5 px-4 w-12 text-center">No</th>
            <th class="py-3.5 px-4">Kode Laporan</th>
            <th class="py-3.5 px-4">Lokasi Kejadian</th>
            <th class="py-3.5 px-4">Waktu Kejadian</th>
            <th class="py-3.5 px-4 text-center">Foto</th>
            <th class="py-3.5 px-4 text-center">Status</th>
            <th class="py-3.5 px-4 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-xs">
          @forelse($laporans as $index => $item)
            <tr class="hover:bg-slate-50/70 transition">
              <!-- No -->
              <td class="py-4 px-4 text-center text-slate-600 font-medium">
                {{ ($laporans->currentPage() - 1) * $laporans->perPage() + $loop->iteration }}
              </td>

              <!-- Kode Laporan -->
              <td class="py-4 px-4 whitespace-nowrap">
                <span class="font-bold text-blue-600 font-mono tracking-wide">
                  {{ $item->kode_laporan }}
                </span>
              </td>

              <!-- Lokasi Kejadian -->
              <td class="py-4 px-4 max-w-xs">
                <div class="font-bold text-slate-900">{{ $item->lokasi }}</div>
                <div class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">{{ $item->deskripsi }}</div>
              </td>

              <!-- Waktu Kejadian -->
              <td class="py-4 px-4 whitespace-nowrap text-slate-700">
                <div class="flex items-center gap-1.5 font-medium">
                  <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  <span>{{ \Carbon\Carbon::parse($item->waktu_kejadian)->translatedFormat('d M Y') }}</span>
                </div>
                <div class="flex items-center gap-1.5 text-[11px] text-slate-400 mt-0.5">
                  <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>{{ \Carbon\Carbon::parse($item->waktu_kejadian)->format('H:i') }} WIB</span>
                </div>
              </td>

              <!-- Foto -->
              <td class="py-4 px-4 text-center whitespace-nowrap">
                @if($item->foto)
                  <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" class="inline-block" title="Lihat Foto">
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Kejadian" class="w-9 h-9 object-cover rounded-lg border border-slate-200 shadow-2xs hover:scale-105 transition">
                  </a>
                @else
                  <span class="text-slate-400 font-medium">-</span>
                @endif
              </td>

              <!-- Status -->
              <td class="py-4 px-4 text-center whitespace-nowrap">
                @if($item->status === 'Disetujui' || $item->status === 'Terverifikasi')
                  <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>Disetujui</span>
                  </span>
                @elseif($item->status === 'Ditolak')
                  <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span>Ditolak</span>
                  </span>
                @else
                  <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-[#fef9c3] text-[#854d0e]">
                    <span>⏳</span>
                    <span>Menunggu</span>
                  </span>
                @endif
              </td>

              <!-- Aksi -->
              <td class="py-4 px-4 text-center whitespace-nowrap">
                <a
                  href="{{ route('laporan.show', $item->id) }}"
                  class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-blue-400 bg-blue-50/50 hover:bg-blue-100 text-blue-600 text-xs font-semibold transition text-decoration-none"
                >
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                  <span>Lihat Detail</span>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-12 text-center text-slate-400">
                Belum ada data laporan karhutla yang masuk.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($laporans->hasPages())
      <div class="p-4 border-t border-slate-100 flex items-center justify-between">
        {{ $laporans->links() }}
      </div>
    @endif
  </div>

</main>
@endsection
