@extends('layouts.app')

@section('title', 'Transaksi Berhasil · CatatRezekimu')

@push('styles')
<style>
    .success-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .card-success {
        max-width: 420px;
        width: 100%;
        background: #ffffff;
        border-radius: 32px;
        box-shadow: 0 20px 60px rgba(0, 20, 40, 0.10);
        padding: 28px 22px;
        text-align: center;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
    }

    .header h2 {
        font-size: 20px;
        font-weight: 700;
        color: #0b3b2c;
        letter-spacing: -0.3px;
    }

    .header .badge {
        background: #eef2f6;
        padding: 4px 12px;
        border-radius: 40px;
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
    }

    .success-icon {
        width: 76px;
        height: 76px;
        margin: 0 auto 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e6f0ec;
        color: #0b3b2c;
        font-size: 42px;
        font-weight: 700;
        box-shadow: 0 8px 20px rgba(11, 59, 44, 0.12);
    }

    .success-title {
        font-size: 24px;
        font-weight: 700;
        color: #0b3b2c;
        margin-bottom: 8px;
    }

    .success-sub {
        font-size: 14px;
        line-height: 1.5;
        color: #64748b;
        margin-bottom: 22px;
    }

    .transaction-meta {
        background: #f8fafc;
        border: 1px solid #eef2f6;
        border-radius: 14px;
        padding: 10px 14px;
        margin-bottom: 20px;
    }

    .transaction-number {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
    }

    .transaction-date {
        margin-top: 3px;
        font-size: 12px;
        color: #94a3b8;
    }

    .barang-list {
        background: #f8fafc;
        border: 1px solid #eef2f6;
        border-radius: 16px;
        padding: 14px 16px;
        margin-bottom: 16px;
        text-align: left;
    }

    .barang-item {
        font-size: 13px;
        color: #475569;
        padding: 6px 0;
        border-bottom: 1px dashed #e2e8f0;
    }

    .barang-item:last-child { border-bottom: none; }

    .barang-item strong { color: #0b3b2c; }

    .ringkasan {
        background: #f8fafc;
        border-radius: 20px;
        padding: 16px 18px;
        border: 1px solid #eef2f6;
        margin-bottom: 24px;
        text-align: left;
    }

    .ringkasan .row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 7px 0;
        font-size: 14px;
    }

    .ringkasan .row .label {
        color: #64748b;
        font-weight: 500;
    }

    .ringkasan .row .value {
        color: #0f172a;
        font-weight: 600;
        text-align: right;
    }

    .ringkasan .row.kembalian .value {
        color: #0b3b2c;
        font-weight: 700;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 2px solid #e2e8f0;
    }

    .total-row .label {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }

    .total-row .value {
        font-size: 20px;
        font-weight: 700;
        color: #0b3b2c;
    }

    .btn-finish {
        background: #0b3b2c;
        color: #ffffff;
        border: none;
        padding: 14px 12px;
        border-radius: 16px;
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        min-height: 52px;
        width: 100%;
        box-shadow: 0 4px 12px rgba(11, 59, 44, 0.20);
        transition: background 0.15s;
        display: block;
        text-align: center;
        text-decoration: none;
        line-height: 24px;
    }

    .btn-finish:hover { background: #0d4635; }
    .btn-finish:active { background: #082f23; }

    .note {
        font-size: 12px;
        line-height: 1.5;
        color: #94a3b8;
        margin-top: 20px;
        border-top: 1px solid #eef2f6;
        padding-top: 16px;
    }

    @media (max-width: 480px) {
        .card-success { padding: 24px 16px; border-radius: 28px; }
        .success-icon { width: 66px; height: 66px; font-size: 36px; }
        .success-title { font-size: 21px; }
    }
</style>
@endpush

@section('content')
<div class="success-wrapper">
    <main class="card-success">

        <!-- HEADER -->
        <header class="header">
            <h2>Transaksi Selesai</h2>
            <span class="badge">
                {{ ucfirst($penjualan->user->role ?? 'sales') }}
            </span>
        </header>

        <!-- SUCCESS -->
        <section>
            <div class="success-icon">✓</div>
            <h1 class="success-title">Penjualan Tersimpan!</h1>
            <p class="success-sub">Transaksi berhasil dicatat.</p>
        </section>

        <!-- META -->
        <section class="transaction-meta">
            <div class="transaction-number">No. Transaksi #TRX-{{ str_pad($penjualan->id, 5, '0', STR_PAD_LEFT) }}</div>
            <div class="transaction-date">{{ $penjualan->created_at->format('d/m/Y · H:i') }}</div>
        </section>

        <!-- DAFTAR BARANG -->
        <section class="barang-list">
            @foreach($penjualan->detail as $detail)
                <div class="barang-item">
                    • {{ $detail->nama_barang_snapshot ?? $detail->barang->nama ?? '(barang dihapus)' }}
                    × {{ $detail->jumlah }}
                    {{ $detail->satuan_snapshot ?? $detail->barang->satuan ?? '-' }}
                    = <strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
                </div>
            @endforeach
        </section>

        <!-- RINGKASAN -->
        <section class="ringkasan">
            <div class="row">
                <span class="label">Total Belanja</span>
                <span class="value">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</span>
            </div>

            <div class="row">
                <span class="label">Uang Dibayar</span>
                <span class="value">Rp {{ number_format($penjualan->uang_dibayar, 0, ',', '.') }}</span>
            </div>

            <div class="row kembalian">
                <span class="label">Kembalian</span>
                <span class="value">Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</span>
            </div>

            <div class="total-row">
                <span class="label">Total Transaksi</span>
                <span class="value">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</span>
            </div>
        </section>

        <!-- AKSI -->
        <a href="{{ auth()->user()->role === 'admin' ? route('dashboard.admin') : route('dashboard.sales') }}"
           class="btn-finish">
            ✓ Selesai
        </a>

        <!-- CATATAN -->
        <p class="note">
            Stok telah dikurangi secara otomatis.
        </p>

    </main>
</div>
@endsection