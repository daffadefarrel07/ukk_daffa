<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <style>
            body{font-family:Figtree, sans-serif;margin:0}
            .container{min-height:100vh;display:flex;align-items:center;justify-content:center;background:#f8fafc}
            .card{background:#fff;padding:2rem;border-radius:0.5rem;box-shadow:0 10px 30px rgba(2,6,23,0.08);width:100%;max-width:420px}
            .input{width:100%;padding:.75rem;border:1px solid #e5e7eb;border-radius:.375rem;margin-top:.5rem}
            .btn{display:inline-block;padding:.75rem 1rem;background:#ef4444;color:#fff;border-radius:.375rem;border:none;margin-top:1rem;width:100%}
            .text-muted{color:#6b7280;font-size:.9rem}
            .error{background:#fff1f2;color:#991b1b;border:1px solid #fecaca;padding:.5rem;border-radius:.375rem;margin-bottom:.75rem}
        </style>
    </head>
    <body>
        <div class="container">
            <div class="card">
                <h1 style="margin:0 0 0.5rem 0">Masuk</h1>

                @if($errors->any())
                    <div class="error">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ url('/login') }}">
                    @csrf
<label>NIS (10 digit)</label>
                    <input class="input" type="text" name="nis" value="{{ old('nis') }}" required autofocus maxlength="10">

                    <label style="margin-top:.75rem">Password</label>
                    <input class="input" type="password" name="password" required>

                    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:.75rem">
                        <label class="text-muted"><input type="checkbox" name="remember"> Ingat saya</label>
                        <a href="{{ route('register') }}" class="text-muted">Daftar</a>
                    </div>

                    <button class="btn" type="submit">Masuk</button>
                </form>
            </div>
        </div>
    </body>
</html>
