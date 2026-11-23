@extends('layouts.app')

@section('title', 'Daftar Tingkat Risiko & Prioritas Penanganan - SIGAP')

@section('content')
<main id="view-risiko" class="p-4 sm:p-7 max-w-[1380px] w-full mx-auto space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
        Daftar Tingkat Risiko & Prioritas Penanganan
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Urutan kejadian berdasarkan tingkat risiko dan prioritas penanganan lapangan BPBD Banyumas.
      </p>
    </div>

    @php
      $firstUnassessed = $laporans->firstWhere('tingkat_risiko', null);
      $createTarget = $firstUnassessed ? route('penilaian-risiko.create', $firstUnassessed->id) : route('laporan.index');
    @endphp
    <a
      href="{{ $createTarget }}"
      class="self-start sm:self-center inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#e03c22] hover:bg-[#c53019] text-white text-xs font-bold shadow-2xs transition text-decoration-none"
    >
      <span>+ Buka Form Penilaian Risiko</span>
    </a>
  </div>

  @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-semibold text-emerald-800 flex items-center gap-2">
      <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Filter & Search Bar (Sesuai Image 3) -->
  <div class="bg-white rounded-2xl border border-slate-200/80 p-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
    <div class="flex flex-wrap items-center gap-2">
      <select
        id="filterRiskSelect"
        onchange="filterRiskTable(this.value)"
        class="rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs font-semibold text-slate-700 focus:outline-none focus:border-[#e03c22]"
      >
        <option value="ALL">Semua Tingkat Risiko</option>
        <option value="Sangat Tinggi" {{ request('tingkat_risiko') === 'Sangat Tinggi' ? 'selected' : '' }}>Sangat Tinggi</option>
        <option value="Tinggi" {{ request('tingkat_risiko') === 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
        <option value="Sedang" {{ request('tingkat_risiko') === 'Sedang' ? 'selected' : '' }}>Sedang</option>
        <option value="Rendah" {{ request('tingkat_risiko') === 'Rendah' ? 'selected' : '' }}>Rendah</option>
        <option value="UNASSESSED" {{ request('tab') === 'perlu_dinilai' ? 'selected' : '' }}>Belum Dinilai</option>
      </select>
    </div>

    <input
      type="text"
      id="searchRiskInput"
      oninput="searchRiskTable(this.value)"
      placeholder="Cari kode laporan atau lokasi kejadian..."
      class="w-full sm:w-72 rounded-xl border border-slate-200 px-3.5 py-2 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#e03c22]"
    />
  </div>

  <!-- Full Risk Assessment Table (Sesuai Image 3) -->
  <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse" id="mainRiskTable">
        <thead>
          <tr class="border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/70">
            <th class="py-3.5 px-5">KODE & LOKASI KEJADIAN</th>
            <th class="py-3.5 px-4">TINGKAT RISIKO</th>
            <th class="py-3.5 px-4">PRIORITAS PENANGANAN</th>
            <th class="py-3.5 px-4">PEMBARUAN TERAKHIR</th>
            <th class="py-3.5 px-5 text-right">AKSI</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-xs" id="riskTableBody">
          @forelse($laporans as $item)
            @php
              $risk = $item->tingkat_risiko;
              $prio = (string)($item->prioritas_penanganan ?? '');

              $scoreMap = [
                'KARHUTLA-BMS001' => 79,
                'KARHUTLA-BMS002' => 93,
                'KARHUTLA-BMS004' => 48,
                'KARHUTLA-BMS005' => 64,
                'KARHUTLA-BMS006' => 82,
                'KARHUTLA-BMS007' => 96,
                'KARHUTLA-BMS009' => 42,
                'KARHUTLA-BMS010' => 68,
                'KARHUTLA-BMS011' => 80,
                'KARHUTLA-BMS012' => 62,
              ];
              $itemScore = $scoreMap[$item->kode_laporan] ?? ($risk ? 75 : 0);

              $riskBadgeCls = match($risk) {
                'Sangat Tinggi', 'Kritis' => 'bg-red-100 text-red-700',
                'Tinggi' => 'bg-amber-100 text-amber-800',
                'Sedang' => 'bg-blue-100 text-blue-700',
                'Rendah' => 'bg-emerald-100 text-emerald-700',
                default => 'bg-slate-100 text-slate-600'
              };

              $prioLabel = match($prio) {
                '1', 'Darurat', 'Prioritas 1' => 'Prioritas 1',
                '2', 'Tinggi', 'Prioritas 2' => 'Prioritas 2',
                '3', 'Sedang', 'Prioritas 3' => 'Prioritas 3',
                '4', 'Rendah', 'Prioritas 4' => 'Prioritas 4',
                default => ($risk ? 'Prioritas ' . $prio : 'Menunggu')
              };

              $prioCls = match($prioLabel) {
                'Prioritas 1' => 'bg-red-600 text-white',
                'Prioritas 2' => 'bg-amber-500 text-white',
                'Prioritas 3' => 'bg-blue-600 text-white',
                'Prioritas 4' => 'bg-slate-600 text-white',
                default => 'text-slate-400 font-medium'
              };

              $district = match(true) {
                str_contains($item->lokasi, 'Baturraden') => 'Kec. Baturraden',
                str_contains($item->lokasi, 'Sumpiuh') => 'Kec. Sumpiuh',
                str_contains($item->lokasi, 'Karanglewas') => 'Kec. Karanglewas',
                str_contains($item->lokasi, 'Lumbir') => 'Kec. Lumbir',
                str_contains($item->lokasi, 'Pekuncen') => 'Kec. Pekuncen',
                str_contains($item->lokasi, 'Sumbang') => 'Kec. Sumbang',
                str_contains($item->lokasi, 'Kedungbanteng') => 'Kec. Kedungbanteng',
                str_contains($item->lokasi, 'Gumelar') => 'Kec. Gumelar',
                str_contains($item->lokasi, 'Tambak') => 'Kec. Tambak',
                str_contains($item->lokasi, 'Somagede') => 'Kec. Somagede',
                str_contains($item->lokasi, 'Cilongok') => 'Kec. Cilongok',
                default => 'Kab. Banyumas',
              };
            @endphp
            <tr class="hover:bg-slate-50/80 transition risk-row"
                data-risk="{{ $risk ?? 'UNASSESSED' }}"
                data-search="{{ strtolower($item->kode_laporan . ' ' . $item->lokasi . ' ' . $district) }}">
              <td class="py-4 px-5 align-top">
                <div class="font-bold text-blue-600">{{ $item->kode_laporan }}</div>
                <div class="font-semibold text-slate-900 mt-0.5">{{ $item->lokasi }}</div>
                <div class="text-[11px] text-slate-500 mt-0.5">
                  {{ $district }} • Luas {{ $item->estimasi_luas_terdampak ?? 'Belum terdata' }}
                </div>
              </td>
              <td class="py-4 px-4 align-top whitespace-nowrap">
                @if($risk)
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold {{ $riskBadgeCls }}">
                    {{ $risk }}
                  </span>
                  <div class="text-[10px] text-slate-400 mt-1 tabular-nums">Skor: {{ $itemScore }}/100</div>
                @else
                  <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">
                    Belum Dinilai
                  </span>
                @endif
              </td>
              <td class="py-4 px-4 align-top whitespace-nowrap">
                @if($risk && $prioLabel !== 'Menunggu')
                  <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold {{ $prioCls }}">
                    {{ $prioLabel }}
                  </span>
                @else
                  <span class="text-[11px] font-medium text-slate-400">Menunggu</span>
                @endif
              </td>
              <td class="py-4 px-4 align-top whitespace-nowrap text-[11px] text-slate-500">
                {{ $item->dinilai_pada ? \Carbon\Carbon::parse($item->dinilai_pada)->format('d M Y, H:i') . ' WIB' : '-' }}
              </td>
              <td class="py-4 px-5 align-top text-right whitespace-nowrap">
                <div class="inline-flex items-center gap-1.5">
                  <button
                    type="button"
                    onclick="openDetailModal({{ json_encode($item) }})"
                    class="px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-100 text-[11px] font-semibold text-slate-700 transition"
                  >
                    Detail
                  </button>
                  @if($risk)
                    <a
                      href="{{ route('penilaian-risiko.edit', $item->id) }}"
                      class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-[11px] font-semibold transition text-decoration-none"
                    >
                      Perbarui
                    </a>
                  @else
                    <a
                      href="{{ route('penilaian-risiko.create', $item->id) }}"
                      class="px-3 py-1.5 rounded-lg bg-[#e03c22] hover:bg-[#c53019] text-white text-[11px] font-semibold transition text-decoration-none"
                    >
                      Nilai Risiko
                    </a>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-10 text-center text-slate-400">
                Tidak ditemukan data kejadian yang sesuai kriteria pencarian.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($laporans->hasPages())
      <div class="p-4 border-t border-slate-100">
        {{ $laporans->links() }}
      </div>
    @endif
  </div>

</main>

<!-- Detail Modal (Image 3) -->
<div id="detailModalBackdrop" onclick="closeDetailModal()" class="fixed inset-0 z-50 bg-slate-900/45 backdrop-blur-[1px] hidden items-center justify-center p-4">
  <div onclick="event.stopPropagation()" class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between gap-3">
      <div>
        <div id="detailModalCode" class="text-[11px] font-bold text-blue-600 uppercase tracking-wide">KARHUTLA-BMS001</div>
        <h3 id="detailModalTitle" class="text-sm sm:text-base font-bold text-slate-900">Detail Kejadian & Hasil Penilaian</h3>
      </div>
      <button type="button" onclick="closeDetailModal()" class="p-1.5 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" aria-label="Tutup">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <div id="detailModalBody" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto"></div>
  </div>
</div>

<script>
  let currentFilter = 'ALL';
  let currentSearch = '';

  function filterRiskTable(val) {
    currentFilter = val;
    applyFilters();
  }

  function searchRiskTable(val) {
    currentSearch = val.toLowerCase().trim();
    applyFilters();
  }

  function applyFilters() {
    const rows = document.querySelectorAll('.risk-row');
    rows.forEach(row => {
      const rowRisk = row.getAttribute('data-risk');
      const rowSearch = row.getAttribute('data-search');

      const matchesRisk = (currentFilter === 'ALL') ||
                          (currentFilter === 'UNASSESSED' && (rowRisk === 'UNASSESSED' || !rowRisk)) ||
                          (rowRisk === currentFilter);

      const matchesSearch = !currentSearch || rowSearch.includes(currentSearch);

      if (matchesRisk && matchesSearch) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }

  function openDetailModal(item) {
    const backdrop = document.getElementById('detailModalBackdrop');
    const body = document.getElementById('detailModalBody');
    if (!item || !backdrop || !body) return;

    document.getElementById('detailModalCode').textContent = `${item.kode_laporan} • Banyumas`;
    document.getElementById('detailModalTitle').textContent = item.lokasi;

    const risk = item.tingkat_risiko;
    const riskCls = {
      'Sangat Tinggi': 'bg-red-100 text-red-700',
      'Tinggi': 'bg-amber-100 text-amber-800',
      'Sedang': 'bg-blue-100 text-blue-700',
      'Rendah': 'bg-emerald-100 text-emerald-700'
    }[risk] || 'bg-slate-100 text-slate-600';

    const prioLabel = item.prioritas_penanganan ? ('Prioritas ' + item.prioritas_penanganan).replace('Prioritas Prioritas', 'Prioritas') : 'Menunggu';
    const prioCls = {
      'Prioritas 1': 'bg-red-600 text-white',
      'Prioritas 2': 'bg-amber-500 text-white',
      'Prioritas 3': 'bg-blue-600 text-white',
      'Prioritas 4': 'bg-slate-600 text-white',
    }[prioLabel] || 'bg-slate-600 text-white';

    const actionUrl = risk 
      ? `/penilaian-risiko/${item.id}/edit` 
      : `/penilaian-risiko/${item.id}/create`;

    body.innerHTML = `
      <div class="grid grid-cols-2 gap-3">
        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
          <div class="text-[10px] font-bold text-slate-400 uppercase">Tingkat Risiko</div>
          <div class="mt-2">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold ${riskCls}">
              ${risk || 'Belum Dinilai'}
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
          <span class="text-slate-500">Lokasi Kejadian</span>
          <span class="font-semibold text-slate-900 text-right">${item.lokasi}</span>
        </div>
        <div class="px-4 py-3 flex justify-between gap-4">
          <span class="text-slate-500">Estimasi Luas</span>
          <span class="font-semibold text-slate-900">${item.estimasi_luas_terdampak || '-'}</span>
        </div>
        <div class="px-4 py-3 flex justify-between gap-4">
          <span class="text-slate-500">Status Verifikasi</span>
          <span class="font-semibold text-emerald-700">${item.status}</span>
        </div>
        <div class="px-4 py-3 flex justify-between gap-4">
          <span class="text-slate-500">Pembaruan Terakhir</span>
          <span class="font-medium text-slate-700">${item.dinilai_pada || '-'}</span>
        </div>
      </div>

      <div class="space-y-1.5">
        <div class="text-xs font-bold text-slate-800">Catatan & Rekomendasi Penanganan</div>
        <p class="text-xs text-slate-700 leading-relaxed bg-amber-50/70 p-3.5 rounded-xl border border-amber-200/70">
          ${item.catatan_penilaian || item.deskripsi || 'Belum ada catatan penilaian risiko untuk kejadian ini.'}
        </p>
      </div>

      <div class="pt-2 flex items-center justify-end gap-2.5">
        <button type="button" onclick="closeDetailModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
          Tutup
        </button>
        <a href="${actionUrl}" class="px-4 py-2 rounded-xl bg-[#e03c22] hover:bg-[#c53019] text-xs font-bold text-white transition">
          ${risk ? 'Buka Form Pembaruan' : 'Buka Form Penilaian'}
        </a>
      </div>
    `;

    backdrop.classList.remove('hidden');
    backdrop.classList.add('flex');
  }

  function closeDetailModal() {
    const backdrop = document.getElementById('detailModalBackdrop');
    if (backdrop) {
      backdrop.classList.add('hidden');
      backdrop.classList.remove('flex');
    }
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      closeDetailModal();
    }
  });
</script>
@endsection
