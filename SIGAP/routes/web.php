<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WilayahKarhutlaController;
use App\Http\Controllers\LaporanKarhutlaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
    return view('petugas.pusdalops.dashboard');
})->name('pusdalops.dashboard');

Route::get('/damkar/dashboard', function () {
    return view('petugas.damkar.dashboard');
})->middleware('auth')->name('damkar.dashboard');

Route::get('/rr/dashboard', function () {
    return view('petugas.rr.dashboard');
})->middleware('auth')->name('rr.dashboard');

Route::get('/rr/dashboard', function () {
    return view('petugas.rr.dashboard');
})->middleware('auth')->name('rr.dashboard');

Route::get('/laporan/create', [LaporanKarhutlaController::class, 'create'])
    ->name('laporan.create');

Route::post('/laporan', [LaporanKarhutlaController::class, 'store'])
    ->name('laporan.store');

Route::get('/cek-status', [LaporanKarhutlaController::class, 'cekStatus'])
    ->name('laporan.cekStatus');

Route::post('/cek-status', [LaporanKarhutlaController::class, 'hasilStatus'])
    ->name('laporan.hasilStatus');

require __DIR__.'/auth.php';
