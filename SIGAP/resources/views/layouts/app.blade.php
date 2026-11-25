
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
