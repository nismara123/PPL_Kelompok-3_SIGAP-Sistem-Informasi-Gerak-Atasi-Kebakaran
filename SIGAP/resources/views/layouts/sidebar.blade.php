@php
    $role = auth()->user()->role ?? null;

    // Warna aksen per role (struktur role tidak diubah, hanya tema tampilan)
    $theme = match ($role) {
        'rr' => ['ac' => '#15803d', 'soft' => '#ecf8ef', 'banner' => '#f1faf4', 'border' => '#d3eddb'],
        'damkar' => ['ac' => '#c81e1e', 'soft' => '#fef0f0', 'banner' => '#fff5f5', 'border' => '#fcdada'],
        default => ['ac' => '#e03c22', 'soft' => '#fff1ee', 'banner' => '#fff5f3', 'border' => '#fde5e0'],
    };

    $roleLabel = match ($role) {
        'pusdalops' => 'BPBD Pusdalops',
        'damkar' => 'Petugas Damkar',
        'rr' => 'BPBD Divisi RR',
        default => 'Petugas BPBD',
    };

    $footerLabel = match ($role) {
        'pusdalops' => 'Petugas Pusdalops',
        'damkar' => 'Petugas Damkar',
        'rr' => 'Petugas Divisi RR',
        default => auth()->user()->name ?? 'Petugas',
    };

    $dashboardRoute = match ($role) {
        'damkar' => 'damkar.dashboard',
        'rr' => 'rr.dashboard',
        default => 'pusdalops.dashboard',
    };

    $unassessedCount = $role === 'pusdalops'
        ? \App\Models\LaporanKarhutla::whereNull('tingkat_risiko')->count()
        : 0;

    $isMenuLaporan = request()->routeIs('laporan.*') && request('mode') !== 'verifikasi';
    $isMenuVerifikasi = request()->routeIs('laporan.*') && request('mode') === 'verifikasi';

    $iconDashboard = 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z';
    $iconWilayah = 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z';
    $iconLaporan = 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
    $iconVerif = 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
    $iconRisiko = 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z';
    $iconDamkar = 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z';
    $iconMonitor = 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z';
    $iconPeta = 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7';
    $iconTugas = 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4';
    $iconUpdate = 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15';
    $iconHasil = 'M9 12l2 2 4-4M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z';
    $iconLahan = 'M12 3c2.5 3.2 5 5.6 5 9.2a5 5 0 11-10 0c0-1.6.7-3.2 1.8-4.7.3 1.4 1.2 2.2 2.2 2.5-.4-2.3.1-4.8 1-7z';
    $iconRehab = 'M5 21V10m0 0c0-3 2-5 5-5 0 3-2 5-5 5zm14 11V8m0 0c0-3-2-5-5-5 0 3 2 5 5 5zM12 21v-8';
    $iconLock = 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z';

    // Daftar menu aktif & terkunci per role
    $menus = match ($role) {
        'pusdalops' => [
            ['label' => 'Dashboard', 'icon' => $iconDashboard, 'href' => route('pusdalops.dashboard'), 'active' => request()->routeIs('pusdalops.dashboard')],
            ['label' => 'Data Wilayah Karhutla', 'icon' => $iconWilayah, 'href' => route('wilayah.index'), 'active' => request()->routeIs('wilayah.*')],
            ['label' => 'Laporan Karhutla', 'icon' => $iconLaporan, 'href' => route('laporan.index'), 'active' => $isMenuLaporan],
            ['label' => 'Verifikasi Laporan', 'icon' => $iconVerif, 'href' => route('laporan.index', ['mode' => 'verifikasi']), 'active' => $isMenuVerifikasi],
            ['label' => 'Penilaian Risiko', 'icon' => $iconRisiko, 'href' => route('penilaian-risiko.index'), 'active' => request()->routeIs('penilaian-risiko.*'), 'badge' => $unassessedCount],
            ['label' => 'Koordinasi Damkar', 'icon' => $iconDamkar, 'href' => route('koordinasi-damkar.index'), 'active' => request()->routeIs('koordinasi-damkar.*')],
        ],
        'damkar' => [
            ['label' => 'Dashboard', 'icon' => $iconDashboard, 'href' => route('damkar.dashboard'), 'active' => request()->routeIs('damkar.dashboard')],
            ['label' => 'Koordinasi Damkar', 'icon' => $iconDamkar, 'href' => route('koordinasi-damkar.index'), 'active' => request()->routeIs('koordinasi-damkar.*')],
        ],
        'rr' => [
            ['label' => 'Dashboard', 'icon' => $iconDashboard, 'href' => route('rr.dashboard'), 'active' => request()->routeIs('rr.dashboard')],
            ['label' => 'Data Kerusakan Lahan', 'icon' => $iconLahan, 'href' => route('kerusakan-lahan.index'), 'active' => request()->routeIs('kerusakan-lahan.*')],
        ],
        default => [
            ['label' => 'Dashboard', 'icon' => $iconDashboard, 'href' => route($dashboardRoute), 'active' => request()->routeIs($dashboardRoute)],
        ],
    };

    $locked = match ($role) {
        'pusdalops' => [
            ['label' => 'Monitoring Penanganan', 'icon' => $iconMonitor],
            ['label' => 'Peta Persebaran', 'icon' => $iconPeta],
        ],
        'damkar' => [
            ['label' => 'Tugas Penanganan', 'icon' => $iconTugas],
            ['label' => 'Update Status Penanganan', 'icon' => $iconUpdate],
            ['label' => 'Hasil Penanganan', 'icon' => $iconHasil],
        ],
        'rr' => [
            ['label' => 'Rehabilitasi Lahan', 'icon' => $iconRehab],
            ['label' => 'Peta Persebaran', 'icon' => $iconPeta],
        ],
        default => [],
    };
