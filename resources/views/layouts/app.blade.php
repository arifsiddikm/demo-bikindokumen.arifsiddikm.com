<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'BikinDokumen — Buat CV, Surat Lamaran, Invoice, dan 40+ jenis dokumen profesional online. Preview langsung, unduh PDF gratis.')">
    <meta name="keywords" content="buat cv online, surat lamaran kerja, invoice generator, template dokumen, download pdf">
    <meta property="og:title" content="@yield('title', 'BikinDokumen') — BikinDokumen">
    <meta property="og:description" content="@yield('meta_description', 'Buat dokumen profesional online dengan mudah')">
    <meta property="og:type" content="website">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BikinDokumen') — BikinDokumen</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        :root {
            --red: #DC2626;
            --red-dark: #B91C1C;
            --red-light: #FEE2E2;
            --red-border: #FECACA;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-400: #9CA3AF;
            --gray-600: #4B5563;
            --gray-800: #1F2937;
            --gray-900: #111827;
        }

        /* ===== NAVBAR ===== */
        .navbar {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        }
        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--gray-900);
        }
        .navbar-logo svg { width: 36px; height: 36px; }
        .navbar-logo span { color: var(--red); }
        .navbar-links { display: flex; align-items: center; gap: 8px; }
        .nav-link {
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--gray-600);
            transition: all 0.2s;
        }
        .nav-link:hover { background: var(--gray-100); color: var(--gray-900); }
        .nav-link.active { background: var(--red-light); color: var(--red); }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-primary { background: var(--red); color: white; }
        .btn-primary:hover { background: var(--red-dark); transform: translateY(-1px); box-shadow: 0 4px 15px rgba(220,38,38,0.35); }
        .btn-secondary { background: white; color: var(--red); border: 1.5px solid var(--red-border); }
        .btn-secondary:hover { background: var(--red-light); border-color: var(--red); }
        .btn-gray { background: var(--gray-100); color: var(--gray-800); }
        .btn-gray:hover { background: var(--gray-200); }
        .btn-danger { background: #EF4444; color: white; }
        .btn-danger:hover { background: #DC2626; }
        .btn-sm { padding: 7px 14px; font-size: 0.8rem; }
        .btn-lg { padding: 14px 32px; font-size: 1rem; border-radius: 12px; }
        .btn-rounded { border-radius: 50px !important; }

        /* ===== FORM INPUTS ===== */
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--gray-800);
            margin-bottom: 6px;
        }
        .form-label .required { color: var(--red); margin-left: 2px; }
        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--gray-200);
            border-radius: 8px;
            font-size: 0.9rem;
            color: var(--gray-900);
            background: white;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
            box-sizing: border-box;
        }
        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 3px rgba(220,38,38,0.08);
        }
        .form-input::placeholder,
        .form-textarea::placeholder { color: var(--gray-400); }
        .form-textarea { resize: vertical; min-height: 100px; }
        .form-select { appearance: none; cursor: pointer; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 38px; }
        .form-error { font-size: 0.8rem; color: #EF4444; margin-top: 4px; }
        .form-hint { font-size: 0.8rem; color: var(--gray-400); margin-top: 4px; }

        /* Checkbox & Radio */
        .form-check { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; cursor: pointer; }
        .form-check input[type="checkbox"],
        .form-check input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: var(--red);
            cursor: pointer;
            border-radius: 4px;
        }
        .form-check-label { font-size: 0.9rem; color: var(--gray-800); cursor: pointer; user-select: none; }

        /* File input */
        .form-file {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px dashed var(--gray-200);
            border-radius: 8px;
            font-size: 0.9rem;
            color: var(--gray-600);
            background: var(--gray-50);
            cursor: pointer;
            box-sizing: border-box;
        }
        .form-file:hover { border-color: var(--red); background: var(--red-light); }

        /* Color input */
        input[type="color"].form-color {
            width: 50px;
            height: 40px;
            padding: 2px 4px;
            border: 1.5px solid var(--gray-200);
            border-radius: 8px;
            cursor: pointer;
            background: white;
        }

        /* ===== ALERT / FLASH ===== */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .alert-success { background: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; }
        .alert-error   { background: #FEE2E2; color: #991B1B; border: 1px solid #FECACA; }
        .alert-info    { background: #DBEAFE; color: #1E40AF; border: 1px solid #BFDBFE; }

        /* ===== BADGE ===== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-red    { background: var(--red-light); color: var(--red); }
        .badge-green  { background: #DCFCE7; color: #166534; }
        .badge-blue   { background: #DBEAFE; color: #1E40AF; }
        .badge-gray   { background: var(--gray-100); color: var(--gray-600); }
        .badge-yellow { background: #FEF9C3; color: #854D0E; }

        /* ===== CONTAINER ===== */
        .container { max-width: 1280px; margin: 0 auto; padding: 0 24px; }
        .page-content { padding: 40px 0 80px; }

        /* ===== FOOTER ===== */
        .footer {
            background: var(--gray-900);
            color: var(--gray-400);
            padding: 40px 0 24px;
            margin-top: auto;
        }
        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .footer-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; flex-wrap: wrap; gap: 20px; }
        .footer-logo { color: white; font-weight: 800; font-size: 1.25rem; display: flex; align-items: center; gap: 8px; }
        .footer-logo span { color: var(--red); }
        .footer-links { display: flex; gap: 24px; }
        .footer-links a { color: var(--gray-400); text-decoration: none; font-size: 0.875rem; transition: color 0.2s; }
        .footer-links a:hover { color: white; }
        .footer-bottom { border-top: 1px solid #374151; padding-top: 20px; text-align: center; font-size: 0.8rem; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .navbar-links .nav-link:not(.btn) { display: none; }
            .footer-top { flex-direction: column; }
        }
    </style>
    @stack('styles')
</head>
<body style="background:#F9FAFB; display:flex; flex-direction:column; min-height:100vh;">

{{-- NAVBAR --}}
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ url('/') }}" class="navbar-logo">
            <svg viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="36" height="36" rx="8" fill="#DC2626"/>
                <rect x="8" y="10" width="20" height="3" rx="1.5" fill="white"/>
                <rect x="8" y="16" width="14" height="3" rx="1.5" fill="white"/>
                <rect x="8" y="22" width="17" height="3" rx="1.5" fill="white"/>
                <circle cx="27" cy="25" r="5" fill="white"/>
                <text x="27" y="28.5" text-anchor="middle" fill="#DC2626" font-size="7" font-weight="900">+</text>
            </svg>
            Bikin<span>Dokumen</span>
        </a>
        <div class="navbar-links">
            <a href="{{ url('/buat-dokumen') }}" class="nav-link {{ request()->is('buat-dokumen*') ? 'active' : '' }}">📄 Buat Dokumen</a>
            @auth
                <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
                <a href="{{ url('/riwayat') }}" class="nav-link {{ request()->is('riwayat') ? 'active' : '' }}">📂 Riwayat</a>
                @if(auth()->user()->is_admin)
                    <a href="{{ url('/admin') }}" class="nav-link" style="color:#7C3AED;">⚙️ Admin</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" id="nav-logout-form">
                    @csrf
                    <button type="button" class="btn btn-gray btn-sm" onclick="confirmLogout()">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar Gratis</a>
            @endauth
        </div>
    </div>
