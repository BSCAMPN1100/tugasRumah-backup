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

    .btn-edit,
.btn-detail,
.btn-delete {
    background: none;
    padding: 0;
    border: none;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    font-family: inherit;
    white-space: nowrap;
}

.btn-detail { color: #0b3b2c; }
.btn-detail:hover { text-decoration: underline; }

.btn-edit { color: #1e293b; }
.btn-edit:hover { text-decoration: underline; }

.btn-delete { color: #991b1b; }
.btn-delete:hover { text-decoration: underline; }

.action-cell {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

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

  {{-- Alert sukses sekarang pakai toast --}}

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
    <div class="action-cell">
        <a href="{{ route('sales.show', $s->id) }}" class="btn-detail">Detail</a>
        <a href="{{ route('sales.edit', $s->id) }}" class="btn-edit">Edit</a>
        @if(!$s->trashed())
            <form id="form-hapus-sales-{{ $s->id }}" action="{{ route('sales.destroy', $s->id) }}" method="POST" style="display:inline; margin:0;">
                @csrf
                @method('DELETE')
                <button type="button" class="btn-delete" onclick="hapusSales({{ $s->id }}, this)">Hapus</button>
            </form>
        @endif
    </div>
</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
    @include('partials.empty-state', [
        'icon' => '👥',
        'title' => 'Belum Ada Akun Sales',
        'description' => 'Tambahkan akun sales pertama Anda untuk mulai mendelegasikan pencatatan penjualan.',
        'actionUrl' => route('sales.create'),
        'actionLabel' => '➕ Tambah Sales Pertama',
    ])
@endif
    </div>

    <div class="mt-4">
        <a href="{{ route('dashboard.admin') }}" class="text-sm text-[#0b3b2c] font-semibold hover:underline">⬅️ Kembali ke Dashboard</a>
    </div>
</div>
@endsection
@push('scripts')
<script>
    async function hapusSales(id, btn) {
    const ok = await showConfirm({
        icon: '🗑️',
        title: 'Hapus Akun Sales',
        message: 'Yakin hapus akun ini? Riwayat transaksi akan tetap tersimpan.',
        yesText: 'Ya, Hapus',
        danger: true
    });
    if (ok) {
        const button = btn || document.querySelector(`#form-hapus-sales-${id} button`);
        setLoading(button, 'Menghapus...');
        document.getElementById('form-hapus-sales-' + id).submit();
    }
                              }

    @if(session('success'))
        showToast(@json(session('success')), 'success');
    @endif
    @if(session('error'))
        showToast(@json(session('error')), 'error');
    @endif
    @if(session('warning'))
        showToast(@json(session('warning')), 'warning');
    @endif
</script>
@endpush