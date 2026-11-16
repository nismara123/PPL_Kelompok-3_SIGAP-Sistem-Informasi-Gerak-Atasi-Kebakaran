@csrf

@if($wilayahList->isEmpty())
    <div class="alert alert-warning d-flex align-items-center gap-2">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>
            Belum ada data wilayah. Tambahkan dulu di menu
            <a href="{{ route('wilayah.index') }}">Data Wilayah Karhutla</a>.
        </div>
    </div>
@endif

<div class="form-section"><i class="bi bi-geo-alt"></i> Lokasi Kejadian</div>

<div class="mb-3">
    <label class="form-label">Wilayah</label>
    <select name="wilayah_id" class="form-select @error('wilayah_id') is-invalid @enderror">
        <option value="">-- Pilih wilayah --</option>
        @foreach($wilayahList as $w)
            <option value="{{ $w->id }}"
                @selected(old('wilayah_id', $item->wilayah_id ?? '') == $w->id)>
                {{ $w->kecamatan }} - {{ $w->desa_kelurahan }}
            </option>
        @endforeach
    </select>
    @error('wilayah_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label class="form-label">Lokasi</label>
    <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror"
           value="{{ old('lokasi', $item->lokasi ?? '') }}"
           placeholder="Contoh: Dusun Karangsalam, RT 02/RW 01">
    @error('lokasi')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-section"><i class="bi bi-fire"></i> Kondisi Kerusakan</div>

<div class="mb-3">
    <label class="form-label">Jenis Kerusakan</label>
    <select name="jenis_kerusakan" class="form-select @error('jenis_kerusakan') is-invalid @enderror">
        <option value="">-- Pilih jenis --</option>
        @foreach($jenisList as $j)
            <option value="{{ $j }}"
                @selected(old('jenis_kerusakan', $item->jenis_kerusakan ?? '') == $j)>
                {{ $j }}
            </option>
        @endforeach
    </select>
    @error('jenis_kerusakan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Luas Terdampak (ha)</label>
        <div class="input-group has-validation">
            <input type="number" step="0.01" name="luas_ha"
                   class="form-control @error('luas_ha') is-invalid @enderror"
                   value="{{ old('luas_ha', $item->luas_ha ?? '') }}" placeholder="0,00">
            <span class="input-group-text" style="border-radius: 0 10px 10px 0;">ha</span>
            @error('luas_ha')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Tanggal Pencatatan</label>
        <input type="date" name="tanggal_pencatatan"
               class="form-control @error('tanggal_pencatatan') is-invalid @enderror"
               value="{{ old('tanggal_pencatatan', isset($item) ? $item->tanggal_pencatatan->format('Y-m-d') : now()->format('Y-m-d')) }}">
        @error('tanggal_pencatatan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-section mt-2"><i class="bi bi-journal-text"></i> Catatan</div>

<div class="mb-4">
    <label class="form-label">Keterangan <span class="text-muted fw-normal">(opsional)</span></label>
    <textarea name="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror"
              placeholder="Kondisi lahan, penyebab, atau informasi tambahan">{{ old('keterangan', $item->keterangan ?? '') }}</textarea>
    @error('keterangan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
