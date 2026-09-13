@extends('layouts.app')

@section('title', 'Edit Sales · CatatRezekimu')

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
        text-decoration: none;
        display: inline-block;
        text-align: center;
        font-weight: 600;
    }
    .btn-secondary:hover { background: #dce1e8; }

    input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 12px;
        font-size: 14px;
    }
    input:focus {
        outline: none;
        border-color: #0b3b2c;
        box-shadow: 0 0 0 3px rgba(11,59,44,0.15);
    }

    label {
        display: block;
        font-weight: 600;
        font-size: 14px;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .error { color: #991b1b; font-size: 13px; margin-top: 4px; }
    .form-group { margin-bottom: 18px; }
    .btn-group { display: flex; gap: 12px; margin-top: 10px; }
    .text-muted { font-size: 12px; color: #94a3b8; margin-top: 4px; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-100 p-4 flex justify-center items-start">
    <div class="card-form">
        <h1 class="text-2xl font-bold text-[#0b3b2c] mb-4">✏️ Edit Sales</h1>

        @if($errors->any())
            <div class="alert-error">
                <ul style="margin-left: 16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('sales.update', $sales->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Sales</label>
                <input type="text" id="name" name="name" value="{{ old('name', $sales->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $sales->email) }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak diubah">
                <p class="text-muted">* Kosongkan jika tidak ingin mengubah password</p>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-primary">Update</button>
                <a href="{{ route('sales.index') }}" class="btn-secondary" style="flex:1;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection