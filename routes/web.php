<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataBayiController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\StatusGiziController;
use App\Http\Controllers\JadwalKegiatanController;
use App\Http\Controllers\JadwalPenimbanganController;
use App\Http\Controllers\PenangananController;
use App\Http\Controllers\PenangananGiziController;

Route::middleware('sudahLogin')->group(function () {
    Route::get('/', [LoginController::class,'chooseRole'])->name('login.choose');
    Route::get('/login', [LoginController::class,'chooseRole'])->name('login.choose');
    Route::get('/login/admin', [LoginController::class,'showAdminForm'])->name('login.admin.form');
    Route::get('/login/tenaga-medis', [LoginController::class,'showTenagaForm'])->name('login.tenaga.form');
});

Route::post('/login/admin',         [LoginController::class,'loginAdmin'])->name('login.admin.proses');
Route::post('/login/tenaga-medis',  [LoginController::class,'loginTenaga'])->name('login.tenaga.proses');
Route::post('/logout',              [LoginController::class,'logout'])->name('logout');

Route::middleware('cekLogin')->group(function () {
    Route::get('data-bayi', [DataBayiController::class, 'index'])->name('data-bayi.index');
    Route::get('cetak-laporan-pdf', [DataBayiController::class, 'cetakLaporanPdf'])->name('data-bayi.cetakLaporanPdf');
    Route::get('/cetak-detail-bayi', [DataBayiController::class, 'cetakDetailBayiPdf']);

    Route::post('data-bayi', [DataBayiController::class, 'store'])->name('data-bayi.store');
    Route::put('data-bayi/{id}', [DataBayiController::class, 'update'])->name('data-bayi.update');
    Route::post('data-bayi-medis', [DataBayiController::class, 'storeMedis'])->name('data-bayi-medis.store');
    Route::delete('data-bayi/{id}', [DataBayiController::class, 'destroy'])->name('data-bayi.destroy');

    Route::get('jadwal-kegiatan', [JadwalKegiatanController::class, 'index'])->name('jadwal-kegiatan.index');
    Route::post('jadwal-kegiatan', [JadwalKegiatanController::class, 'store'])->name('jadwal-kegiatan.store');
    Route::put('jadwal-kegiatan/{id}', [JadwalKegiatanController::class, 'update'])->name('jadwal-kegiatan.update');
    Route::delete('jadwal-kegiatan/{id}', [JadwalKegiatanController::class, 'destroy'])->name('jadwal-kegiatan.destroy');

    Route::get('jadwal-penimbangan', [JadwalPenimbanganController::class, 'index'])->name('jadwal-penimbangan.index');
    Route::post('jadwal-penimbangan', [JadwalPenimbanganController::class, 'store'])->name('jadwal-penimbangan.store');
    Route::put('jadwal-penimbangan/{id}', [JadwalPenimbanganController::class, 'update'])->name('jadwal-penimbangan.update');
    Route::delete('jadwal-penimbangan/{id}', [JadwalPenimbanganController::class, 'destroy'])->name('jadwal-penimbangan.destroy');
    Route::get('cetak-jadwal-kegiatan', [JadwalKegiatanController::class, 'cetak'])->name('jadwal-kegiatan.cetak');
    Route::get('cetak-jadwal-penimbangan', [JadwalPenimbanganController::class, 'cetak'])->name('jadwal-penimbangan.cetak');

    Route::get('penanganan-gizi', [PenangananGiziController::class, 'index'])->name('penanganan-gizi.index');
    Route::get('cetak-penanganan-gizi', [PenangananGiziController::class, 'cetakPenangananGizi'])->name('cetak-penanganan-gizi.index');

    Route::get('status-gizi', [StatusGiziController::class, 'index'])->name('status-gizi.index');
    Route::get('konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi.index');
    Route::get('hasil-deteksi', [DataBayiController::class, 'hasilDeteksi'])->name('hasilDeteksi');
    Route::get('penanganan', [PenangananController::class, 'index'])->name('penanganan.index');
    Route::post('simpan-penanganan', [PenangananController::class, 'store'])->name('penanganan.store');

    Route::get('perhitungan', [DataBayiController::class, 'perhitungan'])->name('perhitungan.index');
});
