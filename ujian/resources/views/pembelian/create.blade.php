@extends('layouts.app')

@section('title', 'Catat Pembelian Stok · CatatRezekimu')

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
        transition: background 0.2s;
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
        transition: background 0.2s;
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

    .daftar-barang {
        max-height: 400px;
        overflow-y: auto;
    }

    .empty-state {
        text-align: center;
        color: #94a3b8;
        padding: 20px 0;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gray-100 p-4 flex justify-center items-start">
    <div class="max-w-md w-full">

        <div class="bg-white rounded-3xl shadow-lg p-5">

            <!-- HEADER -->
            <div class="flex justify-between items-center mb-4">
                <div>
                    <a href="{{ route('pembelian.index') }}" class="text-sm text-[#0b3b2c] font-semibold flex items-center gap-1">
                        ⬅️ Kembali
                    </a>
                    <h1 class="text-2xl font-bold text-[#0b3b2c] mt-1">📦 Catat Pembelian Stok</h1>
                </div>
                <div class="text-xs text-gray-400 text-right">
                    <div>Waktu</div>
                    <div class="font-semibold text-gray-600" id="clock-display">{{ now()->format('d/m/Y H:i:s') }}</div>
                </div>
            </div>

            <!-- SUPPLIER -->
            <div class="mb-5">
                <label for="supplier_id" class="block text-sm font-semibold text-gray-700 mb-1">Supplier</label>
                <div class="flex gap-2">
                    <select id="supplier_id" class="flex-1 border border-gray-300 rounded-2xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-[#0b3b2c] focus:border-transparent bg-white">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($supplier as $s)
                            <option value="{{ $s->id }}">{{ $s->nama }}</option>
                        @endforeach
                    </select>
                    <button onclick="toggleModalSupplier()" class="bg-[#0b3b2c] text-white px-4 py-3 rounded-2xl font-semibold whitespace-nowrap">
                        + Tambah
                    </button>
                </div>
                <p class="text-xs text-gray-400 mt-1">* Pilih supplier yang sudah ada, atau tambahkan baru</p>
            </div>

            <!-- DAFTAR BARANG -->
            <div class="mb-4">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-bold text-gray-800">Daftar Barang</h2>
                    <span class="text-sm text-gray-500" id="total-item-label">0 item</span>
                </div>

                <div id="daftar-barang" class="daftar-barang">
                    <div class="empty-state">Belum ada barang ditambahkan</div>
                </div>

                <button onclick="toggleModalBarang()" class="w-full py-3 border-2 border-dashed border-gray-300 rounded-2xl text-gray-500 font-semibold hover:border-[#0b3b2c] hover:text-[#0b3b2c] transition mt-2">
                    ➕ Tambah Barang
                </button>
            </div>

            <!-- RINGKASAN -->
            <div class="bg-[#f1f5f9] rounded-2xl p-4 mb-5">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-sm text-gray-600">Total Item</div>
                        <div class="text-xl font-bold text-gray-800" id="total-item-count">0 item</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-600">Total Pembelian</div>
                        <div class="text-2xl font-bold text-[#0b3b2c]" id="total-harga">Rp 0</div>
                    </div>
                </div>
            </div>

            <button id="btn-simpan" class="btn-primary text-lg py-4" onclick="simpanPembelian()">
                💾 Simpan Pembelian
            </button>
            <p class="text-xs text-center text-gray-400 mt-3">* Stok akan otomatis bertambah setelah disimpan</p>

        </div>
    </div>
</div>

<!-- ====== MODAL TAMBAH BARANG ====== -->
<div class="modal-overlay" id="modalBarang">
    <div class="modal-content">
        <h2 class="text-xl font-bold text-[#0b3b2c] mb-4">➕ Tambah Barang</h2>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Barang</label>
            <select id="barang-select" class="w-full border border-gray-300 rounded-2xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-[#0b3b2c]">
                <option value="">-- Pilih Barang --</option>
                @foreach($barang as $b)
                    <option value="{{ $b->id }}" data-satuan="{{ $b->satuan }}" data-harga="{{ $b->harga_modal }}">
                        {{ $b->nama }} ({{ $b->satuan }})
                    </option>
                @endforeach
            </select>
            <div id="info-barang" class="text-sm text-gray-500 mt-1 hidden">
                <span>Satuan: <span id="info-satuan"></span></span> ·
                <span>Harga modal: Rp <span id="info-harga"></span></span>
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah</label>
            <input type="number" id="jumlah-barang" value="1" min="1" class="w-full border border-gray-300 rounded-2xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-[#0b3b2c]">
        </div>

        <div class="flex gap-3">
            <button onclick="tambahBarangKeDaftar()" class="flex-1 bg-[#0b3b2c] text-white py-3 rounded-2xl font-semibold">
                Tambahkan
            </button>
            <button onclick="toggleModalBarang()" class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-2xl font-semibold">
                Batal
            </button>
        </div>
    </div>
</div>

<!-- ====== MODAL TAMBAH SUPPLIER ====== -->
<div class="modal-overlay" id="modalSupplier">
    <div class="modal-content">
        <h2 class="text-xl font-bold text-[#0b3b2c] mb-4">➕ Tambah Supplier</h2>

        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Supplier</label>
            <input type="text" id="nama-supplier" placeholder="Contoh: PT Sumber Jaya" class="w-full border border-gray-300 rounded-2xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-[#0b3b2c]">
        </div>

        <div class="flex gap-3">
            <button onclick="tambahSupplier()" class="flex-1 bg-[#0b3b2c] text-white py-3 rounded-2xl font-semibold">
                Simpan Supplier
            </button>
            <button onclick="toggleModalSupplier()" class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-2xl font-semibold">
                Batal
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Data sementara pembelian (di memory)
    let daftarPembelian = [];
    let counterId = 0;

    // ----- FUNGSI MODAL -----
    function toggleModalBarang() {
        const modal = document.getElementById('modalBarang');
        modal.classList.toggle('active');
        if (!modal.classList.contains('active')) {
            document.getElementById('barang-select').value = '';
            document.getElementById('jumlah-barang').value = 1;
            document.getElementById('info-barang').classList.add('hidden');
        }
    }

    function toggleModalSupplier() {
        const modal = document.getElementById('modalSupplier');
        modal.classList.toggle('active');
        if (!modal.classList.contains('active')) {
            document.getElementById('nama-supplier').value = '';
        }
    }

    document.getElementById('modalBarang').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });
    document.getElementById('modalSupplier').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });

    // ----- INFO BARANG SAAT DIPILIH -----
    document.getElementById('barang-select').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const infoDiv = document.getElementById('info-barang');
        if (this.value) {
            document.getElementById('info-satuan').textContent = selected.dataset.satuan || '-';
            document.getElementById('info-harga').textContent = Number(selected.dataset.harga).toLocaleString('id-ID');
            infoDiv.classList.remove('hidden');
        } else {
            infoDiv.classList.add('hidden');
        }
    });

    // ----- TAMBAH BARANG KE DAFTAR -----
    function tambahBarangKeDaftar() {
        const select = document.getElementById('barang-select');
        const selected = select.options[select.selectedIndex];
        const jumlah = parseInt(document.getElementById('jumlah-barang').value) || 1;

        if (!select.value) {
            alert('Silakan pilih barang terlebih dahulu!');
            return;
        }
        if (jumlah < 1) {
            alert('Jumlah minimal 1!');
            return;
        }

        const id = select.value;
        const nama = selected.text.split('(')[0].trim();
        const satuan = selected.dataset.satuan || '';
        const hargaModal = parseFloat(selected.dataset.harga) || 0;
        const subtotal = hargaModal * jumlah;

        const existing = daftarPembelian.find(item => item.barang_id == id);
        if (existing) {
            alert('⚠️ Barang ini sudah ada di daftar!\nSilakan ubah jumlah langsung di daftar, atau hapus jika ingin menambah dengan harga berbeda.');
            return;
        } else {
            daftarPembelian.push({
                id: ++counterId,
                barang_id: parseInt(id),
                nama: nama,
                satuan: satuan,
                harga_modal: hargaModal,
                jumlah: jumlah,
                subtotal: subtotal
            });
        }

        toggleModalBarang();
        renderDaftar();
    }

    function hapusBarang(id) {
        daftarPembelian = daftarPembelian.filter(item => item.id !== id);
        renderDaftar();
    }

    function renderDaftar() {
        const container = document.getElementById('daftar-barang');
        const totalItemLabel = document.getElementById('total-item-label');
        const totalItemCount = document.getElementById('total-item-count');
        const totalHargaEl = document.getElementById('total-harga');

        if (daftarPembelian.length === 0) {
            container.innerHTML = `<div class="empty-state">Belum ada barang ditambahkan</div>`;
            totalItemLabel.textContent = '0 item';
            totalItemCount.textContent = '0 item';
            totalHargaEl.textContent = 'Rp 0';
            return;
        }

        let html = '';
        let totalItem = 0;
        let totalHarga = 0;

        daftarPembelian.forEach(item => {
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
                            <label class="text-xs text-gray-500 block">Harga (per unit)</label>
                            <input type="number" value="${item.harga_modal}" 
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
        totalItemLabel.textContent = `${totalItem} item`;
        totalItemCount.textContent = `${totalItem} item`;
        totalHargaEl.textContent = `Rp ${totalHarga.toLocaleString('id-ID')}`;
    }

    function ubahJumlah(id, value) {
        const item = daftarPembelian.find(i => i.id === id);
        if (!item) return;
        const newJumlah = parseInt(value) || 1;
        if (newJumlah < 1) {
            alert('Jumlah minimal 1!');
            renderDaftar();
            return;
        }
        item.jumlah = newJumlah;
        item.subtotal = item.harga_modal * item.jumlah;
        renderDaftar();
    }

    function ubahHarga(id, value) {
        const item = daftarPembelian.find(i => i.id === id);
        if (!item) return;
        const newHarga = parseFloat(value) || 0;
        if (newHarga < 0) {
            alert('Harga tidak boleh negatif!');
            renderDaftar();
            return;
        }
        item.harga_modal = newHarga;
        item.subtotal = item.harga_modal * item.jumlah;
        renderDaftar();
    }

    function tambahSupplier() {
        const nama = document.getElementById('nama-supplier').value.trim();
        if (!nama) {
            alert('Nama supplier tidak boleh kosong!');
            return;
        }

        fetch('{{ route("supplier.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ nama: nama })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(result => {
            alert('✅ ' + result.message);
            const select = document.getElementById('supplier_id');
            const option = document.createElement('option');
            option.value = result.data.id;
            option.textContent = result.data.nama;
            select.appendChild(option);
            select.value = result.data.id;
            toggleModalSupplier();
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

    function simpanPembelian() {
        const supplierId = document.getElementById('supplier_id').value;
        if (!supplierId) {
            alert('Silakan pilih supplier terlebih dahulu!');
            return;
        }
        if (daftarPembelian.length === 0) {
            alert('Tambahkan minimal 1 barang!');
            return;
        }

        const data = {
            supplier_id: supplierId,
            items: daftarPembelian.map(item => ({
                barang_id: item.barang_id,
                jumlah: item.jumlah,
                harga_modal_saat_beli: item.harga_modal
            }))
        };

        fetch('{{ route("pembelian.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
            daftarPembelian = [];
            renderDaftar();
            document.getElementById('supplier_id').value = '';
        })
        .catch(error => {
            console.error('Error:', error);
            let pesan = 'Terjadi kesalahan saat menyimpan!';
            if (error.errors) {
                pesan = Object.values(error.errors).flat().join('\n');
            } else if (error.message) {
                pesan = error.message;
            }
            alert('❌ ' + pesan);
        });
    }

    // ----- JAM REAL-TIME -----
    function updateClock() {
        const now = new Date();
        const options = {
            timeZone: 'Asia/Jakarta',
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        const formatted = now.toLocaleString('id-ID', options);
        document.getElementById('clock-display').textContent = formatted;
    }

    renderDaftar();
    updateClock();
    setInterval(updateClock, 1000);
</script>
@endpush