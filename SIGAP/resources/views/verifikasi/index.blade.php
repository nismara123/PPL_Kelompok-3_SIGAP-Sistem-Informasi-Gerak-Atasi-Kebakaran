@extends('layouts.app')

@section('title', 'Verifikasi Laporan Kejadian Karhutla - SIGAP')

@section('content')
<main id="view-verifikasi" class="p-4 sm:p-7 max-w-[1380px] w-full mx-auto space-y-6">

  <!-- Header Section -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2.5">
        <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h1 class="text-xl sm:text-2xl font-extrabold text-[#6b1e17] tracking-tight">
          Verifikasi Laporan Karhutla
        </h1>
      </div>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Pusat validasi dan verifikasi laporan kejadian kebakaran hutan dan lahan dari masyarakat oleh Petugas Pusdalops.
      </p>
    </div>

    <div class="flex items-center gap-2">
      <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
        <span>{{ $ringkasan['menunggu'] ?? 0 }} Laporan Butuh Verifikasi</span>
      </span>
    </div>
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

  <!-- 3 Summary Status Cards: Antrean Verifikasi -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <!-- Menunggu Verifikasi (Highlight) -->
    <a href="{{ route('verifikasi.index', ['status' => 'Menunggu']) }}" class="cursor-pointer bg-white rounded-2xl border {{ request('status', 'Menunggu') === 'Menunggu' ? 'border-amber-400 ring-2 ring-amber-400/20' : 'border-slate-200/80' }} p-5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex items-center justify-between text-decoration-none transition hover:border-amber-300">
      <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <div>
          <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">MENUNGGU VERIFIKASI</div>
          <div class="text-2xl font-extrabold text-amber-600 mt-0.5 tabular-nums">{{ $ringkasan['menunggu'] ?? 0 }}</div>
          <div class="text-[11px] font-medium text-slate-400 mt-0.5">Prioritas tindakan petugas</div>
        </div>
      </div>
      <span class="text-xs font-bold text-amber-600">&rarr;</span>
    </a>

    <!-- Sudah Diverifikasi / Disetujui -->
    <a href="{{ route('verifikasi.index', ['status' => 'Disetujui']) }}" class="cursor-pointer bg-white rounded-2xl border {{ request('status') === 'Disetujui' ? 'border-emerald-400 ring-2 ring-emerald-400/20' : 'border-slate-200/80' }} p-5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex items-center justify-between text-decoration-none transition hover:border-emerald-300">
      <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <div>
          <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">TERVERIFIKASI VALID</div>
          <div class="text-2xl font-extrabold text-emerald-600 mt-0.5 tabular-nums">{{ $ringkasan['disetujui'] ?? 0 }}</div>
          <div class="text-[11px] font-medium text-slate-400 mt-0.5">Laporan sah / diteruskan</div>
        </div>
      </div>
      <span class="text-xs font-bold text-emerald-600">&rarr;</span>
    </a>

    <!-- Ditolak -->
    <a href="{{ route('verifikasi.index', ['status' => 'Ditolak']) }}" class="cursor-pointer bg-white rounded-2xl border {{ request('status') === 'Ditolak' ? 'border-rose-400 ring-2 ring-rose-400/20' : 'border-slate-200/80' }} p-5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex items-center justify-between text-decoration-none transition hover:border-rose-300">
      <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <div>
          <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">DITOLAK / TIDAK VALID</div>
          <div class="text-2xl font-extrabold text-rose-600 mt-0.5 tabular-nums">{{ $ringkasan['ditolak'] ?? 0 }}</div>
          <div class="text-[11px] font-medium text-slate-400 mt-0.5">Laporan berulang / hoax</div>
        </div>
      </div>
      <span class="text-xs font-bold text-rose-600">&rarr;</span>
    </a>
  </div>

  <!-- Search & Filter Bar -->
  <form method="GET" action="{{ route('verifikasi.index') }}" class="bg-white rounded-2xl border border-slate-200/80 p-3.5 sm:p-4 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex flex-col md:flex-row items-center gap-3">
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
        placeholder="Cari kode laporan, lokasi, atau keterangan pelapor..."
        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#e03c22]/20 focus:border-[#e03c22] outline-none transition"
      >
    </div>

    <!-- Dropdown Status -->
    <div class="w-full md:w-56">
      <select
        name="status"
        class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs bg-white text-slate-700 focus:ring-2 focus:ring-[#e03c22]/20 focus:border-[#e03c22] outline-none transition cursor-pointer"
      >
        <option value="semua" {{ request('status') === 'semua' ? 'selected' : '' }}>-- Semua Status --</option>
        <option value="Menunggu" {{ request('status', 'Menunggu') === 'Menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
        <option value="Disetujui" {{ request('status') === 'Disetujui' ? 'selected' : '' }}>Disetujui / Terverifikasi</option>
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

  <!-- Table Card: Antrean Verifikasi Laporan -->
  <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] overflow-hidden">
    <!-- Card Header -->
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between gap-3">
      <div>
        <h2 class="text-sm sm:text-base font-bold text-slate-900">
          Antrean & Hasil Verifikasi Laporan
        </h2>
        <p class="text-xs text-slate-500 mt-0.5">
          Tentukan keabsahan data laporan masyarakat langsung dari tabel atau buka detail untuk penelaahan mendalam.
        </p>
      </div>
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
            <th class="py-3.5 px-4">Lokasi & Deskripsi</th>
            <th class="py-3.5 px-4">Waktu Kejadian</th>
            <th class="py-3.5 px-4 text-center">Foto</th>
            <th class="py-3.5 px-4 text-center">Status Verifikasi</th>
            <th class="py-3.5 px-4 text-center">Aksi Verifikasi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-xs">
          @forelse($laporans as $item)
            <tr class="hover:bg-slate-50/70 transition">
              <!-- No -->
              <td class="py-4 px-4 text-center text-slate-600 font-medium align-middle">
                {{ ($laporans->currentPage() - 1) * $laporans->perPage() + $loop->iteration }}
              </td>

              <!-- Kode Laporan -->
              <td class="py-4 px-4 whitespace-nowrap align-middle">
                <span class="font-bold text-blue-600 font-mono tracking-wide">
                  {{ $item->kode_laporan }}
                </span>
                <div class="text-[11px] text-slate-400 mt-0.5">
                  {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                </div>
              </td>

              <!-- Lokasi Kejadian -->
              <td class="py-4 px-4 max-w-xs align-middle">
                <div class="font-bold text-slate-900">{{ $item->lokasi }}</div>
                <div class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">{{ $item->deskripsi }}</div>
              </td>

              <!-- Waktu Kejadian -->
              <td class="py-4 px-4 whitespace-nowrap text-slate-700 align-middle">
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
              <td class="py-4 px-4 text-center whitespace-nowrap align-middle">
                @if($item->foto)
                  <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" class="inline-block" title="Lihat Foto Bukti">
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Bukti" class="w-9 h-9 object-cover rounded-lg border border-slate-200 shadow-2xs hover:scale-105 transition">
                  </a>
                @else
                  <span class="text-slate-400 font-medium">-</span>
                @endif
              </td>

              <!-- Status -->
              <td class="py-4 px-4 text-center whitespace-nowrap align-middle">
                @if($item->status === 'Disetujui' || $item->status === 'Terverifikasi')
                  <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>Terverifikasi</span>
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

              <!-- Aksi Verifikasi -->
              <td class="py-4 px-4 text-center whitespace-nowrap align-middle">
                <div class="inline-flex items-center justify-center gap-1.5">
                  <a
                    href="{{ route('laporan.show', $item->id) }}"
                    class="px-3 py-1.5 rounded-lg border border-blue-200 bg-white hover:bg-blue-50 text-blue-600 text-xs font-semibold transition text-decoration-none"
                  >
                    Rincian
                  </a>

                  @if($item->status === 'Menunggu')
                    <!-- Quick Setujui -->
                    <form action="{{ route('laporan.setujui', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Verifikasi dan setujui laporan ini?')">
                      @csrf
                      <button
                        type="submit"
                        class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition"
                      >
                        Setujui
                      </button>
                    </form>

                    <!-- Quick Tolak -->
                    <button
                      type="button"
                      onclick="openModalTolakRow({{ $item->id }}, '{{ $item->kode_laporan }}')"
                      class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold transition"
                    >
                      Tolak
                    </button>
                  @else
                    <span class="text-[11px] text-slate-400 italic">Selesai</span>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-12 text-center text-slate-400">
                Tidak ada laporan yang sesuai dengan filter verifikasi ini.
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

<!-- Modal Tolak Laporan Row -->
<div id="modalTolakRow" onclick="closeModalTolakRow()" class="fixed inset-0 z-50 bg-slate-900/45 backdrop-blur-[1px] hidden items-center justify-center p-4">
  <div onclick="event.stopPropagation()" class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-md overflow-hidden">
    <div class="px-6 py-4 bg-rose-600 text-white flex items-center justify-between gap-3">
      <h3 class="text-sm font-bold flex items-center gap-2">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <span>Tolak Laporan Karhutla</span>
      </h3>
      <button type="button" onclick="closeModalTolakRow()" class="p-1 rounded-lg text-white/80 hover:text-white hover:bg-rose-700 transition">&times;</button>
    </div>

    <form id="formTolakRow" action="" method="POST">
      @csrf
      <div class="p-6 space-y-4">
        <p class="text-xs text-slate-500">
          Laporan dengan kode <strong id="modalKodeLaporan" class="text-slate-900 font-mono"></strong> akan ditolak. Masukkan alasan penolakan di bawah ini.
        </p>

        <div>
          <label class="block text-xs font-bold text-slate-800 mb-1">
            Alasan Penolakan <span class="text-rose-600">* (Wajib diisi)</span>
          </label>
          <textarea
            name="alasan_penolakan"
            rows="4"
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 outline-none transition"
            placeholder="Contoh: Titik api sudah padam / Lokasi tidak ditemukan / Laporan palsu..."
            required
          ></textarea>
        </div>
      </div>

      <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
        <button type="button" onclick="closeModalTolakRow()" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-white transition">
          Batal
        </button>
        <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition shadow-2xs">
          Simpan Penolakan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  function openModalTolakRow(id, kode) {
    const modal = document.getElementById('modalTolakRow');
    const form = document.getElementById('formTolakRow');
    const kodeSpan = document.getElementById('modalKodeLaporan');

    form.action = `/laporan/${id}/tolak`;
    kodeSpan.textContent = kode;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeModalTolakRow() {
    const modal = document.getElementById('modalTolakRow');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
</script>
@endsection