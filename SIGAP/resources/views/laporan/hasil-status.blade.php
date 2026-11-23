<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hasil Status Laporan - SIGAP</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fff3ee;
            margin: 0;
            padding: 40px 15px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            border-top: 5px solid #f4512c;
        }

        h2 {
            color: #d93620;
            text-align: center;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .status-box {
            background: #fff0e9;
            padding: 18px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 25px;
            border: 1px solid #ffded2;
        }

        .status-box p {
            color: #555;
            margin-top: 0;
            margin-bottom: 10px;
        }

        .status {
            font-size: 20px;
            font-weight: bold;
            color: #f4512c;
        }

        .detail {
            border-bottom: 1px solid #eee;
            padding: 14px 0;
        }

        .detail strong {
            display: block;
            color: #444;
            margin-bottom: 7px;
        }

        .detail span {
            color: #666;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .foto {
            width: 100%;
            max-height: 300px;
            object-fit: contain;
            border-radius: 8px;
            margin-top: 10px;
            background: #fafafa;
            border: 1px solid #eee;
        }

        .button {
            display: block;
            width: 100%;
            padding: 13px;
            margin-top: 15px;
            background: #f4512c;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 7px;
            font-weight: bold;
            font-size: 14px;
            transition: 0.2s;
        }

        .button:hover {
            background: #d93620;
        }

        .secondary {
            background: #fff0e9;
            color: #d93620;
            border: 1px solid #ffded2;
        }

        .secondary:hover {
            background: #ffe1d6;
        }

        .note {
            font-size: 12px;
            color: #888;
            text-align: center;
            margin-top: 25px;
            line-height: 1.5;
        }

        @media (max-width: 480px) {
            body {
                padding: 25px 12px;
            }

            .container {
                padding: 22px;
            }

            h2 {
                font-size: 21px;
            }

            .status {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Hasil Status Laporan</h2>

    <p class="subtitle">
        Informasi perkembangan laporan kebakaran hutan dan lahan.
    </p>

    {{-- Status laporan --}}
    <div class="status-box">
        <p>Status Laporan Saat Ini</p>

        <div class="status">
            {{ $laporan->status }}
        </div>
    </div>

    {{-- Kode laporan --}}
    <div class="detail">
        <strong>Kode Laporan</strong>
        <span>{{ $laporan->kode_laporan }}</span>
    </div>

    {{-- Lokasi kejadian --}}
    <div class="detail">
        <strong>Lokasi Kejadian</strong>
        <span>{{ $laporan->lokasi }}</span>
    </div>

    {{-- Waktu kejadian --}}
    <div class="detail">
        <strong>Waktu Kejadian</strong>
        <span>
            {{ \Carbon\Carbon::parse($laporan->waktu_kejadian)->format('d-m-Y H:i') }}
        </span>
        <span> WIB</span>
    </div>

    {{-- Deskripsi kejadian --}}
    <div class="detail">
        <strong>Deskripsi Kejadian</strong>
        <span>{{ $laporan->deskripsi }}</span>
    </div>

    {{-- Foto dokumentasi --}}
    <div class="detail">
        <strong>Foto Dokumentasi</strong>

        @if ($laporan->foto)
            <img
                src="{{ asset('storage/' . $laporan->foto) }}"
                alt="Foto kejadian karhutla"
                class="foto"
            >
        @else
            <span>Tidak ada foto dokumentasi.</span>
        @endif
    </div>

    {{-- Tombol navigasi --}}
    <a href="{{ route('laporan.cekStatus') }}" class="button">
        Cek Laporan Lain
    </a>

    <a href="{{ route('laporan.create') }}" class="button secondary">
        Buat Laporan Baru
    </a>

    <p class="note">
        SIGAP - Sistem Informasi Gerak Atasi Kebakaran
    </p>

</div>

</body>
</html>
