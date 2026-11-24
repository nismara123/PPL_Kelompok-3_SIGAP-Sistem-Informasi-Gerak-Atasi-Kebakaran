@extends('layouts.app')

@section('title', 'Data Wilayah Pantauan Karhutla - SIGAP')

@section('content')
<main id="view-wilayah" class="p-4 sm:p-7 max-w-[1380px] w-full mx-auto space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
        Data Wilayah Pantauan Karhutla
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Sebaran kecamatan rawan kebakaran hutan dan lahan di wilayah Kabupaten Banyumas.
      </p>
    </div>

    <div class="flex items-center gap-3">
      <!-- Tombol Tambah Wilayah -->
      <a
        href="{{ route('wilayah.create') }}"
        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-[#e03c22] hover:bg-[#c53019] text-white text-xs font-bold shadow-2xs transition shrink-0"
      >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        <span>Tambah Wilayah</span>
      </a>

      <!-- Total Badge -->
      <span class="px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-700 shadow-2xs shrink-0">
        Total: {{ count($wilayah) }} Wilayah Pantauan
      </span>
    </div>
  </div>

  @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-semibold text-emerald-800 flex items-center justify-between gap-2 shadow-2xs">
      <div class="flex items-center gap-2">
        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('success') }}</span>
      </div>
      <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold text-sm leading-none">&times;</button>
    </div>
  @endif

  <!-- Wilayah Cards Grid (3 Columns) -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @php
      $wilayahDataMap = [
        'Kec. Baturraden' => [
          'lokasi' => 'Kawasan Hutan Pinus Limpakuwus, Baturraden',
          'luas' => '6.5 Ha',
          'risk' => 'Tinggi',
          'priority' => 2,
        ],
        'Kec. Sumpiuh' => [
          'lokasi' => 'Perbukitan Karet & Semak Desa Karanggedang, Sumpiuh',
          'luas' => '12.0 Ha',
          'risk' => 'Sangat Tinggi',
          'priority' => 1,
        ],
        'Kec. Karanglewas' => [
          'lokasi' => 'Lahan Kosong & Alang-alang Desa Karanglewas Kidul',
          'luas' => '1.8 Ha',
          'risk' => 'Belum Dinilai',
          'priority' => null,
        ],
        'Kec. Lumbir' => [
          'lokasi' => 'Hutan Produksi Petak 14 Desa Dermaji, Lumbir',
          'luas' => '0.9 Ha',
          'risk' => 'Rendah',
          'priority' => 4,
        ],
        'Kec. Pekuncen' => [
          'lokasi' => 'Perbukitan Hutan Jati Desa Cikembulan, Pekuncen',
          'luas' => '4.2 Ha',
          'risk' => 'Sedang',
          'priority' => 3,
        ],
        'Kec. Sumbang' => [
          'lokasi' => 'Semak Belukar Lereng Selatan Gunung Slamet Kotayasa, Sumbang',
          'luas' => '8.0 Ha',
          'risk' => 'Tinggi',
          'priority' => 2,
        ],
        'Kec. Kedungbanteng' => [
          'lokasi' => 'Hutan Lindung Petak 21 Desa Melung, Kedungbanteng',
          'luas' => '14.5 Ha',
          'risk' => 'Sangat Tinggi',
          'priority' => 1,
        ],
        'Kec. Gumelar' => [
          'lokasi' => 'Perbukitan Kering Tebing Dusun Kaliwadas Desa Cihonje, Gumelar',
          'luas' => '3.5 Ha',
          'risk' => 'Belum Dinilai',
          'priority' => null,
        ],
        'Kec. Tambak' => [
          'lokasi' => 'Lahan Perkebunan Rakyat Desa Kuntili, Tambak',
          'luas' => '1.2 Ha',
          'risk' => 'Rendah',
          'priority' => 4,
        ],
        'Kec. Somagede' => [
          'lokasi' => 'Perbukitan Pinus & Akasia Desa Klinting, Somagede',
          'luas' => '5.0 Ha',
          'risk' => 'Sedang',
          'priority' => 3,
        ],
        'Kec. Cilongok' => [
          'lokasi' => 'Hutan Lindung Tebing Curam Lereng Gunung Slamet Desa Sambirata, Cilongok',
          'luas' => '7.3 Ha',
          'risk' => 'Tinggi',
          'priority' => 2,
        ],
        'Kec. Ajibarang' => [
          'lokasi' => 'Semak Belukar Lahan Perbukitan Desa Sawangan, Ajibarang',
          'luas' => '3.8 Ha',
          'risk' => 'Sedang',
          'priority' => 3,
        ],
        'Kec. Wangon' => [
          'lokasi' => 'Kawasan Hutan Jati & Semak Ilalang Desa Windunegara, Wangon',
          'luas' => '2.1 Ha',
          'risk' => 'Rendah',
          'priority' => 4,
        ],
        'Kec. Purwojati' => [
          'lokasi' => 'Perbukitan Kering Perbatasan Desa Karangmangu, Purwojati',
          'luas' => '3.0 Ha',
          'risk' => 'Sedang',
          'priority' => 3,
        ],
      ];
    @endphp

    @forelse($wilayah as $w)
      @php
        $extra = $wilayahDataMap[$w->kecamatan] ?? [
          'lokasi' => ($w->desa_kelurahan ?? 'Wilayah') . ', ' . $w->kecamatan,
          'luas' => '2.5 Ha',
          'risk' => 'Belum Dinilai',
          'priority' => null,
        ];

        $risk = $extra['risk'];
        $priority = $extra['priority'];

        $riskBadge = match($risk) {
          'Sangat Tinggi' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-100 text-red-700">Sangat Tinggi</span>',
          'Tinggi' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">Tinggi</span>',
          'Sedang' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-700">Sedang</span>',
          'Rendah' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700">Rendah</span>',
          default => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">Belum Dinilai</span>'
        };

        $priorityBadge = match($priority) {
          1 => '<span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-[#dc2626] text-white">Prioritas 1</span>',
          2 => '<span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-[#f59e0b] text-white">Prioritas 2</span>',
          3 => '<span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-[#2563eb] text-white">Prioritas 3</span>',
          4 => '<span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-[#334155] text-white">Prioritas 4</span>',
          default => '<span class="text-[11px] font-medium text-slate-400">Menunggu</span>'
        };

        $lat = $w->latitude ?? '-7.3500';
        $lng = $w->longitude ?? '109.2000';
      @endphp

      <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex flex-col justify-between space-y-4 hover:border-slate-300 transition">
        <!-- Top Section -->
        <div class="space-y-2">
          <div class="flex items-center justify-between gap-2">
            <span class="text-xs font-bold text-slate-900">{{ $w->kecamatan }}</span>
            {!! $riskBadge !!}
          </div>
          <div class="text-xs font-semibold text-slate-800 line-clamp-2 leading-snug">
            {{ $extra['lokasi'] }}
          </div>
          <div class="text-[11px] text-slate-400">
            Koordinat: <span class="font-mono text-slate-600">{{ number_format($lat, 4) }}, {{ number_format($lng, 4) }}</span> • Luas: {{ $extra['luas'] }}
          </div>
        </div>

        <!-- Bottom Action Section -->
        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
          <div>
            {!! $priorityBadge !!}
          </div>
          <div class="flex items-center gap-1.5">
            <!-- Tombol Detail -->
            <button
              type="button"
              onclick="showWilayahModal({{ json_encode($w) }}, {{ json_encode($extra) }})"
              class="px-2.5 py-1 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-[11px] font-semibold text-slate-700 transition"
              title="Lihat Detail Wilayah"
            >
              Detail
            </button>

            <!-- Tombol Edit -->
            <a
              href="{{ route('wilayah.edit', $w->id) }}"
              class="px-2.5 py-1 rounded-lg border border-amber-200 bg-amber-50 hover:bg-amber-100 text-[11px] font-semibold text-amber-800 transition"
              title="Edit Data Wilayah"
            >
              Edit
            </a>

            <!-- Link Form Penilaian -->
            <a
              href="{{ route('penilaian-risiko.index') }}"
              class="text-xs font-semibold text-[#e03c22] hover:underline inline-flex items-center gap-0.5 ml-1 text-decoration-none"
            >
              <span>Form Penilaian</span>
              <span aria-hidden="true">&rarr;</span>
            </a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-span-3 py-12 text-center text-slate-400">
        Belum ada data wilayah pantauan karhutla.
      </div>
    @endforelse
  </div>

