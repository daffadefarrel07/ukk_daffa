<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Selamat Datang</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <style>
            :root{--red:#ef4444;--muted:#6b7280;--bg:#f3f7fb}
            *{box-sizing:border-box}
            body{font-family:Figtree, sans-serif;margin:0;background:linear-gradient(180deg,#f8fafc 0%,var(--bg) 100%);color:#0f172a}
            .center{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem}
            .card{background:rgba(255,255,255,0.96);padding:2rem;border-radius:14px;box-shadow:0 8px 30px rgba(15,23,42,0.08);max-width:640px;width:100%;text-align:center}
            .brand{display:flex;align-items:center;gap:.75rem;justify-content:center;margin-bottom:.5rem}
            .logo{width:56px;height:56px;border-radius:12px;background:linear-gradient(135deg,var(--red),#10b981);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:20px}
            .title{font-size:1.5rem;font-weight:700;margin:0}
            .subtitle{color:var(--muted);margin-top:.35rem;margin-bottom:1.25rem}
            .actions{display:flex;gap:.75rem;flex-wrap:wrap;justify-content:center}
            .btn{display:inline-flex;align-items:center;gap:.5rem;padding:.65rem 1.1rem;border-radius:10px;text-decoration:none;font-weight:600;border:0;cursor:pointer}
            .btn-primary{background:var(--red);color:#fff;box-shadow:0 6px 18px rgba(239,68,68,0.18)}
            .btn-ghost{background:#fff;color:var(--red);border:2px solid rgba(239,68,68,0.12)}
            .muted{color:var(--muted)}
            .small{font-size:.9rem}
            .helper{margin-top:1rem;color:var(--muted);font-size:.95rem}
            @media (max-width:480px){.card{padding:1.25rem}.logo{width:48px;height:48px}}
        </style>
    </head>
    <body>
        <div class="center">
            <div class="card">
                <div class="brand">
                    <div class="logo">A</div>
                </div>

                <h1 class="title">Selamat Bergabung</h1>
                <div class="subtitle small">Silakan pilih aksi untuk melanjutkan</div>

                <div class="actions">
                    @auth
                        <a class="btn btn-primary" href="{{ route('dashboard') }}">
                            <!-- simple dashboard icon -->
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden>
                                <path d="M3 13h8V3H3v10zM3 21h8v-6H3v6zM13 21h8V11h-8v10zM13 3v6h8V3h-8z" fill="currentColor" />
                            </svg>
                            Buka Dashboard
                        </a>

                        <form method="POST" action="{{ route('logout') }}" style="display:inline-block">
                            @csrf
                            <button type="submit" class="btn btn-ghost">Logout</button>
                        </form>
                    @else
                        <a class="btn btn-primary" href="{{ route('login') }}">Login</a>
                        @if (Route::has('register'))
                            <a class="btn btn-ghost" href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>

                <div class="helper">Aplikasi sederhana untuk melaporkan aspirasi dan melihat status tindak lanjut.</div>
            </div>
        </div>
    </body>
</html>
