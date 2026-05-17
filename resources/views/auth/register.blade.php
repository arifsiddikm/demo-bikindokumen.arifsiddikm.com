<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — BikinDokumen</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #FEF2F2 0%, #FFF 50%, #FEF2F2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 20px 60px rgba(220,38,38,0.08), 0 4px 20px rgba(0,0,0,0.06);
            border: 1px solid #FEE2E2;
        }
        .auth-logo { display: flex; align-items: center; gap: 10px; margin-bottom: 28px; justify-content: center; }
        .auth-logo-icon { width: 44px; height: 44px; background: #DC2626; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .auth-logo-text { font-weight: 800; font-size: 1.3rem; color: #111827; }
        .auth-logo-text span { color: #DC2626; }
        .auth-title { font-size: 1.4rem; font-weight: 800; color: #111827; margin: 0 0 6px; }
        .auth-sub { color: #6B7280; font-size: 0.9rem; margin: 0 0 28px; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-weight: 600; font-size: 0.875rem; color: #374151; margin-bottom: 6px; }
        .form-label .required { color: #DC2626; }
        .form-input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            font-size: 0.9rem;
            color: #111827;
            background: white;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
            box-sizing: border-box;
        }
        .form-input:focus { border-color: #DC2626; box-shadow: 0 0 0 3px rgba(220,38,38,0.08); }
        .form-input.is-invalid { border-color: #EF4444; }
        .form-error { font-size: 0.8rem; color: #EF4444; margin-top: 4px; }
        .btn-register {
            width: 100%;
            padding: 13px;
            background: #DC2626;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
        }
        .btn-register:hover { background: #B91C1C; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(220,38,38,0.35); }
        .auth-footer { text-align: center; margin-top: 24px; font-size: 0.875rem; color: #6B7280; }
        .auth-footer a { color: #DC2626; text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { text-decoration: underline; }
        .benefits { background: #FEF2F2; border-radius: 12px; padding: 16px 18px; margin-bottom: 24px; }
        .benefit-item { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #374151; margin-bottom: 6px; }
        .benefit-item:last-child { margin-bottom: 0; }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-logo">
        <div class="auth-logo-icon">
            <svg width="22" height="22" viewBox="0 0 36 36" fill="none"><rect x="4" y="6" width="18" height="3" rx="1.5" fill="white"/><rect x="4" y="12" width="12" height="3" rx="1.5" fill="white"/><rect x="4" y="18" width="15" height="3" rx="1.5" fill="white"/></svg>
        </div>
        <div class="auth-logo-text">Bikin<span>Dokumen</span></div>
    </div>

    <h1 class="auth-title">Buat Akun Gratis 🚀</h1>
    <p class="auth-sub">Bergabung dan buat dokumen profesional sekarang</p>

    <div class="benefits">
        <div class="benefit-item">✅ 40+ jenis dokumen siap pakai</div>
        <div class="benefit-item">✅ Preview langsung & unduh PDF</div>
        <div class="benefit-item">✅ Gratis selamanya</div>
    </div>

    @if($errors->any())
        <div style="background:#FEE2E2;color:#991B1B;border:1px solid #FECACA;padding:12px 14px;border-radius:10px;font-size:0.85rem;margin-bottom:20px;">
            ❌ {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap <span class="required">*</span></label>
            <input type="text" id="name" name="name"
                   class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                   placeholder="Nama kamu" value="{{ old('name') }}" required autocomplete="name">
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="email">Email <span class="required">*</span></label>
            <input type="email" id="email" name="email"
                   class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                   placeholder="contoh@email.com" value="{{ old('email') }}" required autocomplete="email">
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="password">Password <span class="required">*</span></label>
            <input type="password" id="password" name="password"
                   class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                   placeholder="Minimal 6 karakter" required autocomplete="new-password">
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label" for="password_confirmation">Konfirmasi Password <span class="required">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="form-input"
                   placeholder="Ulangi password" required autocomplete="new-password">
        </div>
        <button type="submit" class="btn-register">Daftar Sekarang →</button>
    </form>

    <div class="auth-footer">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
</div>
</body>
</html>
