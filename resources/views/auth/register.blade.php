<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Aspirasi App</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Figtree', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><radialGradient id="g" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffffff11"/><stop offset="100%" stop-color="%23ffffff00"/></radialGradient></defs><circle cx="20" cy="20" r="1" fill="url(%23g)"><animate attributeName="cy" values="20;80;20" dur="3s" repeatCount="indefinite"/></circle><circle cx="80" cy="80" r="1" fill="url(%23g)"><animate attributeName="cy" values="80;20;80" dur="4s" repeatCount="indefinite"/></circle><circle cx="50" cy="10" r="1.5" fill="url(%23g)"><animate attributeName="cy" values="10;90;10" dur="2.5s" repeatCount="indefinite"/></circle></svg>');
            animation: float 20s ease-in-out infinite;
            z-index: 1;
        }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
        .container {
            position: relative;
            z-index: 2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 25px 45px rgba(0,0,0,0.1);
            animation: slideIn 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        h1 {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ffffff, #f0f9ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0 0 2rem 0;
            text-align: center;
        }
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .input-label {
            position: absolute;
            top: 1rem;
            left: 1rem;
            font-size: 0.95rem;
            color: rgba(255,255,255,0.8);
            transition: all 0.3s ease;
            pointer-events: none;
        }
        .input-field {
            width: 100%;
            padding: 1.2rem 1rem 1rem 3rem;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 16px;
            font-size: 1rem;
            color: #ffffff;
            outline: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        .input-field::placeholder { color: rgba(255,255,255,0.5); }
        .input-field:focus {
            border-color: rgba(255,255,255,0.4);
            box-shadow: 0 0 0 4px rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
        .input-field:focus + .input-label,
        .input-field:not(:placeholder-shown) + .input-label {
            top: 0.5rem;
            font-size: 0.8rem;
            color: #ffffff;
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.7);
            z-index: 2;
        }
        .password-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .link-row {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .link-row a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }
        .link-row a:hover { color: #ffffff; }
        .link-row::before {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255,255,255,0.2);
            top: 50%;
            z-index: 0;
        }
        .link-row span {
            background: rgba(255,255,255,0.1);
            padding: 0 1rem;
            color: rgba(255,255,255,0.7);
            z-index: 1;
            backdrop-filter: blur(10px);
        }
        .btn {
            width: 100%;
            padding: 1.2rem;
            background: linear-gradient(135deg, #ec4899, #8b5cf6);
            color: #ffffff;
            border: none;
            border-radius: 16px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(236, 72, 153, 0.4);
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(236, 72, 153, 0.5);
        }
        .btn:active { transform: translateY(-1px); }
        .error {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #fecaca;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
            animation: shake 0.5s ease-in-out;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        @media (max-width: 480px) {
            .card { padding: 2rem 1.5rem; margin: 1rem; }
            h1 { font-size: 1.6rem; }
            .password-row { grid-template-columns: 1fr; gap: 0.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1><i class="fas fa-user-plus"></i> Daftar</h1>

            @if($errors->any())
                <div class="error">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ url('/register') }}">
                @csrf

                <div class="input-group">
                    <i class="fas fa-user input-icon"></i>
                    <input class="input-field" type="text" name="name" value="{{ old('name') }}" required placeholder=" ">
                    <label class="input-label">Nama Lengkap</label>
                </div>

                <div class="input-group">
                    <i class="fas fa-id-badge input-icon"></i>
                    <input class="input-field" type="text" name="nis" value="{{ old('nis') }}" required placeholder=" " maxlength="10">
                    <label class="input-label">NIS (max 10 digit)</label>
                </div>

                <div class="password-row">
                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input class="input-field" type="password" name="password" required placeholder=" ">
                        <label class="input-label">Password</label>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock-open input-icon"></i>
                        <input class="input-field" type="password" name="password_confirmation" required placeholder=" ">
                        <label class="input-label">Konfirmasi Password</label>
                    </div>
                </div>

                <div class="link-row">
                    <span>Sudah punya akun?</span>
                    <a href="{{ route('login') }}">Masuk sekarang</a>
                </div>

                <button class="btn" type="submit">
                    <i class="fas fa-check"></i> Buat Akun
                </button>
            </form>
        </div>
    </div>
    <script>
        // Password toggle for both fields
        document.querySelectorAll('.fas.fa-lock, .fas.fa-lock-open').forEach((icon, index) => {
            const input = icon.parentElement.querySelector('input');
            let showPass = false;
            icon.addEventListener('click', () => {
                showPass = !showPass;
                input.type = showPass ? 'text' : 'password';
                icon.className = showPass ? (index === 0 ? 'fas fa-eye-slash input-icon' : 'fas fa-eye input-icon') : (index === 0 ? 'fas fa-lock input-icon' : 'fas fa-lock-open input-icon');
            });
        });
    </script>
</body>
</html>
