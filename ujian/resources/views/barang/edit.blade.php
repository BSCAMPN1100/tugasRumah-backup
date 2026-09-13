@extends('layouts.app')

@section('title', 'Edit Barang · CatatRezekimu')

@push('styles')
<style>
    .page-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }

    .card-main {
        max-width: 500px;
        width: 100%;
        background: #fff;
        border-radius: 32px;
        padding: 30px 24px;
        box-shadow: 0 20px 60px rgba(0, 20, 40, 0.10);
    }

    .card-main h2 {
        font-size: 24px;
        font-weight: 700;
        color: #0b3b2c;
        margin-bottom: 24px;
    }

    .back-link {
        margin-bottom: 16px;
    }

    .back-link a {
        text-decoration: none;
        color: #0b3b2c;
        font-weight: 600;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        font-weight: 600;
        font-size: 14px;
        color: #1e293b;
        margin-bottom: 4px;
    }

    input[type="text"],
    input[type="number"] {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 12px;
        font-size: 14px;
        transition: border 0.15s;
    }

    input:focus {
        outline: none;
        border-color: #0b3b2c;
        box-shadow: 0 0 0 3px rgba(11, 59, 44, 0.15);
    }

    .btn-group {
        display: flex;
        gap: 12px;
        margin-top: 10px;
    }

    .btn-submit {
        background: #0b3b2c;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        flex: 1;
    }

    .btn-submit:hover { background: #082f23; }

    .btn-cancel {
        background: #eef2f6;
        color: #1e293b;
        border: none;
        padding: 10px 20px;
        border-radius: 40px;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        flex: 1;
    }

    .btn-cancel:hover { background: #dce1e8; }

    .error {
        color: #991b1b;
        font-size: 13px;
        margin-top: 4px;
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="card-main">
        <h2>✏️ Edit Barang</h2>

        <div class="back-link">
            <a href="{{ route('barang.index') }}">⬅️ Kembali ke Data Barang</a>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                <ul style="margin-left: 16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barang.update', $barang->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama">Nama Barang <span style="color:#991b1b;">*</span></label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $barang->nama) }}" required>
                @error('nama') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="satuan">Satuan</label>
                <input type="text" id="satuan" name="satuan" value="{{ old('satuan', $barang->satuan) }}" placeholder="Contoh: kg, liter, pcs">
                @error('satuan') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="harga_modal">Harga Modal (Rp)</label>
                <input type="number" id="harga_modal" name="harga_modal" value="{{ old('harga_modal', $barang->harga_modal) }}" step="0.01" min="0">
                @error('harga_modal') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="harga_jual">Harga Jual (Rp) <span style="color:#991b1b;">*</span></label>
                <input type="number" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $barang->harga_jual) }}" step="0.01" min="0" required>
                @error('harga_jual') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok" value="{{ old('stok', $barang->stok) }}" min="0">
                @error('stok') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-submit">Update</button>
                <a href="{{ route('barang.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection