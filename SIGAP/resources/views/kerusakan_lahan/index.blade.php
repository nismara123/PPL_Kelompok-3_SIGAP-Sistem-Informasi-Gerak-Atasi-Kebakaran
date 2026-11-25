@extends('layouts.app')

@section('title', 'Data Kerusakan Lahan - SIGAP')

@section('content')
<main id="view-kerusakan-lahan" class="p-4 sm:p-7 max-w-[1380px] w-full mx-auto space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
        Data Kerusakan Lahan Terdampak
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Pencatatan kondisi lahan terdampak karhutla sebagai dasar perencanaan rehabilitasi.
      </p>
    </div>

    @if($bisaKelola)
      <a href="{{ route('kerusakan-lahan.create') }}"
         class="self-start sm:self-center inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#e03c22] hover:bg-[#c53019] text-white text-xs font-bold shadow-2xs transition">
        <i class="bi bi-plus-circle"></i> Tambah Data
      </a>
    @endif
  </div>

  @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-semibold text-emerald-800 flex items-center gap-2">
      <i class="bi bi-check-circle-fill text-emerald-600"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Ringkasan -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 flex items-center gap-4">
      <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
        <i class="bi bi-clipboard2-data"></i>
      </div>
      <div>
        <div class="text-2xl font-extrabold text-slate-900 tabular-nums leading-none">{{ number_format($stat['total'], 0, ',', '.') }}</div>
        <div class="text-xs text-slate-500 mt-1.5">Total data tercatat</div>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 flex items-center gap-4">
      <div class="w-11 h-11 rounded-xl bg-orange-50 text-[#e03c22] flex items-center justify-center text-xl shrink-0">
        <i class="bi bi-fire"></i>
      </div>
      <div>
        <div class="text-2xl font-extrabold text-slate-900 tabular-nums leading-none">
          {{ number_format($stat['luas'], 2, ',', '.') }} <span class="text-sm font-semibold text-slate-500">ha</span>
        </div>
        <div class="text-xs text-slate-500 mt-1.5">Total luas terdampak</div>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 flex items-center gap-4">
      <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
        <i class="bi bi-geo-alt"></i>
      </div>
      <div>
        <div class="text-2xl font-extrabold text-slate-900 tabular-nums leading-none">{{ number_format($stat['wilayah'], 0, ',', '.') }}</div>
        <div class="text-xs text-slate-500 mt-1.5">Wilayah terdampak</div>
      </div>
    </div>
  </div>

  </form>

  <!-- Tabel -->
  <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider bg-slate-50/70">
            <th class="py-3.5 px-5">NO</th>
            <th class="py-3.5 px-4">WILAYAH</th>
            <th class="py-3.5 px-4">LOKASI KEJADIAN</th>
            <th class="py-3.5 px-4">JENIS KERUSAKAN</th>
            <th class="py-3.5 px-4">LUAS</th>
            <th class="py-3.5 px-4">TANGGAL</th>
            <th class="py-3.5 px-5 text-right">AKSI</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-slate-100 text-xs">
          @forelse($data as $item)
            <tr class="hover:bg-slate-50/80 transition">
              <td class="py-4 px-5 align-top text-slate-500 tabular-nums">{{ $data->firstItem() + $loop->index }}</td>

              <td class="py-4 px-4 align-top">
                <div class="font-bold text-slate-800">{{ $item->wilayah->kecamatan ?? '-' }}</div>
                <div class="text-slate-500 mt-0.5"><i class="bi bi-geo-alt"></i> {{ $item->wilayah->desa_kelurahan ?? '-' }}</div>
              </td>

              <td class="py-4 px-4 align-top text-slate-700">{{ $item->lokasi }}</td>

              <td class="py-4 px-4 align-top">@include('kerusakan_lahan._badge', ['item' => $item])</td>

              <td class="py-4 px-4 align-top font-semibold text-slate-800 whitespace-nowrap tabular-nums">
                @if($item->luas_ha !== null)
                  {{ number_format($item->luas_ha, 2, ',', '.') }} ha
                @else
                  -
                @endif
              </td>

              <td class="py-4 px-4 align-top text-slate-600 whitespace-nowrap tabular-nums">{{ $item->tanggal_pencatatan->format('d/m/Y') }}</td>

              <td class="py-4 px-5 align-top">
                <div class="flex items-center justify-end gap-1.5">
                  <a href="{{ route('kerusakan-lahan.show', $item) }}" title="Detail"
                     class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-100 font-semibold transition">
                    <i class="bi bi-eye"></i> Detail
                  </a>

                  @if($bisaKelola)
                    <a href="{{ route('kerusakan-lahan.edit', $item) }}" title="Edit"
                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100 font-semibold transition">
                      <i class="bi bi-pencil"></i> Edit
                    </a>

                    <form action="{{ route('kerusakan-lahan.destroy', $item) }}" method="POST" class="m-0"
                          onsubmit="return confirm('Hapus data kerusakan lahan ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" title="Hapus"
                              class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 font-semibold transition">
                        <i class="bi bi-trash"></i> Hapus
                      </button>
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-14 px-5 text-center">
                <i class="bi bi-tree text-4xl text-slate-300 block mb-2"></i>
                <div class="text-sm font-semibold text-slate-600">Data kerusakan lahan belum tersedia.</div>
                @if($bisaKelola)
                  <a href="{{ route('kerusakan-lahan.create') }}"
                     class="inline-flex items-center gap-2 mt-4 px-4 py-2.5 rounded-xl bg-[#e03c22] hover:bg-[#c53019] text-white text-xs font-bold transition">
                    <i class="bi bi-plus-circle"></i> Tambah Data Pertama
                  </a>
                @endif
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($data->hasPages())
      <div class="px-5 py-4 border-t border-slate-100">
        {{ $data->links() }}
      </div>
    @endif
  </div>

</main>
@endsection
