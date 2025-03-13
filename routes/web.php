<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
use App\Http\Controllers\FarmasiController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RmController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MasterController;

Route::get('/', [MainController::class, 'index'])->name('index');

Route::get('/dokter', [MasterController::class, 'indexDokter'])->name('dokter.index');
Route::post('/dokter/store', [MasterController::class, 'storeDokter'])->name('dokter.store');
Route::put('/dokter/{id}', [MasterController::class, 'updateDokter'])->name('dokter.update');
Route::delete('/dokter/{id}', [MasterController::class, 'destroyDokter'])->name('dokter.delete');


Route::get('/distributor', [FarmasiController::class, 'distributor'])->name('distributor');
Route::post('/distributor/store', [FarmasiController::class, 'distributorStore'])->name('distributor.store');
Route::put('/distributor/{id}', [FarmasiController::class, 'distributorEdit'])->name('distributor.edit');
Route::delete('/distributor/{id}', [FarmasiController::class, 'distributorDelete'])->name('distributor.delete');

Route::get('/obat-masuk', [FarmasiController::class, 'indexObatMasuk'])->name('obat-masuk.index');
Route::post('/obat-masuk/store', [FarmasiController::class, 'storeObatMasuk'])->name('obat-masuk.store');
Route::put('/obat-masuk/update/{id}', [FarmasiController::class, 'updateObatMasuk'])->name('obat-masuk.update');
Route::delete('/obat-masuk/delete/{id}', [FarmasiController::class, 'destroyObatMasuk'])->name('obat-masuk.destroy');

Route::get('/penjualan-obat', [FarmasiController::class, 'penjualanObat'])->name('penjualan-obat');
Route::post('/penjualan/store', [FarmasiController::class, 'penjualanStore'])->name('penjualan.store');
Route::get('/penjualan/edit/{id}', [FarmasiController::class, 'penjualanEdit'])->name('penjualan.edit');
Route::put('/penjualan/update/{id}', [FarmasiController::class, 'penjualanUpdate'])->name('penjualan.update');
Route::post('/penjualan', [FarmasiController::class, 'inputPenjualan'])->name('penjualan');
Route::delete('/penjualan/delete/{id}', [FarmasiController::class, 'penjualanDelete'])->name('penjualan.delete');
Route::delete('/penjualan/detail/delete/{id}', [FarmasiController::class, 'penjualanDetailDelete'])->name('penjualan.detail.delete');
Route::get('/datapenjualan/{id}', [FarmasiController::class, 'datapenjualan'])->name('penjualan.data');
Route::get('/search-obat', [FarmasiController::class, 'searchObat']);
Route::get('/cetak-kwitansi/{id}', [FarmasiController::class, 'cetakKwitansi'])->name('cetak-kwitansi');
Route::get('/laporan-farmasi', [FarmasiController::class, 'laporanFarmasi'])->name('laporan-farmasi');

Route::get('/data-pasien', [MainController::class, 'dataPasien'])->name('pasien');
Route::post('/pasien/store', [MainController::class, 'tambahPasien'])->name('pasien.tambah');
Route::put('/pasien/{id}', [MainController::class, 'editPasien'])->name('pasien.edit');
Route::delete('/pasien/{id}', [MainController::class, 'hapusPasien'])->name('pasien.delete');
Route::get('/pasien/search', [MainController::class, 'searchPasien'])->name('pasien.search');

Route::get('/poli-umum', [RmController::class, 'poliUmum'])->name('poli-umum');
Route::put('/poli-umum/{id}', [RmController::class, 'editKunjunganumum'])->name('poli-umum.edit');
Route::delete('/poli-umum/{id}', [RmController::class, 'deleteKunjunganumum'])->name('poli-umum.delete');

Route::get('/poli-gigi', [RmController::class, 'poliGigi'])->name('poli-gigi');
Route::put('/poli-gigi/{id}', [RmController::class, 'editKunjungangigi'])->name('poli-gigi.edit');
Route::delete('/poli-gigi/{id}', [RmController::class, 'deleteKunjungangigi'])->name('poli-gigi.delete');

Route::get('/poli-kia', [RmController::class, 'poliKia'])->name('poli-kia');
Route::get('/rawat-inap', [RmController::class, 'rawatInap'])->name('rawat-inap');
Route::put('/rawat-inap/{id}', [RmController::class, 'editKunjunganinap'])->name('rawat-inap.edit');
Route::delete('/rawat-inap/{id}', [RmController::class, 'deleteKunjunganinap'])->name('rawat-inap.delete');

Route::get('/kunjungan/poli-umum/{pasien_id}', [KunjunganController::class, 'showKunjunganUmum'])->name('kunjungan.poli-umum.form');
Route::get('/kunjungan/poli-gigi/{pasien_id}', [KunjunganController::class, 'showKunjunganGigi'])->name('kunjungan.poli-gigi.form');
Route::get('/kunjungan/rawat-inap/{pasien_id}', [KunjunganController::class, 'showKunjunganInap'])->name('kunjungan.rawat-inap.form');

Route::post('/kunjungan/poli-umum', [KunjunganController::class, 'storeKunjunganUmum'])->name('kunjungan.poli-umum.store');
Route::post('/kunjungan/poli-gigi', [KunjunganController::class, 'storeKunjunganGigi'])->name('kunjungan.poli-gigi.store');
Route::post('/kunjungan/rawat-inap', [KunjunganController::class, 'storeKunjunganInap'])->name('kunjungan.rawat-inap.store');

Route::get('/laporan/kunjungan', [LaporanController::class, 'laporanKunjungan'])->name('laporan.kunjungan');
Route::get('/laporan/farmasi', [LaporanController::class, 'laporanFarmasi'])->name('laporan.farmasi');
