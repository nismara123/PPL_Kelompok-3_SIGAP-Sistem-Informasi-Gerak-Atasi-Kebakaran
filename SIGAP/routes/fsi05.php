<?php

use App\Http\Controllers\PenilaianRisikoController;
use Illuminate\Support\Facades\Route;

// FSI-05: Penilaian Risiko dan Prioritas Kejadian
// PBI-013: Mencatat hasil penilaian risiko suatu kejadian karhutla
// PBI-014: Memperbarui hasil penilaian risiko kejadian
// PBI-015: Melihat tingkat risiko dan prioritas setiap kejadian

Route::middleware(['auth'])->group(function () {
    Route::get('/penilaian-risiko', [PenilaianRisikoController::class, 'index'])
        ->name('penilaian-risiko.index');

    Route::get('/penilaian-risiko/{id}/create', [PenilaianRisikoController::class, 'create'])
        ->whereNumber('id')
        ->name('penilaian-risiko.create');

    Route::post('/laporan/{id}/penilaian-risiko', [PenilaianRisikoController::class, 'store'])
        ->whereNumber('id')
        ->name('penilaian-risiko.store');

    Route::get('/penilaian-risiko/{id}/edit', [PenilaianRisikoController::class, 'edit'])
        ->whereNumber('id')
        ->name('penilaian-risiko.edit');

    Route::put('/laporan/{id}/penilaian-risiko', [PenilaianRisikoController::class, 'update'])
        ->whereNumber('id')
        ->name('penilaian-risiko.update');

    // API Endpoint
    Route::prefix('api')->group(function () {
        Route::get('/penilaian-risiko', [PenilaianRisikoController::class, 'index'])->name('api.penilaian-risiko.index');
        Route::post('/laporan/{id}/penilaian-risiko', [PenilaianRisikoController::class, 'store'])->whereNumber('id')->name('api.penilaian-risiko.store');
        Route::put('/laporan/{id}/penilaian-risiko', [PenilaianRisikoController::class, 'update'])->whereNumber('id')->name('api.penilaian-risiko.update');
    });
});

