@extends('layouts.app')

@section('title', 'Detail Sales · CatatRezekimu')

@push('styles')
<style>
    .card-info {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 16px;
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

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }

    .stat-card {
        background: #f8fafc;
        border: 1px solid #eef2f6;
        border-radius: 16px;
        padding: 16px;
        text-align: center;
    }
    .stat-card .label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 6px;
    }
    .stat-card .value {
        font-size: 18px;
        font-weight: 700;
        color: #0b3b2c;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #eef2f6;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row .label {
        font-weight: 600;
        color: #64748b;
        font-size: 13px;
    }
    .info-row .value {
        font-weight: 600;
        color: #1e293b;
        font-size: 14px;
    }

    .riwayat-item {
        background: #f8fafc;
        border: 1px solid #eef2f6;
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 8px;
    }
    .riwayat-item .header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
    }
    .riwayat-item .id {
        font-weight: 700;
        color: #0b3b2c;
    }
    .riwayat-item .total {
        font-weight: 700;
        color: #0b3b2c;
    }
    .riwayat-item .tanggal {
        font-size: 12px;
        color: #64748b;
    }
    .riwayat-item .detail-list {
        font-size: 13px;
        color: #475569;
        margin-top: 4px;
    }

    .empty-state {
        text-align: center;
        color: #94a3b8;
        padding: 20px 0;
    }

    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto p-5">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <a href="{{ route('sales.index') }}" class="text-sm text-[#0b3b2c] font-semibold">⬅️ Kembali</a>
            <h1 class="text-2xl font-bold text-[#0b3b2c] mt-1">👤 Detail Sales</h1>
        </div>
        <a href="{{ route('sales.edit', $sales->id) }}" class="btn-primary-page">✏️ Edit</a>
    </div>

    <!-- PROFIL -->
    <div class="card-info">
        <h2 class="text-lg font-bold text-[#0b3b2c] mb-3">Profil</h2>
        <div class="info-row">
            <span class="label">Nama</span>
            <span class="value">
                {{ $sales->display_name ?? $sales->name }}
                @if($sales->trashed())
                    <span class="badge-inactive">Tidak Aktif</span>
                @else
                    <span class="badge-active">Aktif</span>
                @endif
            </span>
        </div>
        <div class="info-row">
            <span class="label">Email</span>
            <span class="value">{{ $sales->email }}</span>
        </div>
        <div class="info-row">
            <span class="label">Terdaftar</span>
            <span class="value">{{ $sales->created_at->format('d/m/Y H:i') }}</span>
        </div>
        @if($sales->trashed())
            <div class="info-row">
                <span class="label">Dinonaktifkan</span>
                <span class="value">{{ $sales->deleted_at->format('d/m/Y H:i') }}</span>
            </div>
        @endif
    </div>

    <!-- STATISTIK -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="label">Total Transaksi</div>
            <div class="value">{{ $sales->total_transaksi ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Total Omzet</div>
            <div class="value">Rp {{ number_format($sales->total_omzet ?? 0, 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Keuntungan Kotor</div>
            <div class="value">Rp {{ number_format($sales->total_keuntungan ?? 0, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- RIWAYAT PENJUALAN -->
    <div class="card-info">
        <h2 class="text-lg font-bold text-[#0b3b2c] mb-3">📋 Riwayat Penjualan (10 Terakhir)</h2>

        @if($penjualan->count() > 0)
            @foreach($penjualan as $p)
                <div class="riwayat-item">
                    <div class="header">
                        <span class="id">#{{ $p->id }}</span>
                        <span class="total">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="tanggal">{{ $p->created_at->format('d/m/Y H:i') }}</div>
                    <div class="detail-list">
                        @foreach($p->detail as $detail)
                            <div>
                                • {{ $detail->nama_barang_snapshot ?? $detail->barang->nama ?? '(barang dihapus)' }}
                                × {{ $detail->jumlah }}
                                @ Rp {{ number_format($detail->harga_jual_saat_transaksi, 0, ',', '.') }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">Belum ada transaksi penjualan dari sales ini.</div>
        @endif
    </div>

</div>
@endsection