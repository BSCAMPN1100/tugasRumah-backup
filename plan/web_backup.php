<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PembelianController;
use App\Models\Barang;
use App\Models\TransaksiPenjualan;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard/admin', function () {
            // Data summary
            $totalBarang = Barang::count();

            // Omzet hari ini (dari transaksi penjualan hari ini)
            $omzetHariIni = TransaksiPenjualan::whereDate('created_at', today())->sum('total') ?? 0;

            // Keuntungan kotor hari ini
            $keuntunganHariIni = TransaksiPenjualan::whereDate('created_at', today())->sum('keuntungan_kotor') ?? 0;

            return view('dashboard.admin', compact('totalBarang', 'omzetHariIni', 'keuntunganHariIni'));
        })->name('dashboard.admin');

        Route::resource('barang', BarangController::class);
        Route::resource('pembelian', PembelianController::class)->except(['show', 'edit', 'update', 'destroy']);
    });

    Route::middleware(['role:sales'])->group(function () {
        Route::get('/dashboard/sales', function () {
            return view('dashboard.sales');
        })->name('dashboard.sales');
    });
    Route::get('/test-auth', function () {
    return 'Anda sudah login!';
})->middleware('auth');
});
