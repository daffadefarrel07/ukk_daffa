@extends('admin.layout')

@section('title','Dashboard')

@section('content')
<div class="admin-wrap">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
        <div>
            <h1 style="margin:0">Dashboard Admin</h1>
            <div class="muted small">Ringkas data aspirasi dan histori</div>
        </div>
        <div style="display:flex;gap:.5rem;align-items:center">
            <a class="muted" href="{{ route('dashboard') }}">Kembali ke dashboard</a>
            <form method="POST" action="{{ route('admin.logout') }}" style="margin:0">
                @csrf
                <button type="submit" class="btn btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <section class="grid-cards">
        <div class="card">
            <div class="muted small">Total Pelaporan</div>
            <div class="big">{{ $total ?? 0 }}</div>
        </div>
        <div class="card">
            <div class="muted small">Kategori Terbanyak</div>
            <div class="list">
                @foreach(($byCategory ?? collect())->take(3) as $c)
                    <div>{{ $c['kategori'] }} — <strong>{{ $c['count'] }}</strong></div>
                @endforeach
            </div>
        </div>
        <div class="card">
            <div class="muted small">Per Siswa (Top 3)</div>
            <div class="list">
                @foreach(($bySiswa ?? collect())->take(3) as $s)
                    <div>{{ $s['siswa'] }} — <strong>{{ $s['count'] }}</strong></div>
                @endforeach
            </div>
        </div>
        <div class="card">
            <div class="muted small">Per Tanggal (baru)</div>
            <div class="list">
                @foreach(($byDate ?? collect())->take(3) as $d)
                    <div>{{ $d->date }} — <strong>{{ $d->cnt }}</strong></div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Admin features table exactly as requested -->
    <div class="card feature-table">
        <table class="feature">
            <thead>
                <tr>
                    <th>Admin</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><a href="{{ route('admin.aspirasi.status') }}">Status penyelesaian</a></td>
                </tr>
                <tr>
                    <td><a href="{{ route('admin.aspirasi.feedback') }}">Umpan balik aspirasi</a></td>
                </tr>
                <tr>
                    <td>Histori aspirasi</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="card filters-card">
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
                <button type="submit" class="btn">Terapkan</button>
                <a href="{{ route('admin.dashboard') }}" style="margin-left:.5rem">Reset</a>
            </div>
        </form>
    </div>

    <div class="card">
        <h3 style="margin-top:0">Daftar Aspirasi</h3>
        <div class="muted small">(urut terbaru terlebih dahulu)</div>

        <table class="table">
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
                        <td>{{ optional($it['pelaporan']->created_at)->format('d M Y H:i') }}</td>
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

<style>
.admin-wrap{max-width:1100px;margin:1.5rem auto}
.muted{color:#6b7280}
.small{font-size:.9rem}
.grid-cards{display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1rem}
.card{background:#fff;padding:1rem;border-radius:8px;box-shadow:0 6px 20px rgba(15,23,42,0.06);margin-bottom:1rem}
.big{font-size:20px;font-weight:700;margin-top:.5rem}
.list div{margin-bottom:.25rem}
.feature-table table.feature{width:100%;border-collapse:collapse}
.feature th,.feature td{padding:.6rem;border:1px solid #e5e7eb;text-align:left}
.table{width:100%;border-collapse:collapse}
.table th,.table td{padding:.6rem;border-bottom:1px solid #f1f5f9;text-align:left}
.filters{display:flex;gap:1rem;align-items:center}
.btn{background:#3b82f6;color:#fff;padding:.5rem .75rem;border-radius:6px;border:none}
.btn-logout{background:#fff;border:1px solid #ef4444;color:#ef4444;padding:.4rem .6rem;border-radius:8px;cursor:pointer}
</style>

@endsection
