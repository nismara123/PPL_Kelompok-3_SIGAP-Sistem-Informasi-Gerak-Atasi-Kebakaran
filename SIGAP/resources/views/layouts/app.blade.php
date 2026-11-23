<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'SIGAP — Sistem Penanganan Karhutla | BPBD Kabupaten Banyumas')</title>

    {{-- Tailwind CSS CDN & Google Fonts --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['Inter', 'sans-serif'],
            }
          }
        }
      };
    </script>

    <style>
      .sigap-hero-banner {
        background: linear-gradient(105deg, #741912 0%, #a52918 52%, #c73b1e 100%);
      }
      .tabular-nums {
        font-variant-numeric: tabular-nums;
      }
    </style>

    @stack('styles')
</head>
<body class="bg-[#f7f8fa] text-slate-800 font-sans antialiased min-h-screen flex">

  <!-- Mobile Sidebar Backdrop -->
  <div id="mobileSidebarBackdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 z-30 bg-slate-900/40 hidden lg:hidden"></div>

  <!-- ==================== LEFT SIDEBAR ==================== -->
  @include('layouts.sidebar')

  <!-- ==================== MAIN CONTENT WRAPPER ==================== -->
  <div class="flex-1 flex flex-col min-w-0">

    <!-- Top Header Bar -->
    <header class="sticky top-0 z-20 h-14 bg-white border-b border-slate-200/80 px-4 sm:px-7 flex items-center justify-between gap-3">
      <div class="flex items-center gap-3 min-w-0">
        <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50" aria-label="Menu">
          Menu
        </button>

        <div class="flex items-center gap-2 text-xs text-slate-500 truncate">
          <span class="inline-flex items-center gap-1.5 font-medium text-slate-700">
            <svg class="w-3.5 h-3.5 text-[#e03c22] shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>BPBD Kabupaten Banyumas</span>
          </span>
          <span class="hidden sm:inline text-slate-300">•</span>
          <span class="hidden sm:inline-flex items-center gap-1.5 text-slate-500 tabular-nums">
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>{{ now()->translatedFormat('l, d F Y') }}</span>
          </span>
        </div>
      </div>

      <div class="flex items-center gap-2.5 shrink-0">
        <span class="hidden md:inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-slate-200 bg-white text-xs font-medium text-slate-700">
          <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
          <span>Sistem Aktif & Terhubung</span>
        </span>

        @auth
          <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-slate-200 bg-white text-xs font-semibold text-slate-800">
            <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>{{ auth()->user()->name }}</span>
          </span>
        @endauth
      </div>
    </header>

    <!-- Main Content Yield -->
    <div class="flex-1">
      @yield('content')
    </div>

  </div>

  <script>
    function toggleMobileSidebar() {
      const sidebar = document.getElementById('mobileSidebar');
      const backdrop = document.getElementById('mobileSidebarBackdrop');
      if (sidebar) sidebar.classList.toggle('-translate-x-full');
      if (backdrop) backdrop.classList.toggle('hidden');
    }
  </script>

  @stack('scripts')
</body>
</html>
