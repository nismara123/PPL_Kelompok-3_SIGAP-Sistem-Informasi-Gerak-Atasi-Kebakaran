@extends('layouts.app')

@section('title', 'Tambah Wilayah Karhutla - SIGAP')

@section('content')
<main class="p-4 sm:p-7 max-w-[900px] w-full mx-auto space-y-6">

  <!-- Breadcrumb & Header -->
  <div class="space-y-1">
    <div class="flex items-center gap-2 text-xs text-slate-400">
      <a href="{{ route('wilayah.index') }}" class="hover:text-slate-700 transition">Data Wilayah</a>
      <span>/</span>
      <span class="text-slate-700 font-semibold">Tambah Wilayah</span>
    </div>
    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
      Tambah Wilayah Pantauan Karhutla
    </h1>
    <p class="text-xs sm:text-sm text-slate-500">
      Masukkan data wilayah administratif yang rawan kebakaran hutan dan lahan.
    </p>
  </div>

  @if($errors->any())
    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 space-y-1">
      <div class="font-bold">Mohon perbaiki kesalahan berikut:</div>
      <ul class="list-disc list-inside">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Form Card -->
  <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-6 sm:p-8">
    <form action="{{ route('wilayah.store') }}" method="POST" class="space-y-6">
      @csrf

      <!-- Bagian 1: Identitas Wilayah -->
      <div class="space-y-4">
        <h2 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2">
          Identitas Wilayah Administratif
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Kode Kabupaten <span class="text-rose-500">*</span></label>
            <input
              type="text"
              name="kode_kabupaten"
              value="{{ old('kode_kabupaten', '3302') }}"
              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#e03c22]/20 focus:border-[#e03c22] outline-none transition"
              placeholder="Contoh: 3302"
              required
            >
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Kabupaten <span class="text-rose-500">*</span></label>
            <input
              type="text"
              name="kabupaten"
              value="{{ old('kabupaten', 'Banyumas') }}"
              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#e03c22]/20 focus:border-[#e03c22] outline-none transition"
              placeholder="Kabupaten Banyumas"
              required
            >
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Kode Kecamatan <span class="text-rose-500">*</span></label>
            <input
              type="text"
              name="kode_kecamatan"
              value="{{ old('kode_kecamatan') }}"
              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#e03c22]/20 focus:border-[#e03c22] outline-none transition"
              placeholder="Contoh: 330219"
              required
            >
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Kecamatan <span class="text-rose-500">*</span></label>
            <input
              type="text"
              name="kecamatan"
              value="{{ old('kecamatan') }}"
              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#e03c22]/20 focus:border-[#e03c22] outline-none transition"
              placeholder="Contoh: Kec. Baturraden"
              required
            >
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Kode Desa <span class="text-rose-500">*</span></label>
            <input
              type="text"
              name="kode_desa"
              value="{{ old('kode_desa') }}"
              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#e03c22]/20 focus:border-[#e03c22] outline-none transition"
              placeholder="Contoh: 3302192004"
              required
            >
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Desa / Kelurahan <span class="text-rose-500">*</span></label>
            <input
              type="text"
              name="desa_kelurahan"
              value="{{ old('desa_kelurahan') }}"
              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#e03c22]/20 focus:border-[#e03c22] outline-none transition"
              placeholder="Contoh: Desa Limpakuwus"
              required
            >
          </div>
        </div>
      </div>

      <!-- Bagian 2: Koordinat Lokasi -->
      <div class="space-y-4">
        <h2 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-2">
          Koordinat Lokasi Geografis
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Latitude</label>
            <input
              type="number"
              step="any"
              name="latitude"
              value="{{ old('latitude') }}"
              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#e03c22]/20 focus:border-[#e03c22] outline-none transition"
              placeholder="Contoh: -7.311400"
            >
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Longitude</label>
            <input
              type="number"
              step="any"
              name="longitude"
              value="{{ old('longitude') }}"
              class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-[#e03c22]/20 focus:border-[#e03c22] outline-none transition"
              placeholder="Contoh: 109.242100"
            >
          </div>
        </div>
      </div>

      <!-- Tombol Aksi -->
      <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
        <a
          href="{{ route('wilayah.index') }}"
          class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition"
        >
          Batal
        </a>
        <button
          type="submit"
          class="px-5 py-2.5 rounded-xl bg-[#e03c22] hover:bg-[#c53019] text-xs font-bold text-white shadow-2xs transition"
        >
          Simpan Data Wilayah
        </button>
      </div>

    </form>
  </div>

</main>
@endsection
