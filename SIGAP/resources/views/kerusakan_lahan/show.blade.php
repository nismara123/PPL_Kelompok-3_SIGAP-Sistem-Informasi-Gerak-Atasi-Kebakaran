@extends('layouts.app')

@section('title', 'Detail Kerusakan Lahan - SIGAP')

@section('content')
<main id="view-kerusakan-lahan-detail" class="p-4 sm:p-7 max-w-[1380px] w-full mx-auto space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
        <a href="{{ route('kerusakan-lahan.index') }}" class="hover:text-slate-900 font-medium">Data Kerusakan Lahan</a>
        <span>/</span>
        <span class="text-slate-800 font-semibold">Detail</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Detail Kerusakan Lahan</h1>
      <p class="text-xs sm:text-sm text-slate-500 mt-1.5 flex flex-wrap items-center gap-2">
        @include('kerusakan_lahan._badge', ['item' => $item])
        <span>{{ $item->wilayah->kecamatan ?? '-' }}, {{ $item->wilayah->desa_kelurahan ?? '-' }}</span>
      </p>
    </div>

    <div class="flex items-center gap-2 self-start sm:self-center">
      @if($bisaKelola)
        <a href="{{ route('kerusakan-lahan.edit', $item) }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#e03c22] hover:bg-[#c53019] text-white text-xs font-bold transition">
          <i class="bi bi-pencil"></i> Edit Data
        </a>
      @endif
      <a href="{{ route('kerusakan-lahan.index') }}"
         class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

    <div class="lg:col-span-2 space-y-6">

      <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden">
        <div class="px-5 sm:px-6 py-4 border-b border-slate-100 bg-slate-50/70 flex items-center gap-2 text-sm font-bold text-slate-800">
          <i class="bi bi-info-circle text-[#e03c22]"></i> Informasi Kerusakan
        </div>

        <dl class="px-5 sm:px-6 divide-y divide-dashed divide-slate-200 text-sm">
          <div class="py-3.5 flex flex-col sm:flex-row sm:gap-4">
            <dt class="sm:w-1/3 text-slate-500">Kecamatan</dt>
            <dd class="flex-1 font-semibold text-slate-800">{{ $item->wilayah->kecamatan ?? '-' }}</dd>
          </div>
          <div class="py-3.5 flex flex-col sm:flex-row sm:gap-4">
            <dt class="sm:w-1/3 text-slate-500">Desa/Kelurahan</dt>
            <dd class="flex-1 font-semibold text-slate-800">{{ $item->wilayah->desa_kelurahan ?? '-' }}</dd>
          </div>
          <div class="py-3.5 flex flex-col sm:flex-row sm:gap-4">
            <dt class="sm:w-1/3 text-slate-500">Lokasi Kejadian</dt>
            <dd class="flex-1 font-semibold text-slate-800">{{ $item->lokasi }}</dd>
          </div>
          <div class="py-3.5 flex flex-col sm:flex-row sm:gap-4">
            <dt class="sm:w-1/3 text-slate-500">Jenis Kerusakan</dt>
            <dd class="flex-1">@include('kerusakan_lahan._badge', ['item' => $item])</dd>
          </div>
          <div class="py-3.5 flex flex-col sm:flex-row sm:gap-4">
            <dt class="sm:w-1/3 text-slate-500">Tanggal Pencatatan</dt>
            <dd class="flex-1 font-semibold text-slate-800">{{ $item->tanggal_pencatatan->format('d/m/Y') }}</dd>
          </div>
          <div class="py-3.5 flex flex-col sm:flex-row sm:gap-4">
            <dt class="sm:w-1/3 text-slate-500">Keterangan</dt>
            <dd class="flex-1 text-slate-700">{{ $item->keterangan ?? '-' }}</dd>
          </div>
        </dl>
      </div>

      {{-- Muncul otomatis setelah FSI-10 (Rehabilitasi Lahan) dipasang --}}
      @if(Route::has('rehabilitasi.show'))
        <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden">
          <div class="px-5 sm:px-6 py-4 border-b border-slate-100 bg-slate-50/70 flex items-center gap-2 text-sm font-bold text-slate-800">
            <i class="bi bi-flower1 text-[#e03c22]"></i> Kegiatan Rehabilitasi
          </div>
          <div class="p-5 sm:p-6 space-y-2">
            @forelse($item->rehabilitasi as $r)
              <a href="{{ route('rehabilitasi.show', $r) }}"
                 class="flex items-center justify-between gap-3 p-3.5 rounded-xl border border-slate-200 hover:bg-slate-50 transition">
                <div>
                  <div class="text-sm font-semibold text-slate-800">{{ $r->jenis_kegiatan }}</div>
                  <div class="text-xs text-slate-500">{{ $r->status }}</div>
                </div>
                <div class="flex items-center gap-2">
                  <div class="w-28 h-2 rounded-full bg-slate-100 overflow-hidden">
                    <div class="h-full bg-[#e03c22]" style="width: {{ $r->progres_persen }}%"></div>
                  </div>
                  <span class="text-xs font-semibold text-slate-700 tabular-nums">{{ $r->progres_persen }}%</span>
                </div>
              </a>
            @empty
              <div class="text-sm text-slate-500">Belum ada kegiatan rehabilitasi.</div>
            @endforelse
          </div>
        </div>
      @endif

    </div>

    <div class="lg:col-span-1 space-y-6">

      <div class="sigap-hero-banner rounded-2xl p-6 text-white">
        <div class="text-[11px] font-bold uppercase tracking-wider text-white/70">Luas terdampak</div>
        <div class="mt-1 text-4xl font-extrabold leading-tight tabular-nums">
          @if($item->luas_ha !== null)
            {{ number_format($item->luas_ha, 2, ',', '.') }} <span class="text-lg font-semibold text-white/80">ha</span>
          @else
            -
          @endif
        </div>
      </div>

      <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/70 flex items-center gap-2 text-sm font-bold text-slate-800">
          <i class="bi bi-clock-history text-[#e03c22]"></i> Riwayat Data
        </div>
        <dl class="px-5 divide-y divide-dashed divide-slate-200 text-sm">
          <div class="py-3.5">
            <dt class="text-xs text-slate-500">Dicatat oleh</dt>
            <dd class="font-semibold text-slate-800 mt-0.5">{{ $item->user->name ?? '-' }}</dd>
          </div>
          <div class="py-3.5">
            <dt class="text-xs text-slate-500">Dibuat</dt>
            <dd class="text-slate-700 mt-0.5 tabular-nums">{{ $item->created_at->format('d/m/Y H:i') }}</dd>
          </div>
          <div class="py-3.5">
            <dt class="text-xs text-slate-500">Diperbarui</dt>
            <dd class="text-slate-700 mt-0.5 tabular-nums">{{ $item->updated_at->format('d/m/Y H:i') }}</dd>
          </div>
        </dl>
      </div>

    </div>
  </div>

</main>
@endsection
