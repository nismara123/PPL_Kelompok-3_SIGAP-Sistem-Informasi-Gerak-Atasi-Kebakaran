@extends('layouts.app')

@section('title', 'Verifikasi Laporan Masyarakat - SIGAP')

@section('content')
<main id="view-verifikasi" class="p-4 sm:p-7 max-w-[1380px] w-full mx-auto space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
        <a href="{{ route('pusdalops.dashboard') }}" class="hover:text-slate-900 font-medium text-decoration-none">Dashboard</a>
        <span>/</span>
        <span class="text-slate-800 font-semibold">Daftar Laporan Karhutla</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
        Verifikasi Laporan Masyarakat
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Validasi laporan masuk sebelum atau sesudah dilakukan penilaian risiko lapangan.
      </p>
    </div>

    <div class="flex items-center gap-2">
      <span class="px-3.5 py-1.5 rounded-full border border-slate-200 bg-white text-xs font-semibold text-slate-700 shadow-2xs">
        Total: {{ $ringkasan['total'] ?? count($laporans) }} Laporan
      </span>
    </div>
  </div>

  @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-semibold text-emerald-800 flex items-center gap-2">
      <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Verification Table (Persis Sesuai Image 4) -->
  <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/70">
            <th class="py-3.5 px-5">KODE</th>
            <th class="py-3.5 px-4">LOKASI & PELAPOR</th>
            <th class="py-3.5 px-4">STATUS VERIFIKASI</th>
            <th class="py-3.5 px-5 text-right">TINDAKAN</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-xs">
          @forelse($laporans as $item)
            @php
              $isVerified = in_array($item->status, ['Terverifikasi', 'Disetujui']);
            @endphp
            <tr class="hover:bg-slate-50/80 transition">
              <td class="py-4 px-5 font-bold text-blue-600 align-top whitespace-nowrap">
                <a href="{{ route('laporan.show', $item->id) }}" class="hover:underline text-blue-600 text-decoration-none">
                  {{ $item->kode_laporan }}
                </a>
              </td>
              <td class="py-4 px-4 align-top">
                <div class="font-bold text-slate-900">{{ $item->lokasi }}</div>
                <div class="text-[11px] text-slate-500 mt-0.5">
                  Pelapor: {{ $item->pelapor ?? 'Warga / Relawan MPA' }} • {{ \Carbon\Carbon::parse($item->waktu_kejadian ?? $item->created_at)->format('d M Y, H:i') }} WIB
                </div>
              </td>
              <td class="py-4 px-4 align-top whitespace-nowrap">
                @if($isVerified)
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
              <td class="py-4 px-5 align-top text-right whitespace-nowrap">
                @if(!$isVerified)
                  <form action="{{ route('laporan.setujui', $item->id) }}" method="POST" class="inline m-0">
                    @csrf
                    <button
                      type="submit"
                      class="px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition shadow-2xs"
                    >
                      Verifikasi Laporan
                    </button>
                  </form>
                @else
                  @if($item->tingkat_risiko)
                    <a
                      href="{{ route('penilaian-risiko.edit', $item->id) }}"
                      class="px-3 py-1.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-semibold transition text-decoration-none"
                    >
                      Buka Form Penilaian
                    </a>
                  @else
                    <a
                      href="{{ route('penilaian-risiko.create', $item->id) }}"
                      class="px-3 py-1.5 rounded-lg border border-[#e03c22] bg-[#fff5f3] hover:bg-[#ffedea] text-[#c8321b] text-xs font-semibold transition text-decoration-none"
                    >
                      Buka Form Penilaian
                    </a>
                  @endif
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="py-10 text-center text-slate-400">
                Tidak ada laporan masuk yang memerlukan tindakan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($laporans->hasPages())
      <div class="p-4 border-t border-slate-100">
        {{ $laporans->links() }}
      </div>
    @endif
  </div>

</main>
@endsection
