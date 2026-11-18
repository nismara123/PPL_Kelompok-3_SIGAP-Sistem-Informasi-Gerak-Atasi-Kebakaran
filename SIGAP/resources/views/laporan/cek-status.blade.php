<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cek Status Laporan - SIGAP</title>

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
            max-width: 550px;
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
            margin-bottom: 15px;
        }

        p {
            text-align: center;
            color: #666;
            line-height: 1.5;
        }

        label {
            display: block;
            margin-top: 25px;
            font-weight: bold;
            color: #333;
        }

        input {
            width: 100%;
            padding: 13px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 7px;
            font-size: 14px;
            transition: 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #f4512c;
            box-shadow: 0 0 0 2px rgba(244,81,44,0.12);
        }

        button {
            width: 100%;
            padding: 13px;
            margin-top: 20px;
            background: #f4512c;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: 0.2s;
        }

        button:hover {
            background: #d93620;
        }

        .success {
            background: #fff0e9;
            color: #a8321c;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
            border: 1px solid #ffded2;
        }

        .kode {
            font-size: 20px;
            font-weight: bold;
            color: #f4512c;
            margin: 12px 0;
            word-break: break-word;
        }

        .copy-button {
            width: auto;
            padding: 9px 18px;
            margin-top: 5px;
            background: #d93620;
        }

        .copy-button:hover {
            background: #b92d1b;
        }

        .error {
            background: #fff0ee;
            color: #b42318;
            padding: 12px;
            border-radius: 7px;
            margin: 15px 0;
            border: 1px solid #f5c6c2;
        }

        .error p {
            color: #b42318;
            margin: 5px 0;
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #d93620;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .back:hover {
            text-decoration: underline;
            color: #b92d1b;
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

    <h2>Cek Status Laporan Karhutla</h2>

    <p>
        Masukkan kode laporan untuk mengetahui
        perkembangan laporan kebakaran hutan dan lahan.
    </p>

    {{-- Notifikasi laporan berhasil dikirim --}}
    @if (session('success'))
        <div class="success">

            <strong>{{ session('success') }}</strong>

            @if (session('kode_laporan'))
                <p style="margin-bottom: 5px;">
                    Kode laporan kamu:
                </p>

                <div class="kode" id="kodeLaporan">
                    {{ session('kode_laporan') }}
                </div>

                <button
                    type="button"
                    class="copy-button"
                    onclick="salinKode()">
                    Salin Kode Laporan
                </button>

                <p style="font-size: 12px;">
                    Simpan kode ini untuk mengecek status laporan.
                </p>
            @endif

        </div>
    @endif

    {{-- Notifikasi jika kode tidak ditemukan --}}
    @if (session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    {{-- Pesan validasi --}}
    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Form cek status --}}
    <form action="{{ route('laporan.hasilStatus') }}" method="POST">
        @csrf

        <label for="kode_laporan">
            Kode Laporan
        </label>

        <input
            type="text"
            id="kode_laporan"
            name="kode_laporan"
            placeholder="Contoh: KARHUTLA-A8F3K2QZ"
            value="{{ old('kode_laporan') }}"
            required
        >

        <button type="submit">
            Cek Status Laporan
        </button>

    </form>

    <a href="{{ route('laporan.create') }}" class="back">
        ← Kembali ke Form Pelaporan
    </a>

</div>

<script>
    function salinKode() {
        const kode = document.getElementById('kodeLaporan').innerText;

        navigator.clipboard.writeText(kode)
            .then(() => {
                alert('Kode laporan berhasil disalin!');
            })
            .catch(() => {
                alert('Gagal menyalin kode. Silakan salin secara manual.');
            });
    }
</script>

</body>
</html>
