@extends('layouts.app')

@section('title', 'Riwayat Transaksi · CatatRezekimu')

@push('styles')
<style>
    .card-riwayat {
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
    .filter-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 6px;
        letter-spacing: 0.3px;
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

    .periode-info {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 12px;
    }

    .riwayat-item {
        background: #f8fafc;
        border: 1px solid #eef2f6;
        border-radius: 16px;
        padding: 14px 16px;
        margin-bottom: 10px;
        border-left: 4px solid #ccc;
    }
    .riwayat-item.penjualan { border-left-color: #0b3b2c; }
    .riwayat-item.pembelian { border-left-color: #991b1b; }

    .riwayat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }
    .riwayat-jenis {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .riwayat-jenis.penjualan { color: #0b3b2c; }
    .riwayat-jenis.pembelian { color: #991b1b; }

    .riwayat-total {
        font-size: 16px;
        font-weight: 700;
    }
    .riwayat-total.penjualan { color: #166534; }
    .riwayat-total.pembelian { color: #991b1b; }

    .riwayat-info {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 8px;
    }
    .riwayat-detail {
        font-size: 13px;
        color: #475569;
        padding-left: 4px;
    }
    .riwayat-detail div { margin-bottom: 2px; }

    .empty-state {
        text-align: center;
        color: #94a3b8;
        padding: 30px 0;
    }

    @media (max-width: 480px) {
        .card-riwayat { padding: 16px; }
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto p-4">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <a href="{{ route('dashboard.admin') }}" class="text-sm text-[#0b3b2c] font-semibold">⬅️ Dashboard</a>
            <h1 class="text-2xl font-bold text-[#0b3b2c] mt-1">📋 Riwayat Transaksi</h1>
        </div>
    </div>

    <!-- FILTER -->
    <div class="card-riwayat">
        <div class="periode-info">
            Periode aktif: <strong>{{ $labelPeriode }}</strong>
        </div>

        <!-- Filter Periode -->
        <div class="filter-label">Periode</div>
        <div class="filter-group">
            <a href="{{ route('riwayat.index', ['periode' => 'hari', 'jenis' => $jenis]) }}"
               class="btn-filter {{ $periode === 'hari' ? 'active' : '' }}">Hari Ini</a>
            <a href="{{ route('riwayat.index', ['periode' => '7hari', 'jenis' => $jenis]) }}"
               class="btn-filter {{ $periode === '7hari' ? 'active' : '' }}">7 Hari</a>
            <a href="{{ route('riwayat.index', ['periode' => '30hari', 'jenis' => $jenis]) }}"
               class="btn-filter {{ $periode === '30hari' ? 'active' : '' }}">30 Hari</a>
            <a href="{{ route('riwayat.index', ['periode' => 'bulan', 'jenis' => $jenis]) }}"
               class="btn-filter {{ $periode === 'bulan' ? 'active' : '' }}">Bulan Ini</a>
            <button onclick="toggleCustom()"
                    class="btn-filter {{ $periode === 'custom' ? 'active' : '' }}">Custom</button>
        </div>

        <form action="{{ route('riwayat.index') }}" method="GET"
              class="custom-range {{ $periode === 'custom' ? 'active' : '' }}" id="customRange">
            <input type="hidden" name="periode" value="custom">
            <input type="hidden" name="jenis" value="{{ $jenis }}">
            <input type="date" name="dari" value="{{ $dari }}" required>
            <input type="date" name="sampai" value="{{ $sampai }}" required>
            <button type="submit" class="btn-primary-page">Terapkan</button>
        </form>

        <!-- Filter Jenis -->
        <div class="filter-label mt-3">Jenis Transaksi</div>
        <div class="filter-group">
            <a href="{{ route('riwayat.index', ['periode' => $periode, 'jenis' => 'semua', 'dari' => $dari, 'sampai' => $sampai]) }}"
               class="btn-filter {{ $jenis === 'semua' ? 'active' : '' }}">Semua</a>
            <a href="{{ route('riwayat.index', ['periode' => $periode, 'jenis' => 'penjualan', 'dari' => $dari, 'sampai' => $sampai]) }}"
               class="btn-filter {{ $jenis === 'penjualan' ? 'active' : '' }}">💰 Penjualan</a>
            <a href="{{ route('riwayat.index', ['periode' => $periode, 'jenis' => 'pembelian', 'dari' => $dari, 'sampai' => $sampai]) }}"
               class="btn-filter {{ $jenis === 'pembelian' ? 'active' : '' }}">🛒 Pembelian</a>
        </div>
    </div>

    <!-- TIMELINE -->
    <div class="card-riwayat">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-bold text-[#0b3b2c]">Timeline</h2>
            <span class="text-sm text-gray-500">{{ $riwayat->count() }} transaksi</span>
        </div>

        @if($riwayat->count() > 0)
            @foreach($riwayat as $r)
                <div class="riwayat-item {{ $r['jenis'] }}">
                    <div class="riwayat-header">
                        <span class="riwayat-jenis {{ $r['jenis'] }}">
                            @if($r['jenis'] === 'penjualan')
                                💰 Penjualan #{{ $r['id'] }}
                            @else
                                🛒 Pembelian #{{ $r['id'] }}
                            @endif
                        </span>
                        <span class="riwayat-total {{ $r['jenis'] }}">
                            @if($r['jenis'] === 'penjualan')
                                + Rp {{ number_format($r['total'], 0, ',', '.') }}
                            @else
                                - Rp {{ number_format($r['total'], 0, ',', '.') }}
                            @endif
                        </span>
                    </div>
                    <div class="riwayat-info">
                        @if($r['jenis'] === 'penjualan')
                            👤 {{ $r['pihak'] }}
                        @else
                            🏭 {{ $r['pihak'] }}
                        @endif
                        · 🕐 {{ $r['tanggal']->format('d/m/Y H:i') }}
                    </div>
                    <div class="riwayat-detail">
                        @foreach($r['detail'] as $d)
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
            <div class="empty-state">
                Belum ada transaksi pada periode ini.
            </div>
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