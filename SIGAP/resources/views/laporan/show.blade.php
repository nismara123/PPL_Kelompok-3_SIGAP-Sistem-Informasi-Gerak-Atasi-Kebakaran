@extends('layouts.app')

@section('title', 'Detail Laporan ' . $laporan->kode_laporan . ' - SIGAP')

@section('content')
<main id="view-detail-laporan" class="p-4 sm:p-7 max-w-[1380px] w-full mx-auto space-y-6">

  <!-- Header Section & Back Button -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div class="space-y-1">
      <div>
        <a
          href="{{ route('laporan.index') }}"
          class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-900 transition mb-2"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          <span>Kembali ke Daftar Laporan</span>
        </a>
      </div>
      <h1 class="text-xl sm:text-2xl font-extrabold text-[#64271D] tracking-tight">
        Detail Laporan Kejadian Karhutla
      </h1>
      <p class="text-xs sm:text-sm text-slate-500">
        Rincian informasi lengkap mengenai laporan kebakaran hutan dan lahan.
      </p>
    </div>

    <!-- Status Badge Header -->
    <div class="shrink-0 self-start sm:self-center">
      @if($laporan->status === 'Terverifikasi' || $laporan->status === 'Disetujui')
        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 shadow-2xs">
          <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
          <span>Terverifikasi</span>
        </span>
      @elseif($laporan->status === 'Ditolak')
        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200 shadow-2xs">
          <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
          </svg>
          <span>Ditolak</span>
        </span>
      @else
        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-200 shadow-2xs">
          <span>⏳</span>
          <span>Menunggu Verifikasi</span>
        </span>
      @endif
    </div>
  </div>

  <!-- Alert Messages -->
  @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-semibold text-emerald-800 flex items-center justify-between gap-2 shadow-2xs">
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <span>{{ session('success') }}</span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
    </div>
  @endif

  @if(session('error'))
    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs font-semibold text-rose-800 flex items-center justify-between gap-2 shadow-2xs">
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        <span>{{ session('error') }}</span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-bold">&times;</button>
    </div>
  @endif

  @if($errors->any())
    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 space-y-1">
      <div class="font-bold">Gagal Menyimpan:</div>
      <ul class="list-disc list-inside">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Top 2-Column Grid: Rincian (Left) & Foto (Right) -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

    <!-- Kolom Kiri: Data Rincian Laporan (7 cols) -->
    <div class="lg:col-span-7 space-y-6">

      <!-- Card Data Rincian -->
      <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
          <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h2 class="text-sm font-bold text-slate-900">Data Rincian Laporan</h2>
        </div>

        <div class="p-6">
          <div class="rounded-xl border border-slate-200 divide-y divide-slate-100 text-xs">
            <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-slate-50/50">
              <span class="font-semibold text-slate-500 sm:w-1/3">Kode Laporan</span>
              <span class="font-bold text-blue-600 font-mono text-sm sm:w-2/3">{{ $laporan->kode_laporan }}</span>
            </div>

            <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
              <span class="font-semibold text-slate-500 sm:w-1/3">Status Saat Ini</span>
              <div class="sm:w-2/3">
                @if($laporan->status === 'Terverifikasi' || $laporan->status === 'Disetujui')
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                    Terverifikasi
                  </span>
                @elseif($laporan->status === 'Ditolak')
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">
                    Ditolak
                  </span>
                @else
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-900">
                    Menunggu Verifikasi
                  </span>
                @endif
              </div>
            </div>

            <div class="p-4 flex flex-col sm:flex-row sm:items-start justify-between gap-2">
              <span class="font-semibold text-slate-500 sm:w-1/3">Lokasi Kejadian</span>
              <div class="sm:w-2/3 font-bold text-slate-900 flex items-start gap-1.5">
                <svg class="w-4 h-4 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
                <span>{{ $laporan->lokasi }}</span>
              </div>
            </div>

            <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
              <span class="font-semibold text-slate-500 sm:w-1/3">Waktu Kejadian</span>
              <div class="sm:w-2/3 text-slate-700 flex items-center gap-1.5 font-medium">
                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ \Carbon\Carbon::parse($laporan->waktu_kejadian)->format('d-m-Y H:i') }} WIB</span>
              </div>
            </div>

            <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
              <span class="font-semibold text-slate-500 sm:w-1/3">Waktu Laporan Dibuat</span>
              <span class="sm:w-2/3 text-slate-500 font-mono">{{ $laporan->created_at ? $laporan->created_at->format('d-m-Y H:i:s') . ' WIB' : '-' }}</span>
            </div>

            <div class="p-4 flex flex-col sm:flex-row sm:items-start justify-between gap-2">
              <span class="font-semibold text-slate-500 sm:w-1/3">Deskripsi Lengkap</span>
              <div class="sm:w-2/3 text-slate-700 leading-relaxed whitespace-pre-line bg-slate-50/70 p-3 rounded-xl border border-slate-100">
                {{ $laporan->deskripsi }}
              </div>
            </div>
          </div>

          <!-- Alasan Penolakan Jika Ditolak -->
          @if($laporan->status === 'Ditolak' && $laporan->alasan_penolakan)
            <div class="mt-5 p-4 rounded-xl bg-rose-50 border border-rose-200">
              <div class="flex items-start justify-between gap-3">
                <div class="space-y-1">
                  <div class="text-xs font-bold text-rose-800 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span>Alasan Penolakan Laporan</span>
                  </div>
                  <p class="text-xs text-rose-900 leading-relaxed italic">"{{ $laporan->alasan_penolakan }}"</p>
                  <div class="text-[11px] text-rose-700/80 pt-1">
                    Ditolak oleh: <strong>{{ $laporan->diubah_oleh ?? 'Petugas Pusdalops' }}</strong>
                    @if($laporan->diubah_pada)
                      • ({{ \Carbon\Carbon::parse($laporan->diubah_pada)->format('d-m-Y H:i') }} WIB)
                    @endif
                  </div>
                </div>

                @if($bisaVerifikasi)
                  <button
                    type="button"
                    onclick="openModalEditAlasan()"
                    class="px-3 py-1.5 rounded-lg border border-rose-300 bg-white hover:bg-rose-100 text-xs font-semibold text-rose-700 transition shrink-0"
                  >
                    Edit Alasan
                  </button>
                @endif
              </div>
            </div>
          @endif
        </div>
      </div>

      <!-- Card Riwayat Perubahan Status Laporan -->
      <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
          <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h2 class="text-sm font-bold text-slate-900">Riwayat Perubahan Status Laporan</h2>
        </div>

        <div class="p-6">
          @if(!empty($laporan->riwayat_status) && count($laporan->riwayat_status) > 0)
            <div class="space-y-3 relative pl-4 border-l-2 border-blue-500">
              @foreach(array_reverse($laporan->riwayat_status) as $item)
                <div class="relative bg-slate-50 p-3.5 rounded-xl border border-slate-200/80 text-xs space-y-1">
                  <div class="flex items-center justify-between gap-2">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold {{ str_contains($item['status_baru'] ?? '', 'Ditolak') ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                      {{ $item['status_baru'] ?? '-' }}
                    </span>
                    <span class="text-[11px] text-slate-400">{{ $item['waktu'] ?? '-' }}</span>
                  </div>
                  <div class="text-slate-600">
                    Diproses oleh: <strong class="text-slate-900">{{ $item['diubah_oleh'] ?? 'Petugas' }}</strong>
                  </div>
                  @if(!empty($item['alasan_penolakan']))
                    <div class="p-2.5 rounded-lg bg-rose-50 text-rose-700 border-l-2 border-rose-500 text-[11px] mt-1">
                      <strong>Alasan:</strong> {{ $item['alasan_penolakan'] }}
                    </div>
                  @endif
                </div>
              @endforeach
            </div>
          @else
            <p class="text-xs text-slate-400 italic text-center py-4">
              Belum ada riwayat perubahan status pada laporan ini.
            </p>
          @endif
        </div>
      </div>

    </div>

    <!-- Kolom Kanan: Foto Dokumentasi (5 cols) -->
    <div class="lg:col-span-5 space-y-6">
      <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-2">
          <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <h2 class="text-sm font-bold text-slate-900">Foto Dokumentasi</h2>
        </div>

        <div class="p-6 text-center">
          @if($laporan->foto)
            <div class="mb-4 overflow-hidden rounded-xl border border-slate-200 shadow-sm bg-slate-50">
              <img
                src="{{ asset('storage/' . $laporan->foto) }}"
                alt="Foto Kejadian"
                class="w-full max-h-80 object-cover hover:scale-105 transition duration-300"
              >
            </div>
            <a
              href="{{ asset('storage/' . $laporan->foto) }}"
              target="_blank"
              class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-semibold text-slate-700 transition"
            >
              <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
              </svg>
              <span>Buka Gambar Ukuran Penuh</span>
            </a>
          @else
            <div class="py-12 text-slate-400 space-y-2">
              <svg class="w-12 h-12 mx-auto text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <div class="font-bold text-slate-700 text-xs">Tidak Ada Foto Dokumentasi</div>
              <p class="text-[11px] text-slate-400">Pelapor tidak melampirkan foto pada saat pengiriman laporan.</p>
            </div>
          @endif
        </div>
      </div>
    </div>

  </div>

  <!-- Bagian Bawah: Hasil Penilaian Risiko & Prioritas -->
  <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
        </svg>
        <h2 class="text-sm font-bold text-slate-900">Hasil Penilaian Risiko & Prioritas Kejadian</h2>
      </div>

      @if($laporan->tingkat_risiko)
        <div class="flex items-center gap-2">
          @php
            $riskBadge = match($laporan->tingkat_risiko) {
              'Sangat Tinggi', 'Kritis' => 'bg-red-100 text-red-700',
              'Tinggi' => 'bg-amber-100 text-amber-800',
              'Sedang' => 'bg-blue-100 text-blue-700',
              'Rendah' => 'bg-emerald-100 text-emerald-700',
              default => 'bg-slate-100 text-slate-700'
            };
            $prioVal = (string)$laporan->prioritas_penanganan;
            $prioCls = match($prioVal) {
              '1', 'Darurat', 'Prioritas 1' => 'bg-[#dc2626] text-white',
              '2', 'Tinggi', 'Prioritas 2' => 'bg-[#f59e0b] text-white',
              '3', 'Sedang', 'Prioritas 3' => 'bg-[#2563eb] text-white',
              '4', 'Rendah', 'Prioritas 4' => 'bg-[#334155] text-white',
              default => 'bg-slate-700 text-white'
            };
          @endphp
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $riskBadge }}">
            Risiko: {{ $laporan->tingkat_risiko }}
          </span>
          <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold {{ $prioCls }}">
            Prioritas: {{ $laporan->prioritas_penanganan ?? '-' }}
          </span>
          @if(auth()->check() && auth()->user()->role === 'pusdalops')
            <a
              href="{{ route('penilaian-risiko.edit', $laporan->id) }}"
              class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold transition"
            >
              <span>Edit Penilaian</span>
            </a>
          @endif
        </div>
      @endif
    </div>

    <div class="p-6">
      @if($laporan->tingkat_risiko)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-xs">
          <div class="rounded-xl border border-slate-200 divide-y divide-slate-100">
            <div class="p-3.5 flex justify-between gap-4">
              <span class="text-slate-500 font-semibold">Tingkat Risiko</span>
              <span class="font-bold text-slate-900">{{ $laporan->tingkat_risiko }}</span>
            </div>
            <div class="p-3.5 flex justify-between gap-4">
              <span class="text-slate-500 font-semibold">Prioritas Penanganan</span>
              <span class="font-bold text-slate-900">{{ $laporan->prioritas_penanganan ?? '-' }}</span>
            </div>
            <div class="p-3.5 flex justify-between gap-4">
              <span class="text-slate-500 font-semibold">Estimasi Luas Terdampak</span>
              <span class="font-bold text-slate-900">{{ $laporan->estimasi_luas_terdampak ?: 'Tidak dicantumkan' }}</span>
            </div>
            <div class="p-3.5 flex justify-between gap-4">
              <span class="text-slate-500 font-semibold">Faktor Potensi Bahaya</span>
              <div class="text-right">
                @if($laporan->potensi_bahaya)
                  @foreach(explode(', ', $laporan->potensi_bahaya) as $itemBahaya)
                    <span class="inline-block px-2 py-0.5 rounded bg-slate-100 text-slate-700 text-[11px] font-medium border border-slate-200 mb-1">
                      {{ $itemBahaya }}
                    </span>
                  @endforeach
                @else
                  <span class="text-slate-400 italic">Tidak ada faktor bahaya khusus</span>
                @endif
              </div>
            </div>
          </div>

          <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between space-y-4">
            <div>
              <div class="font-bold text-slate-900 mb-1.5 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <span>Catatan Hasil Analisis Penilaian Risiko:</span>
              </div>
              <p class="text-slate-700 leading-relaxed italic bg-white p-3 rounded-lg border border-slate-200">
                {{ $laporan->catatan_penilaian ?: 'Belum ada catatan penilaian risiko.' }}
              </p>
            </div>

            <div class="pt-2 border-t border-slate-200 flex items-center justify-between text-[11px] text-slate-500">
              <div>Dinilai oleh: <strong class="text-slate-800">{{ $laporan->dinilai_oleh ?? 'Petugas Pusdalops' }}</strong></div>
              <div>{{ $laporan->dinilai_pada ? \Carbon\Carbon::parse($laporan->dinilai_pada)->format('d-m-Y H:i') . ' WIB' : '-' }}</div>
            </div>
          </div>
        </div>
      @else
        <div class="py-8 text-center text-slate-400 space-y-3">
          <p class="text-xs">Laporan ini belum memiliki hasil penilaian risiko.</p>
          @if(auth()->check() && auth()->user()->role === 'pusdalops')
            <a
              href="{{ route('penilaian-risiko.create', $laporan->id) }}"
              class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-[#e03c22] hover:bg-[#c53019] text-white text-xs font-bold transition shadow-2xs"
            >
              <span>Isi Penilaian Risiko</span>
              <span aria-hidden="true">&rarr;</span>
            </a>
          @endif
        </div>
      @endif
    </div>
  </div>

  <!-- Bagian Aksi Verifikasi: Khusus Petugas BPBD Pusdalops -->
  @if($bisaVerifikasi)
    <div class="bg-white rounded-2xl border-l-4 border-l-amber-500 border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-6">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h3 class="text-sm font-bold text-slate-900 flex items-center gap-1.5">
            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>Verifikasi Laporan (Hak Akses Petugas BPBD Pusdalops)</span>
          </h3>
          <p class="text-xs text-slate-500 mt-0.5">
            Tentukan status laporan. Klik <strong>Setujui</strong> untuk verifikasi, atau <strong>Tolak</strong> untuk menolak laporan dengan alasan penolakan.
          </p>
        </div>

        <div class="flex items-center gap-2.5 shrink-0">
          <!-- Tombol Setujui -->
          <form action="{{ route('laporan.setujui', $laporan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI laporan ini?')">
            @csrf
            <button
              type="submit"
              class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-2xs {{ in_array($laporan->status, ['Terverifikasi', 'Disetujui']) ? 'opacity-50 cursor-not-allowed' : '' }}"
              {{ in_array($laporan->status, ['Terverifikasi', 'Disetujui']) ? 'disabled' : '' }}
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
              </svg>
              <span>Setujui</span>
            </button>
          </form>

          <!-- Tombol Tolak -->
          <button
            type="button"
            onclick="openModalTolak()"
            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition shadow-2xs"
          >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>Tolak</span>
          </button>
        </div>
      </div>
    </div>
  @endif

</main>

<!-- ==================== MODAL TOLAK LAPORAN ==================== -->
@if($bisaVerifikasi)
<div id="modalTolak" onclick="closeModalTolak()" class="fixed inset-0 z-50 bg-slate-900/45 backdrop-blur-[1px] hidden items-center justify-center p-4">
  <div onclick="event.stopPropagation()" class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-md overflow-hidden">
    <div class="px-6 py-4 bg-rose-600 text-white flex items-center justify-between gap-3">
      <h3 class="text-sm font-bold flex items-center gap-2">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <span>Konfirmasi Penolakan Laporan</span>
      </h3>
      <button type="button" onclick="closeModalTolak()" class="p-1 rounded-lg text-white/80 hover:text-white hover:bg-rose-700 transition" aria-label="Tutup">&times;</button>
    </div>

    <form action="{{ route('laporan.tolak', $laporan->id) }}" method="POST">
      @csrf
      <div class="p-6 space-y-4">
        <p class="text-xs text-slate-500">
          Laporan dengan kode <strong class="text-slate-900 font-mono">{{ $laporan->kode_laporan }}</strong> akan ditolak. Berikan alasan penolakan secara jelas agar terdokumentasi.
        </p>

        <div>
          <label class="block text-xs font-bold text-slate-800 mb-1">
            Alasan Penolakan <span class="text-rose-600">* (Wajib diisi)</span>
          </label>
          <textarea
            name="alasan_penolakan"
            rows="4"
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-rose-500/20 focus:border-rose-500 outline-none transition"
            placeholder="Contoh: Lokasi tidak sesuai / Titik api sudah padam / Laporan tidak valid..."
            required
          >{{ old('alasan_penolakan') }}</textarea>
        </div>
      </div>

      <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
        <button type="button" onclick="closeModalTolak()" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-white transition">
          Batal
        </button>
        <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition shadow-2xs">
          Simpan Penolakan
        </button>
      </div>
    </form>
  </div>
</div>
@endif

<!-- ==================== MODAL EDIT ALASAN PENOLAKAN ==================== -->
@if($laporan->status === 'Ditolak' && $bisaVerifikasi)
<div id="modalEditAlasan" onclick="closeModalEditAlasan()" class="fixed inset-0 z-50 bg-slate-900/45 backdrop-blur-[1px] hidden items-center justify-center p-4">
  <div onclick="event.stopPropagation()" class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-md overflow-hidden">
    <div class="px-6 py-4 bg-slate-800 text-white flex items-center justify-between gap-3">
      <h3 class="text-sm font-bold flex items-center gap-2">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        <span>Perbarui Alasan Penolakan</span>
      </h3>
      <button type="button" onclick="closeModalEditAlasan()" class="p-1 rounded-lg text-white/80 hover:text-white hover:bg-slate-700 transition" aria-label="Tutup">&times;</button>
    </div>

    <form action="{{ route('laporan.perbaruiAlasan', $laporan->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="p-6 space-y-4">
        <div>
          <label class="block text-xs font-bold text-slate-800 mb-1">
            Alasan Penolakan Baru <span class="text-rose-600">*</span>
          </label>
          <textarea
            name="alasan_penolakan"
            rows="4"
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition"
            required
          >{{ old('alasan_penolakan', $laporan->alasan_penolakan) }}</textarea>
        </div>
      </div>

      <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2.5">
        <button type="button" onclick="closeModalEditAlasan()" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-white transition">
          Batal
        </button>
        <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-2xs">
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
@endif

<script>
  function openModalTolak() {
    const el = document.getElementById('modalTolak');
    if (el) {
      el.classList.remove('hidden');
      el.classList.add('flex');
    }
  }

  function closeModalTolak() {
    const el = document.getElementById('modalTolak');
    if (el) {
      el.classList.add('hidden');
      el.classList.remove('flex');
    }
  }

  function openModalEditAlasan() {
    const el = document.getElementById('modalEditAlasan');
    if (el) {
      el.classList.remove('hidden');
      el.classList.add('flex');
    }
  }

  function closeModalEditAlasan() {
    const el = document.getElementById('modalEditAlasan');
    if (el) {
      el.classList.add('hidden');
      el.classList.remove('flex');
    }
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeModalTolak();
      closeModalEditAlasan();
    }
  });
</script>
@endsection
