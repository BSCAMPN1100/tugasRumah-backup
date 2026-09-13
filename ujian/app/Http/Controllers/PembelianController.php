<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelian = Pembelian::with('supplier', 'detail.barang')->orderBy('created_at', 'desc')->get();
        return view('pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $barang = Barang::all();
        $supplier = Supplier::all();
        return view('pembelian.create', compact('barang', 'supplier'));
    }
public function edit($id)
{
$pembelian = Pembelian::with('detail.barang')->findOrFail($id);
$barang = Barang::all();
$supplier = Supplier::all();
return view('pembelian.edit', compact('pembelian', 'barang', 'supplier'));
}
public function update(Request $request, $id)
{
    try {
        // Validasi
        $validator = validator($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_modal_saat_beli' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // 🔥 Database Transaction
        DB::transaction(function () use ($request, $id) {
            // Ambil data pembelian lama (sebelum diupdate)
            $pembelian = Pembelian::with('detail')->findOrFail($id);

            // 🔥 STEP 1: Kembalikan stok lama (rollback stok)
            foreach ($pembelian->detail as $detail) {
                $barang = Barang::findOrFail($detail->barang_id);
                $barang->stok -= $detail->jumlah;
                $barang->save();
            }

            // 🔥 STEP 2: Hapus detail lama
            $pembelian->detail()->delete();

            // 🔥 STEP 3: Update header
            $totalHarga = 0;
            foreach ($request->items as $item) {
                $totalHarga += $item['jumlah'] * $item['harga_modal_saat_beli'];
            }

            $pembelian->update([
                'supplier_id' => $request->supplier_id,
                'total_harga' => $totalHarga,
            ]);

            // 🔥 STEP 4: Simpan detail baru dan update stok + harga modal
            foreach ($request->items as $item) {
                $barang = Barang::findOrFail($item['barang_id']);

                // Simpan detail baru
                $pembelian->detail()->create([
                    'barang_id' => $item['barang_id'],
                    'nama_barang_snapshot' => $barang->nama,
                    'satuan_snapshot' => $barang->satuan,
                    'jumlah' => $item['jumlah'],
                    'harga_modal_saat_beli' => $item['harga_modal_saat_beli'],
                    'subtotal' => $item['jumlah'] * $item['harga_modal_saat_beli'],
                ]);

                // Update stok
                $barang->stok += $item['jumlah'];

                // Update harga modal
                $barang->harga_modal = $item['harga_modal_saat_beli'];

                $barang->save();
            }
        }); // END DB::transaction

        return response()->json([
            'success' => true,
            'message' => 'Pembelian berhasil diupdate!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
public function batal($id)
{
    try {
        \Log::info('Mencoba membatalkan pembelian ID: ' . $id);

        DB::transaction(function () use ($id) {
            $pembelian = Pembelian::with('detail')->findOrFail($id);

            if ($pembelian->status === 'batal') {
                throw new \Exception('Pembelian ini sudah dibatalkan sebelumnya.');
            }

            // Cek stok
            foreach ($pembelian->detail as $detail) {
                $barang = Barang::findOrFail($detail->barang_id);
                \Log::info("Cek stok {$barang->nama}: stok={$barang->stok}, butuh={$detail->jumlah}");

                if ($barang->stok < $detail->jumlah) {
                    throw new \Exception(
                        "Stok {$barang->nama} tidak mencukupi (tersisa {$barang->stok}, butuh {$detail->jumlah})."
                    );
                }
            }

            // Kurangi stok
            foreach ($pembelian->detail as $detail) {
                $barang = Barang::findOrFail($detail->barang_id);
                $barang->stok -= $detail->jumlah;
                $barang->save();
                \Log::info("Stok {$barang->nama} dikurangi menjadi {$barang->stok}");
            }

            $pembelian->status = 'batal';
            $pembelian->save();
            \Log::info('Pembelian berhasil dibatalkan');
        });

        return redirect()->route('pembelian.index')
            ->with('success', 'Pembelian berhasil dibatalkan!');
    } catch (\Exception $e) {
        \Log::error('Gagal membatalkan pembelian: ' . $e->getMessage());
        return redirect()->route('pembelian.index')
            ->with('error', 'Gagal membatalkan pembelian: ' . $e->getMessage());
    }
}
public function store(Request $request)
{
    try {
        // Validasi
        $validator = validator($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_modal_saat_beli' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
// Cek duplikasi barang_id
$barangIds = array_column($request->items, 'barang_id');
if (count($barangIds) !== count(array_unique($barangIds))) {
    return response()->json([
        'success' => false,
        'message' => 'Tidak boleh ada duplikasi barang dalam satu transaksi!'
    ], 422);
}
// Ambil data supplier
$supplier = Supplier::findOrFail($request->supplier_id);
        // 🔥 Database Transaction (P7)
        DB::transaction(function () use ($request) {
            $totalHarga = 0;
            foreach ($request->items as $item) {
                $totalHarga += $item['jumlah'] * $item['harga_modal_saat_beli'];
            }

            // Simpan header pembelian
$pembelian = Pembelian::create([
'supplier_id' => $request->supplier_id,
'nama_supplier_snapshot' => $supplier->nama,
'total_harga' => $totalHarga,
            ]);

            // Simpan detail dan update stok + harga modal
            foreach ($request->items as $item) {
                $barang = Barang::findOrFail($item['barang_id']);

                // Simpan detail dengan snapshot
                PembelianDetail::create([
                    'pembelian_id' => $pembelian->id,
                    'barang_id' => $item['barang_id'],
                    'nama_barang_snapshot' => $barang->nama,
                    'satuan_snapshot' => $barang->satuan,
                    'jumlah' => $item['jumlah'],
                    'harga_modal_saat_beli' => $item['harga_modal_saat_beli'],
                    'subtotal' => $item['jumlah'] * $item['harga_modal_saat_beli'],
                ]);

                // 🔥 Update stok (existing)
                $barang->stok += $item['jumlah'];

                // 🔥 P6: Update harga modal barang dengan harga modal terbaru
                $barang->harga_modal = $item['harga_modal_saat_beli'];

                $barang->save();
            }
        }); // END DB::transaction

        return response()->json([
            'success' => true,
            'message' => 'Pembelian berhasil dicatat!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}
}