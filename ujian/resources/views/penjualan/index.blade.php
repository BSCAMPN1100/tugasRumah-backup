@extends('layouts.app')

@section('title', 'Riwayat Penjualan · CatatRezekimu')

@push('styles')
<style>
    .card-table {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .btn-primary-page {
        background: #0b3b2c;
        color: white;
        padding: 8px 20px;
        border-radius: 40px;
        text-decoration: none;
        display: inline-block;
        font-weight: 600;
        font-size: 14px;
    }
    .btn-primary-page:hover { background: #082f23; }
    .table-container { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th {
        background: #f8fafc;
        text-align: left;
        padding: 10px 12px;
        font-weight: 600;
        color: #1e293b;
        border-bottom: 2px solid #eef2f6;
    }
    td { padding: 10px 12px; border-bottom: 1px solid #eef2f6; }
    .detail-row { background: #fafcff; }
    .detail-row td { padding-left: 30px; font-size: 13px; color: #475569; }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto p-5">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#0b3b2c]">
            @if($role === 'admin')
                📋 Riwayat Penjualan
            @else
                📋 Riwayat Penjualan Saya
            @endif
        </h1>
        <a href="{{ route('penjualan.create') }}" class="btn-primary-page">➕ Catat Penjualan</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card-table">
        @if($penjualan->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kasir</th>
                            <th>Total</th>
                            <th>Dibayar</th>
                            <th>Kembalian</th>
                            <th>Item</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjualan as $p)
                            <tr>
                                <td>#{{ $p->id }}</td>
                                <td>{{ $p->user->display_name ?? $p->user->name ?? '-' }}</td>
                                <td class="font-semibold">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($p->uang_dibayar, 0, ',', '.') }}</td>
                                <td class="font-semibold text-[#166534]">Rp {{ number_format($p->kembalian, 0, ',', '.') }}</td>
                                <td>{{ $p->detail->count() }} barang</td>
                                <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($role === 'admin')
                                        <a href="{{ route('penjualan.edit', $p->id) }}" class="text-[#0b3b2c] font-semibold hover:underline">
                                            ✏️ Edit
                                        </a>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                            </tr>

                            @foreach($p->detail as $detail)
                                <tr class="detail-row">
                                    <td colspan="8">
                                        <span class="font-medium">
                                            {{ $detail->nama_barang_snapshot ?? $detail->barang->nama ?? '(barang dihapus)' }}
                                        </span>
                                        × {{ $detail->jumlah }}
                                        {{ $detail->satuan_snapshot ?? $detail->barang->satuan ?? '-' }}
                                        @ Rp {{ number_format($detail->harga_jual_saat_transaksi, 0, ',', '.') }}
                                        = <span class="font-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Belum ada data penjualan.</p>
        @endif
    </div>

    <div class="mt-4">
        @if($role === 'admin')
            <a href="{{ route('dashboard.admin') }}" class="text-sm text-[#0b3b2c] font-semibold hover:underline">⬅️ Kembali ke Dashboard Admin</a>
        @else
            <a href="{{ route('dashboard.sales') }}" class="text-sm text-[#0b3b2c] font-semibold hover:underline">⬅️ Kembali ke Dashboard Sales</a>
        @endif
    </div>
</div>
@endsection