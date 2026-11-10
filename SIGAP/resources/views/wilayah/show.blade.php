
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Wilayah Karhutla - SIGAP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

    <div class="mb-4">
        <h2 class="fw-bold">Detail Wilayah Karhutla</h2>
        <p class="text-muted">Informasi lengkap wilayah yang terdaftar di SIGAP.</p>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <h5 class="mb-3">Identitas Wilayah</h5>

            <table class="table table-bordered">
                <tr>
                    <th width="30%">Kode Wilayah</th>
                    <td>{{ $wilayah->kode_wilayah }}</td>
                </tr>
                <tr>
                    <th>Kode Kabupaten</th>
                    <td>{{ $wilayah->kode_kabupaten }}</td>
                </tr>
                <tr>
                    <th>Kabupaten</th>
                    <td>{{ $wilayah->kabupaten }}</td>
                </tr>
                <tr>
                    <th>Kode Kecamatan</th>
                    <td>{{ $wilayah->kode_kecamatan }}</td>
                </tr>
                <tr>
                    <th>Kecamatan</th>
                    <td>{{ $wilayah->kecamatan }}</td>
                </tr>
                <tr>
                    <th>Kode Desa</th>
                    <td>{{ $wilayah->kode_desa }}</td>
                </tr>
                <tr>
                    <th>Desa/Kelurahan</th>
                    <td>{{ $wilayah->desa_kelurahan }}</td>
                </tr>
            </table>

            <h5 class="mt-4 mb-3">Koordinat Lokasi</h5>

            <table class="table table-bordered">
                <tr>
                    <th width="30%">Latitude</th>
                    <td>{{ $wilayah->latitude ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Longitude</th>
                    <td>{{ $wilayah->longitude ?? '-' }}</td>
                </tr>
            </table>

            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('wilayah.edit', $wilayah->id) }}"
                   class="btn btn-warning">
                    Edit Data
                </a>

                <a href="{{ route('wilayah.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </div>
    </div>

</div>

</body>
</html>
