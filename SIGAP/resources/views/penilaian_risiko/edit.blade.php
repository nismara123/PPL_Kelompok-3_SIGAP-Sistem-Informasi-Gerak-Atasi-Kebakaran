@extends('layouts.app')

@section('title', 'Edit Penilaian Risiko - ' . $laporan->kode_laporan . ' - SIGAP')

@section('content')
<main id="view-form-risiko" class="p-4 sm:p-7 max-w-[1380px] w-full mx-auto space-y-6">

  <!-- Page Header & Back Navigation -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
        <a href="{{ route('pusdalops.dashboard') }}" class="hover:text-slate-900 font-medium text-decoration-none">Dashboard</a>
        <span>/</span>
        <a href="{{ route('penilaian-risiko.index') }}" class="hover:text-slate-900 font-medium text-decoration-none">Daftar Risiko</a>
        <span>/</span>
        <span class="text-slate-800 font-semibold">Edit Penilaian Risiko</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
        Edit Penilaian Risiko Kejadian Karhutla
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Ubah hasil penilaian risiko kejadian sesuai kondisi lapangan terbaru dan simpan perubahannya.
      </p>
    </div>

    <!-- Mode Switcher Pill (Sesuai Image 1 & 2) -->
    <div class="inline-flex rounded-xl border border-slate-200 bg-white p-1 self-start sm:self-center shadow-2xs">
      @php
        $firstUnassessed = isset($semuaLaporan) ? $semuaLaporan->firstWhere('tingkat_risiko', null) : null;
        $createUrl = $firstUnassessed ? route('penilaian-risiko.create', $firstUnassessed->id) : route('penilaian-risiko.index', ['tab' => 'perlu_dinilai']);
      @endphp
      <a href="{{ $createUrl }}" class="px-3.5 py-2 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition text-decoration-none">
        Catat Penilaian Baru
      </a>
      <span class="px-3.5 py-2 rounded-lg text-xs font-bold bg-[#e03c22] text-white">
        Perbarui Penilaian
      </span>
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

  <!-- Two-Column Separated Form Layout -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

    <!-- Left 7 Columns: Dedicated Risk Assessment Form -->
    <section class="lg:col-span-7 bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-5 sm:p-6">
      <form action="{{ route('penilaian-risiko.update', $laporan->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        <!-- Step 1: PILIH DATA KEJADIAN KARHUTLA (Dropdown interaktif persis Image 1 & 2) -->
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
              <option value="{{ route('penilaian-risiko.edit', $laporan->id) }}" selected>
                {{ $laporan->kode_laporan }} — {{ $laporan->lokasi }}
              </option>
            @endif
          </select>
        </div>

        <!-- Step 2: Parameter Penilaian Lapangan -->
        <div class="space-y-4">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-slate-800 uppercase tracking-wide">2. Parameter Kondisi Lapangan</span>
            <span class="text-xs font-bold text-slate-700 tabular-nums">
              Skor Otomatis: <span id="liveScoreDisplay" class="text-[#e03c22] text-sm font-extrabold">79</span> / 100
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

          <!-- Parameter 2: Estimasi Luas -->
          <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Estimasi Luas Area Terbakar</label>
            <input type="hidden" name="estimasi_luas_terdampak" id="paramAreaInput" value="{{ $laporan->estimasi_luas_terdampak ?? '2–10 Ha' }}" />
            <input type="hidden" id="paramArea" value="18" />
            <div class="grid grid-cols-3 gap-2.5" data-param-group="paramArea">
              <button type="button" data-val="10" data-label="< 2 Ha" onclick="selectParam('paramArea', 10, '< 2 Ha')" class="param-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-left transition">
                <div class="text-xs font-bold">Kecil</div>
                <div class="text-[11px] opacity-75">&lt; 2 Ha (10)</div>
              </button>
              <button type="button" data-val="18" data-label="2–10 Ha" onclick="selectParam('paramArea', 18, '2–10 Ha')" class="param-btn px-3 py-2.5 rounded-xl border border-[#e03c22] bg-[#fff5f3] text-[#c8321b] text-left transition">
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
            <input type="hidden" id="paramLandType" value="18" />
            <div class="grid grid-cols-3 gap-2.5" data-param-group="paramLandType">
              <button type="button" data-val="10" onclick="selectParam('paramLandType', 10)" class="param-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-left transition">
                <div class="text-xs font-bold">Semak</div>
                <div class="text-[11px] opacity-75">Terbuka (10)</div>
              </button>
              <button type="button" data-val="18" onclick="selectParam('paramLandType', 18)" class="param-btn px-3 py-2.5 rounded-xl border border-[#e03c22] bg-[#fff5f3] text-[#c8321b] text-left transition">
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
            <input type="hidden" id="paramWeather" value="25" />
            <div class="grid grid-cols-3 gap-2.5" data-param-group="paramWeather">
              <button type="button" data-val="10" onclick="selectParam('paramWeather', 10)" class="param-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-left transition">
                <div class="text-xs font-bold">Normal</div>
                <div class="text-[11px] opacity-75">Angin Lemah (10)</div>
              </button>
              <button type="button" data-val="18" onclick="selectParam('paramWeather', 18)" class="param-btn px-3 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-left transition">
                <div class="text-xs font-bold">Kering</div>
                <div class="text-[11px] opacity-75">Angin Sedang (18)</div>
              </button>
              <button type="button" data-val="25" onclick="selectParam('paramWeather', 25)" class="param-btn px-3 py-2.5 rounded-xl border border-[#e03c22] bg-[#fff5f3] text-[#c8321b] text-left transition">
                <div class="text-xs font-bold">Ekstrem</div>
                <div class="text-[11px] opacity-75">Angin Kencang (25)</div>
              </button>
            </div>
          </div>
        </div>

        <!-- Step 3: Penetapan Tingkat Risiko & Prioritas -->
        <div class="pt-4 border-t border-slate-100 space-y-4">
          <div class="text-xs font-bold text-slate-800 uppercase tracking-wide">3. Penetapan Tingkat Risiko & Prioritas</div>

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
                <option value="Sangat Tinggi" {{ old('tingkat_risiko', $laporan->tingkat_risiko) === 'Sangat Tinggi' ? 'selected' : '' }}>Sangat Tinggi</option>
                <option value="Tinggi" {{ old('tingkat_risiko', $laporan->tingkat_risiko) === 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                <option value="Sedang" {{ old('tingkat_risiko', $laporan->tingkat_risiko) === 'Sedang' ? 'selected' : '' }}>Sedang</option>
                <option value="Rendah" {{ old('tingkat_risiko', $laporan->tingkat_risiko) === 'Rendah' ? 'selected' : '' }}>Rendah</option>
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
                <option value="1" {{ old('prioritas_penanganan', $laporan->prioritas_penanganan) == '1' || old('prioritas_penanganan', $laporan->prioritas_penanganan) === 'Darurat' ? 'selected' : '' }}>Prioritas 1 (Darurat)</option>
                <option value="2" {{ old('prioritas_penanganan', $laporan->prioritas_penanganan) == '2' || old('prioritas_penanganan', $laporan->prioritas_penanganan) === 'Tinggi' ? 'selected' : '' }}>Prioritas 2 (Mendesak)</option>
                <option value="3" {{ old('prioritas_penanganan', $laporan->prioritas_penanganan) == '3' || old('prioritas_penanganan', $laporan->prioritas_penanganan) === 'Sedang' ? 'selected' : '' }}>Prioritas 3 (Terjadwal)</option>
                <option value="4" {{ old('prioritas_penanganan', $laporan->prioritas_penanganan) == '4' || old('prioritas_penanganan', $laporan->prioritas_penanganan) === 'Rendah' ? 'selected' : '' }}>Prioritas 4 (Pantau)</option>
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

          <div>
            <label for="alasanPembaruan" class="block text-xs font-semibold text-slate-700 mb-1.5">Alasan Pembaruan (Audit Log)</label>
            <input
              type="text"
              id="alasanPembaruan"
              name="alasan_pembaruan"
              placeholder="Misal: Perubahan arah angin kencang, eskalasi rambatan api..."
              value="{{ old('alasan_pembaruan') }}"
              class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-xs text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-[#e03c22]"
            />
          </div>
        </div>

        <!-- Form Actions -->
        <div class="pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3">
          <a
            href="{{ route('penilaian-risiko.index') }}"
            class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition text-decoration-none"
          >
            &larr; Kembali ke Daftar
          </a>

          <button
            type="submit"
            class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 transition shadow-2xs"
          >
            Simpan Perubahan Penilaian
          </button>
        </div>
      </form>
    </section>

    <!-- Right 5 Columns: Ringkasan Data Kejadian & Hasil Tersimpan -->
    <aside class="lg:col-span-5 space-y-5">
      <!-- Card A: Ringkasan Data Kejadian -->
      <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-5 space-y-4">
        <div class="flex items-center justify-between gap-2 pb-3 border-b border-slate-100">
          <div>
            <div class="text-[10px] font-bold tracking-wider text-slate-400 uppercase">DATA KEJADIAN TERPILIH</div>
            <div class="text-sm font-extrabold text-blue-600 mt-0.5">{{ $laporan->kode_laporan }}</div>
          </div>
          <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700">
            {{ $laporan->status }}
          </span>
        </div>

        <div class="space-y-2.5 text-xs">
          <div>
            <div class="text-[11px] text-slate-400">Lokasi Kejadian</div>
            <div class="font-bold text-slate-900 mt-0.5">{{ $laporan->lokasi }}</div>
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <div class="text-[11px] text-slate-400">Waktu Lapor</div>
              <div class="font-semibold text-slate-800 mt-0.5">{{ \Carbon\Carbon::parse($laporan->waktu_kejadian ?? $laporan->created_at)->format('d M Y, H:i') }} WIB</div>
            </div>
            <div>
              <div class="text-[11px] text-slate-400">Estimasi Luas</div>
              <div class="font-semibold text-slate-800 mt-0.5">{{ $laporan->estimasi_luas_terdampak ?? 'Belum terdata' }}</div>
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

      <!-- Card B: Hasil Penilaian Risiko yang Telah Disimpan -->
      <div class="bg-white rounded-2xl border border-slate-200/80 shadow-[0_1px_3px_rgba(15,23,42,0.03)] p-5 space-y-4">
        <div class="flex items-center justify-between gap-2 pb-3 border-b border-slate-100">
          <div>
            <div class="text-[10px] font-bold tracking-wider text-emerald-600 uppercase">HASIL PENILAIAN SEBELUMNYA</div>
            <div class="text-xs font-semibold text-slate-500 mt-0.5">
              Diperbarui: {{ $laporan->dinilai_pada ? \Carbon\Carbon::parse($laporan->dinilai_pada)->format('d M Y, H:i') . ' WIB' : '-' }}
            </div>
          </div>
          <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-bold">Tersimpan</span>
        </div>

        <div class="grid grid-cols-2 gap-3">
          <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
            <div class="text-[10px] font-bold text-slate-400 uppercase">Tingkat Risiko</div>
            <div class="mt-2">
              <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">
                {{ $laporan->tingkat_risiko ?? 'Belum Dinilai' }}
              </span>
            </div>
          </div>
          <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80">
            <div class="text-[10px] font-bold text-slate-400 uppercase">Prioritas Penanganan</div>
            <div class="mt-2">
              <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-amber-500 text-white">
                Prioritas {{ $laporan->prioritas_penanganan ?? '-' }}
              </span>
            </div>
          </div>
        </div>

        <div class="text-xs space-y-1.5">
          <div class="text-[11px] text-slate-400 pt-1">Catatan Arahan Lapangan:</div>
          <p class="text-slate-700 bg-amber-50/70 border border-amber-200/70 p-3 rounded-xl leading-relaxed">
            {{ $laporan->catatan_penilaian ?? 'Belum ada catatan penilaian.' }}
          </p>
        </div>
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
