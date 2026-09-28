<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KeberangkatanController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\KedatanganController;
use App\Http\Controllers\PapanController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/',  [PapanController::class, 'index'])->name('papan');

Route::get('/datang', [PapanController::class, 'kedatangan'])->name('datang');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [KeberangkatanController::class, 'index'])->name('dashboard');

    Route::get('/resetJadwal', [KeberangkatanController::class, 'resetStatus'])->name('resetJadwal');
    Route::get('/resetKedatangan', [KedatanganController::class, 'resetStatus'])->name('resetKedatangan');

    Route::resource('keberangkatan', KeberangkatanController::class);
    Route::resource('bus', BusController::class);
    Route::resource('lokasi', LokasiController::class);
    Route::resource('user', UserController::class);
    Route::resource('kedatangan', KedatanganController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';