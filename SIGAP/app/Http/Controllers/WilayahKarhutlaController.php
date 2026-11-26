<?php

namespace App\Http\Controllers;

use App\Models\WilayahKarhutla;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;

class WilayahKarhutlaController extends Controller
{
    /**
     * Menampilkan daftar seluruh wilayah karhutla.
     */
    public function index(): View
    {
        $wilayah = WilayahKarhutla::latest()->get();

        return view('wilayah.index', compact('wilayah'));
    }

    /**
     * Menampilkan form tambah wilayah.
     */
    public function create(): View
    {
        return view('wilayah.create');
    }

    /**
     * Menyimpan data wilayah baru.
     */
   
    
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_kabupaten' => 'required|string|max:20',
            'kabupaten' => 'required|string|max:100',
            'kode_kecamatan' => 'required|string|max:20',
            'kecamatan' => 'required|string|max:100',
            'kode_desa' => 'required|string|max:20',
            'desa_kelurahan' => 'required|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ], [
            'kode_kabupaten.required' => 'Kode kabupaten wajib diisi.',
            'kabupaten.required' => 'Nama kabupaten wajib diisi.',
            'kode_kecamatan.required' => 'Kode kecamatan wajib diisi.',
            'kecamatan.required' => 'Nama kecamatan wajib diisi.',
            'kode_desa.required' => 'Kode desa wajib diisi.',
            'desa_kelurahan.required' => 'Nama desa/kelurahan wajib diisi.',
            'latitude.numeric' => 'Latitude harus berupa angka.',
            'latitude.between' => 'Latitude harus antara -90 sampai 90.',
            'longitude.numeric' => 'Longitude harus berupa angka.',
            'longitude.between' => 'Longitude harus antara -180 sampai 180.',
        ]);

        // Membuat kode wilayah yang belum digunakan
        do {
            $kodeWilayah = 'WIL-' . strtoupper(Str::random(10));
        } while (
            WilayahKarhutla::where('kode_wilayah', $kodeWilayah)->exists()
        );

        $validated['kode_wilayah'] = $kodeWilayah;

        WilayahKarhutla::create($validated);

        return redirect()
            ->route('wilayah.index')
            ->with('success', 'Data wilayah berhasil ditambahkan.');
    }



    /**
     * Menampilkan detail wilayah berdasarkan ID.
     */
    public function show(int $id): View
    {
        $wilayah = WilayahKarhutla::findOrFail($id);

        return view('wilayah.show', compact('wilayah'));
    }

    /**
     * Menampilkan form edit wilayah.
     */
    public function edit(int $id): View
    {
        $wilayah = WilayahKarhutla::findOrFail($id);

        return view('wilayah.edit', compact('wilayah'));
    }

    /**
     * Memperbarui data wilayah.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'kode_kabupaten' => 'required|string|max:20',
            'kabupaten' => 'required|string|max:100',
            'kode_kecamatan' => 'required|string|max:20',
            'kecamatan' => 'required|string|max:100',
            'kode_desa' => 'required|string|max:20',
            'desa_kelurahan' => 'required|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $wilayah = WilayahKarhutla::findOrFail($id);
        $wilayah->update($validated);

        return redirect()
            ->route('wilayah.index')
            ->with('success', 'Data wilayah berhasil diperbarui.');
    }
}