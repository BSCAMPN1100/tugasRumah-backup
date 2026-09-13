@extends('layouts.app')

@section('title', 'Kelola Sales · CatatRezekimu')

@push('styles')
<style>
    .card-table {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
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

    .btn-edit {
        background: #eef2f6;
        color: #1e293b;
        padding: 4px 12px;
        border-radius: 40px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }
    .btn-edit:hover { background: #dce1e8; }

    .btn-detail {
        background: #0b3b2c;
        color: white;
        padding: 4px 12px;
        border-radius: 40px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }
    .btn-detail:hover { background: #082f23; }

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
        padding: 4px 12px;
        border-radius: 40px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }
    .btn-delete:hover { background: #fecaca; }

    .badge-active {
        background: #dcfce7;
        color: #166534;
        padding: 2px 12px;
        border-radius: 40px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-inactive {
        background: #fee2e2;
        color: #991b1b;
        padding: 2px 12px;
        border-radius: 40px;
        font-size: 12px;
        font-weight: 600;
    }

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
    .table-container { overflow-x: auto; }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto p-5">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#0b3b2c]">👥 Kelola Akun Sales</h1>
        <a href="{{ route('sales.create') }}" class="btn-primary-page">➕ Tambah Sales</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="card-table">
        @if($sales->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Total Transaksi</th>
                            <th>Total Omzet</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $s)
                            <tr>
                                <td>
                                    {{ $s->display_name ?? $s->name }}
                                    @if($s->trashed())
                                        <span class="badge-inactive">(tidak aktif)</span>
                                    @endif
                                </td>
                                <td>{{ $s->email }}</td>
                                <td>
                                    @if($s->trashed())
                                        <span class="badge-inactive">Tidak Aktif</span>
                                    @else
                                        <span class="badge-active">Aktif</span>
                                    @endif
                                </td>
                                <td>{{ $s->total_transaksi ?? 0 }} transaksi</td>
                                <td>Rp {{ number_format($s->total_omzet ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('sales.show', $s->id) }}" class="btn-detail">👁️ Detail</a>
                                    <a href="{{ route('sales.edit', $s->id) }}" class="btn-edit">✏️ Edit</a>
                                    @if(!$s->trashed())
                                        <form action="{{ route('sales.destroy', $s->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete" onclick="return confirm('Yakin hapus akun ini? Riwayat transaksi akan tetap tersimpan.')">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Belum ada akun Sales.</p>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('dashboard.admin') }}" class="text-sm text-[#0b3b2c] font-semibold hover:underline">⬅️ Kembali ke Dashboard</a>
    </div>
</div>
@endsection