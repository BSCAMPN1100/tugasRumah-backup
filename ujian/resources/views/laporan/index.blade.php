@extends('layouts.app')

@section('title', 'Laporan Keuangan · CatatRezekimu')

@push('styles')
<style>
    .card-laporan {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 16px;
    }

    .btn-primary-page {
        background: #0b3b2c;
        color: white;
        padding: 8px 16px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        border: none;
    }
    .btn-primary-page:hover { background: #082f23; }

    .btn-filter {
        background: #eef2f6;
        color: #1e293b;
        padding: 8px 16px;
        border-radius: 40px;
        text-decoration: none;
        display: inline-block;
        font-weight: 600;
        font-size: 13px;
        border: none;
        cursor: pointer;
    }
    .btn-filter:hover { background: #dce1e8; }
    .btn-filter.active { background: #0b3b2c; color: white; }

    .filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }

    .custom-range {
        display: none;
        gap: 8px;
        margin-top: 8px;
    }
    .custom-range.active { display: flex; flex-wrap: wrap; }
    .custom-range input {
        padding: 6px 12px;
        border: 1px solid #d1d5db;
        border-radius: 12px;
        font-size: 13px;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }
    .summary-card {
        background: #f8fafc;
        border: 1px solid #eef2f6;
        border-radius: 16px;
        padding: 16px;
        text-align: center;
    }
    .summary-card .label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 6px;
    }
    .summary-card .value {
        font-size: 18px;
        font-weight: 700;
        color: #0b3b2c;
    }
    .summary-card.income .value { color: #166534; }
    .summary-card.expense .value { color: #991b1b; }
    .summary-card.profit { background: #e6f0ec; }
    .summary-card.profit .value { color: #0b3b2c; font-size: 20px; }
    .summary-card.profit.negative { background: #fee2e2; }
    .summary-card.profit.negative .value { color: #991b1b; }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #0b3b2c;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .section-title .badge {
        font-size: 12px;
        background: #eef2f6;
        padding: 4px 12px;
        border-radius: 40px;
        color: #64748b;
        font-weight: 500;
    }

    .transaksi-item {
        background: #f8fafc;
        border: 1px solid #eef2f6;
        border-radius: 12px;
        padding: 12px 16px;
        margin-bottom: 8px;
    }
    .transaksi-item .header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 4px;
    }
    .transaksi-item .id { font-weight: 700; color: #0b3b2c; }
    .transaksi-item .total { font-weight: 700; }
    .transaksi-item .total.in { color: #166534; }
    .transaksi-item .total.out { color: #991b1b; }
    .transaksi-item .info {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 6px;
    }
    .transaksi-item .detail-list {
        font-size: 13px;
        color: #475569;
    }

    .empty-state {
        text-align: center;
        color: #94a3b8;
        padding: 20px 0;
        font-size: 13px;
    }
    .periode-info {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 12px;
    }

    @media (max-width: 480px) {
        .summary-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto p-4">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <a href="{{ route('dashboard.admin') }}" class="text-sm text-[#0b3b2c] font-semibold">⬅️ Dashboard</a>
            <h1 class="text-2xl font-bold text-[#0b3b2c] mt-1">📊 Laporan Keuangan</h1>
        </div>
    </div>

    <!-- FILTER PERIODE -->
    <div class="card-laporan">
        <div class="periode-info">
            Periode aktif: <strong>{{ $labelPeriode }}</strong>
        </div>

        <div class="filter-group">
            <a href="{{ route('laporan.index', ['periode' => 'hari']) }}"
               class="btn-filter {{ $periode === 'hari' ? 'active' : '' }}">Hari Ini</a>
            <a href="{{ route('laporan.index', ['periode' => '7hari']) }}"
               class="btn-filter {{ $periode === '7hari' ? 'active' : '' }}">7 Hari</a>
            <a href="{{ route('laporan.index', ['periode' => '30hari']) }}"
               class="btn-filter {{ $periode === '30hari' ? 'active' : '' }}">30 Hari</a>
            <a href="{{ route('laporan.index', ['periode' => 'bulan']) }}"
               class="btn-filter {{ $periode === 'bulan' ? 'active' : '' }}">Bulan Ini</a>
            <button onclick="toggleCustom()"
                    class="btn-filter {{ $periode === 'custom' ? 'active' : '' }}">Custom</button>
        </div>

        <form action="{{ route('laporan.index') }}" method="GET"
              class="custom-range {{ $periode === 'custom' ? 'active' : '' }}" id="customRange">
            <input type="hidden" name="periode" value="custom">
            <input type="date" name="dari" value="{{ $dari }}" required>
            <input type="date" name="sampai" value="{{ $sampai }}" required>
            <button type="submit" class="btn-primary-page">Terapkan</button>
        </form>
    </div>

    <!-- RINGKASAN KEUANGAN -->
    <div class="summary-grid">
        <div class="summary-card income">
            <div class="label">💰 Pemasukan (Omzet)</div>
            <div class="value">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card expense">
            <div class="label">💸 Pengeluaran (Pembelian)</div>
            <div class="value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="label">📈 Keuntungan Kotor</div>
            <div class="value">Rp {{ number_format($totalKeuntunganKotor, 0, ',', '.') }}</div>
        </div>
        <div class="summary-card profit {{ $labaBersih < 0 ? 'negative' : '' }}">
            <div class="label">🎯 Laba Bersih</div>
            <div class="value">Rp {{ number_format($labaBersih, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- DETAIL PENJUALAN (PEMASUKAN) -->
    <div class="card-laporan">
        <div class="section-title">
            <span>💰 Detail Penjualan</span>
            <span class="badge">{{ $totalTransaksiPenjualan }} transaksi</span>
        </div>

        @if($transaksiPenjualan->count() > 0)
            @foreach($transaksiPenjualan as $t)
                <div class="transaksi-item">
                    <div class="header">
                        <span class="id">#{{ $t->id }}</span>
                        <span class="total in">+ Rp {{ number_format($t->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="info">
                        👤 {{ $t->user->display_name ?? $t->user->name ?? '(sales dihapus)' }}
                        · 🕐 {{ $t->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="detail-list">
                        @foreach($t->detail as $d)
                            <div>
                                • {{ $d->nama_barang_snapshot ?? $d->barang->nama ?? '(barang dihapus)' }}
                                × {{ $d->jumlah }}
                                {{ $d->satuan_snapshot ?? $d->barang->satuan ?? '-' }}
                                = <strong>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">Belum ada transaksi penjualan pada periode ini.</div>
        @endif
    </div>

    <!-- DETAIL PEMBELIAN (PENGELUARAN) -->
    <div class="card-laporan">
        <div class="section-title">
            <span>💸 Detail Pembelian</span>
            <span class="badge">{{ $totalTransaksiPembelian }} transaksi</span>
        </div>

        @if($transaksiPembelian->count() > 0)
            @foreach($transaksiPembelian as $p)
                <div class="transaksi-item">
                    <div class="header">
                        <span class="id">#{{ $p->id }}</span>
                        <span class="total out">- Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="info">
                        🏭 {{ $p->nama_supplier_snapshot ?? $p->supplier->nama ?? '(supplier dihapus)' }}
                        · 🕐 {{ $p->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="detail-list">
                        @foreach($p->detail as $d)
                            <div>
                                • {{ $d->nama_barang_snapshot ?? $d->barang->nama ?? '(barang dihapus)' }}
                                × {{ $d->jumlah }}
                                {{ $d->satuan_snapshot ?? $d->barang->satuan ?? '-' }}
                                = <strong>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</strong>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">Belum ada transaksi pembelian pada periode ini.</div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    function toggleCustom() {
        const form = document.getElementById('customRange');
        form.classList.toggle('active');
    }
</script>
@endpush