<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — BikinDokumen</title>
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
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(220,38,38,0.08), 0 4px 20px rgba(0,0,0,0.06);
            border: 1px solid #FEE2E2;
        }
        .auth-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
            justify-content: center;
        }
        .auth-logo-icon {
            width: 44px; height: 44px;
            background: #DC2626;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-logo-text { font-weight: 800; font-size: 1.3rem; color: #111827; }
        .auth-logo-text span { color: #DC2626; }
        .auth-title { font-size: 1.4rem; font-weight: 800; color: #111827; margin: 0 0 6px; }
        .auth-sub { color: #6B7280; font-size: 0.9rem; margin: 0 0 28px; }

        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-weight: 600; font-size: 0.875rem; color: #374151; margin-bottom: 6px; }
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
        .form-input.error { border-color: #EF4444; }
        .form-error { font-size: 0.8rem; color: #EF4444; margin-top: 4px; }

        .btn-login {
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
        .btn-login:hover { background: #B91C1C; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(220,38,38,0.35); }

        .auth-divider { text-align: center; position: relative; margin: 20px 0; }
        .auth-divider::before { content: ''; position: absolute; top: 50%; left: 0; right: 0; height: 1px; background: #E5E7EB; }
        .auth-divider span { position: relative; background: white; padding: 0 12px; color: #9CA3AF; font-size: 0.8rem; }

        .btn-autofill {
            width: 100%;
            padding: 10px;
            background: #F3F4F6;
            color: #374151;
            border: 1.5px dashed #D1D5DB;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-autofill:hover { background: #FEE2E2; border-color: #DC2626; color: #DC2626; }

        .auth-footer { text-align: center; margin-top: 24px; font-size: 0.875rem; color: #6B7280; }
        .auth-footer a { color: #DC2626; text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { text-decoration: underline; }

        .form-check { display: flex; align-items: center; gap: 8px; margin-bottom: 0; cursor: pointer; }
        .form-check input { width: 16px; height: 16px; accent-color: #DC2626; cursor: pointer; }
        .form-check-label { font-size: 0.85rem; color: #6B7280; cursor: pointer; }
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

    <h1 class="auth-title">Selamat Datang 👋</h1>
    <p class="auth-sub">Masuk untuk mulai membuat dokumen profesional</p>

    @if($errors->any())
        <div style="background:#FEE2E2;color:#991B1B;border:1px solid #FECACA;padding:12px 14px;border-radius:10px;font-size:0.85rem;margin-bottom:20px;">
            ❌ {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                   placeholder="contoh@email.com" value="{{ old('email') }}" required autocomplete="email">
        </div>
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-input"
                   placeholder="••••••••" required autocomplete="current-password">
        </div>
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
            <label class="form-check">
                <input type="checkbox" name="remember" value="1">
                <span class="form-check-label">Ingat saya</span>
            </label>
        </div>
        <button type="submit" class="btn-login">Masuk →</button>
    </form>

    <div class="auth-divider"><span>atau coba akun demo</span></div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
        <button type="button" class="btn-autofill" onclick="autofillAdmin()" style="font-size:0.8rem;">
            ⚡ Admin Demo
        </button>
        <button type="button" class="btn-autofill" onclick="autofillUser()" style="font-size:0.8rem;">
            👤 User Demo
        </button>
    </div>
    <div style="text-align:center;font-size:0.72rem;color:#9CA3AF;margin-top:6px;">
        Admin: admin@bikindokumen.id · User: demo@bikindokumen.id
    </div>

    <div class="auth-footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar Gratis</a>
    </div>
</div>

<script>
function autofillAdmin() {
    document.getElementById('email').value = 'admin@bikindokumen.id';
    document.getElementById('password').value = 'admin123';
    document.getElementById('email').focus();
}
function autofillUser() {
    document.getElementById('email').value = 'demo@bikindokumen.id';
    document.getElementById('password').value = 'demo123';
    document.getElementById('email').focus();
}
</script>
</body>
</html>
