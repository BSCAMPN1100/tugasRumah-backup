<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter periode (default: bulan ini)
        $periode = $request->get('periode', 'bulan');
        $dari = $request->get('dari');
        $sampai = $request->get('sampai');

        // Tentukan rentang tanggal
        [$startDate, $endDate, $labelPeriode] = $this->getRentangTanggal($periode, $dari, $sampai);

        // ================= PEMASUKAN (PENJUALAN) =================
        $queryPenjualan = Penjualan::whereBetween('created_at', [$startDate, $endDate]);
        $totalOmzet = (clone $queryPenjualan)->sum('total_harga') ?? 0;
        $totalKeuntunganKotor = (clone $queryPenjualan)->sum('keuntungan_kotor') ?? 0;
        $totalTransaksiPenjualan = (clone $queryPenjualan)->count();

        $transaksiPenjualan = $queryPenjualan->with('user', 'detail')
            ->orderBy('created_at', 'desc')
            ->get();

        // ================= PENGELUARAN (PEMBELIAN) =================
        $queryPembelian = Pembelian::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'selesai'); // hanya yang tidak batal

        $totalPengeluaran = (clone $queryPembelian)->sum('total_harga') ?? 0;
        $totalTransaksiPembelian = (clone $queryPembelian)->count();

        $transaksiPembelian = $queryPembelian->with('supplier', 'detail')
            ->orderBy('created_at', 'desc')
            ->get();

        // ================= LABA BERSIH =================
        $labaBersih = $totalOmzet - $totalPengeluaran;

        return view('laporan.index', compact(
            'periode', 'dari', 'sampai', 'labelPeriode',
            'totalOmzet', 'totalKeuntunganKotor', 'totalTransaksiPenjualan',
            'totalPengeluaran', 'totalTransaksiPembelian',
            'labaBersih',
            'transaksiPenjualan', 'transaksiPembelian'
        ));
    }

    private function getRentangTanggal($periode, $dari, $sampai)
    {
        $now = Carbon::now();

        switch ($periode) {
            case 'hari':
                return [$now->copy()->startOfDay(), $now->copy()->endOfDay(), 'Hari Ini'];
            case '7hari':
                return [$now->copy()->subDays(6)->startOfDay(), $now->copy()->endOfDay(), '7 Hari Terakhir'];
            case '30hari':
                return [$now->copy()->subDays(29)->startOfDay(), $now->copy()->endOfDay(), '30 Hari Terakhir'];
            case 'bulan':
                return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth(), 'Bulan Ini'];
            case 'custom':
                if ($dari && $sampai) {
                    return [
                        Carbon::parse($dari)->startOfDay(),
                        Carbon::parse($sampai)->endOfDay(),
                        Carbon::parse($dari)->format('d/m/Y') . ' - ' . Carbon::parse($sampai)->format('d/m/Y')
                    ];
                }
                return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth(), 'Bulan Ini'];
            default:
                return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth(), 'Bulan Ini'];
        }
    }
}