</main>

<!-- ==================== MODAL DETAIL WILAYAH ==================== -->
<div id="wilayahDetailModal" onclick="closeWilayahModal()" class="fixed inset-0 z-50 bg-slate-900/45 backdrop-blur-[1px] hidden items-center justify-center p-4">
  <div onclick="event.stopPropagation()" class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between gap-3">
      <div>
        <div id="modalWilayahCode" class="text-[11px] font-bold text-blue-600 uppercase tracking-wide">WILAYAH</div>
        <h3 id="modalWilayahTitle" class="text-sm sm:text-base font-bold text-slate-900">Detail Wilayah Pantauan</h3>
      </div>
      <button type="button" onclick="closeWilayahModal()" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" aria-label="Tutup">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <div id="modalWilayahBody" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto"></div>
  </div>
</div>

<script>
  function showWilayahModal(w, extra) {
    const backdrop = document.getElementById('wilayahDetailModal');
    const body = document.getElementById('modalWilayahBody');
    if (!w || !backdrop || !body) return;

    document.getElementById('modalWilayahCode').textContent = `${w.kode_wilayah || 'WILAYAH'} • BANYUMAS`;
    document.getElementById('modalWilayahTitle').textContent = `${w.kecamatan} - ${w.desa_kelurahan || ''}`;

    const riskCls = {
      'Sangat Tinggi': 'bg-red-100 text-red-700',
      'Tinggi': 'bg-amber-100 text-amber-800',
      'Sedang': 'bg-blue-100 text-blue-700',
      'Rendah': 'bg-emerald-100 text-emerald-700'
    }[extra.risk] || 'bg-slate-100 text-slate-600';

    const prioLabel = extra.priority ? `Prioritas ${extra.priority}` : 'Menunggu';
    const prioCls = {
      'Prioritas 1': 'bg-[#dc2626] text-white',
      'Prioritas 2': 'bg-[#f59e0b] text-white',
      'Prioritas 3': 'bg-[#2563eb] text-white',
      'Prioritas 4': 'bg-[#334155] text-white',
    }[prioLabel] || 'bg-slate-500 text-white';

    body.innerHTML = `
      <div class="grid grid-cols-2 gap-3">
        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
          <div class="text-[10px] font-bold text-slate-400 uppercase">Tingkat Risiko</div>
          <div class="mt-2">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold ${riskCls}">
              ${extra.risk || 'Belum Dinilai'}
            </span>
          </div>
        </div>
        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
          <div class="text-[10px] font-bold text-slate-400 uppercase">Prioritas Penanganan</div>
          <div class="mt-2">
            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold ${prioCls}">
              ${prioLabel}
            </span>
          </div>
        </div>
      </div>

      <div class="rounded-xl border border-slate-200 divide-y divide-slate-100 text-xs">
        <div class="px-4 py-3 flex justify-between gap-4">
          <span class="text-slate-500">Nama Wilayah / Titik</span>
          <span class="font-semibold text-slate-900 text-right">${extra.lokasi}</span>
        </div>
        <div class="px-4 py-3 flex justify-between gap-4">
          <span class="text-slate-500">Kecamatan</span>
          <span class="font-semibold text-slate-900">${w.kecamatan}</span>
        </div>
        <div class="px-4 py-3 flex justify-between gap-4">
          <span class="text-slate-500">Desa / Kelurahan</span>
          <span class="font-semibold text-slate-900">${w.desa_kelurahan || '-'}</span>
        </div>
        <div class="px-4 py-3 flex justify-between gap-4">
          <span class="text-slate-500">Kabupaten</span>
          <span class="font-semibold text-slate-900">${w.kabupaten || 'Banyumas'}</span>
        </div>
        <div class="px-4 py-3 flex justify-between gap-4">
          <span class="text-slate-500">Koordinat</span>
          <span class="font-mono font-medium text-slate-800">${w.latitude || '-'}, ${w.longitude || '-'}</span>
        </div>
        <div class="px-4 py-3 flex justify-between gap-4">
          <span class="text-slate-500">Estimasi Luas Rawan</span>
          <span class="font-semibold text-slate-900">${extra.luas}</span>
        </div>
      </div>

      <div class="pt-3 flex items-center justify-end gap-2.5">
        <button type="button" onclick="closeWilayahModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
          Tutup
        </button>
        <a href="/wilayah/${w.id}/edit" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-xs font-bold text-white transition">
          Edit Wilayah
        </a>
      </div>
    `;

    backdrop.classList.remove('hidden');
    backdrop.classList.add('flex');
  }

  function closeWilayahModal() {
    const backdrop = document.getElementById('wilayahDetailModal');
    if (backdrop) {
      backdrop.classList.add('hidden');
      backdrop.classList.remove('flex');
    }
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeWilayahModal();
    }
  });
</script>
@endsection
