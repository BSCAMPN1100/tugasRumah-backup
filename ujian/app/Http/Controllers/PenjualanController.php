<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
public function index()
{
    $user = auth()->user();
    $query = Penjualan::with('user', 'detail.barang')->orderBy('created_at', 'desc');

    // Jika sales, filter hanya miliknya sendiri
    if ($user->role === 'sales') {
        $query->where('user_id', $user->id);
    }

    $penjualan = $query->get();
    $role = $user->role;

    return view('penjualan.index', compact('penjualan', 'role'));
}
    public function create()
    {
        $barang = Barang::where('stok', '>', 0)->get();
        return view('penjualan.create', compact('barang'));
    }
    public function edit($id)
{
    $penjualan = Penjualan::with('detail.barang')->findOrFail($id);
    $barang = Barang::where('stok', '>', 0)->get();
    return view('penjualan.edit', compact('penjualan', 'barang'));
}
public function update(Request $request, $id)
{
    try {
        $validator = validator($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_jual_saat_transaksi' => 'required|numeric|min:0',
            'uang_dibayar' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        DB::transaction(function () use ($request, $id) {
            $penjualan = Penjualan::with('detail')->findOrFail($id);

            // 🔥 STEP 1: Kembalikan stok lama (rollback)
            foreach ($penjualan->detail as $detail) {
                $barang = Barang::findOrFail($detail->barang_id);
                $barang->stok += $detail->jumlah; // Tambahkan kembali stok yang sudah dikurangi
                $barang->save();
            }

            // 🔥 STEP 2: Hapus detail lama
            $penjualan->detail()->delete();

            // 🔥 STEP 3: Hitung ulang total dan keuntungan
            $totalHarga = 0;
            $totalKeuntungan = 0;

            foreach ($request->items as $item) {
                $barang = Barang::findOrFail($item['barang_id']);
                $subtotal = $item['jumlah'] * $item['harga_jual_saat_transaksi'];
                $keuntungan = ($item['harga_jual_saat_transaksi'] - $barang->harga_modal) * $item['jumlah'];

                $totalHarga += $subtotal;
                $totalKeuntungan += $keuntungan;

                // 🔥 STEP 4: Simpan detail baru dengan snapshot
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id' => $item['barang_id'],
                    'nama_barang_snapshot' => $barang->nama,
                    'satuan_snapshot' => $barang->satuan,
                    'jumlah' => $item['jumlah'],
                    'harga_jual_saat_transaksi' => $item['harga_jual_saat_transaksi'],
                    'subtotal' => $subtotal,
                ]);

                // 🔥 STEP 5: Kurangi stok dengan jumlah baru
                $barang->stok -= $item['jumlah'];
                $barang->save();
            }

// Hitung ulang kembalian
$uangDibayar = $request->uang_dibayar ?? $penjualan->uang_dibayar;
$kembalian = $uangDibayar - $totalHarga;

$penjualan->update([
    'total_harga' => $totalHarga,
    'keuntungan_kotor' => $totalKeuntungan,
    'uang_dibayar' => $uangDibayar,
    'kembalian' => $kembalian,
]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Penjualan berhasil diupdate!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
public function success($id)
{
    $penjualan = Penjualan::with('user', 'detail.barang')->findOrFail($id);
    return view('penjualan.success', compact('penjualan'));
}
public function store(Request $request)
{
    \Log::info('STORE PENJUALAN', [
        'all' => $request->all(),
        'uang_dibayar_dari_request' => $request->uang_dibayar,
    ]);
    try {
        // Validasi
        $validator = validator($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_jual_saat_transaksi' => 'required|numeric|min:0',
            'uang_dibayar' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek duplikasi barang
        $barangIds = array_column($request->items, 'barang_id');
        if (count($barangIds) !== count(array_unique($barangIds))) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak boleh ada duplikasi barang dalam satu transaksi!'
            ], 422);
        }

        // Hitung total
        $totalHarga = 0;
        foreach ($request->items as $item) {
            $totalHarga += $item['jumlah'] * $item['harga_jual_saat_transaksi'];
        }

        // Validasi uang dibayar >= total
        if ($request->uang_dibayar < $totalHarga) {
            return response()->json([
                'success' => false,
                'message' => 'Uang dibayar kurang dari total transaksi!'
            ], 422);
        }

        $kembalian = $request->uang_dibayar - $totalHarga;

        // Simpan dalam transaction
        $penjualan = null;
        DB::transaction(function () use ($request, $totalHarga, $kembalian, &$penjualan) {
            // Hitung total keuntungan
            $totalKeuntungan = 0;
            foreach ($request->items as $item) {
                $barang = Barang::findOrFail($item['barang_id']);
                $keuntungan = ($item['harga_jual_saat_transaksi'] - $barang->harga_modal) * $item['jumlah'];
                $totalKeuntungan += $keuntungan;
            }

            // Simpan header
            $penjualan = Penjualan::create([
                'user_id' => auth()->id(),
                'total_harga' => $totalHarga,
                'keuntungan_kotor' => $totalKeuntungan,
                'uang_dibayar' => $request->uang_dibayar,
                'kembalian' => $kembalian,
            ]);

            // Simpan detail & kurangi stok
            foreach ($request->items as $item) {
                $barang = Barang::findOrFail($item['barang_id']);

                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'barang_id' => $item['barang_id'],
                    'nama_barang_snapshot' => $barang->nama,
                    'satuan_snapshot' => $barang->satuan,
                    'jumlah' => $item['jumlah'],
                    'harga_jual_saat_transaksi' => $item['harga_jual_saat_transaksi'],
                    'subtotal' => $item['jumlah'] * $item['harga_jual_saat_transaksi'],
                ]);

                $barang->stok -= $item['jumlah'];
                $barang->save();
            }
        });

        // Tentukan redirect ke halaman success
        return response()->json([
            'success' => true,
            'message' => 'Penjualan berhasil dicatat!',
            'redirect_url' => route('penjualan.success', $penjualan->id),
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}
