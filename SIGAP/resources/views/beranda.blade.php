
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGAP Banyumas | Beranda</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0faf3;
            color: #183c2b;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .topbar {
            background: #14532d;
            color: white;
            text-align: center;
            padding: 8px;
            font-size: 12px;
        }

        header {
            background: #f7fff8;
            border-bottom: 1px solid #dcece0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar {
            max-width: 1200px;
            margin: auto;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand {
            font-size: 20px;
            font-weight: 800;
            color: #14532d;
        }

        .brand small {
            display: block;
            font-size: 9px;
            font-weight: 500;
            letter-spacing: .5px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 25px;
            font-size: 13px;
            font-weight: 600;
        }

        .nav-menu a:hover {
            color: #15803d;
        }

        .btn {
            display: inline-block;
            padding: 12px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            border: none;
            cursor: pointer;
        }

        .btn-orange {
            background: #f47721;
            color: white;
        }

        .btn-green {
            background: #14532d;
            color: white;
        }

        .btn-light {
            background: #e1f2e6;
            color: #14532d;
        }

        .container {
            max-width: 1150px;
            margin: auto;
            padding: 35px 25px;
        }

        .hero {
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            align-items: center;
            gap: 40px;
        }

        .eyebrow {
            color: #267448;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .hero h1 {
            font-size: 38px;
            line-height: 1.25;
            margin-bottom: 18px;
            color: #153d29;
        }

        .hero p {
            color: #617568;
            line-height: 1.8;
            font-size: 14px;
            margin-bottom: 22px;
        }

        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .hero-image {
            min-height: 380px;
            border-radius: 15px;
            background:
                linear-gradient(rgba(20, 40, 25, 0.10), rgba(20, 40, 25, 0.10)),
                url('/images/karhutla-hero.png') center/cover no-repeat;
            box-shadow: 0 8px 25px rgba(20, 83, 45, 0.12);
        }

        .info-strip {
            margin-top: 30px;
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
            color: #567362;
            font-size: 12px;
        }

        .warning {
            background: #e4f2e8;
            border: 1px solid #d2e7d8;
            padding: 20px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .warning h3 {
            font-size: 15px;
            margin-bottom: 6px;
        }

        .warning p {
            color: #64796b;
            font-size: 12px;
            line-height: 1.6;
        }

        .section-title {
            margin-bottom: 22px;
        }

        .section-title h2 {
            font-size: 23px;
            margin-bottom: 8px;
        }

        .section-title p {
            color: #718477;
            font-size: 13px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .stat-card, .case-card, .education-card {
            background: white;
            border: 1px solid #dfebe2;
            border-radius: 12px;
            padding: 20px;
        }

        .stat-card span {
            color: #75877b;
            font-size: 12px;
        }

        .stat-card h3 {
            font-size: 27px;
            margin: 12px 0 5px;
        }

        .stat-card small {
            color: #6a8171;
            font-size: 11px;
        }

        .case-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }

        .case-card h3 {
            font-size: 15px;
            margin: 12px 0 8px;
        }

        .case-card p {
            font-size: 12px;
            color: #718477;
            line-height: 1.7;
        }

        .status {
            display: inline-block;
            padding: 6px 9px;
            border-radius: 20px;
            background: #fff0dc;
            color: #b86a16;
            font-size: 10px;
            font-weight: 700;
        }

        .status.done {
            background: #dcfce7;
            color: #15803d;
        }

        .map-section {
            background: white;
            border: 1px solid #dfebe2;
            border-radius: 14px;
            padding: 22px;
        }

        .map-placeholder {
            height: 280px;
            background: #e2eee4;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #52735d;
            font-size: 14px;
        }

        .education-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .education-card h3 {
            font-size: 15px;
            margin: 12px 0 8px;
        }

        .education-card p {
            color: #718477;
            font-size: 12px;
            line-height: 1.7;
        }

        .education-icon {
            width: 42px;
            height: 42px;
            background: #e0f2e5;
            color: #14532d;
            display: grid;
            place-items: center;
            border-radius: 10px;
            font-size: 20px;
        }

        .cta {
            background: #14532d;
            color: white;
            padding: 35px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .cta h2 {
            font-size: 23px;
            margin-bottom: 10px;
        }

        .cta p {
            font-size: 12px;
            color: #d0e6d6;
            line-height: 1.7;
        }

        footer {
            background: #14532d;
            color: white;
            padding: 45px 25px 20px;
        }

        .footer-content {
            max-width: 1150px;
            margin: auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1.2fr;
            gap: 55px;
        }

        footer h3 {
            font-size: 17px;
            margin-bottom: 15px;
        }

        footer h4 {
            font-size: 14px;
            margin-bottom: 15px;
        }

        footer p, footer a {
            color: #c7ddce;
            font-size: 12px;
            line-height: 1.9;
        }

        .footer-links a {
            display: block;
        }

        .footer-badges {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .footer-badges span {
            background: #286442;
            padding: 8px 10px;
            border-radius: 6px;
            font-size: 10px;
        }

        .copyright {
            max-width: 1150px;
            margin: 30px auto 0;
            padding-top: 20px;
            border-top: 1px solid #32694a;
            display: flex;
            justify-content: space-between;
            gap: 15px;
            color: #c7ddce;
            font-size: 10px;
        }

        @media(max-width: 800px) {
            .navbar {
                flex-wrap: wrap;
            }

            .nav-menu {
                order: 3;
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                gap: 15px;
            }

            .hero {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 30px;
            }

            .stats, .case-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .education-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .warning, .cta {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media(max-width: 480px) {
            .stats, .case-grid {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 26px;
            }

            .copyright {
                flex-direction: column;
            }
        }

                .btn-login-petugas {
            padding: 10px 16px;
            border: 1px solid #dc4b32;
            border-radius: 8px;
            color: #c63d2b;
            font-size: 13px;
            font-weight: 700;
            transition: .2s;
        }

        .btn-login-petugas:hover {
            background: #fff0ed;
            color: #a92e20;
        }


/* ===== LAYOUT FULL WIDTH ===== */

/* Navbar memenuhi lebar layar */
.navbar {
    max-width: none;
    width: 100%;
    padding: 15px clamp(24px, 4vw, 65px);
}

/* Semua section menggunakan lebar layar */
.container {
    max-width: none;
    width: 100%;
    padding: 35px clamp(24px, 4vw, 65px);
}

/* Footer memenuhi lebar layar */
.footer-content {
    max-width: none;
    width: 100%;
    padding: 0 clamp(24px, 4vw, 65px);
}

.copyright {
    max-width: none;
    width: 100%;
    padding-left: clamp(24px, 4vw, 65px);
    padding-right: clamp(24px, 4vw, 65px);
}

/* Hero lebih proporsional */
.hero {
    grid-template-columns: 1.1fr .9fr;
    gap: 55px;
}

.hero-image {
    min-height: 380px;
}

/* Tampilan layar besar */
@media (min-width: 1400px) {
    .hero h1 {
        font-size: 46px;
    }

    .hero p {
        font-size: 16px;
    }

    .section-title h2 {
        font-size: 27px;
    }

    .stat-card,
    .case-card,
    .education-card {
        padding: 25px;
    }
}

/* Tampilan tablet dan HP tetap responsif */
@media (max-width: 800px) {
    .container {
        padding: 25px 20px;
    }

    .navbar {
        padding: 15px 20px;
    }

    .hero-image {
        min-height: 280px;
    }

    .footer-content {
        padding: 0 20px;
    }
}

    </style>
</head>

<body>

    <div class="topbar">
        ♧ Waspada Karhutla — Laporkan segera jika menemukan kebakaran hutan dan lahan.
    </div>

    <header>
        <nav class="navbar">
            <a href="/" class="brand">
                SIGAP Banyumas
                <small>TANGGAP KEBAKARAN KAB. BANYUMAS</small>
            </a>

            <div class="nav-menu">
                <a href="/">Beranda</a>
                <a href="#peta">Peta Pantauan</a>
                <a href="#status">Cek Status Laporan</a>
                <a href="#edukasi">Edukasi Warga</a>
                <a href="{{ route('login') }}" class="btn-login-petugas">
                    Login Petugas
                </a>
                <a href="{{ url('/laporan/create') }}" class="btn btn-orange">
                    🔥 Lapor Kebakaran
                </a>
            </div>
        </nav>
    </header>

    <main>

        <!-- HERO -->
        <section class="container">
            <div class="hero">
                <div>
                    <div class="eyebrow">● PORTAL INFORMASI KEBAKARAN KABUPATEN BANYUMAS</div>

                    <h1>Sistem Informasi Cepat Tanggap Kebakaran Hutan & Lahan Kabupaten Banyumas</h1>

                    <p>
                        SIGAP merupakan website yang membantu masyarakat melaporkan
                        kejadian kebakaran hutan dan lahan serta memperoleh informasi
                        perkembangan penanganan kebakaran di wilayah Kabupaten Banyumas.
                    </p>

                    <div class="hero-buttons">
                        <a href="{{ url('/laporan/create') }}" class="btn btn-orange">
                            🔥 Laporkan Kejadian Sekarang
                        </a>

                        <a href="#peta" class="btn btn-green">
                            Lihat Peta Titik Api
                        </a>
                    </div>

                    <div class="info-strip">
                       
                        <span>✓ Informasi Penanganan Kebakaran</span>
                        <span>◷ Siaga 24 Jam</span>
                    </div>
                </div>

                <div class="hero-image"></div>
            </div>
        </section>

        <!-- PERINGATAN -->
        <section class="container">
            <div class="warning">
                <div>
                    <h3>⚠ Waspada Kebakaran Hutan dan Lahan</h3>
                    <p>
                        Hindari pembakaran sampah dan pembukaan lahan dengan cara dibakar.
                        Segera laporkan apabila menemukan titik api di sekitar Anda.
                    </p>
                </div>
                <a href="{{ url('/laporan/create') }}" class="btn btn-orange">
                    Lapor Cepat
                </a>
            </div>
        </section>

        <!-- STATISTIK -->
        <section class="container">
            <div class="section-title">
                <h2>Statistik Penanganan Kebakaran</h2>
                <p>Informasi ringkas kejadian kebakaran di Kabupaten Banyumas.</p>
            </div>

            <div class="stats">
                <div class="stat-card">
                    <span>Total Laporan</span>
                    <h3>148</h3>
                    <small>Jumlah laporan kejadian</small>
                </div>

                <div class="stat-card">
                    <span>Menunggu Verifikasi</span>
                    <h3>3</h3>
                    <small>Laporan perlu diperiksa</small>
                </div>

                <div class="stat-card">
                    <span>Sedang Ditangani</span>
                    <h3>2</h3>
                    <small>Kejadian dalam penanganan</small>
                </div>

                <div class="stat-card">
                    <span>Selesai Ditangani</span>
                    <h3>143</h3>
                    <small>Laporan selesai ditangani</small>
                </div>
            </div>
        </section>

        <!-- KEJADIAN TERBARU -->
        <section class="container">
            <div class="section-title">
                <h2>Daftar Kejadian Kebakaran Terbaru</h2>
                <p>Informasi kejadian kebakaran yang telah tercatat.</p>
            </div>

            <div class="case-grid">
                <div class="case-card">
                    <span class="status">Sedang Ditangani</span>
                    <h3>Karhutla Lereng Hutan Pinus</h3>
                    <p>Ketenger, Kecamatan Baturraden, Banyumas.</p>
                </div>

                <div class="case-card">
                    <span class="status done">Selesai</span>
                    <h3>Kebakaran Semak Kering</h3>
                    <p>Karangtengah, Kecamatan Cilongok, Banyumas.</p>
                </div>

                <div class="case-card">
                    <span class="status done">Selesai</span>
                    <h3>Kebakaran Perbukitan</h3>
                    <p>Rancamaya, Kecamatan Wangon, Banyumas.</p>
                </div>

                <div class="case-card">
                    <span class="status">Menunggu Verifikasi</span>
                    <h3>Kebakaran Lahan Perkebunan</h3>
                    <p>Krapyak, Kecamatan Pekuncen, Banyumas.</p>
                </div>
            </div>
        </section>

        <!-- PETA -->
        <section class="container" id="peta">
            <div class="map-section">
                <div class="section-title">
                    <h2>Peta Pantauan Titik Kebakaran</h2>
                    <p>Lihat informasi lokasi kejadian kebakaran di wilayah Banyumas.</p>
                </div>

                <div class="map-placeholder">
                    <div>
                        <div style="font-size:35px;">📍</div>
                        <strong>Peta Pantauan Kebakaran</strong>
                        <p style="margin-top:8px;">Peta interaktif akan ditampilkan di sini.</p>
                    </div>
                </div>

                <br>
                <a href="{{ url('/peta') }}" class="btn btn-green">
                    Buka Peta Pantauan
                </a>
            </div>
        </section>

        <!-- STATUS -->
        <section class="container" id="status">
            <div class="section-title">
                <h2>Cek Status Laporan Anda</h2>
                <p>Pantau perkembangan laporan kebakaran menggunakan nomor tiket laporan.</p>
            </div>

            <a href="{{ url('/cek-status') }}" class="btn btn-green">
                Cek Status Laporan →
            </a>
        </section>

        <!-- EDUKASI -->
        <section class="container" id="edukasi">
            <div class="section-title">
                <h2>Edukasi Pencegahan Kebakaran</h2>
                <p>Kenali langkah sederhana untuk mencegah kebakaran hutan dan lahan.</p>
            </div>

            <div class="education-grid">
                <div class="education-card">
                    <div class="education-icon">🚫</div>
                    <h3>Hindari Membakar Sampah</h3>
                    <p>
                        Jangan membakar sampah atau membuka lahan dengan api,
                        terutama saat cuaca panas dan kering.
                    </p>
                </div>

                <div class="education-card">
                    <div class="education-icon">🌳</div>
                    <h3>Jaga Lingkungan Sekitar</h3>
                    <p>
                        Bersihkan area sekitar rumah dan lahan dari bahan
                        mudah terbakar yang dapat memicu kebakaran.
                    </p>
                </div>

                <div class="education-card">
                    <div class="education-icon">📞</div>
                    <h3>Laporkan Titik Api</h3>
                    <p>
                        Segera laporkan kejadian kebakaran agar dapat
                        diketahui dan ditangani oleh petugas.
                    </p>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="container">
            <div class="cta">
                <div>
                    <h2>Bersama Jaga Keselamatan Warga Banyumas</h2>
                    <p>
                        Jika menemukan kebakaran hutan atau lahan,
                        segera sampaikan laporan melalui SIGAP.
                    </p>
                </div>

                <a href="{{ url('/laporan/create') }}" class="btn btn-orange">
                    🔥 Laporkan Kebakaran
                </a>
            </div>
        </section>

    </main>

    <!-- FOOTER -->
    <footer>
        <div class="footer-content">

            <div>
                <h3>🟢 SIGAP Kabupaten Banyumas</h3>
                <p>
                    Sistem Informasi Gerak Atasi Kebakaran merupakan sarana
                    pelaporan dan informasi penanganan kebakaran hutan dan
                    lahan yang terintegrasi dengan BPBD dan petugas pemadam
                    kebakaran Kabupaten Banyumas.
                </p>

                <br>
                <strong style="font-size:11px;">POSKO SIAGA 24 JAM KABUPATEN BANYUMAS</strong>

                <div class="footer-badges">
                    <span>✳ Posko Siaga Lapangan 24 Jam</span>
                    <span>♨ UPTD Damkar Satpol PP</span>
                    <span>🛡 Pusdalops BPBD Banyumas</span>
                </div>
            </div>

            <div class="footer-links">
                <h4>Layanan Warga</h4>
                <a href="/">Beranda Utama</a>
                <a href="#peta">Peta Pantauan Wilayah</a>
                <a href="{{ url('/laporan/create') }}">Form Pelaporan Cepat</a>
                <a href="{{ url('/cek-status') }}">Cek Status Penanganan</a>
                <a href="#edukasi">Edukasi Pencegahan</a>
            </div>

            <div>
                <h4>Pusat Komando & Posko</h4>
                <p>
                    Pusdalops BPBD: Jl. Sukarno Hatta No. 1,
                    Karangklesem, Purwokerto Selatan,
                    Kabupaten Banyumas.
                </p>

                <div class="footer-badges">
                    <span>BPBD Kab. Banyumas</span>
                    <span>UPTD Damkar Satpol PP</span>
                    <span>PDAM Tirta Satria</span>
                    <span>LMDH Lereng Slamet</span>
                </div>
            </div>

        </div>

        <div class="copyright">
            <span>© 2025 Pemerintah Kabupaten Banyumas. Layanan Darurat Terpadu Tanggap Karhutla.</span>
            <span>Pusdalops BPBD & UPTD Damkar Satpol PP Banyumas</span>
        </div>
    </footer>

</body>
</html>
