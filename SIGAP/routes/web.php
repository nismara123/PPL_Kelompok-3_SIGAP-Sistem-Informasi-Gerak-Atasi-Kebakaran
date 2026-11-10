<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WilayahKarhutlaController;
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

require __DIR__.'/auth.php';
