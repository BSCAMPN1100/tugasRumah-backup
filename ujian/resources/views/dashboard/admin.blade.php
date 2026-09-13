@extends('layouts.app')

@section('title', 'Dashboard Admin · CatatRezekimu')

@push('styles')
<style>
    .dashboard-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: flex-start;
        justify-content: center;
        padding: 20px;
    }

    .dashboard-card {
        max-width: 420px;
        width: 100%;
        background: #ffffff;
        border-radius: 32px;
        box-shadow: 0 20px 60px rgba(0, 20, 40, 0.10);
        padding: 28px 20px 36px;
        margin: 0 auto;
    }

    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .dash-header .greeting h2 {
        font-size: 20px;
        font-weight: 700;
        color: #0b3b2c;
        letter-spacing: -0.3px;
    }
    .dash-header .greeting p {
        font-size: 13px;
        color: #64748b;
        margin-top: 2px;
    }

    .btn-logout {
        background: #f1f5f9;
        border: none;
        padding: 10px 16px;
        border-radius: 40px;
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: background 0.15s;
    }
    .btn-logout:hover { background: #e2e8f0; }
    .btn-logout span { font-size: 16px; }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 28px;
    }
    .summary-card {
        background: #f8fafc;
        border-radius: 20px;
        padding: 16px 10px;
        text-align: center;
        border: 1px solid #eef2f6;
    }
    .summary-card .label {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 6px;
    }
    .summary-card .value {
        font-size: 20px;
        font-weight: 700;
        color: #0b3b2c;
    }
    .summary-card .value small {
        font-size: 12px;
        font-weight: 400;
        color: #94a3b8;
        margin-left: 2px;
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 8px;
    }
    .menu-item {
        background: #f8fafc;
        border: 1px solid #eef2f6;
        border-radius: 20px;
        padding: 20px 10px;
        text-align: center;
        transition: background 0.15s, transform 0.1s;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .menu-item:hover {
        background: #f1f5f9;
        transform: scale(0.98);
    }
    .menu-item:active { transform: scale(0.96); }
    .menu-item .icon {
        font-size: 28px;
        display: block;
        margin-bottom: 8px;
    }
    .menu-item .label {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        letter-spacing: -0.2px;
    }
    .menu-item.full-width { grid-column: 1 / -1; }

    .dashboard-footer {
        margin-top: 28px;
        text-align: center;
        font-size: 12px;
        color: #94a3b8;
        border-top: 1px solid #eef2f6;
        padding-top: 20px;
    }
    .dashboard-footer .version {
        background: #f1f5f9;
        padding: 4px 14px;
        border-radius: 40px;
        font-size: 11px;
        font-weight: 500;
        color: #64748b;
        display: inline-block;
    }

    @media (max-width: 480px) {
        .dashboard-card {
            padding: 20px 16px 28px;
            border-radius: 28px;
        }
        .summary-grid { gap: 8px; }
        .summary-card { padding: 12px 6px; }
        .summary-card .value { font-size: 17px; }
        .menu-grid { gap: 10px; }
        .menu-item { padding: 16px 8px; }
        .menu-item .icon { font-size: 24px; }
        .dash-header .greeting h2 { font-size: 18px; }
        .btn-logout { padding: 8px 14px; font-size: 12px; }
    }
</style>
@endpush

@section('content')
<div class="dashboard-wrapper">
    <div class="dashboard-card">

        <!-- Header: sapaan & logout -->
        <div class="dash-header">
            <div class="greeting">
                <h2>👋 Halo, Admin</h2>
                <p>Selamat datang di CatatRezekimu</p>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">
                    <span>⏻</span> Logout
                </button>
            </form>
        </div>

        <!-- Ringkasan 3 kartu -->
        <div class="summary-grid">
            <div class="summary-card">
                <div class="label">Omzet Hari Ini</div>
                <div class="value">Rp {{ number_format($omzetHariIni, 0, ',', '.') }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Keuntungan Kotor</div>
                <div class="value">Rp {{ number_format($keuntunganHariIni, 0, ',', '.') }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Jumlah Produk</div>
                <div class="value">{{ $totalBarang }} <small>produk</small></div>
            </div>
        </div>

        <!-- Menu navigasi -->
        <div class="menu-grid">
            <a href="{{ route('barang.index') }}" class="menu-item">
                <span class="icon">📦</span>
                <span class="label">Data Barang</span>
            </a>
            <a href="{{ route('pembelian.index') }}" class="menu-item">
                <span class="icon">🛒</span>
                <span class="label">Pembelian</span>
            </a>
            <a href="{{ route('penjualan.index') }}" class="menu-item">
                <span class="icon">💰</span>
                <span class="label">Penjualan</span>
            </a>
            <a href="{{ route('sales.index') }}" class="menu-item">
                <span class="icon">👥</span>
                <span class="label">Kelola Sales</span>
            </a>
            <a href="{{ route('laporan.index') }}" class="menu-item">
                <span class="icon">📊</span>
                <span class="label">Laporan Keuangan</span>
            </a>
            <a href="{{ route('riwayat.index') }}" class="menu-item full-width">
                <span class="icon">📋</span>
                <span class="label">Riwayat Transaksi</span>
            </a>
        </div>

        <!-- Footer -->
        <div class="dashboard-footer">
            <span class="version">versi 1.0 · offline</span>
        </div>

    </div>
</div>
@endsection