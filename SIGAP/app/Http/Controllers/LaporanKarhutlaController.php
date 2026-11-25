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

    // PBI-010: Menampilkan daftar seluruh laporan yang masuk (Acceptance Criteria 1)
    public function index(Request $request)
    {
        $query = LaporanKarhutla::query();

        // Fitur pencarian kode laporan, lokasi, atau deskripsi
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('kode_laporan', 'like', "%{$keyword}%")
                  ->orWhere('lokasi', 'like', "%{$keyword}%")
                  ->orWhere('deskripsi', 'like', "%{$keyword}%");
            });
        }

        // Mode halaman: 'verifikasi' (Verifikasi Laporan) atau default (Daftar Laporan)
        $mode = $request->query('mode') === 'verifikasi' ? 'verifikasi' : 'daftar';

        // Fitur filter status (pada mode verifikasi default-nya "Menunggu")
        $statusFilter = $request->input('status');
        if ($mode === 'verifikasi' && !$request->has('status')) {
            $statusFilter = 'Menunggu';
        }

        if (!empty($statusFilter) && $statusFilter !== 'semua') {
            if (in_array($statusFilter, ['Terverifikasi', 'Disetujui'])) {
                $query->whereIn('status', ['Terverifikasi', 'Disetujui']);
            } else {
                $query->where('status', $statusFilter);
            }
        }

        $laporans = $query->latest()->paginate(10)->withQueryString();

        $ringkasan = [
            'total' => LaporanKarhutla::count(),
            'menunggu' => LaporanKarhutla::where('status', 'Menunggu')->count(),
            'disetujui' => LaporanKarhutla::whereIn('status', ['Terverifikasi', 'Disetujui'])->count(),
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

        return view('laporan.index', compact('laporans', 'ringkasan', 'mode', 'statusFilter'));
    }

    // PBI-010: Menampilkan rincian detail satu laporan (Acceptance Criteria 2)
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

        // Pengecekan peran: Hanya Petugas BPBD Pusdalops yang dapat melihat dan menggunakan tombol verifikasi (AC 4)
        $bisaVerifikasi = auth()->check() && auth()->user()->role === 'pusdalops';

        return view('laporan.show', compact('laporan', 'bisaVerifikasi'));
    }

    // PBI-010 & PBI-011: Menyetujui / Memverifikasi laporan
    public function setujui(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'pusdalops') {
            abort(403, 'Akses ditolak. Tombol ini hanya dapat digunakan oleh Petugas BPBD Pusdalops.');
        }

        $laporan = LaporanKarhutla::findOrFail($id);
        $namaPetugas = auth()->user()->name;

        // Catat ke riwayat perubahan status (PBI-012)
        $riwayat = $laporan->riwayat_status ?? [];
        $riwayat[] = [
            'status_sebelumnya' => $laporan->status,
            'status_baru' => 'Disetujui',
            'diubah_oleh' => $namaPetugas,
            'alasan_penolakan' => null,
            'waktu' => now()->format('d-m-Y H:i') . ' WIB',
            'timestamp' => now()->toIso8601String(),
        ];

        $laporan->update([
            'status' => 'Disetujui',
            'riwayat_status' => $riwayat,
            'diubah_oleh' => $namaPetugas,
            'diubah_pada' => now(),
        ]);

        return redirect()->route('laporan.show', $laporan->id)
            ->with('success', 'Laporan berhasil diverifikasi / disetujui.');
    }

    // PBI-011 & PBI-012: Menolak laporan DENGAN Alasan Penolakan Wajib
    public function tolak(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'pusdalops') {
            abort(403, 'Akses ditolak. Tombol ini hanya dapat digunakan oleh Petugas BPBD Pusdalops.');
        }

        $laporan = LaporanKarhutla::findOrFail($id);
        $namaPetugas = auth()->user()->name;
        $alasan = trim($request->input('alasan_penolakan') ?? 'Laporan ditolak oleh Petugas Pusdalops.');

        // Catat ke riwayat perubahan status (PBI-012)
        $riwayat = $laporan->riwayat_status ?? [];
        $riwayat[] = [
            'status_sebelumnya' => $laporan->status,
            'status_baru' => 'Ditolak',
            'diubah_oleh' => $namaPetugas,
            'alasan_penolakan' => $alasan,
            'waktu' => now()->format('d-m-Y H:i') . ' WIB',
            'timestamp' => now()->toIso8601String(),
        ];

        $laporan->update([
            'status' => 'Ditolak',
            'alasan_penolakan' => $alasan,
            'riwayat_status' => $riwayat,
            'diubah_oleh' => $namaPetugas,
            'diubah_pada' => now(),
        ]);

        return redirect()->route('laporan.show', $laporan->id)
            ->with('success', 'Laporan berhasil ditolak dan alasan penolakan telah disimpan.');
    }

    // PBI-012: Edit/Perbarui Alasan Penolakan
    public function perbaruiAlasan(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'pusdalops') {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'alasan_penolakan' => 'required|string|min:5|max:1000',
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan tidak boleh kosong.',
        ]);

        $laporan = LaporanKarhutla::findOrFail($id);
        $namaPetugas = auth()->user()->name;
        $alasanBaru = trim($request->alasan_penolakan);

        $riwayat = $laporan->riwayat_status ?? [];
        $riwayat[] = [
            'status_sebelumnya' => 'Ditolak',
            'status_baru' => 'Ditolak (Pembaruan Alasan)',
            'diubah_oleh' => $namaPetugas,
            'alasan_penolakan' => $alasanBaru,
            'waktu' => now()->format('d-m-Y H:i') . ' WIB',
            'timestamp' => now()->toIso8601String(),
        ];

        $laporan->update([
            'alasan_penolakan' => $alasanBaru,
            'riwayat_status' => $riwayat,
            'diubah_oleh' => $namaPetugas,
            'diubah_pada' => now(),
        ]);

        return redirect()->route('laporan.show', $laporan->id)
            ->with('success', 'Alasan penolakan berhasil diperbarui.');
}
    // API: Mengambil daftar laporan format JSON
    public function apiIndex(Request $request)
    {
        return $this->index($request);
    }

    // API: Mengambil detail laporan format JSON
    public function apiShow(Request $request, $id)
    {
        return $this->show($request, $id);
    }
}
