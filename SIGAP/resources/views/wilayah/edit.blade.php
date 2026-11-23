
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Wilayah Karhutla - SIGAP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

    <h2 class="fw-bold">Edit Data Wilayah Karhutla</h2>
    <p class="text-muted">Perbarui informasi wilayah yang sudah terdaftar.</p>

    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body p-4">

            <form action="{{ route('wilayah.update', $wilayah->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Kode Wilayah</label>
                    <input type="text" class="form-control"
                        value="{{ $wilayah->kode_wilayah }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kode Kabupaten</label>
                    <input type="text" name="kode_kabupaten" class="form-control"
                        value="{{ old('kode_kabupaten', $wilayah->kode_kabupaten) }}" required>
                    @error('kode_kabupaten')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kabupaten</label>
                    <input type="text" name="kabupaten" class="form-control"
                        value="{{ old('kabupaten', $wilayah->kabupaten) }}" required>
                    @error('kabupaten')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kode Kecamatan</label>
                    <input type="text" name="kode_kecamatan" class="form-control"
                        value="{{ old('kode_kecamatan', $wilayah->kode_kecamatan) }}" required>
                    @error('kode_kecamatan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kecamatan</label>
                    <input type="text" name="kecamatan" class="form-control"
                        value="{{ old('kecamatan', $wilayah->kecamatan) }}" required>
                    @error('kecamatan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kode Desa</label>
                    <input type="text" name="kode_desa" class="form-control"
                        value="{{ old('kode_desa', $wilayah->kode_desa) }}" required>
                    @error('kode_desa')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Desa/Kelurahan</label>
                    <input type="text" name="desa_kelurahan" class="form-control"
                        value="{{ old('desa_kelurahan', $wilayah->desa_kelurahan) }}" required>
                    @error('desa_kelurahan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                <h5>Koordinat Lokasi</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Latitude</label>
                        <input type="number" step="any" name="latitude" class="form-control"
                            value="{{ old('latitude', $wilayah->latitude) }}">
                        @error('latitude')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Longitude</label>
                        <input type="number" step="any" name="longitude" class="form-control"
                            value="{{ old('longitude', $wilayah->longitude) }}">
                        @error('longitude')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

                <a href="{{ route('wilayah.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>

</body>
</html>
