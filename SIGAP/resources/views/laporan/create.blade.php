<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Form Laporan Karhutla - SIGAP</title>

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
            max-width: 650px;
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
            margin-bottom: 12px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 20px;
            color: #333;
            font-size: 14px;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 7px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            transition: 0.2s;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #f4512c;
            box-shadow: 0 0 0 2px rgba(244,81,44,0.12);
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        input[type="file"] {
            background: #fffaf8;
            cursor: pointer;
        }

        input[type="file"]::file-selector-button {
            background: #fff0e9;
            color: #d93620;
            border: 1px solid #ffded2;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        input[type="file"]::file-selector-button:hover {
            background: #ffe1d6;
        }

        button {
            width: 100%;
            padding: 14px;
            margin-top: 28px;
            background: #f4512c;
            color: white;
            border: none;
            border-radius: 7px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background: #d93620;
        }

        .error {
            color: #b42318;
            background: #fff0ee;
            padding: 12px 15px;
            border-radius: 7px;
            margin-bottom: 18px;
            border: 1px solid #f5c6c2;
        }

        .error p {
            margin: 5px 0;
            font-size: 14px;
        }

        .info {
            background: #fff0e9;
            color: #a8321c;
            padding: 13px;
            border-radius: 7px;
            border: 1px solid #ffded2;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .footer {
            text-align: center;
            color: #999;
            font-size: 12px;
            margin-top: 25px;
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
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Form Pelaporan Karhutla</h2>

    <p class="subtitle">
        Silakan isi informasi kejadian kebakaran hutan dan lahan.
    </p>

    <div class="info">
        Pelaporan dapat dilakukan tanpa membuat akun.
    </div>

    {{-- Menampilkan pesan kesalahan validasi --}}
    @if ($errors->any())
        <div class="error">
            <strong>Periksa kembali data laporan kamu:</strong>

            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Form pengiriman laporan --}}
    <form action="{{ route('laporan.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <label for="lokasi">Lokasi Kejadian</label>

        <input
            type="text"
            id="lokasi"
            name="lokasi"
            placeholder="Masukkan lokasi kejadian"
            value="{{ old('lokasi') }}"
            required
        >

        <label for="waktu_kejadian">Waktu Kejadian</label>

        <input
            type="datetime-local"
            id="waktu_kejadian"
            name="waktu_kejadian"
            value="{{ old('waktu_kejadian') }}"
            required
        >

        <label for="deskripsi">Deskripsi Kejadian</label>

        <textarea
            id="deskripsi"
            name="deskripsi"
            placeholder="Jelaskan kondisi kebakaran..."
            required
        >{{ old('deskripsi') }}</textarea>

        <label for="foto">Foto Kejadian</label>

        <input
            type="file"
            id="foto"
            name="foto"
            accept=".jpg,.jpeg,.png"
        >

        <button type="submit">
            Kirim Laporan
        </button>

    </form>

    <div class="footer">
        SIGAP - Sistem Informasi Gerak Atasi Kebakaran
    </div>

</div>

</body>
</html>
