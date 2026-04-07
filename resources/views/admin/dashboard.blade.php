<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        body{font-family:Figtree, sans-serif;margin:0;background:#f6f8fb;color:#0f172a}
        .wrap{max-width:1100px;margin:2.25rem auto;padding:1rem}
        .card{background:#fff;padding:1rem;border-radius:12px;box-shadow:0 6px 20px rgba(15,23,42,0.06)}
        .muted{color:#6b7280}
        table{width:100%;border-collapse:collapse;margin-top:.75rem}
        th,td{padding:.6rem;border-bottom:1px solid #f1f5f9;text-align:left}
        .filters{display:flex;gap:1rem;align-items:center}
        .small{font-size:.9rem}
        .badge{display:inline-block;padding:.25rem .5rem;border-radius:.375rem;font-weight:600}
    </style>
</head>
<body>
    <div class="wrap">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
            <div>
                <h1 style="margin:0">Dashboard Admin</h1>
                <div class="muted small">Ringkas data aspirasi dan histori</div>
            </div>
            <div style="display:flex;gap:.5rem;align-items:center">
                <a class="muted" href="{{ route('dashboard') }}">Kembali ke dashboard</a>
                <form method="POST" action="{{ route('admin.logout') }}" style="margin:0">
                    @csrf
                    <button type="submit" style="background:#fff;border:1px solid #ef4444;color:#ef4444;padding:.4rem .6rem;border-radius:8px;cursor:pointer">Logout</button>
                </form>
            </div>
        </div>

        <section style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.25rem">
            <div class="card">
                <div class="muted" style="font-size:13px">Total Pelaporan</div>
                <div style="font-size:20px;font-weight:700;margin-top:.5rem">{{ $total }}</div>
            </div>
            <div class="card">
                <div class="muted" style="font-size:13px">Kategori Terbanyak</div>
                <div style="font-size:14px;margin-top:.5rem">
                    @foreach($byCategory->take(3) as $c)
                        <div>{{ $c['kategori'] }} — <strong>{{ $c['count'] }}</strong></div>
                    @endforeach
                </div>
            </div>
            <div class="card">
                <div class="muted" style="font-size:13px">Per Siswa (Top 3)</div>
                <div style="font-size:14px;margin-top:.5rem">
                    @foreach($bySiswa->take(3) as $s)
                        <div>{{ $s['siswa'] }} — <strong>{{ $s['count'] }}</strong></div>
                    @endforeach
                </div>
            </div>
            <div class="card">
                <div class="muted" style="font-size:13px">Per Tanggal (baru)</div>
                <div style="font-size:14px;margin-top:.5rem">
                    @foreach($byDate->take(3) as $d)
                        <div>{{ $d->date }} — <strong>{{ $d->cnt }}</strong></div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Compact admin features table (per request) -->
        <div class="card" style="margin-bottom:1.25rem">
            <table style="border:1px solid #111;border-collapse:collapse">
                <thead>
                    <tr>
                        <th style="padding:.5rem;border:1px solid #111;background:#f3f4f6">Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td style="padding:.5rem;border:1px solid #111"><a href="{{ route('admin.aspirasi.list') }}">List aspirasi keseluruhan (per tanggal, per bulan, per siswa, per kategori)</a></td></tr>
                    <tr><td style="padding:.5rem;border:1px solid #111"><a href="{{ route('admin.aspirasi.status') }}">Status penyelesaian</a></td></tr>
                    <tr><td style="padding:.5rem;border:1px solid #111"><a href="{{ route('admin.aspirasi.feedback') }}">Umpan balik aspirasi</a></td></tr>
                    <tr><td style="padding:.5rem;border:1px solid #111">Histori aspirasi</td></tr>
                </tbody>
            </table>
        </div>

        <div class="card">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="filters">
                <div>
                    <label class="small muted">Filter Kategori</label>
                    <select name="kategori_id">
                        <option value="">Semua kategori</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" @if(!empty($kategoriId) && $kategoriId == $k->id) selected @endif>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="small muted">Filter Siswa</label>
                    <select name="siswa_id">
                        <option value="">Semua siswa</option>
                        @foreach($siswas as $s)
                            <option value="{{ $s->id }}" @if(!empty($siswaId) && $siswaId == $s->id) selected @endif>{{ $s->nis }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="align-self:end">
                    <button type="submit">Terapkan</button>
                    <a href="{{ route('admin.dashboard') }}" style="margin-left:.5rem">Reset</a>
                </div>
            </form>

        </div>

        <div class="card">
            <h3 style="margin-top:0">Daftar Aspirasi</h3>
            <div class="muted small">(urut terbaru terlebih dahulu)</div>

            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Siswa (NIS)</th>
                        <th>Kategori</th>
                        <th>Lokasi / Keterangan</th>
                        <th>Status</th>
                        <th>Umpan Balik</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $it)
                        <tr>
                            <td>{{ $it['pelaporan']->created_at->format('d M Y H:i') }}</td>
                            <td>{{ optional($it['siswa'])->nis ?? '—' }}</td>
                            <td>{{ $it['kategori'] }}</td>
                            <td>
                                <div style="font-weight:600">{{ $it['pelaporan']->lokasi }}</div>
                                <div class="muted" style="font-size:13px">{{ $it['pelaporan']->ket }}</div>
                            </td>
                            <td>{{ $it['status'] }}</td>
                            <td>{{ $it['feedback'] ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="muted">Belum ada aspirasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
