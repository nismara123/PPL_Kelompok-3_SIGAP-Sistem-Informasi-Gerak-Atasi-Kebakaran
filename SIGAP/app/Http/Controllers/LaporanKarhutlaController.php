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
}
