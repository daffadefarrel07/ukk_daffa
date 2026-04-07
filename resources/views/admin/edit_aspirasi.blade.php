<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Aspirasi</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>
        body{font-family:Figtree, sans-serif;margin:0;background:#f6f8fb;color:#0f172a}
        .wrap{max-width:700px;margin:2.25rem auto;padding:1rem}
        .card{background:#fff;padding:1rem;border-radius:12px;box-shadow:0 6px 20px rgba(15,23,42,0.06)}
        label{display:block;margin-top:.75rem}
        input,select,textarea{width:100%;padding:.5rem;border-radius:8px;border:1px solid #e6eef7}
        button{margin-top:1rem;padding:.5rem .75rem;border-radius:8px;background:#2563eb;color:#fff;border:0}
    </style>
</head>
<body>
    <div class="wrap">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
            <h1 style="margin:0">Edit Aspirasi #{{ $asp->id_aspirasi }}</h1>
            <a href="{{ route('admin.aspirasi.feedback') }}">Kembali</a>
        </div>

        <div class="card">
            @if(session('success'))
                <div style="background:#ecfdf5;padding:.5rem;border-radius:6px;color:#065f46">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.aspirasi.update', $asp->id_aspirasi) }}">
                @csrf
                <label>Status</label>
                <select name="status" required>
                    <option value="Menunggu" @if($asp->status=='Menunggu') selected @endif>Menunggu</option>
                    <option value="Proses" @if($asp->status=='Proses') selected @endif>Proses</option>
                    <option value="Selesai" @if($asp->status=='Selesai') selected @endif>Selesai</option>
                </select>

                <label>Umpan Balik</label>
                <textarea name="feedback" rows="4">{{ old('feedback', $asp->feedback) }}</textarea>

                <button type="submit">Simpan</button>
            </form>
        </div>
    </div>
</body>
</html>