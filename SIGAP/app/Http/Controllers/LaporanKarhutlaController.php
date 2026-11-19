<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKarhutla;
use Illuminate\Support\Str;

class LaporanKarhutlaController extends Controller
{
    // Menampilkan form pelaporan
    public function create()
    {
        return view('laporan.create');
    }

    // Menyimpan laporan masyarakat
    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
            'waktu_kejadian' => 'required|date',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Membuat kode laporan unik
        do {
            $kodeLaporan = 'KARHUTLA-' .
                strtoupper(Str::random(8));
        } while (
            LaporanKarhutla::where(
                'kode_laporan',
                $kodeLaporan
            )->exists()
        );

        // Menyimpan foto jika tersedia
        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')
                ->store('laporan-karhutla', 'public');
        }

        // Menyimpan data laporan
        $laporan = LaporanKarhutla::create([
            'kode_laporan' => $kodeLaporan,
            'lokasi' => $request->lokasi,
            'waktu_kejadian' => $request->waktu_kejadian,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto,
            'status' => 'Menunggu',
        ]);

        return redirect()
            ->route('laporan.cekStatus')
            ->with('success', 'Laporan berhasil dikirim!')
            ->with('kode_laporan', $laporan->kode_laporan);
    }

    // Menampilkan halaman cek status
    public function cekStatus()
    {
        return view('laporan.cek-status');
    }

    // Memproses pencarian status laporan
    public function hasilStatus(Request $request)
    {
        $request->validate([
            'kode_laporan' => 'required|string',
        ]);

        $laporan = LaporanKarhutla::where(
            'kode_laporan',
            strtoupper(trim($request->kode_laporan))
        )->first();

        if (!$laporan) {
            return back()
                ->withInput()
                ->with('error', 'Kode laporan tidak ditemukan.');
        }

        return view('laporan.hasil-status', compact('laporan'));
    }

    // PBI-010: Melihat seluruh daftar laporan karhutla
    public function index(Request $request)
    {
        $query = LaporanKarhutla::query();

        // Pencarian berdasarkan kode laporan atau lokasi
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('kode_laporan', 'like', "%{$keyword}%")
                  ->orWhere('lokasi', 'like', "%{$keyword}%")
                  ->orWhere('deskripsi', 'like', "%{$keyword}%");
            });
        }

        // Filter status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $laporans = $query->latest()->paginate(10)->withQueryString();

        $ringkasan = [
            'total' => LaporanKarhutla::count(),
            'menunggu' => LaporanKarhutla::where('status', 'Menunggu')->count(),
            'disetujui' => LaporanKarhutla::where('status', 'Disetujui')->count(),
            'ditolak' => LaporanKarhutla::where('status', 'Ditolak')->count(),
        ];

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Daftar laporan karhutla berhasil diambil.',
                'ringkasan' => $ringkasan,
                'data' => $laporans,
            ]);
        }

        return view('laporan.index', compact('laporans', 'ringkasan'));
    }

    // PBI-010: Melihat detail rincian satu laporan
    public function show(Request $request, $id)
    {
        $laporan = LaporanKarhutla::findOrFail($id);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Detail laporan berhasil diambil.',
                'data' => $laporan,
            ]);
        }

        $bisaVerifikasi = auth()->check() && auth()->user()->role === 'pusdalops';

        return view('laporan.show', compact('laporan', 'bisaVerifikasi'));
    }

    // PBI-010: Menyetujui laporan (Khusus Petugas BPBD Pusdalops)
    public function setujui(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'pusdalops') {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya Petugas BPBD Pusdalops yang dapat menyetujui laporan.',
                ], 403);
            }

            abort(403, 'Akses ditolak. Hanya Petugas BPBD Pusdalops yang dapat menyetujui laporan.');
        }

        $laporan = LaporanKarhutla::findOrFail($id);
        $laporan->update([
            'status' => 'Disetujui',
        ]);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil disetujui.',
                'data' => $laporan,
            ]);
        }

        return redirect()->route('laporan.show', $laporan->id)
            ->with('success', 'Laporan berhasil disetujui.');
    }

    // PBI-010: Menolak laporan (Khusus Petugas BPBD Pusdalops)
    public function tolak(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'pusdalops') {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya Petugas BPBD Pusdalops yang dapat menolak laporan.',
                ], 403);
            }

            abort(403, 'Akses ditolak. Hanya Petugas BPBD Pusdalops yang dapat menolak laporan.');
        }

        $laporan = LaporanKarhutla::findOrFail($id);
        $laporan->update([
            'status' => 'Ditolak',
        ]);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil ditolak.',
                'data' => $laporan,
            ]);
        }

        return redirect()->route('laporan.show', $laporan->id)
            ->with('success', 'Laporan berhasil ditolak.');
    }

    // API Helper: Mengambil daftar laporan via API JSON
    public function apiIndex(Request $request)
    {
        return $this->index($request);
    }

    // API Helper: Mengambil detail laporan via API JSON
    public function apiShow(Request $request, $id)
    {
        return $this->show($request, $id);
    }
}
