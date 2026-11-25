@extends('layouts.app')

@section('title', 'Edit Kerusakan Lahan - SIGAP')

@section('content')
<main id="view-kerusakan-lahan-edit" class="p-4 sm:p-7 max-w-[1380px] w-full mx-auto space-y-6">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
        <a href="{{ route('kerusakan-lahan.index') }}" class="hover:text-slate-900 font-medium">Data Kerusakan Lahan</a>
        <span>/</span>
        <span class="text-slate-800 font-semibold">Edit Data</span>
      </div>
      <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">Edit Data Kerusakan Lahan</h1>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">Perbarui informasi kerusakan lahan sesuai kondisi terbaru.</p>
    </div>

    <a href="{{ route('kerusakan-lahan.index') }}"
       class="self-start sm:self-center inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 overflow-hidden">
      <div class="px-5 sm:px-6 py-4 border-b border-slate-100 bg-slate-50/70 flex items-center gap-2 text-sm font-bold text-slate-800">
        <i class="bi bi-ui-checks text-[#e03c22]"></i> Formulir Kerusakan Lahan
      </div>

      <form action="{{ route('kerusakan-lahan.update', $item) }}" method="POST" class="p-5 sm:p-6">
        @method('PUT')
        @include('kerusakan_lahan._form')

        <div class="flex flex-wrap gap-2">
          <button type="submit"
                  class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#e03c22] hover:bg-[#c53019] text-white text-xs font-bold transition">
            <i class="bi bi-check2-circle"></i> Simpan Perubahan
          </button>
          <a href="{{ route('kerusakan-lahan.index') }}"
             class="px-5 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold transition">
            Batal
          </a>
        </div>
      </form>
    </div>

    <div class="lg:col-span-1">
      @include('kerusakan_lahan._tips')
    </div>
  </div>

</main>
@endsection
