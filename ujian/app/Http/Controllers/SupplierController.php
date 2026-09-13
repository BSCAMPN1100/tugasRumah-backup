<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => [
                'required',
                'string',
                'max:100',
                Rule::unique('suppliers', 'nama')->whereNull('deleted_at'),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $supplier = Supplier::create([
            'nama' => $request->nama
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Supplier berhasil ditambahkan!',
            'data' => $supplier
        ]);
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $hasPembelian = $supplier->pembelian()->count() > 0;
        $supplier->delete();

        if ($hasPembelian) {
            return redirect()->route('pembelian.index')
                ->with('warning', 'Supplier berhasil dinonaktifkan. Riwayat pembelian tetap tersimpan.');
        } else {
            return redirect()->route('pembelian.index')
                ->with('success', 'Supplier berhasil dihapus!');
        }
    }
}