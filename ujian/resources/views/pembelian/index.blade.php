@extends('layouts.app')

@section('title', 'Riwayat Pembelian · CatatRezekimu')

@push('styles')
<style>
    .card-table { background: white; border-radius: 16px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 20px; }
    .btn-primary-page { background: #0b3b2c; color: white; padding: 8px 20px; border-radius: 40px; text-decoration: none; display: inline-block; font-weight: 600; font-size: 14px; }
    .btn-primary-page:hover { background: #082f23; }
    .table-container { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 14px; }
    th { background: #f8fafc; text-align: left; padding: 10px 12px; font-weight: 600; color: #1e293b; border-bottom: 2px solid #eef2f6; }
    td { padding: 10px 12px; border-bottom: 1px solid #eef2f6; }
    .detail-row { background: #fafcff; }
    .detail-row td { padding-left: 30px; font-size: 13px; color: #475569; }
    .badge-active {
        background: #dcfce7;
        color: #166534;
        padding: 2px 8px;
        border-radius: 40px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-inactive {
        background: #fee2e2;
        color: #991b1b;
        padding: 2px 8px;
        border-radius: 40px;
        font-size: 11px;
        font-weight: 600;
    }
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 16px;
        border: 1px solid #fecaca;
    }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto p-5">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#0b3b2c]">📋 Riwayat Pembelian</h1>
        <a href="{{ route('pembelian.create') }}" class="btn-primary-page">➕ Catat Pembelian</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    <div class="card-table">
        @if($pembelian->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Supplier</th>
                            <th>Total</th>
                            <th>Item</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembelian as $p)
                            <tr>
                                <td>#{{ $p->id }}</td>
                                <td>
                                    {{ $p->nama_supplier_snapshot ?? $p->supplier->nama ?? '(supplier dihapus)' }}
                                    @if($p->supplier && $p->supplier->trashed())
                                        <span class="badge-inactive">(tidak aktif)</span>
                                    @elseif(!$p->supplier)
                                        <span class="badge-inactive">(dihapus)</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td>{{ $p->detail->count() }} barang</td>
                                <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($p->status === 'selesai')
                                        <span class="badge-active">Selesai</span>
                                    @else
                                        <span class="badge-inactive">Batal</span>
                                    @endif
                                </td>
                                <td>
                                    @if($p->status === 'selesai')
                                        <a href="{{ route('pembelian.edit', $p->id) }}" class="text-[#0b3b2c] font-semibold hover:underline">Edit</a>
                                        <form action="{{ route('pembelian.batal', $p->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="text-[#991b1b] font-semibold hover:underline" onclick="return confirm('Yakin batalkan pembelian ini? Stok akan dikembalikan.')">Batal</button>
                                        </form>
                                    @else
                                        <span class="text-gray-400">Tidak ada aksi</span>
                                    @endif
                                </td>
                            </tr>

                            @foreach($p->detail as $detail)
                                <tr class="detail-row">
                                    <td colspan="7">
                                        <span class="font-medium">{{ $detail->nama_barang_snapshot ?? $detail->barang->nama ?? '(barang dihapus)' }}</span>
                                        × {{ $detail->jumlah }}
                                        {{ $detail->satuan_snapshot ?? $detail->barang->satuan ?? '-' }}
                                        @ Rp {{ number_format($detail->harga_modal_saat_beli, 0, ',', '.') }}
                                        = <span class="font-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Belum ada data pembelian.</p>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('dashboard.admin') }}" class="text-sm text-[#0b3b2c] font-semibold hover:underline">⬅️ Kembali ke Dashboard</a>
    </div>
</div>
@endsection