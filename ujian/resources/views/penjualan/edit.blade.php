@extends('layouts.app')

@section('title', 'Edit Penjualan · CatatRezekimu')

@push('styles')
<style>
    .btn-primary {
        background-color: #0b3b2c;
        color: white;
        padding: 12px 24px;
        border-radius: 40px;
        font-weight: 600;
        border: none;
        width: 100%;
        font-size: 16px;
        cursor: pointer;
    }
    .btn-primary:hover { background-color: #082f23; }

    .btn-danger {
        background-color: #fee2e2;
        color: #991b1b;
        padding: 6px 14px;
        border-radius: 40px;
        font-weight: 600;
        border: none;
        font-size: 12px;
        cursor: pointer;
    }
    .btn-danger:hover { background-color: #fecaca; }

    .card-item {
        background: #f8fafc;
        border: 1px solid #eef2f6;
        border-radius: 16px;
        padding: 14px 16px;
        margin-bottom: 12px;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 50;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    .modal-overlay.active { display: flex; }

    .modal-content {
        background: white;
        border-radius: 32px;
        padding: 24px;
        max-width: 500px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
    }

    .daftar-barang { max-height: 400px; overflow-y: auto; }

    .empty-state { text-align: center; color: #94a3b8; padding: 20px 0; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-100 p-4 flex justify-center items-start">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-3xl shadow-lg p-5">

            <div class="flex justify-between items-center mb-4">
                <div>
                    <a href="{{ route('penjualan.index') }}" class="text-sm text-[#0b3b2c] font-semibold">⬅️ Kembali</a>
                    <h1 class="text-2xl font-bold text-[#0b3b2c] mt-1">✏️ Edit Penjualan #{{ $penjualan->id }}</h1>
                </div>
                <div class="text-xs text-gray-400 text-right">
                    <div>Waktu</div>
                    <div class="font-semibold text-gray-600" id="clock-display">{{ now()->format('d/m/Y H:i:s') }}</div>
                </div>
            </div>

            <div class="mb-4">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-bold text-gray-800">Daftar Barang</h2>
                    <span class="text-sm text-gray-500" id="total-item-label">{{ $penjualan->detail->count() }} item</span>
                </div>

                <div id="daftar-barang" class="daftar-barang"></div>

                <button onclick="toggleModalBarang()" class="w-full py-3 border-2 border-dashed border-gray-300 rounded-2xl text-gray-500 font-semibold hover:border-[#0b3b2c] hover:text-[#0b3b2c] transition mt-2">
                    ➕ Tambah Barang
                </button>
            </div>

            <!-- RINGKASAN -->
            <div class="bg-[#f1f5f9] rounded-2xl p-4 mb-5">
                <div class="flex justify-between items-center mb-3">
                    <div>
                        <div class="text-sm text-gray-600">Total Item</div>
                        <div class="text-xl font-bold text-gray-800" id="total-item-count">0 item</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-600">Total Penjualan</div>
                        <div class="text-2xl font-bold text-[#0b3b2c]" id="total-harga">Rp 0</div>
                    </div>
                </div>

                <!-- PEMBAYARAN -->
                <div class="border-t border-gray-300 pt-3">
                    <div class="mb-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Uang Dibayar</label>
                        <input type="number" id="uang-dibayar" 
                               value="{{ $penjualan->uang_dibayar }}" 
                               min="0" 
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-[#0b3b2c]"
                               oninput="hitungKembalian()">
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-gray-700">Kembalian</span>
                        <span class="text-xl font-bold text-[#166534]" id="kembalian-display">Rp 0</span>
                    </div>
                </div>
            </div>

            <button id="btn-simpan" class="btn-primary text-lg py-4" onclick="updatePenjualan()">
                💾 Update Penjualan
            </button>
            <p class="text-xs text-center text-gray-400 mt-3">* Stok akan dikoreksi otomatis</p>

        </div>
    </div>
</div>

<!-- MODAL TAMBAH BARANG -->
<div class="modal-overlay" id="modalBarang">
    <div class="modal-content">
        <h2 class="text-xl font-bold text-[#0b3b2c] mb-4">➕ Tambah Barang</h2>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Barang</label>
            <select id="barang-select" class="w-full border border-gray-300 rounded-2xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-[#0b3b2c]">
                <option value="">-- Pilih Barang --</option>
                @foreach($barang as $b)
                    <option value="{{ $b->id }}" data-satuan="{{ $b->satuan }}" data-harga="{{ $b->harga_jual }}" data-stok="{{ $b->stok }}">
                        {{ $b->nama }} (Stok: {{ $b->stok }})
                    </option>
                @endforeach
            </select>
            <div id="info-barang" class="text-sm text-gray-500 mt-1 hidden">
                <span>Satuan: <span id="info-satuan"></span></span> ·
                <span>Harga jual: Rp <span id="info-harga"></span></span> ·
                <span>Stok: <span id="info-stok"></span></span>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah</label>
            <input type="number" id="jumlah-barang" value="1" min="1" class="w-full border border-gray-300 rounded-2xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-[#0b3b2c]">
        </div>

        <div class="flex gap-3">
            <button onclick="tambahBarangKeDaftar()" class="flex-1 bg-[#0b3b2c] text-white py-3 rounded-2xl font-semibold">Tambahkan</button>
            <button onclick="toggleModalBarang()" class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-2xl font-semibold">Batal</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const penjualanId = {{ $penjualan->id }};
    let daftarPenjualan = [];
    let counterId = 0;

    // Load data lama
    @foreach($penjualan->detail as $detail)
        daftarPenjualan.push({
            id: ++counterId,
            barang_id: {{ $detail->barang_id }},
            nama: "{{ $detail->barang->nama }}",
            satuan: "{{ $detail->barang->satuan }}",
            harga_jual: {{ $detail->harga_jual_saat_transaksi }},
            jumlah: {{ $detail->jumlah }},
            subtotal: {{ $detail->subtotal }}
        });
    @endforeach

    function toggleModalBarang() {
        const modal = document.getElementById('modalBarang');
        modal.classList.toggle('active');
        if (!modal.classList.contains('active')) {
            document.getElementById('barang-select').value = '';
            document.getElementById('jumlah-barang').value = 1;
            document.getElementById('info-barang').classList.add('hidden');
        }
    }

    document.getElementById('barang-select').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const infoDiv = document.getElementById('info-barang');
        if (this.value) {
            document.getElementById('info-satuan').textContent = selected.dataset.satuan || '-';
            document.getElementById('info-harga').textContent = Number(selected.dataset.harga).toLocaleString('id-ID');
            document.getElementById('info-stok').textContent = selected.dataset.stok || 0;
            infoDiv.classList.remove('hidden');
        } else {
            infoDiv.classList.add('hidden');
        }
    });

    function tambahBarangKeDaftar() {
        const select = document.getElementById('barang-select');
        const selected = select.options[select.selectedIndex];
        const jumlah = parseInt(document.getElementById('jumlah-barang').value) || 1;

        if (!select.value) { alert('Silakan pilih barang!'); return; }
        if (jumlah < 1) { alert('Jumlah minimal 1!'); return; }

        const stokTersedia = parseInt(selected.dataset.stok) || 0;
        if (jumlah > stokTersedia) {
            alert('Stok tidak cukup! Tersedia: ' + stokTersedia);
            return;
        }

        const id = select.value;
        const nama = selected.text.split('(')[0].trim();
        const satuan = selected.dataset.satuan || '';
        const hargaJual = parseFloat(selected.dataset.harga) || 0;
        const subtotal = hargaJual * jumlah;

        const existing = daftarPenjualan.find(item => item.barang_id == id);
        if (existing) {
            alert('⚠️ Barang ini sudah ada di daftar!');
            return;
        } else {
            daftarPenjualan.push({
                id: ++counterId,
                barang_id: parseInt(id),
                nama: nama,
                satuan: satuan,
                harga_jual: hargaJual,
                jumlah: jumlah,
                subtotal: subtotal
            });
        }

        toggleModalBarang();
        renderDaftar();
    }

    function hapusBarang(id) {
        daftarPenjualan = daftarPenjualan.filter(item => item.id !== id);
        renderDaftar();
    }

    function hitungKembalian() {
        const totalHarga = daftarPenjualan.reduce((sum, item) => sum + item.subtotal, 0);
        const uangDibayar = parseFloat(document.getElementById('uang-dibayar').value) || 0;
        const kembalian = uangDibayar - totalHarga;

        const display = document.getElementById('kembalian-display');
        if (kembalian < 0) {
            display.textContent = 'Rp ' + Math.abs(kembalian).toLocaleString('id-ID') + ' (Kurang)';
            display.className = 'text-xl font-bold text-[#991b1b]';
        } else {
            display.textContent = 'Rp ' + kembalian.toLocaleString('id-ID');
            display.className = 'text-xl font-bold text-[#166534]';
        }
    }

    function renderDaftar() {
        const container = document.getElementById('daftar-barang');
        const totalItemLabel = document.getElementById('total-item-label');
        const totalItemCount = document.getElementById('total-item-count');
        const totalHargaEl = document.getElementById('total-harga');

        if (daftarPenjualan.length === 0) {
            container.innerHTML = `<div class="empty-state">Belum ada barang ditambahkan</div>`;
            totalItemLabel.textContent = '0 item';
            totalItemCount.textContent = '0';
            totalHargaEl.textContent = 'Rp 0';
            return;
        }

        let html = '';
        let totalItem = 0;
        let totalHarga = 0;

        daftarPenjualan.forEach(item => {
            totalItem += item.jumlah;
            totalHarga += item.subtotal;

            html += `
                <div class="card-item">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <div class="font-semibold text-gray-800">${item.nama}</div>
                            <div class="text-sm text-gray-500">Satuan: ${item.satuan}</div>
                        </div>
                        <button onclick="hapusBarang(${item.id})" class="btn-danger">✕ Hapus</button>
                    </div>
                    <div class="flex flex-wrap gap-3 items-center">
                        <div class="flex-1 min-w-[120px]">
                            <label class="text-xs text-gray-500 block">Harga Jual</label>
                            <input type="number" value="${item.harga_jual}" 
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm"
                                   onchange="ubahHarga(${item.id}, this.value)">
                        </div>
                        <div class="flex-1 min-w-[80px]">
                            <label class="text-xs text-gray-500 block">Jumlah</label>
                            <input type="number" value="${item.jumlah}" min="1" 
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm"
                                   onchange="ubahJumlah(${item.id}, this.value)">
                        </div>
                        <div class="flex-1 text-right">
                            <div class="text-xs text-gray-500">Subtotal</div>
                            <div class="font-bold text-[#0b3b2c] text-lg">Rp ${item.subtotal.toLocaleString('id-ID')}</div>
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
        totalItemLabel.textContent = `${daftarPenjualan.length} item`;
        totalItemCount.textContent = `${totalItem}`;
        totalHargaEl.textContent = `Rp ${totalHarga.toLocaleString('id-ID')}`;
        hitungKembalian();
    }

    function ubahJumlah(id, value) {
        const item = daftarPenjualan.find(i => i.id === id);
        if (!item) return;
        const newJumlah = parseInt(value) || 1;
        if (newJumlah < 1) { alert('Jumlah minimal 1!'); renderDaftar(); return; }
        item.jumlah = newJumlah;
        item.subtotal = item.harga_jual * item.jumlah;
        renderDaftar();
    }

    function ubahHarga(id, value) {
        const item = daftarPenjualan.find(i => i.id === id);
        if (!item) return;
        const newHarga = parseFloat(value) || 0;
        if (newHarga < 0) { alert('Harga tidak boleh negatif!'); renderDaftar(); return; }
        item.harga_jual = newHarga;
        item.subtotal = item.harga_jual * item.jumlah;
        renderDaftar();
    }

    function updatePenjualan() {
        if (daftarPenjualan.length === 0) {
            alert('Tambahkan minimal 1 barang!');
            return;
        }

        const totalHarga = daftarPenjualan.reduce((sum, item) => sum + item.subtotal, 0);
        const uangDibayar = parseFloat(document.getElementById('uang-dibayar').value) || 0;

        if (uangDibayar < totalHarga) {
            alert('Uang dibayar kurang dari total! Total: Rp ' + totalHarga.toLocaleString('id-ID'));
            return;
        }

        const data = {
            items: daftarPenjualan.map(item => ({
                barang_id: item.barang_id,
                jumlah: item.jumlah,
                harga_jual_saat_transaksi: item.harga_jual
            })),
            uang_dibayar: uangDibayar
        };

        fetch(`/penjualan/${penjualanId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(result => {
            alert('✅ ' + result.message);
            window.location.href = '{{ route("penjualan.index") }}';
        })
        .catch(error => {
            console.error('Error:', error);
            let pesan = 'Terjadi kesalahan!';
            if (error.errors) {
                pesan = Object.values(error.errors).flat().join('\n');
            } else if (error.message) {
                pesan = error.message;
            }
            alert('❌ ' + pesan);
        });
    }

    function updateClock() {
        const now = new Date();
        const options = { timeZone: 'Asia/Jakarta', day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
        document.getElementById('clock-display').textContent = now.toLocaleString('id-ID', options);
    }

    renderDaftar();
    updateClock();
    setInterval(updateClock, 1000);

    document.getElementById('modalBarang').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });
</script>
@endpush