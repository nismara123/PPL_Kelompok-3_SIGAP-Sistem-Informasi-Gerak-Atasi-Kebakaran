<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WilayahKarhutlaController;
use App\Http\Controllers\LaporanKarhutlaController;
use App\Models\LaporanKarhutla;
use App\Models\WilayahKarhutla;
use Illuminate\Support\Facades\Route;


Route::get('/n', function () {
    return view('welcome');
});

use App\Http\Controllers\BerandaController;

Route::get('/', [BerandaController::class, 'index'])
    ->name('beranda');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/login-berhasil', function () {
    return 'Login SIGAP berhasil!';
})->middleware('auth')->name('login.berhasil');


Route::middleware(['auth'])->group(function () {
    Route::resource('wilayah', WilayahKarhutlaController::class);
});

Route::get('/pusdalops/dashboard', function () {
    $totalLaporan = LaporanKarhutla::count();
    $menunggu = LaporanKarhutla::where('status', 'Menunggu')->count();
    $terverifikasi = LaporanKarhutla::whereIn('status', ['Terverifikasi', 'Disetujui'])->count();
    $perluPenilaian = LaporanKarhutla::whereIn('status', ['Terverifikasi', 'Disetujui'])->whereNull('tingkat_risiko')->count();
    $risikoTinggiKritis = LaporanKarhutla::whereIn('tingkat_risiko', ['Kritis', 'Tinggi'])->count();
    $totalWilayah = \App\Models\WilayahKarhutla::count();

    $laporanTerbaru = LaporanKarhutla::latest()->take(6)->get();
    $semuaLaporan = LaporanKarhutla::latest()->get();

    $ringkasan = [
        'total' => $totalLaporan,
        'menunggu' => $menunggu,
        'terverifikasi' => $terverifikasi,
        'perlu_penilaian' => $perluPenilaian,
        'risiko_tinggi_kritis' => $risikoTinggiKritis,
        'total_wilayah' => $totalWilayah,
    ];

    return view('petugas.pusdalops.dashboard', compact('ringkasan', 'laporanTerbaru', 'semuaLaporan'));
})->middleware('auth')->name('pusdalops.dashboard');

Route::get('/damkar/dashboard', function () {
    return view('petugas.damkar.dashboard');
})->middleware('auth')->name('damkar.dashboard');

Route::get('/rr/dashboard', function () {
    return view('petugas.rr.dashboard');
})->middleware('auth')->name('rr.dashboard');

require __DIR__.'/fsi02.php';
require __DIR__.'/fsi05.php';

Route::get('/laporan/create', [LaporanKarhutlaController::class, 'create'])
    ->name('laporan.create');

Route::post('/laporan', [LaporanKarhutlaController::class, 'store'])
    ->name('laporan.store');

Route::get('/cek-status', [LaporanKarhutlaController::class, 'cekStatus'])
    ->name('laporan.cekStatus');

Route::post('/cek-status', [LaporanKarhutlaController::class, 'hasilStatus'])
    ->name('laporan.hasilStatus');

Route::middleware(['auth'])->group(function () {
    Route::get('/laporan', [LaporanKarhutlaController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{id}', [LaporanKarhutlaController::class, 'show'])->whereNumber('id')->name('laporan.show');
    Route::post('/laporan/{id}/setujui', [LaporanKarhutlaController::class, 'setujui'])->whereNumber('id')->name('laporan.setujui');
    Route::post('/laporan/{id}/tolak', [LaporanKarhutlaController::class, 'tolak'])->whereNumber('id')->name('laporan.tolak');
    Route::put('/laporan/{id}/perbarui-alasan', [LaporanKarhutlaController::class, 'perbaruiAlasan'])->whereNumber('id')->name('laporan.perbaruiAlasan');

    // Endpoint API untuk mengambil daftar dan detail laporan serta persetujuan
    Route::prefix('api')->group(function () {
        Route::get('/laporan', [LaporanKarhutlaController::class, 'apiIndex'])->name('api.laporan.index');
        Route::get('/laporan/{id}', [LaporanKarhutlaController::class, 'apiShow'])->whereNumber('id')->name('api.laporan.show');
        Route::post('/laporan/{id}/setujui', [LaporanKarhutlaController::class, 'setujui'])->whereNumber('id')->name('api.laporan.setujui');
        Route::post('/laporan/{id}/tolak', [LaporanKarhutlaController::class, 'tolak'])->whereNumber('id')->name('api.laporan.tolak');
    });
});

require __DIR__.'/auth.php';
