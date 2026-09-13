<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Menampilkan daftar barang
public function index()
{
    $barang = Barang::all();
    $role = auth()->user()->role; // 'admin' atau 'sales'
    return view('barang.index', compact('barang', 'role'));
}

    // Menampilkan form tambah barang
    public function create()
    {
        return view('barang.create');
    }

    // Menyimpan barang baru
public function store(Request $request)
{
    // Trim nama
    $request->merge(['nama' => trim($request->nama)]);

    $request->validate([
        'nama' => 'required|string|max:255|unique:barang,nama',
        'satuan' => 'nullable|string|max:50',
        'harga_jual' => 'required|numeric|min:0',
        // stok dan harga_modal bisa diisi opsional, kita set default 0
    ]);

    Barang::create([
        'nama' => $request->nama,
        'satuan' => $request->satuan,
        'stok' => $request->stok ?? 0,
        'harga_modal' => $request->harga_modal ?? 0,
        'harga_jual' => $request->harga_jual,
    ]);

    return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan!');
}

    // Menampilkan form edit barang
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    // Mengupdate barang
public function update(Request $request, $id)
{
    // Trim nama
    $request->merge(['nama' => trim($request->nama)]);

    $request->validate([
        'nama' => 'required|string|max:255|unique:barang,nama,' . $id,
        'satuan' => 'nullable|string|max:50',
        'harga_jual' => 'required|numeric|min:0',
    ]);

    $barang = Barang::findOrFail($id);
    $barang->nama = $request->nama;
    $barang->satuan = $request->satuan;
    $barang->stok = $request->stok ?? $barang->stok; // jika tidak diisi, tetap pakai yang lama
    $barang->harga_modal = $request->harga_modal ?? $barang->harga_modal;
    $barang->harga_jual = $request->harga_jual;
    $barang->save();

    return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate!');
}
    // Menghapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus!');
    }
}
