
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 p-6">
    <div class="max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('koordinasi-damkar.index') }}"
               class="text-sm text-blue-600 hover:underline">
                &larr; Kembali ke Koordinasi Damkar
            </a>

            <h1 class="text-2xl font-bold text-slate-800 mt-3">
                Detail Permintaan Penanganan
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Informasi kejadian dan konfirmasi penanganan Damkar.
            </p>
        </div>

        {{-- Pesan error --}}
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Informasi koordinasi --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
            <h2 class="font-bold text-lg mb-5">Informasi Permintaan BPBD</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <p class="text-xs text-slate-500">Kode Laporan</p>
                    <p class="font-semibold">
                        {{ $koordinasi->laporan->kode_laporan ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Petugas BPBD</p>
                    <p class="font-semibold">
                        {{ $koordinasi->petugasBpbd->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Petugas Damkar</p>
                    <p class="font-semibold">
                        {{ $koordinasi->petugasDamkar->name ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Waktu Koordinasi</p>
                    <p class="font-semibold">
                        {{ $koordinasi->waktu_koordinasi
                            ? $koordinasi->waktu_koordinasi->format('d/m/Y H:i')
                            : '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Metode Komunikasi</p>
                    <p class="font-semibold">{{ $koordinasi->metode_komunikasi }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Prioritas</p>
                    <p class="font-semibold">{{ $koordinasi->prioritas }}</p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Status Permintaan</p>
                    <p class="font-semibold">{{ $koordinasi->status }}</p>
                </div>
            </div>

            <div class="border-t border-slate-100 mt-5 pt-5">
                <h3 class="font-semibold mb-3">Informasi Kejadian</h3>

                @if($koordinasi->laporan)
                    @foreach($koordinasi->laporan->getAttributes() as $field => $value)
                        @if(!in_array($field, ['id', 'created_at', 'updated_at', 'deleted_at', 'remember_token']))
                            <div class="mb-3">
                                <p class="text-xs text-slate-500">
                                    {{ ucfirst(str_replace('_', ' ', $field)) }}
                                </p>
                                <p class="text-sm text-slate-800">
                                    {{ is_scalar($value) ? ($value !== null && $value !== '' ? $value : '-') : '-' }}
                                </p>
                            </div>
                        @endif
                    @endforeach
                @else
                    <p class="text-sm text-slate-500">Data laporan tidak ditemukan.</p>
                @endif

                <div class="mt-4">
                    <p class="text-xs text-slate-500">Catatan dari BPBD</p>
                    <p class="text-sm text-slate-800">
                        {{ $koordinasi->catatan ?: 'Tidak ada catatan.' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Form konfirmasi --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h2 class="font-bold text-lg mb-2">Konfirmasi Penanganan</h2>

            @if(in_array($koordinasi->status, ['Menunggu Konfirmasi', 'Terkirim']))

                <p class="text-sm text-slate-500 mb-5">
                    Silakan tentukan keputusan penanganan berdasarkan informasi kejadian.
                </p>

                <form action="{{ route('koordinasi-damkar.confirm', $koordinasi->id) }}"
                      method="POST">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-semibold mb-2">
                            Keputusan Penanganan
                        </label>

                        <select name="status" id="status" required
                                class="w-full border border-slate-300 rounded-lg px-3 py-2.5">
                            <option value="">Pilih keputusan</option>
                            <option value="Diterima" {{ old('status') === 'Diterima' ? 'selected' : '' }}>
                                Terima Permintaan
                            </option>
                            <option value="Ditolak" {{ old('status') === 'Ditolak' ? 'selected' : '' }}>
                                Tolak Permintaan
                            </option>
                        </select>
                    </div>

                    <div id="tim-section" class="mb-5 hidden">
                        <label class="block text-sm font-semibold mb-2">
                            Tim yang Ditugaskan
                        </label>

                        <input type="text"
                               name="tim_ditugaskan"
                               value="{{ old('tim_ditugaskan') }}"
                               placeholder="Masukkan nama atau identitas tim Damkar"
                               class="w-full border border-slate-300 rounded-lg px-3 py-2.5">

                    </div>

                    <div id="catatan-section" class="mb-5 hidden">
                        <label class="block text-sm font-semibold mb-2">
                            Alasan Penolakan
                        </label>

                        <textarea name="catatan_konfirmasi"
                                  rows="3"
                                  placeholder="Tuliskan alasan penolakan..."
                                  class="w-full border border-slate-300 rounded-lg px-3 py-2.5">{{ old('catatan_konfirmasi') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold">
                            Simpan Konfirmasi
                        </button>
                    </div>
                </form>

            @else

                <div class="p-4 bg-green-50 rounded-lg text-green-800">
                    <p class="font-semibold">Permintaan sudah dikonfirmasi.</p>
                    <p class="text-sm mt-2">Status: {{ $koordinasi->status }}</p>

                    @if($koordinasi->tim_ditugaskan)
                        <p class="text-sm mt-2">
                            Tim ditugaskan: {{ $koordinasi->tim_ditugaskan }}
                        </p>
                    @endif

                    @if($koordinasi->catatan_konfirmasi)
                        <p class="text-sm mt-2">
                            Catatan: {{ $koordinasi->catatan_konfirmasi }}
                        </p>
                    @endif

                    @if($koordinasi->waktu_konfirmasi)
                        <p class="text-sm mt-2">
                            Waktu konfirmasi:
                            {{ $koordinasi->waktu_konfirmasi->format('d/m/Y H:i') }}
                        </p>
                    @endif
                </div>

            @endif
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const status = document.getElementById('status');

    if (!status) return;

    const timSection = document.getElementById('tim-section');
    const catatanSection = document.getElementById('catatan-section');
    const timInput = document.querySelector('[name="tim_ditugaskan"]');
    const catatanInput = document.querySelector('[name="catatan_konfirmasi"]');

    function updateForm() {
        timSection.classList.add('hidden');
        catatanSection.classList.add('hidden');

        timInput.required = false;
        catatanInput.required = false;

        if (status.value === 'Diterima') {
            timSection.classList.remove('hidden');
            timInput.required = true;
        }

        if (status.value === 'Ditolak') {
            catatanSection.classList.remove('hidden');
            catatanInput.required = true;
        }
    }

    status.addEventListener('change', updateForm);
    updateForm();
});
</script>
@endsection
