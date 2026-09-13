@extends('layouts.app')

@section('title', 'Data Barang · CatatRezekimu')

@push('styles')
<style>
    .page-wrapper {
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .card-main {
        max-width: 800px;
        width: 100%;
        background: #fff;
        border-radius: 32px;
        box-shadow: 0 20px 60px rgba(0, 20, 40, 0.10);
        padding: 24px 18px 30px;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
    }

    .card-header h2 {
        font-size: 20px;
        font-weight: 700;
        color: #0b3b2c;
        margin: 0;
    }

    .card-header .badge {
        background: #eef2f6;
        padding: 4px 12px;
        border-radius: 40px;
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
    }

    .btn-tambah {
        background: #0b3b2c;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        margin-bottom: 16px;
        text-decoration: none;
    }

    .btn-tambah:hover { background: #082f23; }
    .btn-tambah span { font-size: 18px; line-height: 1; }

    .barang-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .barang-item {
        background: #f8fafc;
        border: 1px solid #eef2f6;
        border-radius: 16px;
        padding: 14px 16px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
    }

    .barang-info {
        display: flex;
        flex-wrap: wrap;
        gap: 6px 14px;
        flex: 1;
    }

    .barang-info .field {
        display: flex;
        align-items: baseline;
        gap: 4px;
        font-size: 14px;
    }

    .barang-info .field .label {
        font-weight: 500;
        color: #64748b;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .barang-info .field .value {
        font-weight: 600;
        color: #0f172a;
    }

    .barang-info .field .value.stok {
        color: #0b3b2c;
        background: #e6f0ec;
        padding: 0 8px;
        border-radius: 20px;
        font-size: 13px;
    }

    .aksi-admin {
        display: flex;
        gap: 8px;
        margin-left: 8px;
    }

    .btn-edit, .btn-hapus {
        border: none;
        padding: 6px 14px;
        border-radius: 40px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-edit {
        background: #eef2f6;
        color: #1e293b;
    }
    .btn-edit:hover { background: #dce1e8; }

    .btn-hapus {
        background: #fee2e2;
        color: #991b1b;
        display: none;
    }
    .btn-hapus:hover { background: #fecaca; }

    .note {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 16px;
        text-align: center;
        border-top: 1px solid #eef2f6;
        padding-top: 16px;
    }

    @media (max-width: 600px) {
        .barang-item { flex-direction: column; align-items: stretch; gap: 10px; }
        .aksi-admin { margin-left: 0; justify-content: flex-end; }
        .btn-tambah { width: 100%; justify-content: center; }
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="card-main">

        <div class="card-header">
            <div style="display: flex; align-items: center; gap: 12px;">
                @if($role === 'admin')
                    <a href="{{ route('dashboard.admin') }}" style="text-decoration: none; font-size: 14px; color: #0b3b2c; font-weight: 600;">
                        ⬅️ Dashboard
                    </a>
                @else
                    <a href="{{ route('dashboard.sales') }}" style="text-decoration: none; font-size: 14px; color: #0b3b2c; font-weight: 600;">
                        ⬅️ Dashboard
                    </a>
                @endif
                <h2>📦 Data Barang</h2>
            </div>
            <span class="badge">{{ ucfirst($role) }}</span>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if($role === 'admin')
            <a href="{{ route('barang.create') }}" class="btn-tambah">
                <span>➕</span> Tambah Barang
            </a>
        @endif

        <div class="barang-list">
            @forelse($barang as $item)
                <div class="barang-item">
                    <div class="barang-info">
                        <span class="field"><span class="label">Nama</span><span class="value">{{ $item->nama }}</span></span>
                        @if($item->satuan)
                            <span class="field"><span class="label">Satuan</span><span class="value">{{ $item->satuan }}</span></span>
                        @endif
                        @if($role === 'admin')
                            <span class="field"><span class="label">Modal</span><span class="value">Rp {{ number_format($item->harga_modal, 0, ',', '.') }}</span></span>
                        @endif
                        <span class="field"><span class="label">Jual</span><span class="value">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</span></span>
                        <span class="field"><span class="label">Stok</span><span class="value stok">{{ $item->stok }}</span></span>
                    </div>
                    @if($role === 'admin')
                        <div class="aksi-admin">
                            <a href="{{ route('barang.edit', $item->id) }}" class="btn-edit">✏️ Edit</a>
                        </div>
                    @endif
                </div>
            @empty
                <p style="text-align:center; color:#94a3b8;">Belum ada data barang.</p>
            @endforelse
        </div>

        <div class="note">* Hapus data tidak tersedia (versi 1.0)</div>
    </div>
</div>
@endsection