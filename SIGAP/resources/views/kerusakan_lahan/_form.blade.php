@csrf

@php
    // Kelas input bersama; border berubah merah bila field punya error validasi.
    $inputBase = 'w-full rounded-xl border bg-white px-3.5 py-2.5 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#e03c22]/25 focus:border-[#e03c22]';
@endphp

@if($wilayahList->isEmpty())
  <div class="mb-5 p-4 rounded-xl bg-amber-50 border border-amber-200 text-xs font-semibold text-amber-800 flex items-start gap-2">
    <i class="bi bi-exclamation-triangle-fill mt-0.5"></i>
    <div>
      Belum ada data wilayah. Tambahkan dulu di menu
      <a href="{{ route('wilayah.index') }}" class="underline">Data Wilayah Karhutla</a>.
    </div>
  </div>
@endif

<div class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-wider text-[#e03c22] mb-4">
  <i class="bi bi-geo-alt"></i> Lokasi Kejadian
  <span class="flex-1 h-px bg-slate-200"></span>
</div>

<div class="mb-4">
  <label for="wilayah_id" class="block text-xs font-bold text-slate-700 mb-1.5">Wilayah <span class="text-red-500">*</span></label>
  <select id="wilayah_id" name="wilayah_id" class="{{ $inputBase }} @error('wilayah_id') border-red-400 @else border-slate-300 @enderror">
    <option value="">-- Pilih wilayah --</option>
    @foreach($wilayahList as $w)
      <option value="{{ $w->id }}" @selected(old('wilayah_id', $item->wilayah_id ?? '') == $w->id)>
        {{ $w->kecamatan }} - {{ $w->desa_kelurahan }}
      </option>
    @endforeach
  </select>
  @error('wilayah_id')
    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
  @enderror
</div>

<div class="mb-6">
  <label for="lokasi" class="block text-xs font-bold text-slate-700 mb-1.5">Lokasi <span class="text-red-500">*</span></label>
  <input type="text" id="lokasi" name="lokasi"
         class="{{ $inputBase }} @error('lokasi') border-red-400 @else border-slate-300 @enderror"
         value="{{ old('lokasi', $item->lokasi ?? '') }}"
         placeholder="Contoh: Dusun Karangsalam, RT 02/RW 01">
  @error('lokasi')
    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
  @enderror
</div>

<div class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-wider text-[#e03c22] mb-4">
  <i class="bi bi-fire"></i> Kondisi Kerusakan
  <span class="flex-1 h-px bg-slate-200"></span>
</div>

<div class="mb-4">
  <label for="jenis_kerusakan" class="block text-xs font-bold text-slate-700 mb-1.5">Jenis Kerusakan <span class="text-red-500">*</span></label>
  <select id="jenis_kerusakan" name="jenis_kerusakan" class="{{ $inputBase }} @error('jenis_kerusakan') border-red-400 @else border-slate-300 @enderror">
    <option value="">-- Pilih jenis --</option>
    @foreach($jenisList as $j)
      <option value="{{ $j }}" @selected(old('jenis_kerusakan', $item->jenis_kerusakan ?? '') == $j)>{{ $j }}</option>
    @endforeach
  </select>
  @error('jenis_kerusakan')
    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
  @enderror
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
  <div>
    <label for="luas_ha" class="block text-xs font-bold text-slate-700 mb-1.5">Luas Terdampak (ha)</label>
    <div class="flex">
      <input type="number" step="0.01" id="luas_ha" name="luas_ha"
             class="{{ $inputBase }} rounded-r-none @error('luas_ha') border-red-400 @else border-slate-300 @enderror"
             value="{{ old('luas_ha', $item->luas_ha ?? '') }}" placeholder="0.00">
      <span class="inline-flex items-center px-3.5 rounded-r-xl border border-l-0 border-slate-300 bg-slate-50 text-xs font-semibold text-slate-500">ha</span>
    </div>
    @error('luas_ha')
      <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label for="tanggal_pencatatan" class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Pencatatan <span class="text-red-500">*</span></label>
    <input type="date" id="tanggal_pencatatan" name="tanggal_pencatatan"
           class="{{ $inputBase }} @error('tanggal_pencatatan') border-red-400 @else border-slate-300 @enderror"
           value="{{ old('tanggal_pencatatan', isset($item) ? $item->tanggal_pencatatan->format('Y-m-d') : now()->format('Y-m-d')) }}">
    @error('tanggal_pencatatan')
      <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
    @enderror
  </div>
</div>

<div class="flex items-center gap-2 text-[11px] font-bold uppercase tracking-wider text-[#e03c22] mb-4">
  <i class="bi bi-journal-text"></i> Catatan
  <span class="flex-1 h-px bg-slate-200"></span>
</div>

<div class="mb-6">
  <label for="keterangan" class="block text-xs font-bold text-slate-700 mb-1.5">
    Keterangan <span class="font-normal text-slate-400">(opsional)</span>
  </label>
  <textarea id="keterangan" name="keterangan" rows="3"
            class="{{ $inputBase }} @error('keterangan') border-red-400 @else border-slate-300 @enderror"
            placeholder="Kondisi lahan, penyebab, atau informasi tambahan">{{ old('keterangan', $item->keterangan ?? '') }}</textarea>
  @error('keterangan')
    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
  @enderror
</div>
