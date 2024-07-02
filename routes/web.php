<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/', [App\Http\Controllers\AuthController::class, 'index'])->name('login')->middleware('guest');
Route::get('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register')->middleware('guest');

Route::post('/add', [App\Http\Controllers\AuthController::class, 'add'])->name('add');
Route::post('/verify', [App\Http\Controllers\AuthController::class, 'verify'])->name('verify');

Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::get('/barang', [App\Http\Controllers\BarangController::class, 'index'])->name('barang');
Route::get('/barang/{kd_brg}/edit', [App\Http\Controllers\BarangController::class, 'edit'])->name('barang.edit');
Route::put('/barang/{kd_brg}', [App\Http\Controllers\BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/{kd_brg}', [App\Http\Controllers\BarangController::class, 'destroy'])->name('barang.destroy');

Route::get('/pembelian', [App\Http\Controllers\PembelianController::class, 'index'])->name('pembelian');
Route::post('/pembelian/store', [App\Http\Controllers\PembelianController::class, 'store'])->name('pembelian.store');

// Route untuk validasi kode barang
Route::post('/check-kodebarang', [App\Http\Controllers\PembelianController::class, 'checkKodeBarang'])->name('check.kodebarang');

Route::get('/pengeluaran', [App\Http\Controllers\PengeluaranController::class, 'index'])->name('pengeluaran');
Route::post('/pengeluaran/store', [App\Http\Controllers\PengeluaranController::class, 'store'])->name('pengeluaran.store');

Route::get('/setstok', [App\Http\Controllers\SetStokController::class, 'index'])->name('setstok');
Route::post('/setstok/store', [App\Http\Controllers\SetStokController::class, 'store'])->name('setstok.store');

Route::get('/setjual', [App\Http\Controllers\SetJualController::class, 'index'])->name('setjual');
Route::post('/setjual/store', [App\Http\Controllers\SetJualController::class, 'store'])->name('setjual.store');

Route::get('/fakturPembelian', [App\Http\Controllers\FakturPembelianController::class, 'index'])->name('fakturPembelian');
Route::get('/faktur-pembelian/{no_faktur}', [App\Http\Controllers\FakturPembelianController::class, 'view'])->name('fakturPembelian.view');

Route::get('/fakturPengeluaran', [App\Http\Controllers\FakturPengeluaranController::class, 'index'])->name('fakturPengeluaran');
Route::get('/faktur-pengeluaran/{no_fk}', [App\Http\Controllers\FakturPengeluaranController::class, 'view'])->name('fakturPengeluaran.view');

Route::get('/laporan/stok-barang', [App\Http\Controllers\LaporanController::class, 'stokBarang'])->name('lapStok');
Route::get('/laporan/penjualan', [App\Http\Controllers\LaporanController::class, 'penjualan'])->name('lapPenjualan');
Route::get('/laporan/pengeluaran-perbulan', [App\Http\Controllers\LaporanController::class, 'pengeluaranPerbulan'])->name('lapBarangKeluar');
Route::get('/laporan/pembelian-perbulan', [App\Http\Controllers\LaporanController::class, 'pembelianPerbulan'])->name('lapBarangMasuk');

Route::get('/laporan/pembelian-perbulan/pdf', [App\Http\Controllers\LaporanController::class, 'exportPdfPembelian'])->name('laporan.pembelian_perbulan.pdf');
Route::get('/laporan/pembelian-perbulan/excel', [App\Http\Controllers\LaporanController::class, 'exportExcelPembelian'])->name('laporan.pembelian_perbulan.excel');

Route::get('/laporan/pengeluaran-perbulan/pdf', [App\Http\Controllers\LaporanController::class, 'exportPdfPengeluaran'])->name('laporan.pengeluaran_perbulan.pdf');
Route::get('/laporan/pengeluaran-perbulan/excel', [App\Http\Controllers\LaporanController::class, 'exportExcelPengeluaran'])->name('laporan.pengeluaran_perbulan.excel');

Route::get('/laporan/penjualan/pdf', [App\Http\Controllers\LaporanController::class, 'exportPdfPenjualan'])->name('laporan.Penjualan.pdf');
Route::get('/laporan/penjualan/excel', [App\Http\Controllers\LaporanController::class, 'exportExcelPenjualan'])->name('laporan.Penjualan.excel');


Route::get('/laporan/stok/pdf', [App\Http\Controllers\LaporanController::class, 'exportPdfStok'])->name('laporan.stokBarang.pdf');
Route::get('/laporan/stok/excel', [App\Http\Controllers\LaporanController::class, 'exportExcelStok'])->name('laporan.stokBarang.excel');
