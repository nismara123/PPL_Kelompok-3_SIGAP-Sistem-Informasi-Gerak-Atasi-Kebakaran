
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 p-6">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">
                    Koordinasi Damkar
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Daftar permintaan koordinasi penanganan kebakaran hutan dan lahan.
                </p>
            </div>

            @if(auth()->user()->role === 'pusdalops')
                <a href="{{ route('koordinasi-damkar.create') }}"
                   class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-semibold">
                    + Kirim Permintaan
                </a>
            @endif
        </div>

        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Pesan error --}}
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Pesan validasi --}}
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Tabel koordinasi --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-100 text-slate-600">
                        <tr>
                            <th class="px-4 py-3">No.</th>
                            <th class="px-4 py-3">Kode Laporan</th>
                            <th class="px-4 py-3">Petugas Damkar</th>
                            <th class="px-4 py-3">Metode Komunikasi</th>
                            <th class="px-4 py-3">Waktu Koordinasi</th>
                            <th class="px-4 py-3">Prioritas</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse($koordinasi as $index => $item)
                            <tr class="hover:bg-slate-50">

                                <td class="px-4 py-3">
                                    {{ $koordinasi->firstItem() + $index }}
                                </td>

                                <td class="px-4 py-3 font-semibold text-slate-700">
                                    {{ $item->laporan->kode_laporan ?? '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $item->petugasDamkar->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $item->metode_komunikasi }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $item->waktu_koordinasi
                                        ? $item->waktu_koordinasi->format('d/m/Y H:i')
                                        : '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $item->prioritas }}
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-3">
                                    @php
                                        $statusClass = match($item->status) {
                                            'Diterima' => 'bg-green-100 text-green-700',
                                            'Ditolak' => 'bg-red-100 text-red-700',
                                            default => 'bg-yellow-100 text-yellow-700',
                                        };
                                    @endphp

                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                        {{ $item->status }}
                                    </span>
                                </td>

                                {{-- Aksi Pusdalops --}}
                                <td class="px-4 py-3">
                                    @if(auth()->user()->role === 'pusdalops')

                                        @if(!$item->waktu_konfirmasi)
                                            <form action="{{ route('koordinasi-damkar.update-status', $item->id) }}"
                                                  method="POST"
                                                  class="flex items-center gap-2">
                                                @csrf
                                                @method('PATCH')

                                                <select name="status"
                                                        class="border border-slate-300 rounded-lg px-2 py-1.5 text-xs">
                                                    <option value="Menunggu Konfirmasi"
                                                        {{ $item->status === 'Menunggu Konfirmasi' ? 'selected' : '' }}>
                                                        Menunggu Konfirmasi
                                                    </option>
                                                    <option value="Diterima"
                                                        {{ $item->status === 'Diterima' ? 'selected' : '' }}>
                                                        Diterima
                                                    </option>
                                                    <option value="Ditolak"
                                                        {{ $item->status === 'Ditolak' ? 'selected' : '' }}>
                                                        Ditolak
                                                    </option>
                                                </select>

                                                <button type="submit"
                                                        class="px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-xs font-semibold">
                                                    Simpan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-500">
                                                Sudah dikonfirmasi Damkar
                                            </span>
                                        @endif

                                    {{-- Aksi Petugas Damkar --}}
                                    @elseif(auth()->user()->role === 'damkar')

                                        <a href="{{ route('koordinasi-damkar.show', $item->id) }}"
                                           class="inline-block px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-xs font-semibold">
                                            Lihat Detail
                                        </a>

                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8"
                                    class="px-4 py-8 text-center text-slate-500">
                                    Belum ada permintaan koordinasi Damkar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-4">
                {{ $koordinasi->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
