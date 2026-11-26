
@extends('layouts.app')

@section('title', 'Tambah Wilayah Karhutla - SIGAP')

@section('content')
<main class="max-w-3xl mx-auto px-4 py-5 space-y-4">

    <!-- Header -->
    <div>
        <a href="{{ route('wilayah.index') }}"
           class="text-xs text-slate-500 hover:text-[#e03c22]">
            Data Wilayah / Tambah Wilayah
        </a>

        <h1 class="mt-2 text-xl font-bold text-slate-900">
            Tambah Wilayah Karhutla
        </h1>
        <p class="mt-1 text-xs text-slate-500">
            Masukkan data wilayah pantauan Kabupaten Banyumas.
        </p>
    </div>

    <form action="{{ route('wilayah.store') }}" method="POST"
          class="bg-white border border-slate-200 rounded-lg overflow-hidden">
        @csrf

        <!-- Identitas Wilayah -->
        <div class="p-4 sm:p-5">
            <h2 class="text-sm font-bold text-slate-800 mb-4">
                Identitas Wilayah
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-3">

                @php
                    $fields = [
                        ['kode_kabupaten', 'Kode Kabupaten', 'Contoh kode kabupaten'],
                        ['kabupaten', 'Kabupaten', 'Banyumas'],
                        ['kode_kecamatan', 'Kode Kecamatan', 'Kode kecamatan'],
                        ['kecamatan', 'Kecamatan', 'Nama kecamatan'],
                        ['kode_desa', 'Kode Desa', 'Kode desa'],
                        ['desa_kelurahan', 'Desa/Kelurahan', 'Nama desa atau kelurahan'],
                    ];
                @endphp

                @foreach($fields as $field)
                    <div>
                        <label for="{{ $field[0] }}"
                               class="block text-xs font-semibold text-slate-700 mb-1.5">
                            {{ $field[1] }}
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="{{ $field[0] }}"
                            name="{{ $field[0] }}"
                            value="{{ old($field[0], $field[0] === 'kabupaten' ? 'Banyumas' : '') }}"
                            placeholder="{{ $field[2] }}"
                            required
                            class="w-full px-3 py-2 text-sm border border-slate-300 rounded-md outline-none focus:border-[#e03c22] focus:ring-1 focus:ring-red-100"
                        >

                        @error($field[0])
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

            </div>
        </div>

        <div class="border-t border-slate-200"></div>

        <!-- Koordinat -->
        <div class="p-4 sm:p-5">
            <h2 class="text-sm font-bold text-slate-800 mb-4">
                Koordinat Lokasi
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label for="latitude"
                           class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Latitude
                    </label>
                    <input
                        type="number"
                        step="any"
                        id="latitude"
                        name="latitude"
                        value="{{ old('latitude') }}"
                        placeholder="Contoh: -7.4278"
                        class="w-full px-3 py-2 text-sm border border-slate-300 rounded-md outline-none focus:border-[#e03c22] focus:ring-1 focus:ring-red-100"
                    >
                    @error('latitude')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="longitude"
                           class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Longitude
                    </label>
                    <input
                        type="number"
                        step="any"
                        id="longitude"
                        name="longitude"
                        value="{{ old('longitude') }}"
                        placeholder="Contoh: 109.2396"
                        class="w-full px-3 py-2 text-sm border border-slate-300 rounded-md outline-none focus:border-[#e03c22] focus:ring-1 focus:ring-red-100"
                    >
                    @error('longitude')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <p class="mt-3 text-xs text-slate-500">
                Koordinat digunakan untuk menentukan lokasi wilayah pada peta SIGAP.
            </p>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end gap-2 px-4 py-3 bg-slate-50 border-t border-slate-200">
            <a href="{{ route('wilayah.index') }}"
               class="px-4 py-2 text-xs font-semibold text-slate-600 border border-slate-300 rounded-md hover:bg-slate-100">
                Kembali
            </a>

            <button type="submit"
                    class="px-4 py-2 text-xs font-semibold text-white bg-[#e03c22] rounded-md hover:bg-[#c8321b]">
                Simpan Wilayah
            </button>
        </div>

    </form>
</main>
@endsection
