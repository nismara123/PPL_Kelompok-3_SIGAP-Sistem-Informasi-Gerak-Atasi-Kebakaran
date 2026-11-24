@extends('layouts.app')

@section('title', 'Detail Wilayah Karhutla - SIGAP')

@section('content')
<main class="p-4 sm:p-7 max-w-[900px] w-full mx-auto space-y-6">

  <!-- Breadcrumb & Header -->
  <div class="space-y-1">
    <div class="flex items-center gap-2 text-xs text-slate-400">
      <a href="{{ route('wilayah.index') }}" class="hover:text-slate-700 transition">Data Wilayah</a>
      <span>/</span>
      <span class="text-slate-700 font-semibold">Detail Wilayah</span>
    </div>
    <div class="flex items-center justify-between gap-4">
      <div>
        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
          Detail Wilayah: {{ $wilayah->kecamatan }}
        </h1>
        <p class="text-xs sm:text-sm text-slate-500">
          Informasi administratif dan koordinat wilayah pantauan karhutla.
        </p>
      </div>
      <span class="px-3 py-1 rounded-lg bg-blue-50 text-blue-700 font-mono text-xs font-bold border border-blue-200">
        {{ $wilayah->kode_wilayah }}
      </span>
    </div>
  </div>

  <!-- Detail Card -->
  <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-6 sm:p-8 space-y-6">

    <!-- Identitas Wilayah -->
    <div>
      <h2 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 mb-4">
        Identitas Administratif Wilayah
      </h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
          <div class="text-[10px] font-bold text-slate-400 uppercase">Kode Kabupaten</div>
          <div class="font-semibold text-slate-900 mt-1 font-mono">{{ $wilayah->kode_kabupaten }}</div>
        </div>

        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
          <div class="text-[10px] font-bold text-slate-400 uppercase">Kabupaten</div>
          <div class="font-semibold text-slate-900 mt-1">{{ $wilayah->kabupaten }}</div>
        </div>

        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
          <div class="text-[10px] font-bold text-slate-400 uppercase">Kode Kecamatan</div>
          <div class="font-semibold text-slate-900 mt-1 font-mono">{{ $wilayah->kode_kecamatan }}</div>
        </div>

        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
          <div class="text-[10px] font-bold text-slate-400 uppercase">Kecamatan</div>
          <div class="font-bold text-slate-900 mt-1 text-sm">{{ $wilayah->kecamatan }}</div>
        </div>

        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
          <div class="text-[10px] font-bold text-slate-400 uppercase">Kode Desa</div>
          <div class="font-semibold text-slate-900 mt-1 font-mono">{{ $wilayah->kode_desa }}</div>
        </div>

        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60">
          <div class="text-[10px] font-bold text-slate-400 uppercase">Desa / Kelurahan</div>
          <div class="font-semibold text-slate-900 mt-1">{{ $wilayah->desa_kelurahan ?? '-' }}</div>
        </div>
      </div>
    </div>

    <!-- Koordinat Lokasi -->
    <div>
      <h2 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3 mb-4">
        Koordinat Geografis
      </h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 flex items-center justify-between">
          <div>
            <div class="text-[10px] font-bold text-slate-400 uppercase">Latitude</div>
            <div class="font-mono font-bold text-slate-900 mt-1">{{ $wilayah->latitude ?? '-' }}</div>
          </div>
        </div>

        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 flex items-center justify-between">
          <div>
            <div class="text-[10px] font-bold text-slate-400 uppercase">Longitude</div>
            <div class="font-mono font-bold text-slate-900 mt-1">{{ $wilayah->longitude ?? '-' }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
      <form action="{{ route('wilayah.destroy', $wilayah->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data wilayah {{ $wilayah->kecamatan }} ini?');">
        @csrf
        @method('DELETE')
        <button
          type="submit"
          class="px-4 py-2.5 rounded-xl border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-bold transition"
        >
          Hapus Wilayah
        </button>
      </form>

      <div class="flex items-center gap-2.5">
        <a
          href="{{ route('wilayah.index') }}"
          class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition text-decoration-none"
        >
          Kembali ke Daftar Wilayah
        </a>
        <a
          href="{{ route('wilayah.edit', $wilayah->id) }}"
          class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-xs font-bold text-white shadow-2xs transition text-decoration-none"
        >
          Edit Data Wilayah
        </a>
      </div>
    </div>

  </div>

</main>
@endsection
