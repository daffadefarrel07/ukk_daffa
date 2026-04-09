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
        input[type=text],select,textarea{width:100%;padding:.6rem;border-radius:8px;border:1px solid #e6eef7;margin-top:.4rem;box-sizing:border-box}
        button{margin-top:1rem;padding:.6rem 1rem;border-radius:8px;background:#ef4444;color:#fff;border:0;cursor:pointer}
        .loading{opacity:.7;pointer-events:none}
        .muted{color:#6b7280}
        a.btn-back{display:inline-block;margin-top:1rem;color:#ef4444;text-decoration:none}
        .success{background:#ecfdf5;border:1px solid #10b981;color:#065f46;padding:1rem;border-radius:8px;margin-top:1rem}
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

            <form id="aspirasi-form">
                @csrf
                <label for="nis">NIS <span class="muted">(required)</span></label>
<input id="nis" name="nis" type="text" required value="{{ old('nis', optional($siswa)->nis ?? '') }}" autofocus maxlength="10" placeholder="Max 10 karakter" />

                <label for="kategori_id">Kategori <span class="muted">(required)</span></label>
                <select id="kategori_id" name="kategori_id" required>
                    <option value="">--- Pilih Kategori ---</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama }}
                        </option>
                    @endforeach
                </select>

<label for="lokasi">Lokasi / Judul <span class="muted">(required)</span></label>
                <input id="lokasi" name="lokasi" type="text" required value="{{ old('lokasi') }}" maxlength="255" />

                <label for="foto">Foto (opsional, max 2MB, JPG/PNG/GIF)</label>
                <input id="foto" name="foto" type="file" accept="image/*" />

                <label for="ket">Keterangan</label>
                <textarea id="ket" name="ket" rows="4" maxlength="500">{{ old('ket') }}</textarea>

                <button id="submit-btn" type="submit">📤 Kirim Aspirasi</button>
            </form>

            <a class="btn-back" href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('aspirasi-form');
                    const submitBtn = document.getElementById('submit-btn');
                    const nisInput = document.getElementById('nis');
                    
                    if (nisInput) nisInput.focus();
                    
                    form.addEventListener('submit', async function(e) {
                        e.preventDefault();
                        
                        const formData = new FormData(form);
                        
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'Mengirim...';
                        document.body.classList.add('loading');
                        
                        try {
const response = await fetch('{{ route('siswa.aspirasi.store') }}', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            });
                            
                            const data = await response.json();
                            
                            if (data.success) {
                                const msgDiv = document.createElement('div');
                                msgDiv.className = 'success';
                                msgDiv.innerHTML = '✅ ' + data.message;
                                form.parentNode.insertBefore(msgDiv, form.nextSibling);
                                setTimeout(() => {
                                    window.location.href = data.redirect;
                                }, 1500);
                            } else {
                                alert('❌ Gagal: ' + (data.message || 'Unknown error'));
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('❌ Network error. Coba lagi.');
                        } finally {
                            submitBtn.disabled = false;
                            submitBtn.textContent = '📤 Kirim Aspirasi';
                            document.body.classList.remove('loading');
                        }
                    });
                });
            </script>
        </div>
    </div>
</body>
</html>
