<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKarhutla;

class PenilaianRisikoController extends Controller
{
    /**
     * PBI-015: Melihat tingkat risiko dan prioritas setiap kejadian.
     * Menampilkan daftar antrean dan kejadian beserta status triase risiko dan prioritas penanganan.
     */
    public function index(Request $request)
    {
        $query = LaporanKarhutla::query();

        // Filter tab antrean triase
        $tab = $request->get('tab', 'semua');
        if ($tab === 'perlu_dinilai') {
            $query->whereNull('tingkat_risiko');
        } elseif ($tab === 'darurat_kritis') {
            $query->where(function ($q) {
                $q->whereIn('tingkat_risiko', ['Kritis', 'Tinggi'])
                  ->orWhereIn('prioritas_penanganan', ['Darurat', 'Tinggi']);
            });
        } elseif ($tab === 'sudah_dinilai') {
            $query->whereNotNull('tingkat_risiko');
        }

        // Pencarian berdasarkan kode laporan, lokasi, atau deskripsi kejadian
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('kode_laporan', 'like', "%{$keyword}%")
                  ->orWhere('lokasi', 'like', "%{$keyword}%")
                  ->orWhere('deskripsi', 'like', "%{$keyword}%");
            });
        }

        // Filter eksplisit tingkat risiko
        if ($request->filled('tingkat_risiko') && $request->tingkat_risiko !== 'semua') {
            if ($request->tingkat_risiko === 'belum_dinilai') {
                $query->whereNull('tingkat_risiko');
            } else {
                $query->where('tingkat_risiko', $request->tingkat_risiko);
            }
        }

        // Filter eksplisit prioritas penanganan
        if ($request->filled('prioritas') && $request->prioritas !== 'semua') {
            if ($request->prioritas === 'belum_dinilai') {
                $query->whereNull('prioritas_penanganan');
            } else {
                $query->where('prioritas_penanganan', $request->prioritas);
            }
        }

        // Pengurutan pintar untuk posko operasional Pusdalops
        $sort = $request->get('sort', 'urgensi');
        if ($sort === 'urgensi') {
            // Prioritaskan Darurat & Kritis di atas, disusul yang belum dinilai, lalu waktu terbaru
            $query->orderByRaw("
                CASE 
                    WHEN prioritas_penanganan = 'Darurat' THEN 1
                    WHEN tingkat_risiko = 'Kritis' THEN 2
                    WHEN prioritas_penanganan = 'Tinggi' THEN 3
                    WHEN tingkat_risiko = 'Tinggi' THEN 4
                    WHEN tingkat_risiko IS NULL THEN 5
                    WHEN prioritas_penanganan = 'Sedang' THEN 6
                    WHEN prioritas_penanganan = 'Rendah' THEN 7
                    ELSE 8
                END ASC, created_at DESC
            ");
        } elseif ($sort === 'terlama') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $laporans = $query->paginate(10)->withQueryString();

        // Ringkasan metrik statistik operasional
        $ringkasan = [
            'total' => LaporanKarhutla::count(),
            'kritis' => LaporanKarhutla::where('tingkat_risiko', 'Kritis')->count(),
            'tinggi' => LaporanKarhutla::where('tingkat_risiko', 'Tinggi')->count(),
            'sedang' => LaporanKarhutla::where('tingkat_risiko', 'Sedang')->count(),
            'rendah' => LaporanKarhutla::where('tingkat_risiko', 'Rendah')->count(),
            'belum_dinilai' => LaporanKarhutla::whereNull('tingkat_risiko')->count(),
            'darurat' => LaporanKarhutla::where('prioritas_penanganan', 'Darurat')->count(),
        ];

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Daftar penilaian risiko berhasil diambil.',
                'ringkasan' => $ringkasan,
                'tab' => $tab,
                'data' => $laporans,
            ]);
        }

        return view('penilaian_risiko.index', compact('laporans', 'ringkasan', 'tab'));
    }

    /**
     * PBI-013: Menyediakan form untuk memasukkan hasil penilaian risiko kejadian.
     */
    public function create($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'pusdalops') {
            abort(403, 'Akses ditolak. Fitur ini hanya untuk Petugas BPBD Pusdalops.');
        }

        $laporan = LaporanKarhutla::findOrFail($id);
        $semuaLaporan = LaporanKarhutla::latest()->get();

        return view('penilaian_risiko.create', compact('laporan', 'semuaLaporan'));
    }

    /**
     * PBI-013: Menyimpan hasil penilaian risiko pada data kejadian.
     * Acceptance Criteria:
     * 1. Sistem menyediakan form untuk memasukkan hasil penilaian risiko kejadian.
     * 2. Petugas dapat menyimpan hasil penilaian risiko pada data kejadian.
     * 3. Sistem menampilkan hasil penilaian risiko yang telah disimpan.
     */
    public function store(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'pusdalops') {
            abort(403, 'Akses ditolak. Fitur ini hanya untuk Petugas BPBD Pusdalops.');
        }

        $request->validate([
            'tingkat_risiko' => 'required|in:Rendah,Sedang,Tinggi,Kritis,Sangat Tinggi',
            'prioritas_penanganan' => 'required|in:Rendah,Sedang,Tinggi,Darurat,1,2,3,4,Prioritas 1,Prioritas 2,Prioritas 3,Prioritas 4',
            'estimasi_luas_terdampak' => 'nullable|string|max:100',
            'potensi_bahaya' => 'nullable',
            'catatan_penilaian' => 'nullable|string|max:2500',
        ], [
            'tingkat_risiko.required' => 'Pilih tingkat risiko kejadian karhutla.',
            'prioritas_penanganan.required' => 'Pilih prioritas penanganan untuk tim lapangan.',
        ]);

        $laporan = LaporanKarhutla::findOrFail($id);
        $namaPetugas = auth()->user()->name;

        // Tangani faktor potensi bahaya sekitar
        $potensiBahaya = $request->potensi_bahaya;
        if (is_array($potensiBahaya)) {
            $potensiBahaya = implode(', ', $potensiBahaya);
        }

        // Rekam riwayat penilaian (Audit trail)
        $riwayat = $laporan->riwayat_penilaian ?? [];
        $riwayat[] = [
            'aksi' => 'Penilaian Awal',
            'tingkat_risiko' => $request->tingkat_risiko,
            'prioritas_penanganan' => $request->prioritas_penanganan,
            'estimasi_luas_terdampak' => $request->estimasi_luas_terdampak,
            'potensi_bahaya' => $potensiBahaya,
            'catatan_penilaian' => trim($request->catatan_penilaian),
            'dinilai_oleh' => $namaPetugas,
            'waktu' => now()->format('d-m-Y H:i') . ' WIB',
            'timestamp' => now()->toIso8601String(),
        ];

        $laporan->update([
            'tingkat_risiko' => $request->tingkat_risiko,
            'prioritas_penanganan' => $request->prioritas_penanganan,
            'estimasi_luas_terdampak' => $request->estimasi_luas_terdampak,
            'potensi_bahaya' => $potensiBahaya,
            'catatan_penilaian' => trim($request->catatan_penilaian),
            'dinilai_oleh' => $namaPetugas,
            'dinilai_pada' => now(),
            'riwayat_penilaian' => $riwayat,
        ]);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Hasil penilaian risiko dan prioritas berhasil disimpan.',
                'data' => $laporan,
            ]);
        }

        return redirect()->route('laporan.show', $laporan->id)
            ->with('success', 'Hasil penilaian risiko dan prioritas penanganan kejadian berhasil disimpan.');
    }

    /**
     * PBI-014: Form ubah/memperbarui hasil penilaian risiko kejadian.
     */
    public function edit($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'pusdalops') {
            abort(403, 'Akses ditolak. Fitur ini hanya untuk Petugas BPBD Pusdalops.');
        }

        $laporan = LaporanKarhutla::findOrFail($id);
        $semuaLaporan = LaporanKarhutla::latest()->get();

        return view('penilaian_risiko.edit', compact('laporan', 'semuaLaporan'));
    }

    /**
     * PBI-014: Memperbarui hasil penilaian risiko kejadian.
     * Acceptance Criteria:
     * 1. Petugas dapat memilih data kejadian yang akan diperbarui penilaian risikonya.
     * 2. Sistem menyediakan fungsi untuk mengubah hasil penilaian risiko.
     * 3. Sistem menyimpan dan menampilkan hasil perubahan penilaian risiko.
     */
    public function update(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'pusdalops') {
            abort(403, 'Akses ditolak. Fitur ini hanya untuk Petugas BPBD Pusdalops.');
        }

        $request->validate([
            'tingkat_risiko' => 'required|in:Rendah,Sedang,Tinggi,Kritis,Sangat Tinggi',
            'prioritas_penanganan' => 'required|in:Rendah,Sedang,Tinggi,Darurat,1,2,3,4,Prioritas 1,Prioritas 2,Prioritas 3,Prioritas 4',
            'estimasi_luas_terdampak' => 'nullable|string|max:100',
            'potensi_bahaya' => 'nullable',
            'catatan_penilaian' => 'nullable|string|max:2500',
            'alasan_pembaruan' => 'nullable|string|max:500',
        ], [
            'tingkat_risiko.required' => 'Pilih tingkat risiko kejadian.',
            'prioritas_penanganan.required' => 'Pilih prioritas penanganan kejadian.',
        ]);

        $laporan = LaporanKarhutla::findOrFail($id);
        $namaPetugas = auth()->user()->name;

        $potensiBahaya = $request->potensi_bahaya;
        if (is_array($potensiBahaya)) {
            $potensiBahaya = implode(', ', $potensiBahaya);
        }

        // Catat pembaruan ke riwayat penilaian lengkap dengan audit trail
        $riwayat = $laporan->riwayat_penilaian ?? [];
        $riwayat[] = [
            'aksi' => 'Pembaruan Penilaian',
            'tingkat_risiko_lama' => $laporan->tingkat_risiko,
            'tingkat_risiko_baru' => $request->tingkat_risiko,
            'prioritas_lama' => $laporan->prioritas_penanganan,
            'prioritas_baru' => $request->prioritas_penanganan,
            'estimasi_luas_terdampak' => $request->estimasi_luas_terdampak,
            'potensi_bahaya' => $potensiBahaya,
            'catatan_penilaian' => trim($request->catatan_penilaian),
            'alasan_pembaruan' => $request->alasan_pembaruan ? trim($request->alasan_pembaruan) : 'Pembaruan kondisi lapangan',
            'diubah_oleh' => $namaPetugas,
            'waktu' => now()->format('d-m-Y H:i') . ' WIB',
            'timestamp' => now()->toIso8601String(),
        ];

        $laporan->update([
            'tingkat_risiko' => $request->tingkat_risiko,
            'prioritas_penanganan' => $request->prioritas_penanganan,
            'estimasi_luas_terdampak' => $request->estimasi_luas_terdampak,
            'potensi_bahaya' => $potensiBahaya,
            'catatan_penilaian' => trim($request->catatan_penilaian),
            'dinilai_oleh' => $namaPetugas,
            'dinilai_pada' => now(),
            'riwayat_penilaian' => $riwayat,
        ]);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Hasil penilaian risiko berhasil diperbarui.',
                'data' => $laporan,
            ]);
        }

        return redirect()->route('laporan.show', $laporan->id)
            ->with('success', 'Hasil penilaian risiko dan prioritas kejadian berhasil diperbarui.');
    }
}
