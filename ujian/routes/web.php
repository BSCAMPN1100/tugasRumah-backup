<?php

use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\UserController;
use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RiwayatController; // ← TAMBAHKAN DI ATAS

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

Route::middleware(['role:admin'])->group(function () {

Route::get('/dashboard/admin', function () {
    $totalBarang = Barang::count();
    $omzetHariIni = Penjualan::whereDate('created_at', today())->sum('total_harga') ?? 0;
    $keuntunganHariIni = Penjualan::whereDate('created_at', today())->sum('keuntungan_kotor') ?? 0;
    return view('dashboard.admin', compact('totalBarang', 'omzetHariIni', 'keuntunganHariIni'));
})->name('dashboard.admin');
    Route::resource('barang', BarangController::class);
    Route::resource('pembelian', PembelianController::class)->only(['index', 'create', 'store', 'edit', 'update']);
Route::resource('supplier', SupplierController::class)->only(['store', 'destroy']);
Route::resource('penjualan', PenjualanController::class)->only(['edit', 'update']);

    // ✅ Kelola Sales (cukup sekali)
    Route::resource('sales', UserController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::get('/sales/duplicate', [UserController::class, 'duplicate'])->name('sales.duplicate');
    Route::post('/sales/duplicate-handle', [UserController::class, 'handleDuplicate'])->name('sales.duplicate.handle');

    // ✅ Pembatalan Pembelian
    Route::post('/pembelian/{id}/batal', [PembelianController::class, 'batal'])->name('pembelian.batal');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
});

// ✅ Route untuk ADMIN dan SALES (penjualan)
Route::middleware(['role:admin,sales'])->group(function () {
Route::get('/penjualan/{id}/success', [PenjualanController::class, 'success'])->name('penjualan.success');
Route::resource('penjualan', PenjualanController::class)->only(['index', 'create', 'store']);
});

Route::middleware(['role:sales'])->group(function () {
    Route::get('/dashboard/sales', function () {
        $userId = auth()->id();
        $hariIni = today();

        // Ringkasan hari ini untuk sales yang login
        $totalTransaksiHariIni = \App\Models\Penjualan::where('user_id', $userId)
            ->whereDate('created_at', $hariIni)
            ->count();

        $omzetHariIni = \App\Models\Penjualan::where('user_id', $userId)
            ->whereDate('created_at', $hariIni)
            ->sum('total_harga') ?? 0;

        return view('dashboard.sales', compact('totalTransaksiHariIni', 'omzetHariIni'));
    })->name('dashboard.sales');
});
});