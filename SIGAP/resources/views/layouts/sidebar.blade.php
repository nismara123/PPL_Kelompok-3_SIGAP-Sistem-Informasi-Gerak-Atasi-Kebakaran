@php
    $role = auth()->user()->role ?? null;
@endphp

<aside id="mobileSidebar" class="fixed lg:sticky top-0 left-0 z-40 h-screen w-64 bg-white border-r border-slate-200/80 flex flex-col justify-between transition-transform duration-200 -translate-x-full lg:translate-x-0 shrink-0">
  <div class="overflow-y-auto">

    @if($role === 'damkar')
      {{-- ==================== SIDEBAR KHUSUS ROLE PETUGAS DAMKAR ==================== --}}
      <!-- Brand Header -->
      <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-[#c8321b] text-white flex items-center justify-center shrink-0 shadow-2xs">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.5 3.2 5 5.6 5 9.2a5 5 0 11-10 0c0-1.6.7-3.2 1.8-4.7.3 1.4 1.2 2.2 2.2 2.5-.4-2.3.1-4.8 1-7z" />
          </svg>
        </div>
        <div class="min-w-0">
          <div class="text-lg font-extrabold tracking-tight text-slate-900 leading-none">SIGAP</div>
          <div class="text-[11px] font-medium text-slate-500 mt-1 truncate">Sistem Informasi Karhutla</div>
        </div>
      </div>

      <!-- Active Role Banner -->
      <div class="px-5 py-3.5 bg-[#fff5f3] border-b border-[#fde5e0]">
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">LOGIN SEBAGAI</div>
        <div class="mt-1 flex items-center gap-2 text-xs font-bold text-[#c8321b]">
          Petugas Damkar
        </div>
      </div>

      <!-- Navigation Menu -->
      <div class="px-3.5 py-4 space-y-1">
        {{-- Dashboard Damkar --}}
        <a href="{{ route('damkar.dashboard') }}"
           class="nav-item w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold bg-[#c8321b] text-white shadow-2xs transition text-decoration-none">
          <span class="flex items-center gap-2.5">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span>Dashboard</span>
          </span>
        </a>

        <!-- Menu Damkar Terkunci -->
        <div class="space-y-1 pt-1.5">
          <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-medium text-slate-400 select-none">
            <span class="flex items-center gap-2.5">
              <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
              </svg>
              <span>Tugas Penanganan</span>
            </span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>

          <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-medium text-slate-400 select-none">
            <span class="flex items-center gap-2.5">
              <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
              <span class="leading-tight">Update Status<br><span class="text-[10px]">Penanganan</span></span>
            </span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>

          <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-medium text-slate-400 select-none">
            <span class="flex items-center gap-2.5">
              <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>Hasil Penanganan</span>
            </span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>
        </div>
      </div>

    @elseif($role === 'rr')
      {{-- ==================== SIDEBAR KHUSUS ROLE BPBD DIVISI RR ==================== --}}
      <!-- Brand Header -->
      <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-[#1d5c38] text-white flex items-center justify-center shrink-0 shadow-2xs">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.5 3.2 5 5.6 5 9.2a5 5 0 11-10 0c0-1.6.7-3.2 1.8-4.7.3 1.4 1.2 2.2 2.2 2.5-.4-2.3.1-4.8 1-7z" />
          </svg>
        </div>
        <div class="min-w-0">
          <div class="text-lg font-extrabold tracking-tight text-slate-900 leading-none">SIGAP</div>
          <div class="text-[11px] font-medium text-slate-500 mt-1 truncate">Sistem Informasi Karhutla</div>
        </div>
      </div>

      <!-- Active Role Banner -->
      <div class="px-5 py-3.5 bg-[#f0f9f4] border-b border-[#daf0e2]">
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">LOGIN SEBAGAI</div>
        <div class="mt-1 flex items-center gap-2 text-xs font-bold text-[#1d5c38]">
          BPBD Divisi RR
        </div>
      </div>

      <!-- Navigation Menu -->
      <div class="px-3.5 py-4 space-y-1">
        {{-- Dashboard RR --}}
        <a href="{{ route('rr.dashboard') }}"
           class="nav-item w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold bg-[#1d5c38] text-white shadow-2xs transition text-decoration-none">
          <span class="flex items-center gap-2.5">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span>Dashboard</span>
          </span>
        </a>

        <!-- Menu RR Terkunci -->
        <div class="space-y-1 pt-1.5">
          <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-medium text-slate-400 select-none">
            <span class="flex items-center gap-2.5">
              <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
              <span>Data Kerusakan Lahan</span>
            </span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>

          <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-medium text-slate-400 select-none">
            <span class="flex items-center gap-2.5">
              <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
              <span>Rehabilitasi Lahan</span>
            </span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>

          <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-medium text-slate-400 select-none">
            <span class="flex items-center gap-2.5">
              <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
              </svg>
              <span>Peta Persebaran</span>
            </span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>
        </div>
      </div>

    @else
      {{-- ==================== SIDEBAR KHUSUS ROLE BPBD PUSDALOPS (TETAP SAMA TANPA DIUBAH) ==================== --}}
      <!-- Brand Header -->
      <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-[#e03c22] text-white flex items-center justify-center shrink-0 shadow-2xs">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.5 3.2 5 5.6 5 9.2a5 5 0 11-10 0c0-1.6.7-3.2 1.8-4.7.3 1.4 1.2 2.2 2.2 2.5-.4-2.3.1-4.8 1-7z" />
          </svg>
        </div>
        <div class="min-w-0">
          <div class="text-lg font-extrabold tracking-tight text-slate-900 leading-none">SIGAP</div>
          <div class="text-[11px] font-medium text-slate-500 mt-1 truncate">Sistem Informasi Karhutla</div>
        </div>
      </div>

      <!-- Active Role Banner -->
      <div class="px-5 py-3.5 bg-[#fff5f3] border-b border-[#fde5e0]">
        <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">LOGIN SEBAGAI</div>
        <div class="mt-1.5 flex items-center gap-2 text-xs font-bold text-[#c8321b]">
          <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
          </svg>
          <span>BPBD Pusdalops</span>
        </div>
      </div>

      <!-- Navigation Menu -->
      <div class="px-3.5 py-4 space-y-1">
        <div class="px-3 pb-1.5 text-[10px] font-bold tracking-wider text-slate-400 uppercase">MENU UTAMA</div>

        {{-- Dashboard --}}
        <a href="{{ route('pusdalops.dashboard') }}"
           class="nav-item w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs {{ request()->routeIs('pusdalops.dashboard') ? 'font-bold bg-[#fff1ee] text-[#e03c22]' : 'font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} transition">
          <span class="flex items-center gap-2.5">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span>Dashboard</span>
          </span>
        </a>

        {{-- Data Wilayah Karhutla --}}
        <a href="{{ route('wilayah.index') }}"
           class="nav-item w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs {{ request()->routeIs('wilayah.*') ? 'font-bold bg-[#fff1ee] text-[#e03c22]' : 'font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} transition">
          <span class="flex items-center gap-2.5">
            <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('wilayah.*') ? 'text-[#e03c22]' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Data Wilayah Karhutla</span>
          </span>
        </a>

        {{-- Laporan Karhutla --}}
        <a href="{{ route('laporan.index') }}"
           class="nav-item w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs {{ request()->routeIs('laporan.index') ? 'font-bold bg-[#e03c22] text-white shadow-2xs' : 'font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} transition">
          <span class="flex items-center gap-2.5">
            <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('laporan.index') ? 'text-white' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span>Laporan Karhutla</span>
          </span>
        </a>

        <!-- Locked Modules Pusdalops -->
        <div class="space-y-1 pt-1">
          @php
            $unassessedCount = \App\Models\LaporanKarhutla::whereNull('tingkat_risiko')->count();
          @endphp

          {{-- Verifikasi Laporan --}}
          <a href="{{ route('verifikasi.index') }}"
             class="nav-item w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs {{ request()->routeIs('verifikasi.*') ? 'font-bold bg-[#fff1ee] text-[#e03c22]' : 'font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} transition text-decoration-none">
            <span class="flex items-center gap-2.5">
              <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('verifikasi.*') ? 'text-[#e03c22]' : 'text-slate-400' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>Verifikasi Laporan</span>
            </span>
          </a>

          {{-- Penilaian Risiko --}}
          <a href="{{ route('penilaian-risiko.index') }}"
             class="nav-item w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs {{ request()->routeIs('penilaian-risiko.*') ? 'font-bold bg-[#fff1ee] text-[#e03c22]' : 'font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900' }} transition text-decoration-none">
            <span class="flex items-center gap-2.5">
              <svg class="w-4 h-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
              <span>Penilaian Risiko</span>
            </span>
            @if($unassessedCount > 0)
              <span class="w-5 h-5 rounded-full bg-rose-100 text-rose-600 font-bold text-[10px] flex items-center justify-center">
                {{ $unassessedCount }}
              </span>
            @endif
          </a>

          <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-medium text-slate-400 select-none" title="Fitur dalam tahap pengembangan">
            <span class="flex items-center gap-2.5">
              <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span>Koordinasi Damkar</span>
            </span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>

          <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-medium text-slate-400 select-none" title="Fitur dalam tahap pengembangan">
            <span class="flex items-center gap-2.5">
              <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              <span>Monitoring Penanganan</span>
            </span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>

          <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-medium text-slate-400 select-none" title="Fitur dalam tahap pengembangan">
            <span class="flex items-center gap-2.5">
              <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
              </svg>
              <span>Peta Persebaran</span>
            </span>
            <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>
        </div>
      </div>
    @endif

  </div>

  <!-- Bottom Sidebar Footer with User Profile and Logout -->
  <div class="p-3.5 border-t border-slate-100 space-y-2">
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-700 px-1 truncate">
      <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
      </svg>
      <span class="truncate">
        @if($role === 'damkar')
          Petugas Damkar
        @elseif($role === 'rr')
          Petugas Divisi RR
        @else
          {{ auth()->user()->name ?? 'Petugas Pusdalops' }}
        @endif
      </span>
    </div>

    <form method="POST" action="{{ route('logout') }}" class="m-0">
      @csrf
      <button
        type="submit"
        class="w-full flex items-center gap-2 px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-rose-50 hover:text-rose-600 transition"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        <span>Keluar</span>
      </button>
    </form>
  </div>
</aside>