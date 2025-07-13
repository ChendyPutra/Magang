<?php

use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengelolaanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PemasukanController::class, 'showForUser'])->name('welcome');



Route::get('/pengeluaran/view', [PengeluaranController::class, 'view'])->name('pengeluaran_view');


Route::get('/rapbdes', [AnggaranController::class, 'rapbdes'])->name('RAPBDes');


Route::post('/komentar/{type}', [KomentarController::class, 'store'])->name('komentar.store');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/laporan/index', [LaporanController::class, 'index'])->name('laporan.index');

    Route::get('/pengelolaan/index', [PengelolaanController::class, 'index'])->name('pengelolaan.index');

    Route::get('/komentar/{type}/index', [KomentarController::class, 'show'])->name('komentar.show');



    Route::get('/komentar/index', [KomentarController::class, 'index'])->name('komentar.index');
    Route::get('/komentar/masuk', [KomentarController::class, 'masuk'])->name('komentar.masuk');
    Route::get('/komentar/keluar', [KomentarController::class, 'keluar'])->name('komentar.keluar');
    Route::get('/komentar/rapbdess', [KomentarController::class, 'rapbdess'])->name('komentar.rapbdess');


    Route::get('/pemasukan', [PemasukanController::class, 'index'])->name('pemasukan.index');
    Route::get('/pemasukan/create', [PemasukanController::class, 'create'])->name('pemasukan.create');
    Route::post('/pemasukan', [PemasukanController::class, 'store'])->name('pemasukan.store');
    Route::get('/pemasukan/{id}/edit', [PemasukanController::class, 'edit'])->name('pemasukan.edit');
    Route::put('/pemasukan/{id}', [PemasukanController::class, 'update'])->name('pemasukan.update');
    Route::delete('/pemasukan/{id}', [PemasukanController::class, 'destroy'])->name('pemasukan.destroy');

    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::get('/pengeluaran/create', [PengeluaranController::class, 'create'])->name('pengeluaran.create');
    Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::get('/pengeluaran/{id}/edit', [PengeluaranController::class, 'edit'])->name('pengeluaran.edit');
    Route::put('/pengeluaran/{id}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
    Route::delete('/pengeluaran/{id}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');
    Route::get('/anggaran', [AnggaranController::class, 'index'])->name('anggaran.index');
    Route::get('/anggaran/diagram', [AnggaranController::class, 'diagram'])->name('anggaran.diagram');
    Route::get('/anggaran/create', [AnggaranController::class, 'create'])->name('anggaran.create');
    Route::post('/anggaran', [AnggaranController::class, 'store'])->name('anggaran.store');
    Route::get('/anggaran/{id}/edit', [AnggaranController::class, 'edit'])->name('anggaran.edit');
    Route::put('/anggaran/{id}', [AnggaranController::class, 'update'])->name('anggaran.update');
    Route::delete('/anggaran/{id}', [AnggaranController::class, 'destroy'])->name('anggaran.destroy');
    Route::post('/anggaran/update-realisasi/{id}', [AnggaranController::class, 'updateRealisasi']);
    Route::get('/filter-statistik/{tahun}', [AnggaranController::class, 'filterStatistik']);  // Menyederhanakan rute
    Route::get('/download-pdf/{tahun?}', [LaporanController::class, 'downloadPDF'])->name('download.pdf');
    Route::get('/rekap/data', [LaporanController::class, 'getData'])->name('rekap.data');




});

require __DIR__ . '/auth.php';
