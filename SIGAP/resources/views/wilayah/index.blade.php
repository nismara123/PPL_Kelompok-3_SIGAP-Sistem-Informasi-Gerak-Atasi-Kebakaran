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

    <div class="flex items-center gap-2">
      <a href="{{ route('wilayah.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#e03c22] hover:bg-[#c8321b] text-white text-xs font-bold shadow-sm transition">
        <span class="text-base leading-none">+</span> Tambah Wilayah
      </a>
      <span class="px-3.5 py-2 rounded-xl border border-slate-200 bg-white text-xs font-semibold text-slate-700 shadow-2xs">
        Total: {{ count($wilayah) }} Wilayah Pantauan
      </span>
    </div>
  </div>

  @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-semibold text-emerald-800 flex items-center gap-2">
      <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Pencarian Wilayah -->
<div class="bg-white border border-slate-200 rounded-xl p-3">
    
    <div class="flex flex-col sm:flex-row gap-2">
    <div class="relative flex-1">
        <svg class="absolute w-4 h-4 -translate-y-1/2 left-3 top-1/2 text-slate-400"
             fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="7"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="m16 16 4 4"/>
        </svg>

        <input
            type="text"
            id="cariWilayah"
            placeholder="Cari kecamatan, desa, atau kode wilayah..."
            class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 rounded-lg outline-none focus:border-[#e03c22] focus:ring-1 focus:ring-red-100"
        >
    </div>

    <button
        type="button"
        id="tombolCariWilayah"
        class="px-5 py-2.5 text-sm font-semibold text-white bg-[#e03c22] rounded-lg hover:bg-[#c8321b] transition"
    >
        Cari
    </button>
</div>
    <p class="mt-2 text-[11px] text-slate-500">
        Ketik nama wilayah yang ingin dicari atau diubah.
    </p>
</div>

  <!-- Wilayah Cards Grid (Banyak Titik Wilayah Rawan Karhutla Sesuai Request) -->
  <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-5">
    @php
      // Mapping data riil kejadian karhutla untuk masing-masing kecamatan di Banyumas
      $wilayahDataMap = [
        'Kec. Baturraden' => [
          'lokasi' => 'Kawasan Hutan Pinus Limpakuwus, Baturraden',
          'luas' => '6.5 Ha',
          'risk' => 'Tinggi',
          'priority' => 2,
          'report_id' => 'KARHUTLA-BMS001',
        ],
        'Kec. Sumpiuh' => [
          'lokasi' => 'Perbukitan Karet & Semak Desa Karanggedang, Sumpiuh',
          'luas' => '12.0 Ha',
          'risk' => 'Sangat Tinggi',
          'priority' => 1,
          'report_id' => 'KARHUTLA-BMS002',
        ],
        'Kec. Karanglewas' => [
          'lokasi' => 'Lahan Kosong & Alang-alang Desa Karanglewas Kidul',
          'luas' => '1.8 Ha',
          'risk' => 'Belum Dinilai',
          'priority' => null,
          'report_id' => 'KARHUTLA-BMS003',
        ],
        'Kec. Lumbir' => [
          'lokasi' => 'Hutan Produksi Petak 14 Desa Dermaji, Lumbir',
          'luas' => '0.9 Ha',
          'risk' => 'Rendah',
          'priority' => 4,
          'report_id' => 'KARHUTLA-BMS004',
        ],
        'Kec. Pekuncen' => [
          'lokasi' => 'Perbukitan Hutan Jati Desa Cikembulan, Pekuncen',
          'luas' => '4.2 Ha',
          'risk' => 'Sedang',
          'priority' => 3,
          'report_id' => 'KARHUTLA-BMS005',
        ],
        'Kec. Sumbang' => [
          'lokasi' => 'Semak Belukar Lereng Selatan Gunung Slamet Kotayasa, Sumbang',
          'luas' => '8.0 Ha',
          'risk' => 'Tinggi',
          'priority' => 2,
          'report_id' => 'KARHUTLA-BMS006',
        ],
        'Kec. Kedungbanteng' => [
          'lokasi' => 'Hutan Lindung Petak 21 Desa Melung, Kedungbanteng',
          'luas' => '14.5 Ha',
          'risk' => 'Sangat Tinggi',
          'priority' => 1,
          'report_id' => 'KARHUTLA-BMS007',
        ],
        'Kec. Gumelar' => [
          'lokasi' => 'Perbukitan Kering Tebing Dusun Kaliwadas Desa Cihonje, Gumelar',
          'luas' => '3.5 Ha',
          'risk' => 'Belum Dinilai',
          'priority' => null,
          'report_id' => 'KARHUTLA-BMS008',
        ],
        'Kec. Tambak' => [
          'lokasi' => 'Lahan Perkebunan Rakyat Desa Kuntili, Tambak',
          'luas' => '1.2 Ha',
          'risk' => 'Rendah',
          'priority' => 4,
          'report_id' => 'KARHUTLA-BMS009',
        ],
        'Kec. Somagede' => [
          'lokasi' => 'Perbukitan Pinus & Akasia Desa Klinting, Somagede',
          'luas' => '5.0 Ha',
          'risk' => 'Sedang',
          'priority' => 3,
          'report_id' => 'KARHUTLA-BMS010',
        ],
        'Kec. Cilongok' => [
          'lokasi' => 'Hutan Lindung Tebing Curam Lereng Gunung Slamet Desa Sambirata, Cilongok',
          'luas' => '7.3 Ha',
          'risk' => 'Tinggi',
          'priority' => 2,
          'report_id' => 'KARHUTLA-BMS011',
        ],
        'Kec. Ajibarang' => [
          'lokasi' => 'Semak Belukar Lahan Perbukitan Desa Sawangan, Ajibarang',
          'luas' => '3.8 Ha',
          'risk' => 'Sedang',
          'priority' => 3,
          'report_id' => 'KARHUTLA-BMS012',
        ],
        'Kec. Wangon' => [
          'lokasi' => 'Kawasan Hutan Jati & Semak Ilalang Desa Windunegara, Wangon',
          'luas' => '2.1 Ha',
          'risk' => 'Rendah',
          'priority' => 4,
          'report_id' => null,
        ],
        'Kec. Purwojati' => [
          'lokasi' => 'Perbukitan Kering Perbatasan Desa Karangmangu, Purwojati',
          'luas' => '3.0 Ha',
          'risk' => 'Sedang',
          'priority' => 3,
          'report_id' => null,
        ],
      ];
    @endphp

    @forelse($wilayah as $w)
      @php
        $extra = $wilayahDataMap[$w->kecamatan] ?? [
          'lokasi' => ($w->desa_kelurahan ?? 'Wilayah') . ', ' . $w->kecamatan,
          'luas' => '2.5 Ha',
          'risk' => 'Sedang',
          'priority' => 3,
          'report_id' => null,
        ];

        $risk = $extra['risk'];
        $priority = $extra['priority'];

        $riskBadge = match($risk) {
          'Sangat Tinggi' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-red-100 text-red-700">Sangat Tinggi</span>',
          'Tinggi' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">Tinggi</span>',
          'Sedang' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-100 text-blue-700">Sedang</span>',
          'Rendah' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700">Rendah</span>',
          default => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-600">Belum Dinilai</span>'
        };

        $priorityBadge = match($priority) {
          1 => '<span class="inline-flex items-center whitespace-nowrap px-2.5 py-1 rounded-lg text-[11px] font-bold bg-red-600 text-white">Prioritas 1</span>',
          2 => '<span class="inline-flex items-center whitespace-nowrap px-2.5 py-1 rounded-lg text-[11px] font-bold bg-amber-500 text-white">Prioritas 2</span>',
          3 => '<span class="inline-flex items-center whitespace-nowrap px-2.5 py-1 rounded-lg text-[11px] font-bold bg-blue-600 text-white">Prioritas 3</span>',
          4 => '<span class="inline-flex items-center whitespace-nowrap px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-600 text-white">Prioritas 4</span>',
          default => '<span class="text-[11px] font-medium text-slate-400">Menunggu</span>'
        };

        $lat = $w->latitude ?? '-7.3500';
        $lng = $w->longitude ?? '109.2000';
      @endphp


<div
    class="wilayah-card bg-white rounded-2xl border border-slate-200/80 p-4 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex flex-col justify-between gap-3 hover:border-slate-300 transition"
    data-search="{{ strtolower($w->kode_wilayah . ' ' . $w->kabupaten . ' ' . $w->kecamatan . ' ' . $w->desa_kelurahan) }}"
>
        <div class="space-y-2">
          <div class="flex items-center justify-between gap-2">
            <span class="text-xs font-bold text-slate-900">{{ $w->kecamatan }}</span>
            {!! $riskBadge !!}
          </div>
          <div class="text-xs font-semibold text-slate-700 line-clamp-2 leading-snug">
            {{ $extra['lokasi'] }}
          </div>
          <div class="text-[11px] text-slate-500">
            Koordinat: <span class="font-mono text-slate-600">{{ number_format($lat, 4) }}, {{ number_format($lng, 4) }}</span> • Luas: {{ $extra['luas'] }}
          </div>
        </div>

        <div class="pt-3.5 border-t border-slate-100 flex flex-wrap items-center justify-between gap-x-3 gap-y-2">
          {!! $priorityBadge !!}
          <div class="flex items-center gap-2 whitespace-nowrap">
            <button
                type="button"
                class="btn-detail-wilayah px-2.5 py-1 rounded-lg border border-slate-200 text-[11px] font-semibold text-slate-700 hover:bg-slate-50 transition"
                data-kode="{{ $w->kode_wilayah }}"
                data-kabupaten="{{ $w->kabupaten }}"
                data-kecamatan="{{ $w->kecamatan }}"
                data-desa="{{ $w->desa_kelurahan }}"
                data-kode-kabupaten="{{ $w->kode_kabupaten }}"
                data-kode-kecamatan="{{ $w->kode_kecamatan }}"
                data-kode-desa="{{ $w->kode_desa }}"
                data-latitude="{{ $w->latitude }}"
                data-longitude="{{ $w->longitude }}"
                data-lokasi="{{ $extra['lokasi'] }}"
                data-luas="{{ $extra['luas'] }}"
                data-risiko="{{ $risk }}"
                data-prioritas="{{ $priority ?? '-' }}"
            >
                Detail
            </button>
            <a href="{{ route('wilayah.edit', $w->id) }}" class="px-2.5 py-1 rounded-lg border border-amber-200 bg-amber-50 text-[11px] font-semibold text-amber-800 hover:bg-amber-100 transition">Edit</a>
            <a href="{{ route('penilaian-risiko.index') }}" class="text-xs font-semibold text-[#e03c22] hover:underline inline-flex items-center gap-1 ml-1 whitespace-nowrap">
              <span>Form Penilaian</span><span aria-hidden="true">&rarr;</span>
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
<!-- Modal Detail Wilayah -->
<div id="modalDetailWilayah"
     class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-900/50 p-4">

    <div class="w-full max-w-xl rounded-2xl bg-white shadow-2xl overflow-hidden">

        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <div>
                <h2 class="text-lg font-bold text-slate-900">
                    Detail Wilayah Karhutla
                </h2>
                <p class="text-xs text-slate-500 mt-1">
                    Informasi lengkap wilayah pantauan SIGAP
                </p>
            </div>

            <button type="button" id="tutupModalWilayah"
                    class="text-2xl text-slate-400 hover:text-slate-700">
                &times;
            </button>
        </div>

        <!-- Isi -->
        <div class="p-6 max-h-[70vh] overflow-y-auto">

            <h3 class="text-sm font-bold text-slate-800 mb-3">
                Identitas Wilayah
            </h3>

            <div class="space-y-3 text-sm">

                <div class="flex justify-between gap-4">
                    <span class="text-slate-500">Kode Wilayah</span>
                    <span id="detailKode" class="font-semibold text-slate-800 text-right">-</span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-slate-500">Kode Kabupaten</span>
                    <span id="detailKodeKabupaten" class="font-semibold text-slate-800 text-right">-</span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-slate-500">Kabupaten</span>
                    <span id="detailKabupaten" class="font-semibold text-slate-800 text-right">-</span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-slate-500">Kode Kecamatan</span>
                    <span id="detailKodeKecamatan" class="font-semibold text-slate-800 text-right">-</span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-slate-500">Kecamatan</span>
                    <span id="detailKecamatan" class="font-semibold text-slate-800 text-right">-</span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-slate-500">Kode Desa</span>
                    <span id="detailKodeDesa" class="font-semibold text-slate-800 text-right">-</span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-slate-500">Desa/Kelurahan</span>
                    <span id="detailDesa" class="font-semibold text-slate-800 text-right">-</span>
                </div>
            </div>

            <hr class="my-5 border-slate-100">

            <h3 class="text-sm font-bold text-slate-800 mb-3">
                Informasi Pantauan
            </h3>

            <div class="space-y-3 text-sm">

                <div class="flex justify-between gap-4">
                    <span class="text-slate-500">Lokasi</span>
                    <span id="detailLokasi" class="font-semibold text-slate-800 text-right max-w-[60%]">-</span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-slate-500">Luas</span>
                    <span id="detailLuas" class="font-semibold text-slate-800">-</span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-slate-500">Tingkat Risiko</span>
                    <span id="detailRisiko" class="font-semibold text-slate-800">-</span>
                </div>

                <div class="flex justify-between gap-4">
                    <span class="text-slate-500">Prioritas</span>
                    <span id="detailPrioritas" class="font-semibold text-slate-800">-</span>
                </div>
            </div>

            <hr class="my-5 border-slate-100">

            <h3 class="text-sm font-bold text-slate-800 mb-3">
                Koordinat Lokasi
            </h3>

            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-xl bg-slate-50 p-3">
                    <p class="text-xs text-slate-500">Latitude</p>
                    <p id="detailLatitude" class="mt-1 font-mono text-sm font-semibold text-slate-800">-</p>
                </div>

                <div class="rounded-xl bg-slate-50 p-3">
                    <p class="text-xs text-slate-500">Longitude</p>
                    <p id="detailLongitude" class="mt-1 font-mono text-sm font-semibold text-slate-800">-</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex justify-end border-t border-slate-100 px-6 py-4">
            <button type="button" id="tutupModalWilayahBawah"
                    class="rounded-xl bg-slate-800 px-5 py-2 text-xs font-bold text-white hover:bg-slate-700">
                Tutup
            </button>
        </div>

    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalDetailWilayah');

    const fields = {
        'detailKode': 'kode',
        'detailKodeKabupaten': 'kodeKabupaten',
        'detailKabupaten': 'kabupaten',
        'detailKodeKecamatan': 'kodeKecamatan',
        'detailKecamatan': 'kecamatan',
        'detailKodeDesa': 'kodeDesa',
        'detailDesa': 'desa',
        'detailLokasi': 'lokasi',
        'detailLuas': 'luas',
        'detailRisiko': 'risiko',
        'detailPrioritas': 'prioritas',
        'detailLatitude': 'latitude',
        'detailLongitude': 'longitude'
    };

    document.querySelectorAll('.btn-detail-wilayah').forEach(button => {
        button.addEventListener('click', function () {
            Object.entries(fields).forEach(([elementId, dataName]) => {
                const element = document.getElementById(elementId);
                element.textContent = this.dataset[dataName] || '-';
            });

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    function tutupModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('tutupModalWilayah').addEventListener('click', tutupModal);
    document.getElementById('tutupModalWilayahBawah').addEventListener('click', tutupModal);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            tutupModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            tutupModal();
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('cariWilayah');
    const cards = document.querySelectorAll('.wilayah-card');

    const hasilKosong = document.createElement('div');
    hasilKosong.className =
        'col-span-full hidden py-10 text-center text-sm text-slate-500';
    hasilKosong.textContent = 'Data wilayah yang dicari tidak ditemukan.';

    const grid = cards[0]?.parentElement;

    if (grid) {
        grid.appendChild(hasilKosong);
    }

    input.addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();
        let jumlahTampil = 0;

        cards.forEach(card => {
            const data = card.dataset.search || '';
            const cocok = data.includes(keyword);

            card.style.display = cocok ? '' : 'none';

            if (cocok) {
                jumlahTampil++;
            }
        });

        hasilKosong.classList.toggle('hidden', jumlahTampil !== 0);
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('cariWilayah');
    const cards = document.querySelectorAll('.wilayah-card');

    if (!input) return;

    const grid = cards[0]?.parentElement;

    const pesanKosong = document.createElement('div');
    pesanKosong.className =
        'col-span-full py-10 text-center text-sm text-slate-500';
    pesanKosong.textContent = 'Data wilayah tidak ditemukan.';
    pesanKosong.style.display = 'none';

    if (grid) {
        grid.appendChild(pesanKosong);
    }

    input.addEventListener('input', function () {
        const kataKunci = this.value.toLowerCase().trim();
        let jumlahHasil = 0;

        cards.forEach(function (card) {
            const data = card.dataset.search || '';
            const cocok = data.includes(kataKunci);

            card.style.display = cocok ? '' : 'none';

            if (cocok) jumlahHasil++;
        });

        if (grid) {
            pesanKosong.style.display =
                jumlahHasil === 0 ? 'block' : 'none';
        }
    });
});
</script>