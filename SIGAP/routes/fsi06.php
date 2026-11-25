<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KoordinasiDamkarController;

Route::middleware(['auth'])->group(function () {

    // ==========================================
    // PBI-016: Mengirim Permintaan Penanganan
    // ==========================================

    // Menampilkan daftar koordinasi Damkar
    Route::get('/koordinasi-damkar', [KoordinasiDamkarController::class, 'index'])
        ->name('koordinasi-damkar.index');

    // Menampilkan form pengiriman permintaan
    Route::get('/koordinasi-damkar/create', [KoordinasiDamkarController::class, 'create'])
        ->name('koordinasi-damkar.create');

    // Menyimpan permintaan koordinasi
    Route::post('/koordinasi-damkar', [KoordinasiDamkarController::class, 'store'])
        ->name('koordinasi-damkar.store');


    // ==========================================
    // PBI-018: Konfirmasi dan Penentuan Tim Damkar
    // ==========================================

    // Menampilkan detail permintaan untuk petugas Damkar
    Route::get('/koordinasi-damkar/{id}', [KoordinasiDamkarController::class, 'show'])
        ->name('koordinasi-damkar.show');

    // Petugas Damkar memberikan konfirmasi dan menentukan tim
    Route::post('/koordinasi-damkar/{id}/confirm', [KoordinasiDamkarController::class, 'confirm'])
        ->name('koordinasi-damkar.confirm');

});
