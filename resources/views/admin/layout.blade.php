<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <a class="brand" href="{{ route('admin.dashboard') }}">Admin Panel</a>
            <nav class="nav">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.aspirasi.list') }}">Aspirasi</a>
                <a href="{{ route('admin.aspirasi.status') }}">Status</a>
                <a href="{{ route('admin.aspirasi.feedback') }}">Feedback</a>
                <form method="POST" action="{{ route('admin.logout') }}" class="inline-form">@csrf <button type="submit" class="link-button">Logout</button></form>
            </nav>
        </div>
    </header>

    <main class="container main">
        @if(session('success'))
            <div class="flash success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>

    <footer class="admin-footer">© {{ date('Y') }} - Admin</footer>
</body>
</html>
