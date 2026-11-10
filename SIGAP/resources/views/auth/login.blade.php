
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login SIGAP - Kabupaten Banyumas</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 24px;
            background: #20252b;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        /* CONTAINER UTAMA */
        .login-wrapper {
            width: 100%;
            min-height: calc(100vh - 48px);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        /* CARD LOGIN */
        .login-card {
            width: 100%;
            max-width: 1000px;
            min-height: 580px;
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(0, 0, 0, .25);
        }

        .login-card > .row {
            min-height: 580px;
        }

        /* PANEL KIRI */
        .brand-panel {
            height: 100%;
            min-height: 580px;
            padding: 45px 43px;
            color: #ffffff;

            background: linear-gradient(
                145deg,
                #242a30 0%,
                #382b2b 55%,
                #512b28 100%
            );

            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand-logo {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            border-radius: 12px;
            background: #e65c35;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 25px;
            color: #ffffff;
        }

        .brand-title {
            font-size: 43px;
            font-weight: 800;
            letter-spacing: 4px;
            color: #ffffff;
        }

        .brand-highlight {
            color: #f18b5e;
        }

        .brand-description {
            color: #d1d1d1;
            font-size: 14px;
            line-height: 1.85;
            max-width: 390px;
        }

        .brand-label {
            color: #f3a27d;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .brand-footer {
            font-size: 11px;
            line-height: 1.7;
            color: #b8b8b8;
            border-top: 1px solid rgba(255, 255, 255, .2);
            padding-top: 18px;
        }

        /* PANEL KANAN */
        .form-panel {
            height: 100%;
            min-height: 580px;
            background: #fafaf9;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 45px 48px;
        }

        .form-content {
            width: 100%;
            max-width: 370px;
            margin: 0 auto;
        }

        .form-title {
            color: #272b30;
            font-size: 27px;
            font-weight: 700;
            margin-bottom: 9px;
        }

        .form-subtitle {
            color: #888888;
            font-size: 13px;
            line-height: 1.7;
            margin-bottom: 0;
        }

        .form-label {
            color: #34383d;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 9px;
        }

        .form-control {
            width: 100%;
            height: 47px;
            border-radius: 7px;
            border: 1px solid #dedede;
            font-size: 13px;
            background: #ffffff;
        }

        .form-control:focus {
            border-color: #e65c35;
            box-shadow: 0 0 0 .2rem rgba(230, 92, 53, .12);
        }

        .form-check-input:checked {
            background-color: #d95735;
            border-color: #d95735;
        }

        .btn-sigap {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 7px;
            background: #d95735;
            color: #ffffff;

            font-size: 13px;
            font-weight: 700;
            letter-spacing: .7px;

            transition: background .2s ease;
        }

        .btn-sigap:hover {
            background: #bd4528;
            color: #ffffff;
        }

        .form-footer {
            color: #999999;
            font-size: 11px;
            line-height: 1.8;
        }

        .error-message {
            padding: 11px 13px;
            margin-bottom: 20px;
            border-radius: 7px;
            background: #fff0ed;
            border: 1px solid #ffd1c6;
            color: #b42318;
            font-size: 12px;
        }

        /* TABLET DAN HP */
        @media (max-width: 767.98px) {

            body {
                padding: 16px;
            }

            .login-wrapper {
                min-height: auto;
            }

            .login-card {
                max-width: 480px;
                min-height: auto;
                border-radius: 14px;
            }

            .login-card > .row {
                min-height: auto;
            }

            .brand-panel {
                min-height: 330px;
                padding: 30px;
            }

            .brand-title {
                font-size: 35px;
            }

            .brand-panel .my-5 {
                margin-top: 30px !important;
                margin-bottom: 30px !important;
            }

            .brand-description {
                font-size: 13px;
            }

            .form-panel {
                min-height: auto;
                padding: 38px 30px;
            }

            .form-content {
                max-width: 100%;
            }

            .form-title {
                font-size: 24px;
            }
        }

        /* HP KECIL */
        @media (max-width: 380px) {

            body {
                padding: 10px;
            }

            .brand-panel {
                padding: 25px 22px;
            }

            .form-panel {
                padding: 30px 22px;
            }

            .brand-title {
                font-size: 30px;
            }
        }
    </style>
</head>

<body>

    <main class="login-wrapper">

        <div class="card login-card">

            <div class="row g-0">

                <!-- PANEL IDENTITAS SIGAP -->
                <div class="col-md-6">

                    <section class="brand-panel">

                        <div>
                            <div class="d-flex align-items-center gap-3">

                                <div class="brand-logo">
                                    <i class="bi bi-fire"></i>
                                </div>

                                <h3 class="brand-title mb-0">
                                    SIGAP
                                </h3>

                            </div>
                        </div>

                        <div class="my-5">

                            <div class="brand-label mb-3">
                                KABUPATEN BANYUMAS
                            </div>

                            <h1 class="fw-bold mb-4">
                                Gerak Cepat.<br>
                                <span class="brand-highlight">
                                    Tanggap Tepat.
                                </span>
                            </h1>

                            <p class="brand-description">
                                Sistem Informasi Gerak Atasi Kebakaran
                                untuk mendukung pelaporan, pemantauan,
                                dan koordinasi penanganan kebakaran
                                hutan dan lahan secara terintegrasi.
                            </p>

                            <div class="mt-4">
                                <span class="badge rounded-pill bg-dark border border-secondary px-3 py-2">
                                    <i class="bi bi-shield-check me-2"></i>
                                    Sistem Informasi Karhutla
                                </span>
                            </div>

                        </div>

                        <div class="brand-footer">
                            BADAN PENANGGULANGAN BENCANA DAERAH
                            <br>
                            KABUPATEN BANYUMAS
                        </div>

                    </section>

                </div>

                <!-- PANEL FORM LOGIN -->
                <div class="col-md-6">

                    <section class="form-panel">

                        <div class="form-content">

                            <div class="mb-5">

                                <div class="brand-label mb-2">
                                    PORTAL PETUGAS
                                </div>

                                <h2 class="form-title">
                                    Selamat Datang
                                </h2>

                                <p class="form-subtitle">
                                    Silakan masuk untuk mengakses sistem SIGAP.
                                </p>

                            </div>

                            <!-- PESAN ERROR -->
                            @if ($errors->any())

                                <div class="error-message">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>

                            @endif

                            <!-- FORM LOGIN -->
                            <form method="POST" action="{{ route('login') }}">

                                @csrf

                                <!-- EMAIL -->
                                <div class="mb-4">

                                    <label for="email" class="form-label">
                                        Alamat Email
                                    </label>

                                    <input
                                        type="email"
                                        class="form-control"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="Masukkan email petugas"
                                        required
                                        autofocus
                                        autocomplete="username"
                                    >

                                </div>

                                <!-- PASSWORD -->
                                <div class="mb-3">

                                    <label for="password" class="form-label">
                                        Kata Sandi
                                    </label>

                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password"
                                        name="password"
                                        placeholder="Masukkan kata sandi"
                                        required
                                        autocomplete="current-password"
                                    >

                                </div>

                                <!-- INGAT SAYA -->
                                <div class="form-check mb-4">

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="remember"
                                        id="remember"
                                    >

                                    <label
                                        class="form-check-label small text-secondary"
                                        for="remember"
                                    >
                                        Ingat saya
                                    </label>

                                </div>

                                <!-- TOMBOL LOGIN -->
                                <button
                                    type="submit"
                                    class="btn btn-sigap"
                                >
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    MASUK KE SIGAP
                                </button>

                            </form>

                            <!-- FOOTER -->
                            <div class="text-center mt-5 pt-3 border-top">

                                <p class="form-footer mb-0">
                                    Akses khusus petugas yang berwenang.
                                    <br>
                                    SIGAP &copy; {{ date('Y') }} Kabupaten Banyumas.
                                </p>

                            </div>

                        </div>

                    </section>

                </div>

            </div>

        </div>

    </main>

</body>
</html>
