<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Aspirasi</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        body{font-family:Figtree, sans-serif;margin:0;background:#f6f8fb;color:#0f172a}
        .wrap{max-width:720px;margin:3rem auto;padding:1rem}
        .card{background:#fff;padding:1rem;border-radius:12px;box-shadow:0 6px 20px rgba(15,23,42,0.06)}
        label{display:block;margin-top:.75rem;font-weight:600}
        input[type=text],select,textarea{width:100%;padding:.6rem;border-radius:8px;border:1px solid #e6eef7;margin-top:.4rem}
        button{margin-top:1rem;padding:.6rem 1rem;border-radius:8px;background:#ef4444;color:#fff;border:0}
        .muted{color:#6b7280}
        a.btn-back{display:inline-block;margin-top:1rem;color:#ef4444}
    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <h2 style="margin:0">Tambah Aspirasi</h2>
            <div class="muted">Akun: {{ auth()->user()->name }} — {{ optional($siswa)->nis ?? '-' }} (Kelas {{ optional($siswa)->kelas ?? '-' }})</div>

            @if ($errors->any())
                <div style="margin-top:1rem;color:#b91c1c;font-weight:600">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('siswa.aspirasi.store') }}">
                @csrf
                <label for="nis">NIS</label>
                <input id="nis" name="nis" type="text" required value="{{ old('nis', optional($siswa)->nis ?? '') }}" autofocus />

                <label for="kategori_id">Kategori</label>
                <select id="kategori_id" name="kategori_id" required>
                    <option value="">Pilih kategori</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                    @endforeach
                </select>

                <label for="lokasi">Lokasi / Judul singkat</label>
                <input id="lokasi" name="lokasi" type="text" required />

                <label for="ket">Keterangan (opsional)</label>
                <textarea id="ket" name="ket" rows="4"></textarea>

                <button type="submit">Kirim Aspirasi</button>
            </form>

            <a class="btn-back" href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>
            <script>
                // if autofocus isn't supported, ensure focus via JS
                document.addEventListener('DOMContentLoaded', function(){
                    var nis = document.getElementById('nis');
                    if(nis) nis.focus();
                });
            </script>
        </div>
    </div>
</body>
</html>
