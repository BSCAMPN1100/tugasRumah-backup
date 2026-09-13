<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua sales (termasuk yang sudah dihapus)
     */
public function index()
{
    $sales = User::withTrashed()
        ->where('role', 'sales')
        ->withCount('penjualan as total_transaksi')
        ->withSum('penjualan as total_omzet', 'total_harga')
        ->get();

    return view('sales.index', compact('sales'));
}
    /**
     * Menampilkan form tambah sales
     */
    public function create()
    {
        return view('sales.create');
    }
public function show($id)
{
    $sales = User::withTrashed()
        ->where('role', 'sales')
        ->withCount('penjualan as total_transaksi')
        ->withSum('penjualan as total_omzet', 'total_harga')
        ->withSum('penjualan as total_keuntungan', 'keuntungan_kotor')
        ->findOrFail($id);

    // Ambil 10 riwayat penjualan terakhir
    $penjualan = \App\Models\Penjualan::where('user_id', $id)
        ->with('detail')
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();

    return view('sales.show', compact('sales', 'penjualan'));
}
    /**
     * Menyimpan sales baru ke database
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cek apakah ada user dengan nama yang sama (termasuk yang sudah dihapus)
        $existingUser = User::withTrashed()->where('name', $request->name)->first();

        if ($existingUser) {
            // Jika ada, arahkan ke halaman pilihan duplikasi
            return redirect()->route('sales.duplicate', [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);
        }

        // Jika tidak ada duplikat, buat langsung
        return $this->createUser($request->name, $request->email, $request->password);
    }
    /**
     * Menampilkan halaman pilihan duplikasi (P5)
     */
    public function duplicate(Request $request)
    {
        $name = $request->query('name');
        $email = $request->query('email');
        $password = $request->query('password');

        return view('sales.duplicate', compact('name', 'email', 'password'));
    }

    /**
     * Memproses pilihan duplikasi (P5)
     */
    public function handleDuplicate(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $choice = $request->choice; // 'A' atau 'B'

        if ($choice === 'A') {
            // Opsi A: Pakai nama "Budi", riwayat lama berubah jadi "Budi (tidak aktif)"
            $existingUser = User::withTrashed()->where('name', $name)->first();
            if ($existingUser) {
                // Update display_name user lama
                $existingUser->display_name = $name . ' (tidak aktif)';
                $existingUser->save();
            }

            // Buat user baru dengan nama yang sama
            return $this->createUser($name, $email, $password);
        }

        if ($choice === 'B') {
            // Opsi B: Pakai nama "Budi (2)"
            $newDisplayName = User::generateDisplayName($name);
            return $this->createUser($name, $email, $password, $newDisplayName);
        }

        return redirect()->route('sales.create')->with('error', 'Pilihan tidak valid!');
    }

    /**
     * Fungsi internal untuk membuat user baru
     */
    private function createUser($name, $email, $password, $displayName = null)
    {
        $user = User::create([
            'name' => $name,
            'display_name' => $displayName ?? $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'sales',
        ]);

        return redirect()->route('sales.index')
            ->with('success', "Sales '{$user->display_name}' berhasil ditambahkan!");
    }

    /**
     * Menampilkan form edit sales
     */
    public function edit($id)
    {
        $sales = User::findOrFail($id);
        return view('sales.edit', compact('sales'));
    }

    /**
     * Mengupdate data sales
     */
    public function update(Request $request, $id)
    {
        $sales = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($sales->id),
            ],
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'name' => $request->name,
            'display_name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $sales->update($data);

        return redirect()->route('sales.index')
            ->with('success', 'Sales berhasil diupdate!');
    }

    /**
     * Menghapus sales (soft delete)
     */
    public function destroy($id)
    {
        $sales = User::findOrFail($id);
        $sales->delete();

        return redirect()->route('sales.index')
            ->with('success', 'Sales berhasil dihapus! (Riwayat tetap tersimpan)');
    }
}
