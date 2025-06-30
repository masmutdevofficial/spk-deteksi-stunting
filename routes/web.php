<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataBayiController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\StatusGiziController;
use App\Http\Controllers\JadwalKegiatanController;
use App\Http\Controllers\JadwalPenimbanganController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('data-bayi', [DataBayiController::class, 'index'])->name('data-bayi.index');
Route::post('data-bayi', [DataBayiController::class, 'store'])->name('data-bayi.store');
Route::put('data-bayi/{id}', [DataBayiController::class, 'update'])->name('data-bayi.update');
Route::delete('data-bayi/{id}', [DataBayiController::class, 'destroy'])->name('data-bayi.destroy');

Route::get('jadwal-kegiatan', [JadwalKegiatanController::class, 'index'])->name('jadwal-kegiatan.index');
Route::post('jadwal-kegiatan', [JadwalKegiatanController::class, 'store'])->name('jadwal-kegiatan.store');
Route::put('jadwal-kegiatan/{id}', [JadwalKegiatanController::class, 'update'])->name('jadwal-kegiatan.update');
Route::delete('jadwal-kegiatan/{id}', [JadwalKegiatanController::class, 'destroy'])->name('jadwal-kegiatan.destroy');

Route::get('jadwal-penimbangan', [JadwalPenimbanganController::class, 'index'])->name('jadwal-penimbangan.index');
Route::post('jadwal-penimbangan', [JadwalPenimbanganController::class, 'store'])->name('jadwal-penimbangan.store');
Route::put('jadwal-penimbangan/{id}', [JadwalPenimbanganController::class, 'update'])->name('jadwal-penimbangan.update');
Route::delete('jadwal-penimbangan/{id}', [JadwalPenimbanganController::class, 'destroy'])->name('jadwal-penimbangan.destroy');

Route::get('status-gizi', [StatusGiziController::class, 'index'])->name('status-gizi.index');
Route::get('konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi.index');