</nav>

{{-- FLASH MESSAGES --}}
@if(session('success') || session('error'))
<div class="container" style="padding-top:20px;">
    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif
</div>
@endif

{{-- MAIN CONTENT --}}
<main style="flex:1;">
    @yield('content')
</main>

{{-- FOOTER --}}
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-top">
            <div class="footer-logo">
                <svg width="28" height="28" viewBox="0 0 36 36" fill="none"><rect width="36" height="36" rx="8" fill="#DC2626"/><rect x="8" y="10" width="20" height="3" rx="1.5" fill="white"/><rect x="8" y="16" width="14" height="3" rx="1.5" fill="white"/><rect x="8" y="22" width="17" height="3" rx="1.5" fill="white"/></svg>
                Bikin<span>Dokumen</span>
            </div>
            <div class="footer-links">
                <a href="{{ url('/buat-dokumen') }}">Buat Dokumen</a>
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                    <a href="{{ url('/riwayat') }}">Riwayat</a>
                @else
                    <a href="{{ route('login') }}">Masuk</a>
                    <a href="{{ route('register') }}">Daftar</a>
                @endauth
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} BikinDokumen. Buat dokumen profesional dengan mudah & cepat.
        </div>
    </div>
</footer>

<script>
function confirmLogout() {
    Swal.fire({
        title: 'Keluar dari akun?',
        text: 'Kamu akan logout dari BikinDokumen.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#DC2626',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Keluar',
        cancelButtonText: 'Batal',
        borderRadius: '12px',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('nav-logout-form').submit();
        }
    });
}
</script>
@stack('scripts')
</body>
</html>
