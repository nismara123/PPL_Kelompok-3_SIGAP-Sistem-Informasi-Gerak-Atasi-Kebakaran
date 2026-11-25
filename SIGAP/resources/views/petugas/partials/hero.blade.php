{{-- Hero banner dashboard. Variabel: $badge, $judul, $deskripsi, $status, $wilayah, $gradient --}}
<section class="rounded-2xl p-6 sm:p-8 text-white shadow-2xs" style="background: {{ $gradient }}">
  <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
    <div class="max-w-2xl space-y-3">
      <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white text-slate-800 text-[11px] font-semibold shadow-2xs">
        <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944z" clip-rule="evenodd" />
        </svg>
        <span>{{ $badge }}</span>
      </div>
      <h1 class="text-2xl sm:text-[28px] font-extrabold tracking-tight leading-tight">{{ $judul }}</h1>
      <p class="text-xs sm:text-sm text-white/90 leading-relaxed">{{ $deskripsi }}</p>
    </div>

    <div class="self-start lg:self-center bg-[#0d1117]/85 border border-white/10 rounded-2xl px-5 py-4 shrink-0">
      <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase mb-2">STATUS KESIAPSIAGAAN</div>
      <div class="flex items-center gap-2.5">
        <span class="px-2.5 py-1 rounded-full bg-[#e11d48] text-white text-[11px] font-extrabold tracking-wide">SIAGA KARHUTLA</span>
        <span class="text-xs font-semibold text-white">{{ $wilayah ?? 'Wilayah Banyumas' }}</span>
      </div>
    </div>
  </div>
</section>
