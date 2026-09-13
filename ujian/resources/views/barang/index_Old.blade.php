<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f1f5f9; }
        table { border-collapse: collapse; width: 100%; background: white; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #0b3b2c; color: white; }
        .btn { display: inline-block; padding: 6px 12px; background: #0b3b2c; color: white; text-decoration: none; border-radius: 4px; }
        .btn-danger { background: #dc2626; }
    </style>
</head>
<body>
    <h1>Data Barang</h1>
    @if(session('success'))
    <div style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
        {{ session('success') }}
    </div>
@endif
    <a href="{{ route('barang.create') }}" class="btn">Tambah Barang</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Stok</th>
            <th>Harga Modal</th>
            <th>Harga Jual</th>
            <th>Aksi</th>
        </tr>
        @foreach ($barang as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->stok }}</td>
            <td>Rp {{ number_format($item->harga_modal, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
            <td>
                <a href="{{ route('barang.edit', $item->id) }}" class="btn">Edit</a>
                <form action="{{ route('barang.destroy', $item->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    <br>
    <a href="{{ route('dashboard.admin') }}">Kembali ke Dashboard</a>
</body>
</html>
