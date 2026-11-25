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

      <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-[0_1px_3px_rgba(15,23,42,0.03)] flex flex-col justify-between gap-4 hover:border-slate-300 transition">
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
            <a href="{{ route('wilayah.show', $w->id) }}" class="px-2.5 py-1 rounded-lg border border-slate-200 text-[11px] font-semibold text-slate-700 hover:bg-slate-50 transition">Detail</a>
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
@endsection
