<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login · CatatRezekimu</title>

    <!-- Google Fonts (inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet" />

    <style>
        /* ----- RESET & GLOBAL ----- */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: linear-gradient(145deg, #f1f5f9 0%, #e2e8f0 100%);
        }

        /* ----- CARD UTAMA ----- */
        .login-card {
            max-width: 440px;
            width: 100%;
            background: #ffffff;
            border-radius: 32px;
            box-shadow: 0 20px 60px rgba(0, 20, 40, 0.12);
            padding: 40px 32px 36px;
            transition: box-shadow 0.3s, transform 0.2s;
        }

        .login-card:hover {
            box-shadow: 0 24px 72px rgba(0, 20, 40, 0.16);
        }

        /* ----- BRAND / HEADER ----- */
        .brand {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 68px;
            height: 68px;
            background: #0b3b2c;
            border-radius: 20px;
            margin-bottom: 16px;
            color: #ffffff;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.5px;
            box-shadow: 0 8px 24px rgba(11, 59, 44, 0.25);
            transition: transform 0.2s;
        }

        .brand-icon:hover {
            transform: scale(1.02);
        }

        .brand h1 {
            font-size: 28px;
            font-weight: 700;
            color: #0b3b2c;
            letter-spacing: -0.3px;
        }

        .brand .sub {
            font-size: 15px;
            font-weight: 400;
            color: #64748b;
            margin-top: 6px;
            letter-spacing: 0.2px;
        }

        /* ----- FORM ELEMEN ----- */
        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .form-group .input-wrap {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 14px 48px 14px 18px;
            font-size: 15px;
            font-weight: 400;
            font-family: 'Inter', sans-serif;
            color: #0f172a;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 16px;
            outline: none;
            transition: border 0.25s, box-shadow 0.25s, background 0.25s;
        }

        .form-group input:focus {
            border-color: #0b3b2c;
            box-shadow: 0 0 0 4px rgba(11, 59, 44, 0.10);
            background: #ffffff;
        }

        .form-group input::placeholder {
            color: #94a3b8;
            font-weight: 400;
            font-size: 14px;
        }

        /* Toggle password icon SVG */
        .input-wrap .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            user-select: none;
            transition: color 0.2s;
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-wrap .toggle-password:hover {
            color: #0b3b2c;
        }

        .input-wrap .toggle-password svg {
            width: 20px;
            height: 20px;
        }

        .input-wrap .toggle-password .hidden {
            display: none;
        }

        /* ----- PESAN ERROR ----- */
        .error-message {
            background: #fef2f2;
            border-left: 4px solid #dc2626;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 500;
            color: #991b1b;
        }

        .error-message .icon {
            font-size: 18px;
            line-height: 1;
        }

        .error-message.hidden {
            display: none;
        }

        /* ----- TOMBOL LOGIN ----- */
        .btn-login {
            width: 100%;
            padding: 16px;
            background: #0b3b2c;
            border: none;
            border-radius: 16px;
            color: #ffffff;
            font-size: 17px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 6px 20px rgba(11, 59, 44, 0.30);
            margin-top: 6px;
            letter-spacing: 0.3px;
        }

        .btn-login:hover {
            background: #0a3426;
            box-shadow: 0 8px 28px rgba(11, 59, 44, 0.35);
        }

        .btn-login:active {
            transform: scale(0.97);
            background: #082f23;
        }

        /* ----- FOOTER ----- */
        .login-footer {
            text-align: center;
            margin-top: 28px;
            font-size: 13px;
            color: #94a3b8;
            border-top: 1px solid #eef2f6;
            padding-top: 24px;
        }

        .login-footer .version {
            display: inline-block;
            background: #f1f5f9;
            padding: 4px 14px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 500;
            color: #64748b;
        }

        /* ====== RESPONSIVE UNTUK LAPTOP / DESKTOP ====== */
        @media (min-width: 640px) {
            .login-card {
                padding: 48px 40px 40px;
                max-width: 480px;
            }

            .brand-icon {
                width: 76px;
                height: 76px;
                font-size: 36px;
            }

            .brand h1 {
                font-size: 32px;
            }

            .brand .sub {
                font-size: 16px;
            }

            .form-group input {
                padding: 16px 48px 16px 20px;
                font-size: 16px;
            }

            .btn-login {
                padding: 18px;
                font-size: 18px;
            }
        }

        @media (min-width: 1024px) {
            .login-card {
                padding: 56px 48px 44px;
                max-width: 520px;
                border-radius: 40px;
            }

            .brand-icon {
                width: 84px;
                height: 84px;
                font-size: 40px;
                border-radius: 24px;
            }

            .brand h1 {
                font-size: 36px;
            }

            .brand .sub {
                font-size: 17px;
            }

            .form-group input {
                padding: 18px 52px 18px 24px;
                font-size: 17px;
                border-radius: 18px;
            }

            .btn-login {
                padding: 20px;
                font-size: 19px;
                border-radius: 18px;
            }

            .login-footer {
                margin-top: 32px;
                padding-top: 28px;
                font-size: 14px;
            }
        }

        /* ====== RESPONSIVE UNTUK HP ====== */
        @media (max-width: 480px) {
            .login-card {
                padding: 32px 20px 28px;
                border-radius: 28px;
            }

            .brand h1 {
                font-size: 24px;
            }

            .brand-icon {
                width: 56px;
                height: 56px;
                font-size: 26px;
            }

            .form-group input {
                padding: 13px 44px 13px 16px;
                font-size: 15px;
            }

            .btn-login {
                padding: 15px;
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

    <div class="login-card">

        <!-- Brand -->
        <div class="brand">
            <div class="brand-icon">📦</div>
            <h1>CatatRezekimu</h1>
            <div class="sub">Manajemen Stok &amp; Keuangan</div>
        </div>

        <!-- Pesan error dari Laravel -->
        @if ($errors->any())
            <div class="error-message">
                <span class="icon">⚠️</span>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Form Login -->
        <form action="{{ url('/login') }}" method="POST">
            @csrf

            <!-- Username -->
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrap">
                    <input type="text" id="username" name="username"
                           placeholder="Masukkan username Anda"
                           value="{{ old('username') }}" required autofocus />
                </div>
            </div>

            <!-- Password dengan toggle SVG modern -->
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input type="password" id="password" name="password"
                           placeholder="Masukkan password" required />
                    <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan password">
                        <!-- Icon Mata Terbuka (Default/Tersembunyi) -->
                        <svg class="icon-eye" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <!-- Icon Mata Tertutup (Aktif saat password terlihat) -->
                        <svg class="icon-eye-off hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path>
                            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"></path>
                            <path d="M6.61 6.61A13.52 13.52 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"></path>
                            <line x1="2" y1="2" x2="22" y2="22"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>

        <!-- Footer -->
        <div class="login-footer">
            <span class="version">versi 1.0 &bull; offline</span>
        </div>

    </div>

    <script>
        // Toggle password visibility
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const iconEye = toggleBtn.querySelector('.icon-eye');
        const iconEyeOff = toggleBtn.querySelector('.icon-eye-off');

        toggleBtn.addEventListener('click', function() {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            
            // Toggle tipe input
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

            // Toggle ikon SVG
            iconEye.classList.toggle('hidden', isPassword);
            iconEyeOff.classList.toggle('hidden', !isPassword);

            // Update aria-label untuk aksesibilitas
            this.setAttribute('aria-label', isPassword ? 'Sembunyikan password' : 'Tampilkan password');
        });
    </script>

</body>
</html>
