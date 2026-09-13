@extends('layouts.app')

@section('title', 'Duplikasi Nama Sales · CatatRezekimu')

@push('styles')
<style>
    .card-form {
        background: white;
        border-radius: 16px;
        padding: 24px;
        max-width: 500px;
        margin: 0 auto;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .btn-primary {
        background: #0b3b2c;
        color: white;
        padding: 10px 20px;
        border-radius: 40px;
        border: none;
        width: 100%;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-primary:hover { background: #082f23; }

    .btn-secondary {
        background: #eef2f6;
        color: #1e293b;
        padding: 10px 20px;
        border-radius: 40px;
        border: none;
        width: 100%;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-secondary:hover { background: #dce1e8; }

    .option-box {
        background: #f8fafc;
        border: 2px solid #eef2f6;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 12px;
    }
    .option-box:hover {
        border-color: #0b3b2c;
        background: #f1f5f9;
    }
    .option-box input[type="radio"] {
        width: auto;
        margin-right: 8px;
    }

    .form-group { margin-bottom: 18px; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-100 p-4 flex justify-center items-start">
    <div class="card-form">
        <h1 class="text-2xl font-bold text-[#0b3b2c] mb-2">⚠️ Nama Sales Sudah Pernah Digunakan</h1>
        <p class="text-gray-600 text-sm mb-4">
            Akun dengan nama <strong>"{{ $name }}"</strong> sudah pernah dibuat sebelumnya (mungkin sudah dihapus).
            Pilih salah satu opsi di bawah ini:
        </p>

        <form action="{{ route('sales.duplicate.handle') }}" method="POST">
            @csrf
            <input type="hidden" name="name" value="{{ $name }}">
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="password" value="{{ $password }}">

            <div class="form-group">
                <div class="option-box">
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input type="radio" name="choice" value="A" required>
                        <div>
                            <span class="font-semibold">Opsi A: Pakai nama "{{ $name }}"</span>
                            <p class="text-sm text-gray-500 mt-1">
                                Riwayat transaksi lama akan otomatis berubah menjadi <strong>"{{ $name }} (tidak aktif)"</strong>.
                                Akun baru akan bernama <strong>"{{ $name }}"</strong>.
                            </p>
                        </div>
                    </label>
                </div>

                <div class="option-box">
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input type="radio" name="choice" value="B" required>
                        <div>
                            <span class="font-semibold">Opsi B: Pakai nama "{{ $name }} (2)"</span>
                            <p class="text-sm text-gray-500 mt-1">
                                Akun baru akan dibuat dengan nama <strong>"{{ $name }} (2)"</strong>.
                                Riwayat transaksi lama tetap bernama <strong>"{{ $name }}"</strong>.
                            </p>
                        </div>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-primary">Lanjutkan</button>
            <a href="{{ route('sales.create') }}" class="btn-secondary mt-2" style="display: block; text-align: center; text-decoration: none;">Batal</a>
        </form>
    </div>
</div>
@endsection