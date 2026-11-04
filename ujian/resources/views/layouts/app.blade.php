<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CatatRezekimu')</title>

    {{-- Google Fonts (Inter) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* ============================================================
           GLOBAL RESET
        ============================================================ */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            color: #1e293b;
        }

        /* ============================================================
           WARNA BRAND
        ============================================================ */
        :root {
            --brand-primary: #0b3b2c;
            --brand-primary-hover: #082f23;
            --brand-primary-light: #e6f0ec;
            --danger: #991b1b;
            --danger-light: #fee2e2;
            --success: #166534;
            --success-light: #dcfce7;
        }

        /* ============================================================
           TOP NAVBAR
        ============================================================ */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 40;
            background: #ffffff;
            border-bottom: 1px solid #eef2f6;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 16px;
            height: 60px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-back-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #0b3b2c;
            text-decoration: none;
            font-size: 18px;
            font-weight: 700;
            transition: background 0.15s;
            flex-shrink: 0;
        }
        .nav-back-btn:hover { background: #e2e8f0; }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            color: #0b3b2c;
            font-weight: 700;
            font-size: 16px;
            white-space: nowrap;
        }

        .navbar-menu {
            display: flex;
            gap: 2px;
            flex: 1;
            overflow-x: auto;
            scrollbar-width: none;
        }
        .navbar-menu::-webkit-scrollbar { display: none; }

        .nav-link {
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            color: #475569;
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            transition: background 0.15s, color 0.15s;
        }
        .nav-link:hover { background: #f1f5f9; color: #0b3b2c; }
        .nav-link.active { background: #e6f0ec; color: #0b3b2c; font-weight: 600; }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
            flex-shrink: 0;
        }

        .nav-user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            line-height: 1.2;
        }

        .nav-user-name {
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .nav-user-role {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .nav-logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #fee2e2;
            color: #991b1b;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 700;
            transition: background 0.15s;
        }
        .nav-logout-btn:hover { background: #fecaca; }

        /* ============================================================
           BUTTONS
        ============================================================ */
        .btn-primary {
            background-color: var(--brand-primary);
            color: white;
            padding: 10px 20px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            text-align: center;
            transition: background 0.15s;
        }
        .btn-primary:hover { background-color: var(--brand-primary-hover); }

        .btn-secondary {
            background-color: #eef2f6;
            color: #1e293b;
            padding: 8px 18px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            transition: background 0.15s;
        }
        .btn-secondary:hover { background-color: #dce1e8; }

        .btn-danger {
            background-color: var(--danger-light);
            color: var(--danger);
            padding: 6px 14px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 12px;
            border: none;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-danger:hover { background-color: #fecaca; }

        /* ============================================================
           CARDS
        ============================================================ */
        .card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* ============================================================
   TOAST NOTIFICATION
============================================================ */
.toast-container {
    position: fixed;
    top: 76px;
    right: 16px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 8px;
    pointer-events: none;
    max-width: 360px;
}

.toast {
    pointer-events: auto;
    background: white;
    border-radius: 12px;
    padding: 14px 18px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    display: flex;
    align-items: flex-start;
    gap: 12px;
    animation: toastIn 0.3s ease;
    min-width: 280px;
    border-left: 4px solid #ccc;
}
.toast.success { border-left-color: #166534; }
.toast.error   { border-left-color: #991b1b; }
.toast.warning { border-left-color: #ca8a04; }
.toast.info    { border-left-color: #0b3b2c; }

.toast-icon { font-size: 20px; flex-shrink: 0; }
.toast-message { flex: 1; font-size: 14px; color: #1e293b; line-height: 1.4; }
.toast-close {
    background: none; border: none; color: #94a3b8;
    cursor: pointer; font-size: 20px; padding: 0; line-height: 1;
}
.toast-close:hover { color: #1e293b; }

@keyframes toastIn {
    from { transform: translateX(120%); opacity: 0; }
    to   { transform: translateX(0); opacity: 1; }
}
@keyframes toastOut {
    from { transform: translateX(0); opacity: 1; }
    to   { transform: translateX(120%); opacity: 0; }
}

@media (max-width: 768px) {
    .toast-container {
        top: 66px;
        left: 12px;
        right: 12px;
        max-width: none;
    }
    .toast { min-width: 0; }
}

/* ============================================================
   CONFIRM MODAL
============================================================ */
.confirm-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 1001;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.confirm-overlay.active { display: flex; }

.confirm-box {
    background: white;
    border-radius: 20px;
    padding: 24px;
    max-width: 400px;
    width: 100%;
    text-align: center;
    animation: popIn 0.2s ease;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
}
@keyframes popIn {
    from { transform: scale(0.95); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}

.confirm-icon { font-size: 48px; margin-bottom: 12px; }
.confirm-title {
    font-size: 18px; font-weight: 700;
    color: #1e293b; margin-bottom: 8px;
}
.confirm-message {
    font-size: 14px; color: #64748b;
    margin-bottom: 20px; line-height: 1.5;
}
.confirm-buttons { display: flex; gap: 10px; }
.confirm-btn {
    flex: 1;
    padding: 10px 16px;
    border-radius: 40px;
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
    transition: background 0.15s;
    font-family: inherit;
}
.confirm-btn.yes {
    background: #0b3b2c;
    color: white;
}
.confirm-btn.yes:hover { background: #082f23; }
.confirm-btn.yes.danger {
    background: #991b1b;
}
.confirm-btn.yes.danger:hover { background: #7f1d1d; }
.confirm-btn.no {
    background: #eef2f6;
    color: #1e293b;
}
.confirm-btn.no:hover { background: #dce1e8; }
        /* ============================================================
           BADGES
        ============================================================ */
        .badge-active {
            background: var(--success-light);
            color: var(--success);
            padding: 2px 10px;
            border-radius: 40px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-inactive {
            background: var(--danger-light);
            color: var(--danger);
            padding: 2px 10px;
            border-radius: 40px;
            font-size: 11px;
            font-weight: 600;
        }

        /* ============================================================
           ALERTS
        ============================================================ */
        .alert-success {
            background: var(--success-light);
            color: var(--success);
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 16px;
            font-size: 14px;
        }
        .alert-error {
            background: var(--danger-light);
            color: var(--danger);
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 16px;
            font-size: 14px;
        }
/* ============================================================
   LOADING SPINNER
============================================================ */
.spinner-inline {
    display: inline-block;
    width: 14px;
    height: 14px;
    border: 2px solid currentColor;
    border-top-color: transparent;
    border-radius: 50%;
    animation: spinnerSpin 0.6s linear infinite;
    vertical-align: middle;
    margin-right: 6px;
    opacity: 0.8;
}

@keyframes spinnerSpin {
    to { transform: rotate(360deg); }
}

button:disabled,
.btn-primary:disabled,
.btn-secondary:disabled {
    cursor: not-allowed;
          }
/* ============================================================
   VALIDATION STATE
============================================================ */
input.input-error,
select.input-error,
textarea.input-error {
    border-color: #991b1b !important;
    background-color: #fef2f2 !important;
    box-shadow: 0 0 0 3px rgba(153, 27, 27, 0.1) !important;
}

input.input-valid,
select.input-valid,
textarea.input-valid {
    border-color: #166534 !important;
    background-color: #f0fdf4 !important;
}

input.input-checking,
select.input-checking,
textarea.input-checking {
    border-color: #ca8a04 !important;
}

.validation-message {
    font-size: 12px;
    margin-top: 4px;
    display: flex;
    align-items: center;
    gap: 4px;
    line-height: 1.4;
}
.validation-message.error { color: #991b1b; }
.validation-message.success { color: #166534; }
.validation-message.checking { color: #ca8a04; }

.validation-message .spinner-inline {
    width: 12px;
    height: 12px;
    border-width: 2px;
         }
/* ============================================================
   DIRTY FORM MODAL (reuse confirm-modal style)
============================================================ */
.confirm-overlay.dirty-warning {
    z-index: 1002;
}
.confirm-overlay.dirty-warning .confirm-box {
    border: 2px solid #ca8a04;
  }
/* ============================================================
   EMPTY STATE
============================================================ */
.empty-state {
    text-align: center;
    padding: 48px 20px;
    max-width: 420px;
    margin: 0 auto;
}

.empty-state-icon {
    font-size: 64px;
    line-height: 1;
    margin-bottom: 16px;
    opacity: 0.8;
}

.empty-state-title {
    font-size: 20px;
    font-weight: 700;
    color: #0b3b2c;
    margin-bottom: 8px;
    letter-spacing: -0.3px;
}

.empty-state-description {
    font-size: 14px;
    line-height: 1.6;
    color: #64748b;
    margin-bottom: 20px;
}

.empty-state-action {
    display: inline-block;
    background: #0b3b2c;
    color: white;
    padding: 10px 24px;
    border-radius: 40px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.15s;
}

.empty-state-action:hover {
    background: #082f23;
}

/* Empty state versi kecil (untuk card/daftar di dalam form) */
.empty-state.empty-state-sm {
    padding: 24px 16px;
}
.empty-state.empty-state-sm .empty-state-icon {
    font-size: 40px;
    margin-bottom: 8px;
}
.empty-state.empty-state-sm .empty-state-title {
    font-size: 14px;
    margin-bottom: 4px;
}
.empty-state.empty-state-sm .empty-state-description {
    font-size: 12px;
    margin-bottom: 0;
  }
        /* ============================================================
           MOBILE
        ============================================================ */
        @media (max-width: 768px) {
            .navbar-container {
                height: 56px;
                padding: 0 12px;
                gap: 8px;
            }
            .navbar-menu { display: none; }
            .nav-brand { font-size: 14px; }
            .nav-user-role { display: none; }
            .nav-user-name { font-size: 12px; max-width: 80px; }
            .nav-back-btn, .nav-logout-btn {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }
        }
.nav-logout-btn:disabled {
    font-size: 10px;
    white-space: nowrap;
    padding: 0 8px;
    width: auto;
    min-width: 60px;
}
    </style>

    @stack('styles')
</head>
<body>

    {{-- ============================================================
         TOP NAVBAR
    ============================================================ --}}
    @auth
    <nav class="navbar">
        <div class="navbar-container">

            {{-- LEFT: Back + Brand --}}
            <div class="navbar-left">
                @if(!request()->routeIs('dashboard.*'))
                    <a href="{{ auth()->user()->role === 'admin' ? route('dashboard.admin') : route('dashboard.sales') }}"
                       class="nav-back-btn"
                       title="Kembali ke Dashboard">
                        ←
                    </a>
                @endif
                <a href="{{ auth()->user()->role === 'admin' ? route('dashboard.admin') : route('dashboard.sales') }}"
                   class="nav-brand">
                    🏪 <span>CatatRezekimu</span>
                </a>
            </div>

            {{-- CENTER: Menu (desktop only) --}}
            <div class="navbar-menu">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('dashboard.admin') }}" class="nav-link {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('barang.index') }}" class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}">Barang</a>
                    <a href="{{ route('pembelian.index') }}" class="nav-link {{ request()->routeIs('pembelian.*') ? 'active' : '' }}">Pembelian</a>
                    <a href="{{ route('penjualan.index') }}" class="nav-link {{ request()->routeIs('penjualan.*') ? 'active' : '' }}">Penjualan</a>
                    <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">Sales</a>
                    <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">Laporan</a>
                    <a href="{{ route('riwayat.index') }}" class="nav-link {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">Riwayat</a>
                @elseif(auth()->user()->role === 'sales')
                    <a href="{{ route('dashboard.sales') }}" class="nav-link {{ request()->routeIs('dashboard.sales') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('penjualan.create') }}" class="nav-link {{ request()->routeIs('penjualan.create') ? 'active' : '' }}">Catat Penjualan</a>
                    <a href="{{ route('penjualan.index') }}" class="nav-link {{ request()->routeIs('penjualan.index') ? 'active' : '' }}">Riwayat</a>
                @endif
            </div>

            {{-- RIGHT: User Info + Logout --}}
            <div class="navbar-right">
                <div class="nav-user-info">
                    <span class="nav-user-name">{{ auth()->user()->display_name ?? auth()->user()->name }}</span>
                    <span class="nav-user-role">{{ auth()->user()->role }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;" onsubmit="setLoading(this.querySelector('[type=submit]'), 'Logout...'); return true;">
    @csrf
    <button type="submit" class="nav-logout-btn" title="Logout">⏻</button>
                </form>
            </div>

        </div>
    </nav>
    @endauth
{{-- ============================================================
     TOAST CONTAINER
============================================================ --}}
<div id="toast-container" class="toast-container"></div>

{{-- ============================================================
     CONFIRM MODAL
============================================================ --}}
<div id="confirm-modal" class="confirm-overlay">
    <div class="confirm-box">
        <div class="confirm-icon" id="confirm-icon">⚠️</div>
        <h3 class="confirm-title" id="confirm-title">Konfirmasi</h3>
        <p class="confirm-message" id="confirm-message">Apakah Anda yakin?</p>
        <div class="confirm-buttons">
            <button type="button" class="confirm-btn no" id="confirm-no">Batal</button>
            <button type="button" class="confirm-btn yes" id="confirm-yes">Ya, Lanjutkan</button>
        </div>
    </div>
</div>
    {{-- ============================================================
         KONTEN UTAMA
    ============================================================ --}}
    @yield('content')
{{-- ============================================================
     TOAST & CONFIRM SYSTEM
============================================================ --}}
<script>
    // ---------- TOAST NOTIFICATION ----------
    function showToast(message, type = 'info', duration = 3500) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const icons = { success: '✅', error: '❌', warning: '⚠️', info: 'ℹ️' };
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <span class="toast-icon">${icons[type] || icons.info}</span>
            <span class="toast-message">${message}</span>
            <button class="toast-close" type="button">×</button>
        `;

        toast.querySelector('.toast-close').addEventListener('click', () => {
            toast.style.animation = 'toastOut 0.3s ease forwards';
            setTimeout(() => toast.remove(), 300);
        });

        container.appendChild(toast);

        setTimeout(() => {
            if (toast.parentElement) {
                toast.style.animation = 'toastOut 0.3s ease forwards';
                setTimeout(() => toast.remove(), 300);
            }
        }, duration);
    }

    // ---------- CONFIRM MODAL ----------
    function showConfirm(options = {}) {
        return new Promise((resolve) => {
            const overlay = document.getElementById('confirm-modal');
            const icon = document.getElementById('confirm-icon');
            const title = document.getElementById('confirm-title');
            const message = document.getElementById('confirm-message');
            const yesBtn = document.getElementById('confirm-yes');
            const noBtn = document.getElementById('confirm-no');

            icon.textContent = options.icon || '⚠️';
            title.textContent = options.title || 'Konfirmasi';
            message.textContent = options.message || 'Apakah Anda yakin?';
            yesBtn.textContent = options.yesText || 'Ya, Lanjutkan';
            yesBtn.className = 'confirm-btn yes' + (options.danger ? ' danger' : '');
            noBtn.textContent = options.noText || 'Batal';

            overlay.classList.add('active');

            const cleanup = () => {
                overlay.classList.remove('active');
                yesBtn.onclick = null;
                noBtn.onclick = null;
                overlay.onclick = null;
            };

            yesBtn.onclick = () => { cleanup(); resolve(true); };
            noBtn.onclick = () => { cleanup(); resolve(false); };
            overlay.onclick = (e) => {
                if (e.target === overlay) { cleanup(); resolve(false); }
            };
        });
    }

    // ---------- HELPER: form submit dengan konfirmasi ----------
    async function confirmSubmit(e, message, options = {}) {
        e.preventDefault();
        const ok = await showConfirm({ message, ...options });
        if (ok) e.target.submit();
        return false;
    }
  // ---------- LOADING STATE HELPER ----------
/**
 * Ubah tombol menjadi loading state.
 * @param {HTMLElement} button - elemen tombol
 * @param {string} loadingText - teks saat loading (default: 'Menyimpan...')
 */
function setLoading(button, loadingText = 'Menyimpan...') {
    if (!button) return;
    // Simpan konten asli jika belum tersimpan
    if (!button.dataset.originalHtml) {
        button.dataset.originalHtml = button.innerHTML;
    }
    button.disabled = true;
    button.style.opacity = '0.7';
    button.style.cursor = 'not-allowed';
    button.innerHTML = `<span class="spinner-inline"></span>${loadingText}`;
}

/**
 * Kembalikan tombol ke state normal.
 * @param {HTMLElement} button - elemen tombol
 */
function resetLoading(button) {
    if (!button) return;
    button.disabled = false;
    button.style.opacity = '';
    button.style.cursor = '';
    if (button.dataset.originalHtml) {
        button.innerHTML = button.dataset.originalHtml;
        delete button.dataset.originalHtml;
    }
}

/**
 * Helper untuk submit form dengan loading state.
 * @param {HTMLFormElement} form - form yang akan disubmit
 * @param {HTMLElement} button - tombol yang men-trigger submit (opsional)
 * @param {string} loadingText - teks saat loading (default: 'Menyimpan...')
 */
function submitWithLoading(form, button = null, loadingText = 'Menyimpan...') {
    if (button) setLoading(button, loadingText);
    form.submit();
      }
// ---------- FORMAT ANGKA RIBUAN ----------
/**
 * Format angka menjadi format ribuan dengan titik.
 * Contoh: 50000 → "50.000"
 */
function formatRibuan(value) {
    if (value === null || value === undefined || value === '') return '';
    const digitsOnly = String(value).replace(/\D/g, '');
    if (digitsOnly === '') return '';
    return digitsOnly.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

/**
 * Parse string format ribuan ke number murni.
 * Contoh: "50.000" → 50000
 */
function parseAngka(value) {
    if (!value) return 0;
    const clean = String(value).replace(/\./g, '').replace(/[^\d]/g, '');
    return parseFloat(clean) || 0;
}

/**
 * Pasang auto-format ke input.
 * - Input di-format saat mengetik.
 * - Cursor tetap di posisi wajar.
 * - Format final saat blur.
 */
function attachAutoFormat(input) {
    if (!input || input.dataset.autoFormatAttached === 'true') return;
    input.dataset.autoFormatAttached = 'true';

    input.addEventListener('input', function() {
        const cursorPos = this.selectionStart;
        const beforeCursor = this.value.substring(0, cursorPos);
        const digitsBeforeCursor = beforeCursor.replace(/\D/g, '').length;

        this.value = formatRibuan(this.value);

        // Set posisi cursor
        if (digitsBeforeCursor === 0) {
            this.setSelectionRange(0, 0);
        } else {
            let newPos = 0;
            let digitCount = 0;
            for (let i = 0; i < this.value.length; i++) {
                if (/\d/.test(this.value[i])) {
                    digitCount++;
                    if (digitCount === digitsBeforeCursor) {
                        newPos = i + 1;
                        break;
                    }
                }
            }
            this.setSelectionRange(newPos, newPos);
        }
    });

    input.addEventListener('blur', function() {
        if (this.value) {
            this.value = formatRibuan(this.value);
        }
    });
}

/**
 * Strip format ribuan dari semua input [data-formatted] sebelum submit.
 */
function stripFormatBeforeSubmit(form) {
    if (!form) return;
    form.querySelectorAll('[data-formatted]').forEach(input => {
        if (input.value) {
            input.value = parseAngka(input.value);
        }
    });
}

// ---------- AUTO ATTACH FORMAT RIBUAN SAAT PAGE LOAD ----------
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-formatted]').forEach(input => {
        if (input.value) {
            input.value = formatRibuan(input.value);
        }
        attachAutoFormat(input);
    });
});

// ---------- STRIP FORMAT SEBELUM SUBMIT (DELEGATION) ----------
document.addEventListener('submit', function(e) {
    stripFormatBeforeSubmit(e.target);
});
// ---------- VALIDATION SYSTEM ----------
/**
 * Pasang validasi real-time ke input.
 */
function attachValidation(input) {
    if (!input || input.dataset.validationAttached === 'true') return;
    input.dataset.validationAttached = 'true';

    const hasUnique = (input.dataset.validate || '').includes('unique:');
    let inputTimer = null;
    let uniqueTimer = null;

    input.addEventListener('input', function() {
        clearTimeout(inputTimer);
        inputTimer = setTimeout(() => validateInput(input), 300);

        if (hasUnique) {
            input.dataset.uniqueState = 'pending';
            clearTimeout(uniqueTimer);
            uniqueTimer = setTimeout(() => runUniqueCheck(input), 700);
        }
    });

    input.addEventListener('blur', function() {
        clearTimeout(inputTimer);
        validateInput(input);

        if (hasUnique) {
            clearTimeout(uniqueTimer);
            runUniqueCheck(input);
        }
    });
  }

/**
 * Validasi input berdasarkan data-validate.
 * Return true jika valid, false jika error.
 */
function validateInput(input) {
    const rules = (input.dataset.validate || '').split('|').filter(Boolean);
    if (rules.length === 0) return true;

    const value = input.value || '';
    const label = input.dataset.validateLabel || input.name || 'Field';
    const isFormatted = input.dataset.formatted !== undefined;

    let error = null;

    for (const rule of rules) {
        const [ruleName, ...params] = rule.split(':');

        if (ruleName === 'required') {
            if (!value.trim()) {
                error = `${label} wajib diisi`;
                break;
            }
        } else if (ruleName === 'min') {
            const min = parseInt(params[0]);
            if (value.length < min) {
                error = `${label} minimal ${min} karakter`;
                break;
            }
        } else if (ruleName === 'max') {
            const max = parseInt(params[0]);
            if (value.length > max) {
                error = `${label} maksimal ${max} karakter`;
                break;
            }
        } else if (ruleName === 'email') {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (value && !re.test(value)) {
                error = `${label} harus berformat email valid`;
                break;
            }
        } else if (ruleName === 'numeric') {
            if (value) {
                const angka = isFormatted ? parseAngka(value) : parseFloat(value);
                if (isNaN(angka)) {
                    error = `${label} harus berupa angka`;
                    break;
                }
            }
        } else if (ruleName === 'min_value') {
            const min = parseFloat(params[0]);
            if (value) {
                const angka = isFormatted ? parseAngka(value) : parseFloat(value);
                if (!isNaN(angka) && angka < min) {
                    error = `${label} minimal ${min}`;
                    break;
                }
            }
        } else if (ruleName === 'unique') {
            // ⚠️ Akan diaktifkan di CP 5C (butuh endpoint AJAX)
        }
    }

    applyValidationState(input, error);
    return !error;
}

/**
 * Terapkan state visual ke input (error/valid/normal).
 */
function applyValidationState(input, error) {
    input.classList.remove('input-error', 'input-valid', 'input-checking');

    let messageEl = input.parentElement.querySelector('.validation-message');

    if (error) {
        input.classList.add('input-error');
        if (!messageEl) {
            messageEl = document.createElement('div');
            input.parentElement.appendChild(messageEl);
        }
        messageEl.className = 'validation-message error';
        messageEl.textContent = '⚠️ ' + error;
    } else if (input.value && input.value.trim() !== '') {
        input.classList.add('input-valid');
        if (messageEl) messageEl.remove();
    } else {
        if (messageEl) messageEl.remove();
    }
}
/**
 * Cek unique ke server (async).
 */
async function runUniqueCheck(input) {
    const rules = (input.dataset.validate || '').split('|');
    const uniqueRule = rules.find(r => r.startsWith('unique:'));
    if (!uniqueRule) return;

    const value = input.value.trim();
    if (!value) {
        input.dataset.uniqueState = 'unknown';
        return;
    }

    // Parse: unique:model,field
    const params = uniqueRule.replace('unique:', '').split(',');
    const model = params[0];
    const field = params[1];
    const excludeId = input.dataset.validateExcludeId || null;

    input.dataset.uniqueState = 'pending';
    input.classList.remove('input-error', 'input-valid');
    input.classList.add('input-checking');

    let messageEl = input.parentElement.querySelector('.validation-message');
    if (!messageEl) {
        messageEl = document.createElement('div');
        input.parentElement.appendChild(messageEl);
    }
    messageEl.className = 'validation-message checking';
    messageEl.innerHTML = '<span class="spinner-inline"></span> Memeriksa...';

    try {
        const response = await fetch('/check-unique', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ model, field, value, exclude_id: excludeId })
        });

        if (!response.ok) throw new Error('Network error');

        const result = await response.json();

        input.classList.remove('input-checking');

        if (result.is_unique) {
            input.dataset.uniqueState = 'valid';
            input.classList.add('input-valid');
            messageEl.className = 'validation-message success';
            messageEl.textContent = '✓ ' + (input.dataset.validateLabel || 'Data') + ' tersedia';
            setTimeout(() => {
                if (messageEl.parentElement && messageEl.classList.contains('success')) {
                    messageEl.remove();
                }
            }, 2000);
        } else {
            input.dataset.uniqueState = 'invalid';
            input.classList.add('input-error');
            messageEl.className = 'validation-message error';
            messageEl.textContent = '⚠️ ' + (input.dataset.validateLabel || 'Data') + ' sudah digunakan';
        }
    } catch (error) {
        console.error('Unique check error:', error);
        input.classList.remove('input-checking');
        input.dataset.uniqueState = 'unknown';
        if (messageEl) messageEl.remove();
    }
    }

/**
 * Validasi semua input [data-validate] dalam form.
 * Return true jika semua valid.
 */
function validateForm(form) {
    if (!form) return true;
    let allValid = true;
    let hasPendingUnique = false;

    form.querySelectorAll('[data-validate]').forEach(input => {
        if (!validateInput(input)) allValid = false;

        if ((input.dataset.validate || '').includes('unique:')) {
            if (input.dataset.uniqueState === 'invalid') {
                allValid = false;
            } else if (input.dataset.uniqueState === 'pending') {
                hasPendingUnique = true;
            }
        }
    });

    if (hasPendingUnique) {
        showToast('Sedang memeriksa ketersediaan data. Silakan tunggu sebentar...', 'info');
        return false;
    }

    return allValid;
  }
// ---------- EMPTY STATE HELPER ----------
function emptyStateSmallHtml(icon, title, description) {
    return `<div class="empty-state empty-state-sm">
        ${icon ? '<div class="empty-state-icon" aria-hidden="true">' + icon + '</div>' : ''}
        ${title ? '<h3 class="empty-state-title">' + title + '</h3>' : ''}
        ${description ? '<p class="empty-state-description">' + description + '</p>' : ''}
    </div>`;
  }
// ---------- DIRTY FORM CHECK ----------
const dirtyForms = new Set();
let pageDirty = false;

function markFormDirty(form) {
    if (!form) return;
    dirtyForms.add(form);
}

function clearFormDirty(form) {
    if (!form) return;
    dirtyForms.delete(form);
}

function isFormDirty(form) {
    return dirtyForms.has(form);
}

function markPageDirty() {
    pageDirty = true;
}

function clearPageDirty() {
    pageDirty = false;
}

function clearAllDirty() {
    dirtyForms.clear();
    pageDirty = false;
}

function hasAnyDirty() {
    return pageDirty || dirtyForms.size > 0;
}

// Attach dirty tracking ke form
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form[data-dirty-check]').forEach(form => {
        form.addEventListener('input', () => markFormDirty(form));
        form.addEventListener('change', () => markFormDirty(form));
        form.addEventListener('submit', function(e) {
            // Clear hanya jika submit tidak dicegah (validasi lolos)
            setTimeout(() => {
                if (!e.defaultPrevented) clearFormDirty(form);
            }, 0);
        });
    });
});

// Intercept link klik (internal navigation)
document.addEventListener('click', async function(e) {
    if (e.button !== 0 || e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) return;

    const link = e.target.closest('a[href]');
    if (!link) return;

    if (link.hasAttribute('data-skip-dirty-check')) return;
    if (link.target === '_blank' || link.hasAttribute('download')) return;

    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript:')) return;

    if (!hasAnyDirty()) return;

    e.preventDefault();

    const ok = await showConfirm({
        icon: '⚠️',
        title: 'Perubahan Belum Disimpan',
        message: 'Anda memiliki perubahan pada form yang belum disimpan. Yakin ingin keluar?',
        yesText: 'Ya, Keluar',
        noText: 'Tetap di Sini',
        danger: true
    });

    if (ok) {
        clearAllDirty();
        window.location.href = link.href;
    }
});

// beforeunload untuk external navigation (close tab, refresh)
window.addEventListener('beforeunload', function(e) {
    if (!hasAnyDirty()) return;
    e.preventDefault();
    e.returnValue = '';
    return '';
});
// ---------- AUTO ATTACH SAAT PAGE LOAD ----------
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-validate]').forEach(input => {
        attachValidation(input);
        // Validasi awal jika ada value (misal dari old() atau database)
        if (input.value && input.value.trim() !== '') {
            validateInput(input);
        }
    });
});

</script>
    @stack('scripts')
</body>
</html>