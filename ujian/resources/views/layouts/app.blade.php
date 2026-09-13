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

    {{-- Tailwind CSS (sementara via CDN) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Global Styles --}}
    <style>
        /* ============================================================
           GLOBAL RESET
        ============================================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
    </style>

    {{-- Setiap halaman bisa tambah style sendiri di sini --}}
    @stack('styles')
</head>
<body>

    {{-- ============================================================
         KONTEN UTAMA
         Setiap halaman akan mengisi bagian ini.
    ============================================================ --}}
    @yield('content')

    {{-- Setiap halaman bisa tambah script sendiri di sini --}}
    @stack('scripts')
</body>
</html>
