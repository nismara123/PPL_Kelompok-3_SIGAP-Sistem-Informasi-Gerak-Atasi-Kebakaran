@extends('layouts.app')

@section('title', 'Form Penilaian Risiko - ' . $laporan->kode_laporan . ' - SIGAP')

@section('content')
<main id="view-form-risiko" class="p-4 sm:p-7 max-w-[1380px] w-full mx-auto space-y-6">

  <!-- Page Header & Back Navigation (Persis Sesuai Image 1 & 2) -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
        <a href="{{ route('pusdalops.dashboard') }}" class="hover:text-slate-900 font-medium text-decoration-none">Dashboard</a>
        <span>/</span>
        <span class="text-slate-800 font-semibold">Form Penilaian Risiko Kejadian</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
        Form Pencatatan Penilaian Risiko Kejadian
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Masukkan hasil penilaian risiko kejadian baru untuk menetapkan tingkat risiko dan prioritas penanganan.
      </p>
    </div>

    <!-- Mode Switcher Pill (Sesuai Image 1 & 2) -->
    <div class="inline-flex rounded-xl border border-slate-200 bg-white p-1 self-start sm:self-center shadow-2xs">
      <span class="px-3.5 py-2 rounded-lg text-xs font-bold bg-[#e03c22] text-white">
        Catat Penilaian Baru
      </span>
      @php
        $firstAssessed = isset($semuaLaporan) ? $semuaLaporan->firstWhere('tingkat_risiko', '!=', null) : null;
        $editUrl = $firstAssessed ? route('penilaian-risiko.edit', $firstAssessed->id) : route('penilaian-risiko.index', ['tab' => 'sudah_dinilai']);
      @endphp
      <a href="{{ $editUrl }}" class="px-3.5 py-2 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition text-decoration-none">
        Perbarui Penilaian
      </a>
    </div>
  </div>

  @if($errors->any())
    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800">
      <div class="font-bold mb-1">Terjadi kesalahan pengisian form:</div>
      <ul class="list-disc list-inside space-y-0.5">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Two-Column Separated Form Layout (Sesuai Image 1 & 2) -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

    <!-- Left 7 Columns: Form Input -->
    <section class="lg:col-span-7 bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-5 sm:p-6">
      <form action="{{ route('penilaian-risiko.store', $laporan->id) }}" method="POST" class="space-y-5">
        @csrf

        <!-- 1. PILIH DATA KEJADIAN KARHUTLA (Dropdown interaktif persis Image 1 & 2) -->
        <div class="pb-4 border-b border-slate-100">
          <label for="incidentSelect" class="block text-xs font-bold text-slate-800 uppercase tracking-wide mb-2">
            1. PILIH DATA KEJADIAN KARHUTLA
          </label>
          <select
            id="incidentSelect"
            onchange="window.location.href = this.value;"
            class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-xs font-semibold text-slate-800 focus:outline-none focus:border-[#e03c22]"
          >
            @if(isset($semuaLaporan))
              @foreach($semuaLaporan as $inc)
                @php
                  $targetUrl = $inc->tingkat_risiko 
                    ? route('penilaian-risiko.edit', $inc->id) 
                    : route('penilaian-risiko.create', $inc->id);
                @endphp
                <option value="{{ $targetUrl }}" {{ $inc->id == $laporan->id ? 'selected' : '' }}>
                  {{ $inc->kode_laporan }} — {{ $inc->lokasi }} ({{ $inc->tingkat_risiko ? 'Sudah Dinilai: ' . $inc->tingkat_risiko : 'Belum Dinilai' }})
                </option>
              @endforeach
            @else
              <option value="{{ route('penilaian-risiko.create', $laporan->id) }}" selected>
                {{ $laporan->kode_laporan }} — {{ $laporan->lokasi }}
              </option>
            @endif
          </select>
        </div>

        <!-- 2. PARAMETER KONDISI LAPANGAN (Persis Image 1 & 2) -->
        <div class="space-y-4">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-slate-800 uppercase tracking-wide">2. PARAMETER KONDISI LAPANGAN</span>
            <span class="text-xs font-bold text-slate-700 tabular-nums">
              Skor Otomatis: <span id="liveScoreDisplay" class="text-[#e03c22] text-sm font-extrabold">56</span> / 100
            </span>
          </div>

          <!-- Parameter 1: Jarak ke Pemukiman -->
          <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jarak ke Pemukiman / Objek Vital</label>
            <input type="hidden" id="paramProximity" value="18" />
            <div class="grid grid-cols-3 gap-2.5" data-param-group="paramProximity">
              <button type="button" data-val="10" onclick="selectParam('paramProximity', 10)" class="param-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-left transition">
                <div class="text-xs font-bold">Jauh</div>
                <div class="text-[11px] opacity-75">&gt; 2 km (10)</div>
              </button>
              <button type="button" data-val="18" onclick="selectParam('paramProximity', 18)" class="param-btn px-3 py-2.5 rounded-xl border border-[#e03c22] bg-[#fff5f3] text-[#c8321b] text-left transition">
                <div class="text-xs font-bold">Sedang</div>
                <div class="text-[11px] opacity-75">500m–2km (18)</div>
              </button>
              <button type="button" data-val="25" onclick="selectParam('paramProximity', 25)" class="param-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-left transition">
                <div class="text-xs font-bold">Sangat Dekat</div>
                <div class="text-[11px] opacity-75">&lt; 500m (25)</div>
              </button>
            </div>
          </div>

          <!-- Parameter 2: Estimasi Luas Area -->
          <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Estimasi Luas Area Terbakar</label>
            <input type="hidden" name="estimasi_luas_terdampak" id="paramAreaInput" value="{{ $laporan->estimasi_luas_terdampak ?? '< 2 Ha' }}" />
            <input type="hidden" id="paramArea" value="10" />
            <div class="grid grid-cols-3 gap-2.5" data-param-group="paramArea">
              <button type="button" data-val="10" data-label="< 2 Ha" onclick="selectParam('paramArea', 10, '< 2 Ha')" class="param-btn px-3 py-2.5 rounded-xl border border-[#e03c22] bg-[#fff5f3] text-[#c8321b] text-left transition">
                <div class="text-xs font-bold">Kecil</div>
                <div class="text-[11px] opacity-75">&lt; 2 Ha (10)</div>
              </button>
              <button type="button" data-val="18" data-label="2–10 Ha" onclick="selectParam('paramArea', 18, '2–10 Ha')" class="param-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-left transition">
                <div class="text-xs font-bold">Menengah</div>
                <div class="text-[11px] opacity-75">2–10 Ha (18)</div>
              </button>
              <button type="button" data-val="25" data-label="> 10 Ha" onclick="selectParam('paramArea', 25, '> 10 Ha')" class="param-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-left transition">
                <div class="text-xs font-bold">Luas</div>
                <div class="text-[11px] opacity-75">&gt; 10 Ha (25)</div>
              </button>
            </div>
          </div>

          <!-- Parameter 3: Jenis Lahan -->
          <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jenis Lahan & Vegetasi</label>
            <input type="hidden" id="paramLandType" value="10" />
            <div class="grid grid-cols-3 gap-2.5" data-param-group="paramLandType">
              <button type="button" data-val="10" onclick="selectParam('paramLandType', 10)" class="param-btn px-3 py-2.5 rounded-xl border border-[#e03c22] bg-[#fff5f3] text-[#c8321b] text-left transition">
                <div class="text-xs font-bold">Semak</div>
                <div class="text-[11px] opacity-75">Terbuka (10)</div>
              </button>
              <button type="button" data-val="18" onclick="selectParam('paramLandType', 18)" class="param-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-left transition">
                <div class="text-xs font-bold">Hutan Pinus</div>
                <div class="text-[11px] opacity-75">Produksi (18)</div>
              </button>
              <button type="button" data-val="25" onclick="selectParam('paramLandType', 25)" class="param-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-left transition">
                <div class="text-xs font-bold">Gambut / Lindung</div>
                <div class="text-[11px] opacity-75">Kritis (25)</div>
              </button>
            </div>
          </div>

          <!-- Parameter 4: Kondisi Cuaca -->
          <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kondisi Cuaca & Kecepatan Angin</label>
            <input type="hidden" id="paramWeather" value="18" />
            <div class="grid grid-cols-3 gap-2.5" data-param-group="paramWeather">
              <button type="button" data-val="10" onclick="selectParam('paramWeather', 10)" class="param-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-left transition">
                <div class="text-xs font-bold">Normal</div>
                <div class="text-[11px] opacity-75">Angin Lemah (10)</div>
              </button>
              <button type="button" data-val="18" onclick="selectParam('paramWeather', 18)" class="param-btn px-3 py-2.5 rounded-xl border border-[#e03c22] bg-[#fff5f3] text-[#c8321b] text-left transition">
                <div class="text-xs font-bold">Kering</div>
                <div class="text-[11px] opacity-75">Angin Sedang (18)</div>
              </button>
              <button type="button" data-val="25" onclick="selectParam('paramWeather', 25)" class="param-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-left transition">
                <div class="text-xs font-bold">Ekstrem</div>
                <div class="text-[11px] opacity-75">Angin Kencang (25)</div>
              </button>
            </div>
          </div>
        </div>

        <!-- 3. PENETAPAN TINGKAT RISIKO & PRIORITAS (Persis Image 1 & 2) -->
        <div class="pt-4 border-t border-slate-100 space-y-4">
          <div class="text-xs font-bold text-slate-800 uppercase tracking-wide">3. PENETAPAN TINGKAT RISIKO & PRIORITAS</div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="riskLevelInput" class="block text-xs font-semibold text-slate-700 mb-1.5">Tingkat Risiko Kejadian</label>
              <select
                id="riskLevelInput"
                name="tingkat_risiko"
                onchange="syncPriority()"
                required
                class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-xs font-bold text-slate-900 focus:outline-none focus:border-[#e03c22]"
              >
                <option value="Sangat Tinggi" {{ old('tingkat_risiko') === 'Sangat Tinggi' ? 'selected' : '' }}>Sangat Tinggi</option>
                <option value="Tinggi" {{ old('tingkat_risiko') === 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                <option value="Sedang" {{ old('tingkat_risiko', 'Sedang') === 'Sedang' ? 'selected' : '' }} selected>Sedang</option>
                <option value="Rendah" {{ old('tingkat_risiko') === 'Rendah' ? 'selected' : '' }}>Rendah</option>
              </select>
            </div>

            <div>
              <label for="priorityInput" class="block text-xs font-semibold text-slate-700 mb-1.5">Prioritas Penanganan</label>
              <select
                id="priorityInput"
                name="prioritas_penanganan"
                required
                class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2.5 text-xs font-bold text-slate-900 focus:outline-none focus:border-[#e03c22]"
              >
                <option value="1" {{ old('prioritas_penanganan') == '1' ? 'selected' : '' }}>Prioritas 1 (Darurat)</option>
                <option value="2" {{ old('prioritas_penanganan') == '2' ? 'selected' : '' }}>Prioritas 2 (Mendesak)</option>
                <option value="3" {{ old('prioritas_penanganan', '3') == '3' ? 'selected' : '' }} selected>Prioritas 3 (Terjadwal)</option>
                <option value="4" {{ old('prioritas_penanganan') == '4' ? 'selected' : '' }}>Prioritas 4 (Pantau)</option>
              </select>
            </div>
          </div>

          <div>
            <label for="assessmentNotes" class="block text-xs font-semibold text-slate-700 mb-1.5">Catatan Hasil Penilaian & Arahan Lapangan</label>
            <textarea
              id="assessmentNotes"
              name="catatan_penilaian"
              rows="3"
              placeholder="Tuliskan arah rambatan api, jarak ke permukiman, sumber air terdekat, atau rekomendasi pengerahan regu..."
              class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#e03c22]"
            >{{ old('catatan_penilaian', $laporan->catatan_penilaian) }}</textarea>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
          <a
            href="{{ route('pusdalops.dashboard') }}"
            class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition text-decoration-none"
          >
            &larr; Kembali ke Dashboard
          </a>

          <button
            type="submit"
            class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-[#e03c22] hover:bg-[#c53019] transition shadow-2xs"
          >
            Simpan Hasil Penilaian
          </button>
        </div>
      </form>
    </section>

    <!-- Right 5 Columns: Side Cards (Persis Sesuai Image 1 & 2) -->
    <aside class="lg:col-span-5 space-y-5">
      <!-- Card A: DATA KEJADIAN TERPILIH -->
      <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-5 space-y-4">
        <div class="flex items-center justify-between gap-2 pb-3 border-b border-slate-100">
          <div>
            <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">DATA KEJADIAN TERPILIH</div>
            <div class="text-sm font-extrabold text-blue-600 mt-0.5">{{ $laporan->kode_laporan }}</div>
          </div>
          @if($laporan->status === 'Terverifikasi' || $laporan->status === 'Disetujui')
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">
              Terverifikasi
            </span>
          @else
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-100 text-amber-800">
              Menunggu
            </span>
          @endif
        </div>

        <div class="space-y-2.5 text-xs">
          <div>
            <div class="text-[11px] text-slate-400">Lokasi Kejadian</div>
            <div class="font-bold text-slate-900 mt-0.5">{{ $laporan->lokasi }}</div>
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <div class="text-[11px] text-slate-400">Wilayah Kecamatan</div>
              @php
                $dist = str_contains($laporan->lokasi, 'Baturraden') ? 'Kec. Baturraden'
                  : (str_contains($laporan->lokasi, 'Sumpiuh') ? 'Kec. Sumpiuh'
                  : (str_contains($laporan->lokasi, 'Karanglewas') ? 'Kec. Karanglewas'
                  : (str_contains($laporan->lokasi, 'Lumbir') ? 'Kec. Lumbir'
                  : 'Kab. Banyumas')));
              @endphp
              <div class="font-semibold text-slate-800 mt-0.5">{{ $dist }}</div>
            </div>
            <div>
              <div class="text-[11px] text-slate-400">Estimasi Luas</div>
              <div class="font-semibold text-slate-800 mt-0.5">{{ $laporan->estimasi_luas_terdampak ?? '1.8 Ha' }}</div>
            </div>
          </div>
          <div>
            <div class="text-[11px] text-slate-400">Laporan Kondisi Lapangan</div>
            <p class="text-slate-600 leading-relaxed mt-0.5 bg-slate-50 p-3 rounded-xl border border-slate-200/70">
              {{ $laporan->deskripsi }}
            </p>
          </div>
        </div>
      </div>

      <!-- Card B: STATUS PENILAIAN RISIKO (Persis Image 1 & 2) -->
      <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-5 space-y-4">
        <div class="pb-3 border-b border-slate-100">
          <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">STATUS PENILAIAN RISIKO</div>
          <div class="text-sm font-bold text-slate-800 mt-0.5">
            Belum Ada Hasil Penilaian Tersimpan
          </div>
        </div>
        <p class="text-xs text-slate-500 leading-relaxed">
          Kejadian <strong class="text-slate-800">{{ $laporan->kode_laporan }}</strong> belum memiliki hasil penilaian risiko. Silakan lengkapi parameter di sebelah kiri lalu tekan <strong class="text-slate-800">Simpan Hasil Penilaian</strong>.
        </p>
      </div>
    </aside>

  </div>
</main>

<script>
  function selectParam(paramId, value, label) {
    const hidden = document.getElementById(paramId);
    if (hidden) hidden.value = value;

    if (label && paramId === 'paramArea') {
      const areaInput = document.getElementById('paramAreaInput');
      if (areaInput) areaInput.value = label;
    }

    const group = document.querySelector(`[data-param-group="${paramId}"]`);
    if (group) {
      group.querySelectorAll('.param-btn').forEach(btn => {
        const btnVal = Number(btn.getAttribute('data-val'));
        if (btnVal === Number(value)) {
          btn.className = 'param-btn px-3 py-2.5 rounded-xl border border-[#e03c22] bg-[#fff5f3] text-[#c8321b] text-left transition';
        } else {
          btn.className = 'param-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-left transition';
        }
      });
    }

    updateLiveScore();
  }

  function updateLiveScore() {
    const p1 = Number(document.getElementById('paramProximity').value || 0);
    const p2 = Number(document.getElementById('paramArea').value || 0);
    const p3 = Number(document.getElementById('paramLandType').value || 0);
    const p4 = Number(document.getElementById('paramWeather').value || 0);
    const total = p1 + p2 + p3 + p4;

    const display = document.getElementById('liveScoreDisplay');
    if (display) display.textContent = total;

    let recRisk = 'Rendah';
    let recPrio = '4';

    if (total >= 86) {
      recRisk = 'Sangat Tinggi';
      recPrio = '1';
    } else if (total >= 70) {
      recRisk = 'Tinggi';
      recPrio = '2';
    } else if (total >= 52) {
      recRisk = 'Sedang';
      recPrio = '3';
    }

    const riskSelect = document.getElementById('riskLevelInput');
    const prioSelect = document.getElementById('priorityInput');
    if (riskSelect) riskSelect.value = recRisk;
    if (prioSelect) prioSelect.value = recPrio;
  }

  function syncPriority() {
    const risk = document.getElementById('riskLevelInput').value;
    const map = {
      'Sangat Tinggi': '1',
      'Tinggi': '2',
      'Sedang': '3',
      'Rendah': '4'
    };
    const prioSelect = document.getElementById('priorityInput');
    if (prioSelect && map[risk]) prioSelect.value = map[risk];
  }
</script>
@endsection
