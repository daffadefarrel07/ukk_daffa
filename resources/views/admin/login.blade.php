<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        body{font-family:Figtree, sans-serif;margin:0;background:#f3f7fb;color:#0f172a}
        .center{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem}
        .card{background:#fff;padding:2rem;border-radius:12px;box-shadow:0 8px 30px rgba(15,23,42,0.06);max-width:440px;width:100%}
        input{width:100%;padding:.6rem;border-radius:8px;border:1px solid #e6eef7;margin-top:.5rem}
        button{margin-top:1rem;padding:.6rem 1rem;border-radius:8px;background:#ef4444;color:#fff;border:0}
        .muted{color:#6b7280}
    </style>
</head>
<body>
    <div class="center">
        <div class="card">
            <h2 style="margin:0">Admin Login</h2>
            <div class="muted" style="margin-top:.25rem">Masuk sebagai admin (hardcoded)</div>

            @if($errors->any())
                <div style="color:#b91c1c;margin-top:.75rem">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" style="margin-top:1rem">
                @csrf
<label>NIS / Username / Email</label>
                <input name="username" value="{{ old('username') }}" required maxlength="255" placeholder="NIS, nama, atau email" />
                <label style="margin-top:.6rem">Password</label>
                <input type="password" name="password" required />
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
