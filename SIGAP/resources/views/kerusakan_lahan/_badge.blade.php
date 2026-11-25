{{-- Badge jenis kerusakan. Warna diambil dari KerusakanLahan::WARNA lewat accessor $item->warna --}}
<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold whitespace-nowrap"
      style="background-color: {{ $item->warna }}1A; color: {{ $item->warna }};">
  {{ $item->jenis_kerusakan }}
</span>
