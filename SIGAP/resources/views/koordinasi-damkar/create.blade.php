
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 p-6">
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('koordinasi-damkar.index') }}"
               class="text-sm text-slate-500 hover:text-[#e03c22]">
                ← Kembali ke Koordinasi Damkar
            </a>

            <h1 class="text-2xl font-bold text-slate-800 mt-3">
                Kirim Permintaan Penanganan
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Isi informasi laporan dan petugas Damkar yang akan menerima permintaan penanganan.
            </p>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

            <form action="{{ route('koordinasi-damkar.store') }}"
                  method="POST">
                @csrf

                {{-- Pilih Laporan --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Pilih Laporan Kebakaran
                    </label>

                    <select name="laporan_karhutla_id"
                            id="laporan_karhutla_id"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-200 focus:border-[#e03c22]"
                            required>

                        <option value="">-- Pilih Laporan --</option>

                        @foreach($laporans as $laporan)
                            @php
                                $tingkatRisiko = trim((string) $laporan->tingkat_risiko);

                                $risikoValid = in_array(
                                    $tingkatRisiko,
                                    ['Tinggi', 'Sedang', 'Rendah']
                                );
                            @endphp

                            <option value="{{ $laporan->id }}"
                                    data-tingkat-risiko="{{ $risikoValid ? $tingkatRisiko : '' }}"
                                    {{ old('laporan_karhutla_id') == $laporan->id ? 'selected' : '' }}
                                    {{ !$risikoValid ? 'disabled' : '' }}>

                                {{ $laporan->kode_laporan }}
                                - {{ $laporan->lokasi }}
                                ({{ $laporan->status }})

                                {{ $risikoValid
                                    ? '- Risiko '.$tingkatRisiko
                                    : '- Belum Dinilai' }}
                            </option>
                        @endforeach
                    </select>

                    @error('laporan_karhutla_id')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="text-xs text-slate-500 mt-2">
                        Hanya laporan yang sudah memiliki hasil penilaian risiko
                        Tinggi, Sedang, atau Rendah yang dapat dipilih.
                    </p>
                </div>

                {{-- Tingkat Risiko Kejadian --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Tingkat Risiko Kejadian
                    </label>

                    <div id="tingkat-risiko-preview"
                         class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-3 text-sm text-slate-500">
                        Pilih laporan untuk melihat tingkat risiko kejadian.
                    </div>

                    <p class="text-xs text-slate-500 mt-2">
                        Tingkat risiko ditampilkan berdasarkan hasil penilaian
                        kejadian kebakaran pada laporan.
                    </p>
                </div>

                {{-- Pilih Petugas Damkar --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Petugas Damkar Penerima
                    </label>

                    <select name="petugas_damkar_id"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-200 focus:border-[#e03c22]"
                            required>

                        <option value="">-- Pilih Petugas Damkar --</option>

                        @foreach($petugasDamkar as $petugas)
                            <option value="{{ $petugas->id }}"
                                {{ old('petugas_damkar_id') == $petugas->id ? 'selected' : '' }}>
                                {{ $petugas->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('petugas_damkar_id')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Metode Komunikasi --}}
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Metode Komunikasi
                    </label>

                    <select name="metode_komunikasi"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-200 focus:border-[#e03c22]"
                            required>

                        <option value="">-- Pilih Metode Komunikasi --</option>

                        <option value="Telepon"
                            {{ old('metode_komunikasi') == 'Telepon' ? 'selected' : '' }}>
                            Telepon
                        </option>

                        <option value="WhatsApp"
                            {{ old('metode_komunikasi') == 'WhatsApp' ? 'selected' : '' }}>
                            WhatsApp
                        </option>

                        <option value="Radio"
                            {{ old('metode_komunikasi') == 'Radio' ? 'selected' : '' }}>
                            Radio
                        </option>
                    </select>

                    @error('metode_komunikasi')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Catatan Penanganan
                    </label>

                    <textarea name="catatan"
                              rows="4"
                              maxlength="2000"
                              placeholder="Tuliskan informasi tambahan mengenai kejadian atau arahan penanganan..."
                              class="w-full border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-red-200 focus:border-[#e03c22]">{{ old('catatan') }}</textarea>

                    @error('catatan')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Informasi --}}
                <div class="bg-orange-50 border border-orange-100 rounded-xl p-4 mb-6">
                    <p class="text-sm text-orange-800">
                        <strong>Informasi:</strong>
                        Tingkat risiko kejadian mengikuti hasil penilaian
                        pada laporan karhutla. Tanggal dan waktu permintaan
                        koordinasi akan dicatat otomatis ketika permintaan
                        dikirim. Waktu konfirmasi Damkar juga akan dicatat
                        otomatis oleh sistem.
                    </p>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end gap-3">
                    <a href="{{ route('koordinasi-damkar.index') }}"
                       class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 text-sm font-semibold hover:bg-slate-50">
                        Batal
                    </a>

                    <button type="submit"
                            id="submit-button"
                            disabled
                            class="px-5 py-2.5 rounded-xl bg-[#e03c22] text-white text-sm font-semibold hover:bg-red-700 transition opacity-50 cursor-not-allowed">
                        Kirim Permintaan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- JavaScript Tingkat Risiko Otomatis --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const laporanSelect = document.getElementById('laporan_karhutla_id');
    const preview = document.getElementById('tingkat-risiko-preview');
    const submitButton = document.getElementById('submit-button');

    function updateTingkatRisiko() {

        const selectedOption =
            laporanSelect.options[laporanSelect.selectedIndex];

        const tingkatRisiko = selectedOption.dataset.tingkatRisiko;

        preview.className =
            'w-full border rounded-xl px-4 py-3 text-sm';

        // Belum memilih laporan
        if (!laporanSelect.value) {

            preview.textContent =
                'Pilih laporan untuk melihat tingkat risiko kejadian.';

            preview.classList.add(
                'border-slate-200',
                'bg-slate-50',
                'text-slate-500'
            );

            submitButton.disabled = true;
            submitButton.classList.add(
                'opacity-50',
                'cursor-not-allowed'
            );

            return;
        }

        // Laporan belum memiliki penilaian risiko
        if (!tingkatRisiko) {

            preview.textContent =
                'Laporan belum memiliki penilaian risiko.';

            preview.classList.add(
                'border-slate-200',
                'bg-slate-50',
                'text-slate-500'
            );

            submitButton.disabled = true;
            submitButton.classList.add(
                'opacity-50',
                'cursor-not-allowed'
            );

            return;
        }

        // Menampilkan tingkat risiko
        preview.textContent = tingkatRisiko;

        if (tingkatRisiko === 'Tinggi') {

            preview.classList.add(
                'border-red-200',
                'bg-red-50',
                'text-red-700'
            );

        } else if (tingkatRisiko === 'Sedang') {

            preview.classList.add(
                'border-yellow-200',
                'bg-yellow-50',
                'text-yellow-700'
            );

        } else if (tingkatRisiko === 'Rendah') {

            preview.classList.add(
                'border-green-200',
                'bg-green-50',
                'text-green-700'
            );
        }

        // Mengaktifkan tombol kirim
        submitButton.disabled = false;
        submitButton.classList.remove(
            'opacity-50',
            'cursor-not-allowed'
        );
    }

    laporanSelect.addEventListener('change', updateTingkatRisiko);

    updateTingkatRisiko();

});
</script>
@endsection
