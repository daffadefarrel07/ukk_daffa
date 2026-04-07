<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Siswa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        body{font-family:Figtree, sans-serif;margin:0;background:#f6f8fb;color:#0f172a}
        .wrap{max-width:1100px;margin:2.25rem auto;padding:1rem}
        .card{background:#fff;padding:1rem;border-radius:12px;box-shadow:0 6px 20px rgba(15,23,42,0.06)}
        .muted{color:#6b7280}
        .feature{padding:1rem;border-radius:10px}
        .badge{display:inline-block;padding:.25rem .5rem;border-radius:.375rem;font-weight:600}
        .status-Menunggu{background:#fef3c7;color:#92400e}
        .status-Proses{background:#bfdbfe;color:#1e3a8a}
        .status-Selesai{background:#bbf7d0;color:#065f46}
        table{width:100%;border-collapse:collapse}
        th,td{padding:.6rem;border-bottom:1px solid #f1f5f9;text-align:left}
        a.btn{display:inline-block;padding:.5rem .85rem;border-radius:8px;text-decoration:none}
        a.primary{background:#ef4444;color:#fff}
        a.ghost{background:#fff;color:#ef4444;border:1px solid #ef4444}
    </style>
</head>
<body>
    <div class="wrap">
        @if(session('success'))
            <div style="background:#ecfdf5;border:1px solid #10b981;color:#065f46;padding:.75rem 1rem;border-radius:8px;margin-bottom:1rem">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#fff1f2;border:1px solid #f43f5e;color:#7f1d1d;padding:.75rem 1rem;border-radius:8px;margin-bottom:1rem">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div style="background:#fff7ed;border:1px solid #f59e0b;color:#92400e;padding:.75rem 1rem;border-radius:8px;margin-bottom:1rem">
                <strong>Terjadi kesalahan:</strong>
                <ul style="margin:0.5rem 0 0 1.1rem;padding:0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
            <div>
                <h1 style="margin:0">Dashboard Siswa</h1>
                <div class="muted">{{ $siswa->nis }} — Kelas {{ $siswa->kelas }}</div>
            </div>
            <div style="display:flex;gap:.5rem;align-items:center">
                <a class="btn primary" href="{{ route('siswa.dashboard') }}">Refresh</a>
                <a class="btn ghost" href="{{ route('siswa.aspirasi.create') }}" onclick="event.preventDefault();window.location.href='{{ route('siswa.aspirasi.create') }}'" role="button">Tambah Aspirasi</a>
            </div>
        </div>

        <!-- feature cards -->
        <section style="display:grid;grid-template-columns:repeat(5,1fr);gap:1rem;margin-bottom:1.25rem">
            <div class="card feature">
                <div class="muted" style="font-size:13px">Status Penyelesaian</div>
                <div style="font-size:20px;font-weight:700;margin-top:.5rem">{{ $completionPercent }}%</div>
                <div style="height:8px;background:#eef2f7;border-radius:999px;margin-top:.6rem;overflow:hidden">
                    <div style="width:{{ $completionPercent }}%;height:8px;background:linear-gradient(90deg,#06b6d4,#10b981)"></div>
                </div>
            </div>

            <div class="card feature">
                <div class="muted" style="font-size:13px">Histori Aspirasi</div>
                <div style="font-size:20px;font-weight:700;margin-top:.5rem">{{ $aspirasiCount }}</div>
                <div class="muted" style="font-size:13px;margin-top:.5rem">Lihat histori lengkap di bawah</div>
            </div>

            <div class="card feature">
                <div class="muted" style="font-size:13px">Menunggu</div>
                <div style="font-size:20px;font-weight:700;margin-top:.5rem">{{ $waitingCount ?? 0 }}</div>
                <div class="muted" style="font-size:13px;margin-top:.5rem">Jumlah aspirasi berstatus Menunggu</div>
            </div>

            <div class="card feature">
                <div class="muted" style="font-size:13px">Umpan Balik Aspirasi</div>
                <div style="font-size:15px;font-weight:600;margin-top:.5rem">@if($latestFeedback) {{ \Illuminate\Support\Str::limit($latestFeedback,80) }} @else <span class="muted">Belum ada</span> @endif</div>
                <div class="muted" style="font-size:13px;margin-top:.5rem">Umpan balik terbaru dari admin</div>
            </div>

            <div class="card feature">
                <div class="muted" style="font-size:13px">Progres Perbaikan</div>
                <div style="font-size:20px;font-weight:700;margin-top:.5rem">{{ $avgProgress }}%</div>
                <div class="muted" style="font-size:13px;margin-top:.5rem">Rata-rata progres keseluruhan</div>
            </div>
        </section>

        <div style="display:grid;grid-template-columns:1fr 320px;gap:1rem">
            <main>
                <div class="card">
                    <h3 style="margin-top:0">Histori Aspirasi</h3>
                    @if(count($items) === 0)
                        <div class="muted">Belum ada aspirasi yang dilaporkan.</div>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Lokasi / Keterangan</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $it)
                                    <tr>
                                        <td>{{ $it['pelaporan']->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div style="font-weight:600">{{ $it['pelaporan']->lokasi }}</div>
                                            <div class="muted" style="font-size:13px">{{ $it['pelaporan']->ket }}</div>
                                        </td>
                                        <td>{{ $it['kategori'] }}</td>
                                        <td><span class="badge status-{{ $it['status'] }}">{{ $it['status'] }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </main>

            <aside>
                <div class="card">
                    <h4 style="margin:0 0 .5rem 0">Umpan Balik</h4>
                    @php
                        if ($items instanceof \Illuminate\Support\Collection) {
                            $feedbacks = $items->map(fn($i) => $i['feedback'] ?? null)->filter()->all();
                        } else {
                            $feedbacks = array_filter(array_map(function($i){ return $i['feedback'] ?? null; }, (array) $items));
                        }
                    @endphp
                    @if(empty($feedbacks))
                        <div class="muted">Belum ada umpan balik.</div>
                    @else
                        <ul style="padding-left:1rem;margin:0">
                            @foreach($items as $it)
                                @if($it['feedback'])
                                    <li style="margin-bottom:.6rem">
                                        <div style="font-weight:600">{{ $it['kategori'] }}</div>
                                        <div class="muted" style="font-size:13px">{{ $it['feedback'] }}</div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif

                    <hr style="margin:1rem 0;border-color:#eef2f7">
                    <div class="muted" style="font-size:13px">Keterangan: Menunggu=0%, Proses≈50%, Selesai=100%</div>
                </div>
            </aside>
        </div>
    </div>
</body>
</html>