@endphp

<aside id="mobileSidebar" class="fixed lg:sticky top-0 left-0 z-40 h-screen w-64 bg-white border-r border-slate-200/80 flex flex-col justify-between transition-transform duration-200 -translate-x-full lg:translate-x-0 shrink-0">
  <div class="overflow-y-auto">
    <!-- Brand Header -->
    <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3">
      <div class="w-11 h-11 rounded-xl text-white flex items-center justify-center shrink-0 shadow-sm" style="background: {{ $theme['ac'] }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.5 3.2 5 5.6 5 9.2a5 5 0 11-10 0c0-1.6.7-3.2 1.8-4.7.3 1.4 1.2 2.2 2.2 2.5-.4-2.3.1-4.8 1-7z" />
        </svg>
      </div>
      <div class="min-w-0 flex flex-col justify-center">
        <div class="text-lg font-extrabold tracking-tight text-slate-900 leading-none">SIGAP</div>
        <div class="text-[11px] font-medium text-slate-500 mt-1 leading-none whitespace-nowrap">Sistem Informasi Karhutla</div>
      </div>
    </div>

    <!-- Active Role Banner -->
    <div class="px-5 py-3.5 border-b" style="background: {{ $theme['banner'] }}; border-color: {{ $theme['border'] }}">
      <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">LOGIN SEBAGAI</div>
      <div class="mt-1.5 flex items-center gap-2 text-xs font-bold" style="color: {{ $theme['ac'] }}">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
        </svg>
        <span>{{ $roleLabel }}</span>
      </div>
    </div>

    <!-- Navigation Menu -->
    <div class="px-3.5 py-4 space-y-1">
      <div class="px-3 pb-1.5 text-[10px] font-bold tracking-wider text-slate-400 uppercase">MENU UTAMA</div>

      @foreach($menus as $m)
        <a href="{{ $m['href'] }}"
           class="nav-item w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs transition {{ $m['active'] ? 'font-bold' : 'font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
           @if($m['active']) style="background: {{ $theme['soft'] }}; color: {{ $theme['ac'] }}" @endif>
          <span class="flex items-center gap-2.5">
            <svg class="w-4 h-4 shrink-0 {{ $m['active'] ? '' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="{{ $m['icon'] }}" />
            </svg>
            <span>{{ $m['label'] }}</span>
          </span>
          @if(!empty($m['badge']) && $m['badge'] > 0)
            <span class="px-1.5 py-0.5 text-[10px] font-bold rounded-full bg-red-100 text-red-700 tabular-nums">{{ $m['badge'] }}</span>
          @endif
        </a>
      @endforeach

      @if(count($locked))
        <div class="space-y-1">
          @foreach($locked as $l)
            <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-medium text-slate-400 select-none" title="Fitur dalam tahap pengembangan">
              <span class="flex items-center gap-2.5">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="{{ $l['icon'] }}" />
                </svg>
                <span>{{ $l['label'] }}</span>
              </span>
              <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $iconLock }}" />
              </svg>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>

  <!-- Footer: profil + keluar -->
  <div class="p-4 border-t border-slate-100 space-y-3">
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-700 px-1">
      <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
      </svg>
      <span class="truncate">{{ $footerLabel }}</span>
    </div>
    <form method="POST" action="{{ route('logout') }}" class="m-0">
      @csrf
      <button type="submit" class="w-full flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-700 hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        <span>Keluar</span>
      </button>
    </form>
  </div>
</aside>
