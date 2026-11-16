<?php

use App\Http\Controllers\KerusakanLahanController;
use Illuminate\Support\Facades\Route;

// FSI-02: Pengelolaan Data Kerusakan Lahan Terdampak
// PBI-004 tambah | PBI-005 ubah | PBI-006 daftar + detail
Route::middleware('auth')->group(function () {
    Route::resource('kerusakan-lahan', KerusakanLahanController::class)
        ->parameters(['kerusakan-lahan' => 'kerusakanLahan']);
});
