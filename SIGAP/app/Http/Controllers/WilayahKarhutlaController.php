<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WilayahKarhutla;
use Illuminate\Support\Str;


class WilayahKarhutlaController extends Controller
{
    // Menampilkan daftar wilayah
    public function index()
    {
        $wilayah = WilayahKarhutla::latest()->get();

        return view('wilayah.index', compact('wilayah'));
    }

    // Menampilkan form tambah wilayah
    public function create()
    {
        return view('wilayah.create');
    }

    // Menyimpan data wilayah
    public function store(Request $request)
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

        $validated['kode_wilayah'] = 'WIL-' . strtoupper(Str::random(10));

        WilayahKarhutla::create($validated);

        return redirect()->route('wilayah.index')
            ->with('success', 'Data wilayah berhasil ditambahkan.');
    }

    // Menampilkan detail wilayah
    public function show($id)
    {
        $wilayah = WilayahKarhutla::findOrFail($id);

        return view('wilayah.show', compact('wilayah'));
    }

    // Menampilkan form edit
    public function edit($id)
    {
        $wilayah = WilayahKarhutla::findOrFail($id);

        return view('wilayah.edit', compact('wilayah'));
    }

    // Memperbarui data wilayah
    public function update(Request $request, $id)
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

        return redirect()->route('wilayah.index')
            ->with('success', 'Data wilayah berhasil diperbarui.');
    }
}