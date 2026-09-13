<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f1f5f9; }
        .container { max-width: 500px; margin: 0 auto; background: white; padding: 24px; border-radius: 16px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-weight: 600; margin-bottom: 4px; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; }
        .btn { display: inline-block; padding: 10px 20px; background: #0b3b2c; color: white; border: none; border-radius: 8px; cursor: pointer; }
        .btn:hover { background: #0a3426; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Barang</h1>
        <form action="{{ route('barang.update', $barang->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama">Nama Barang</label>
                <input type="text" name="nama" id="nama" value="{{ $barang->nama }}" required>
            </div>
            <div class="form-group">
                <label for="harga_jual">Harga Jual</label>
                <input type="number" name="harga_jual" id="harga_jual" value="{{ $barang->harga_jual }}" min="0" step="100" required>
            </div>
            <button type="submit" class="btn">Update</button>
            <a href="{{ route('barang.index') }}">Kembali</a>
        </form>
    </div>
</body>
</html>
