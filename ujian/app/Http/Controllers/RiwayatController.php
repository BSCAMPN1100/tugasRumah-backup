<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter filter
        $periode = $request->get('periode', 'bulan');
        $jenis = $request->get('jenis', 'semua');
        $dari = $request->get('dari');
        $sampai = $request->get('sampai');

        // Tentukan rentang tanggal
        [$startDate, $endDate, $labelPeriode] = $this->getRentangTanggal($periode, $dari, $sampai);

        // Kumpulkan transaksi
        $riwayat = collect();

        // Penjualan (jika jenis = semua atau penjualan)
        if ($jenis === 'semua' || $jenis === 'penjualan') {
            $penjualan = Penjualan::with('user', 'detail')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            foreach ($penjualan as $p) {
                $riwayat->push([
                    'jenis' => 'penjualan',
                    'id' => $p->id,
                    'tanggal' => $p->created_at,
                    'pihak' => $p->user->display_name ?? $p->user->name ?? '(sales dihapus)',
                    'total' => $p->total_harga,
                    'detail' => $p->detail,
                ]);
            }
        }

        // Pembelian (jika jenis = semua atau pembelian)
        if ($jenis === 'semua' || $jenis === 'pembelian') {
            $pembelian = Pembelian::with('supplier', 'detail')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'selesai')
                ->get();

            foreach ($pembelian as $p) {
                $riwayat->push([
                    'jenis' => 'pembelian',
                    'id' => $p->id,
                    'tanggal' => $p->created_at,
                    'pihak' => $p->nama_supplier_snapshot ?? $p->supplier->nama ?? '(supplier dihapus)',
                    'total' => $p->total_harga,
                    'detail' => $p->detail,
                ]);
            }
        }

        // Urutkan berdasarkan tanggal terbaru
        $riwayat = $riwayat->sortByDesc('tanggal')->values();

        return view('riwayat.index', compact(
            'riwayat', 'periode', 'jenis', 'dari', 'sampai', 'labelPeriode'
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
