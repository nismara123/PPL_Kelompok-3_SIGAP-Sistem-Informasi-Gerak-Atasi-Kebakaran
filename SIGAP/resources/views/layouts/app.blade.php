
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SIGAP — Sistem Informasi Karhutla | BPBD Kabupaten Banyumas')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    }
                }
            }
        };
    </script>

    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            min-height: 100%;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            color: #202938;
        }

        .main-content {
            flex: 1;
            min-width: 0;
            min-height: 100vh;
            background: #f5f7fa;
        }

        .topbar {
            height: 58px;
            background: #ffffff;
            border-bottom: 1px solid #e9edf2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .topbar-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 13px;
            border: 1px solid #e8ebef;
            border-radius: 999px;
            background: #fff;
            color: #475569;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
        }

        .page-content {
            min-width: 0;
            padding: 28px;
        }

        .container-fluid {
            padding: 0;
        }

        .container-fluid h2 {
            font-size: 28px;
            font-weight: 700;
            color: #202938;
        }

        .container-fluid .card {
            border: 1px solid #e8edf2;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(15, 23, 42, .03);
        }

        .container-fluid .card-body {
            padding: 24px;
        }

        .container-fluid p {
            line-height: 1.55;
        }


/* ================================
   SIDEBAR SIGAP - PERAPIAN TAMPILAN
================================ */

/* Bentuk utama sidebar */
#mobileSidebar {
    width: 260px;
    min-width: 260px;
    background: #fffdfb;
    border-right: 1px solid #eee9e5;
    box-shadow: 3px 0 14px rgba(30, 41, 59, 0.035);
}

/* Area sidebar yang bisa discroll */
#mobileSidebar > div:first-child {
    scrollbar-width: thin;
    scrollbar-color: #dedede transparent;
}

/* Bagian logo */
#mobileSidebar > div:first-child > div:first-child {
    min-height: 96px;
    padding: 20px;
}

/* Banner role */
#mobileSidebar > div:first-child > div:nth-child(2) {
    padding-top: 16px;
    padding-bottom: 16px;
}

/* Area menu */
#mobileSidebar .nav-item {
    min-height: 46px;
    padding: 11px 13px;
    margin-bottom: 5px;
    border: 1px solid transparent;
    border-radius: 11px;
    text-decoration: none;
    line-height: 1.45;
    transition: all 0.2s ease;
}

/* Menu aktif - warna tetap mengikuti role */
#mobileSidebar .nav-item[style] {
    border-color: color-mix(in srgb, currentColor 18%, transparent);
    box-shadow: 0 3px 8px rgba(15, 23, 42, 0.07);
}

/* Menu yang bisa diklik saat diarahkan */
#mobileSidebar .nav-item:not([style]):hover {
    transform: translateX(3px);
    background: #f5f5f5;
}

/* Ikon menu */
#mobileSidebar .nav-item svg {
    width: 17px;
    height: 17px;
}

/* Menu terkunci */
#mobileSidebar .select-none {
    min-height: 44px;
    padding: 10px 13px;
    margin-bottom: 5px;
    border-radius: 11px;
    opacity: 0.72;
}

/* Footer sidebar */
#mobileSidebar > div:last-child {
    padding: 16px;
    background: #fffdfb;
    border-top: 1px solid #eee9e5;
}

/* Tombol keluar */
#mobileSidebar form button {
    min-height: 44px;
    border-radius: 10px;
    transition: all 0.2s ease;
}

#mobileSidebar form button:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(15, 23, 42, 0.06);
}


        @media (max-width: 768px) {
            .topbar {
                padding: 0 16px;
            }

            .topbar-info {
                display: none;
            }

            .page-content {
                padding: 20px 16px;
            }
        }

        /* FIX SIDEBAR AGAR TETAP DIAM SAAT HALAMAN DI-SCROLL */
@media (min-width: 1024px) {
    #mobileSidebar {
        position: fixed !important;
        top: 0;
        left: 0;
        height: 100vh !important;
        width: 255px;
        min-width: 255px;
        z-index: 40;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: width .25s ease, min-width .25s ease;
    }

    /* Area menu bisa scroll sendiri */
    #mobileSidebar > div:first-child {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Footer tetap di bagian bawah */
    #mobileSidebar > div:last-child {
        flex-shrink: 0;
    }

    /* Geser konten utama mengikuti lebar sidebar */
    .main-content {
        margin-left: 255px;
        width: calc(100% - 255px);
        transition: margin-left .25s ease, width .25s ease;
    }

    /* Ketika sidebar dikecilkan */
    body.sidebar-is-collapsed .main-content {
        margin-left: 76px;
        width: calc(100% - 76px);
    }
}
    </style>

    @stack('styles')
</head>

<body class="min-h-screen flex">

    {{-- BACKDROP SIDEBAR MOBILE --}}
    <div
        id="mobileSidebarBackdrop"
        onclick="toggleMobileSidebar()"
        class="fixed inset-0 z-30 bg-slate-900/40 hidden lg:hidden">
    </div>

    {{-- SIDEBAR --}}
    @include('layouts.sidebar')

    {{-- AREA UTAMA --}}
    <main class="main-content">

        {{-- HEADER ATAS --}}
        @php
            $currentUser = auth()->user();
            $currentRole = $currentUser->role ?? null;

            $roleLabel = match($currentRole) {
                'pusdalops' => 'Petugas Pusdalops',
                'damkar' => 'Petugas Damkar',
                'rr' => 'Petugas Divisi RR',
                default => 'Petugas BPBD',
            };
        @endphp

        <header class="topbar">

            <div class="flex items-center gap-3 min-w-0">

                <button
                    type="button"
                    onclick="toggleMobileSidebar()"
                    class="lg:hidden text-slate-600 text-xl mr-1"
                    aria-label="Buka menu">
                    <i class="bi bi-list"></i>
                </button>

                <div class="topbar-info flex items-center gap-2 text-xs text-slate-600 whitespace-nowrap">
                    <i class="bi bi-geo-alt text-red-500"></i>
                    <span>BPBD Kabupaten Banyumas</span>
                    <span class="text-slate-300">•</span>
                    <i class="bi bi-calendar3 text-slate-400"></i>
                    <span>{{ now()->locale('id')->translatedFormat('l, d F Y') }}</span>
                </div>

            </div>

            <div class="flex items-center gap-2">

                <div class="topbar-pill">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Sistem Aktif &amp; Terhubung</span>
                </div>

                <div class="topbar-pill">
                    <i class="bi bi-person text-blue-600"></i>
                    <span>{{ $roleLabel }}</span>
                </div>

            </div>

        </header>

        {{-- ISI HALAMAN --}}
        <div class="page-content">
            @yield('content')
        </div>

    </main>

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const backdrop = document.getElementById('mobileSidebarBackdrop');

            if (sidebar) {
                sidebar.classList.toggle('-translate-x-full');
            }

            if (backdrop) {
                backdrop.classList.toggle('hidden');
            }
        }
    </script>

    @stack('scripts')

</body>
</html>
