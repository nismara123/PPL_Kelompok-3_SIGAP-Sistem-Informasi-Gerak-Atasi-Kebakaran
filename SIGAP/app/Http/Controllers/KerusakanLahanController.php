<?php

namespace App\Http\Controllers;

use App\Models\KerusakanLahan;
use App\Models\WilayahKarhutla;
use Illuminate\Http\Request;

class KerusakanLahanController extends Controller
{
    // Role: rr = BPBD Divisi RR (kelola data), pusdalops = BPBD Pusdalops (lihat data)
    private function izinkan(array $roles): void
    {
        abort_unless(
            in_array(auth()->user()->role ?? null, $roles, true),
            403,
            'Anda tidak memiliki akses ke halaman ini.'
        );
    }

    // PBI-006: daftar kerusakan lahan + pencarian + filter
    public function index(Request $request)
    {
        $this->izinkan(['rr', 'pusdalops']);

        $data = KerusakanLahan::with('wilayah')
            ->when($request->q, fn ($q, $v) => $q->where('lokasi', 'like', "%{$v}%"))
            ->when($request->kecamatan, fn ($q, $v) => $q->whereHas('wilayah', fn ($w) => $w->where('kecamatan', $v)))
            ->latest('tanggal_pencatatan')
            ->paginate(10)
            ->withQueryString();

        $ringkasan = [
            'total' => KerusakanLahan::count(),
            'luas' => (float) KerusakanLahan::sum('luas_ha'),
            'kecamatan' => KerusakanLahan::join('wilayah_karhutla', 'wilayah_karhutla.id', '=', 'kerusakan_lahan.wilayah_id')
                ->distinct()
                ->count('wilayah_karhutla.kecamatan'),
        ];

        return view('kerusakan_lahan.index', [
            'ringkasan' => $ringkasan,
            'data' => $data,
            'kecamatanList' => WilayahKarhutla::orderBy('kecamatan')->distinct()->pluck('kecamatan'),
            'bisaKelola' => auth()->user()->role === 'rr',
        ]);
    }

    // PBI-004: form tambah
    public function create()
    {
        $this->izinkan(['rr']);

        return view('kerusakan_lahan.create', $this->dataForm());
    }

    public function store(Request $request)
    {
        $this->izinkan(['rr']);

        $validated = $this->validated($request);
        $validated['user_id'] = auth()->id();

        KerusakanLahan::create($validated);

        return redirect()->route('kerusakan-lahan.index')
            ->with('success', 'Data kerusakan lahan berhasil disimpan.');
    }

    // PBI-006: detail
    public function show(KerusakanLahan $kerusakanLahan)
    {
        $this->izinkan(['rr', 'pusdalops']);

        $kerusakanLahan->load('wilayah', 'user');

        return view('kerusakan_lahan.show', [
            'item' => $kerusakanLahan,
            'bisaKelola' => auth()->user()->role === 'rr',
        ]);
    }

    // PBI-005: form ubah
    public function edit(KerusakanLahan $kerusakanLahan)
    {
        $this->izinkan(['rr']);

        return view('kerusakan_lahan.edit', ['item' => $kerusakanLahan] + $this->dataForm());
    }

    public function update(Request $request, KerusakanLahan $kerusakanLahan)
    {
        $this->izinkan(['rr']);

        $kerusakanLahan->update($this->validated($request));

        return redirect()->route('kerusakan-lahan.index')
            ->with('success', 'Perubahan data kerusakan lahan berhasil disimpan.');
    }

    public function destroy(KerusakanLahan $kerusakanLahan)
    {
        $this->izinkan(['rr']);

        $kerusakanLahan->delete();

        return redirect()->route('kerusakan-lahan.index')
            ->with('success', 'Data kerusakan lahan berhasil dihapus.');
    }

    private function dataForm(): array
    {
        return [
            'wilayahList' => WilayahKarhutla::orderBy('kecamatan')->orderBy('desa_kelurahan')->get(),
            'jenisList' => KerusakanLahan::JENIS,
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'wilayah_id' => 'required|exists:wilayah_karhutla,id',
            'lokasi' => 'required|string|max:255',
            'jenis_kerusakan' => 'required|in:' . implode(',', KerusakanLahan::JENIS),
            'luas_ha' => 'nullable|numeric|gt:0',
            'tanggal_pencatatan' => 'required|date',
            'keterangan' => 'nullable|string',
        ], [
            'wilayah_id.required' => 'Wilayah wajib dipilih.',
            'wilayah_id.exists' => 'Wilayah yang dipilih tidak valid.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'jenis_kerusakan.required' => 'Jenis kerusakan wajib dipilih.',
            'jenis_kerusakan.in' => 'Jenis kerusakan tidak valid.',
            'luas_ha.numeric' => 'Luas harus berupa angka.',
            'luas_ha.gt' => 'Luas harus lebih besar dari 0.',
            'tanggal_pencatatan.required' => 'Tanggal pencatatan wajib diisi.',
            'tanggal_pencatatan.date' => 'Tanggal pencatatan tidak valid.',
        ]);
    }
}
