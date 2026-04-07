<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Umpan Balik Aspirasi</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        body{font-family:Figtree, sans-serif;margin:0;background:#f6f8fb;color:#0f172a}
        .wrap{max-width:900px;margin:2.25rem auto;padding:1rem}
        .card{background:#fff;padding:1rem;border-radius:12px;box-shadow:0 6px 20px rgba(15,23,42,0.06)}
        table{width:100%;border-collapse:collapse;margin-top:.75rem}
        th,td{padding:.6rem;border-bottom:1px solid #f1f5f9;text-align:left}
    </style>
</head>
<body>
    <div class="wrap">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
            <h1 style="margin:0">Umpan Balik Aspirasi</h1>
            <a href="{{ route('admin.dashboard') }}">Kembali</a>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Umpan Balik</th>
                        <th>Diubah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $it)
                        <tr>
                            <td>{{ $it->id_aspirasi }}</td>
                            <td>{{ $it->kategori->nama ?? '—' }}</td>
                            <td>{{ $it->status }}</td>
                            <td>{{ $it->feedback }}</td>
                            <td>{{ $it->updated_at->format('d M Y') }}</td>
                            <td style="white-space:nowrap"><a href="{{ route('admin.aspirasi.edit', $it->id_aspirasi) }}">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Belum ada umpan balik.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>