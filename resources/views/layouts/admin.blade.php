<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — BikinDokumen Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        :root {
            --sidebar-w: 260px;
            --red: #DC2626;
            --red-dark: #B91C1C;
            --red-light: #FEE2E2;
            --purple: #7C3AED;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-400: #9CA3AF;
            --gray-600: #4B5563;
            --gray-800: #1F2937;
            --gray-900: #111827;
        }

        body { background: var(--gray-50); display: flex; min-height: 100vh; }

        /* ===== SIDEBAR ===== */
        .admin-sidebar {
            width: var(--sidebar-w);
            background: var(--gray-900);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            overflow-y: auto;
            z-index: 200;
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand {
            padding: 20px 20px 16px;
            border-bottom: 1px solid #374151;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .sidebar-brand-logo {
            width: 36px; height: 36px;
            background: var(--red);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .sidebar-brand-text { color: white; font-weight: 800; font-size: 1.05rem; }
        .sidebar-brand-text span { color: #FCA5A5; }
        .sidebar-badge {
            background: var(--purple);
            color: white;
            font-size: 0.6rem;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .sidebar-section-label {
            padding: 16px 20px 6px;
            font-size: 0.7rem;
            font-weight: 700;
            color: #6B7280;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .sidebar-nav { padding: 0 12px; }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            color: #9CA3AF;
            transition: all 0.2s;
            margin-bottom: 2px;
        }
        .sidebar-link:hover { background: #1F2937; color: white; }
        .sidebar-link.active { background: var(--red); color: white; }
        .sidebar-link .icon { font-size: 1rem; width: 20px; text-align: center; }
        .sidebar-link .badge-count {
            margin-left: auto;
            background: rgba(255,255,255,0.15);
            color: white;
            font-size: 0.7rem;
            padding: 2px 7px;
            border-radius: 50px;
        }

        .sidebar-footer {
            padding: 16px 12px;
            margin-top: auto;
            border-top: 1px solid #374151;
        }
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            background: #1F2937;
        }
        .sidebar-user-avatar {
            width: 34px; height: 34px;
            background: var(--red);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }
        .sidebar-user-name { color: white; font-weight: 600; font-size: 0.85rem; }
        .sidebar-user-role { color: #6B7280; font-size: 0.75rem; }

        /* ===== MAIN CONTENT ===== */
        .admin-main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .admin-topbar {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 0 28px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .admin-topbar-title {
            font-weight: 700;
            font-size: 1rem;
            color: var(--gray-900);
        }
        .admin-topbar-actions { display: flex; align-items: center; gap: 12px; }
        .topbar-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.2s;
        }
        .topbar-btn-gray { background: var(--gray-100); color: var(--gray-800); }
        .topbar-btn-gray:hover { background: var(--gray-200); }
        .topbar-btn-red { background: var(--red); color: white; }
        .topbar-btn-red:hover { background: var(--red-dark); }

        .admin-content { padding: 28px; flex: 1; }

        /* ===== PAGE HEADER ===== */
        .admin-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }
        .admin-page-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--gray-900);
            margin: 0;
        }
        .admin-page-sub { color: var(--gray-600); font-size: 0.875rem; margin: 4px 0 0; }

        /* ===== CARDS ===== */
        .admin-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            padding: 24px;
            margin-bottom: 20px;
        }
        .admin-card-title {
            font-weight: 700;
            font-size: 1rem;
            color: var(--gray-900);
            margin: 0 0 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .stat-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .stat-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .stat-card-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
        .stat-card-value { font-size: 1.6rem; font-weight: 800; color: var(--gray-900); line-height: 1; }
        .stat-card-label { color: var(--gray-600); font-size: 0.8rem; margin-top: 4px; }

        /* ===== TABLE ===== */
        .table-wrap { overflow-x: auto; border-radius: 8px; }
        .admin-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        .admin-table th {
            background: var(--gray-50);
            padding: 12px 16px;
            text-align: left;
            font-weight: 700;
            color: var(--gray-600);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--gray-200);
            white-space: nowrap;
        }
        .admin-table td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--gray-100);
            color: var(--gray-800);
            vertical-align: middle;
        }
        .admin-table tr:last-child td { border-bottom: none; }
        .admin-table tr:hover td { background: var(--gray-50); }
        .group-row-header td {
            background: var(--gray-50);
            font-weight: 700;
            color: var(--gray-600);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 16px;
        }

        /* ===== TOOLBAR ===== */
        .admin-toolbar {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .admin-search-input {
            flex: 1;
            min-width: 200px;
            padding: 9px 14px;
            border: 1.5px solid var(--gray-200);
            border-radius: 8px;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.2s;
        }
        .admin-search-input:focus { border-color: var(--red); }
        .admin-select {
            padding: 9px 36px 9px 14px;
            border: 1.5px solid var(--gray-200);
            border-radius: 8px;
            font-size: 0.875rem;
            outline: none;
            background: white;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            appearance: none;
            cursor: pointer;
        }

        /* ===== ACTION BUTTONS ===== */
        .btn-admin-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            background: var(--red);
            color: white;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-admin-primary:hover { background: var(--red-dark); }
        .btn-admin-sm {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.775rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-edit { background: #DBEAFE; color: #1D4ED8; }
        .btn-edit:hover { background: #BFDBFE; }
        .btn-delete { background: #FEE2E2; color: #DC2626; }
        .btn-delete:hover { background: #FECACA; }
        .btn-view { background: var(--gray-100); color: var(--gray-800); }
        .btn-view:hover { background: var(--gray-200); }

        /* ===== BADGE ===== */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 50px; font-size: 0.75rem; font-weight: 600; }
        .badge-green  { background: #DCFCE7; color: #166534; }
        .badge-red    { background: #FEE2E2; color: #DC2626; }
        .badge-blue   { background: #DBEAFE; color: #1E40AF; }
        .badge-gray   { background: var(--gray-100); color: var(--gray-600); }
        .badge-yellow { background: #FEF9C3; color: #854D0E; }
        .badge-purple { background: #EDE9FE; color: #6D28D9; }

        /* ===== GROUP STATS ===== */
        .group-stats { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 24px; }
        .gstat-card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 10px;
            padding: 12px 20px;
            text-align: center;
            min-width: 100px;
        }
        .gstat-num { font-size: 1.4rem; font-weight: 800; color: var(--red); }
        .gstat-label { font-size: 0.75rem; color: var(--gray-600); margin-top: 2px; }

        /* ===== FORMS ===== */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-weight: 600; font-size: 0.875rem; color: var(--gray-800); margin-bottom: 6px; }
        .form-label .required { color: var(--red); }
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--gray-200);
            border-radius: 8px;
            font-size: 0.875rem;
            color: var(--gray-900);
            background: white;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
            box-sizing: border-box;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 3px rgba(220,38,38,0.08);
        }
        .form-textarea { resize: vertical; min-height: 100px; }
        .form-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 38px; cursor: pointer; }
        .form-check { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; cursor: pointer; }
        .form-check input[type="checkbox"], .form-check input[type="radio"] { width: 18px; height: 18px; accent-color: var(--red); cursor: pointer; }
        .form-check-label { font-size: 0.875rem; color: var(--gray-800); cursor: pointer; user-select: none; }
        .form-error { font-size: 0.8rem; color: #EF4444; margin-top: 4px; }
        .form-hint { font-size: 0.8rem; color: var(--gray-400); margin-top: 4px; }

        /* ===== TOGGLE ===== */
        .toggle-switch { position: relative; display: inline-block; width: 42px; height: 24px; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: var(--gray-200); border-radius: 34px; transition: .3s; }
        .toggle-slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background: white; border-radius: 50%; transition: .3s; }
        input:checked + .toggle-slider { background: #22C55E; }
        input:checked + .toggle-slider:before { transform: translateX(18px); }

        /* ===== PAGINATION ===== */
        .pagination { display: flex; align-items: center; gap: 6px; justify-content: center; padding: 20px 0; }
        .pagination .page-link { padding: 7px 12px; border-radius: 8px; text-decoration: none; font-size: 0.8rem; font-weight: 600; color: var(--gray-600); background: white; border: 1px solid var(--gray-200); transition: all 0.2s; }
        .pagination .page-link:hover { background: var(--gray-100); }
        .pagination .page-link.active { background: var(--red); color: white; border-color: var(--red); }

        @media (max-width: 768px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-main { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<aside class="admin-sidebar">
    <a href="{{ url('/admin') }}" class="sidebar-brand">
        <div class="sidebar-brand-logo">
            <svg width="20" height="20" viewBox="0 0 36 36" fill="none"><rect x="4" y="6" width="18" height="3" rx="1.5" fill="white"/><rect x="4" y="12" width="12" height="3" rx="1.5" fill="white"/><rect x="4" y="18" width="15" height="3" rx="1.5" fill="white"/></svg>
        </div>
        <div>
            <div class="sidebar-brand-text">Bikin<span>Dokumen</span></div>
            <div style="margin-top:2px;"><span class="sidebar-badge">ADMIN</span></div>
        </div>
    </a>

    <div style="padding: 8px 0;">
        <div class="sidebar-section-label">Menu Utama</div>
        <div class="sidebar-nav">
            <a href="{{ url('/admin') }}" class="sidebar-link {{ request()->is('admin') ? 'active' : '' }}">
                <span class="icon">📊</span> Dashboard
            </a>
            <a href="{{ route('admin.documents.index') }}" class="sidebar-link {{ request()->is('admin/documents*') ? 'active' : '' }}">
                <span class="icon">📄</span> Semua Dokumen
            </a>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                <span class="icon">🗂️</span> Kategori
            </a>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                <span class="icon">👥</span> Pengguna
            </a>
        </div>

        <div class="sidebar-section-label">Laporan</div>
        <div class="sidebar-nav">
            <a href="{{ route('admin.reports.index') }}" class="sidebar-link {{ request()->is('admin/reports*') ? 'active' : '' }}">
                <span class="icon">📈</span> Laporan & Ekspor
            </a>
        </div>

        <div class="sidebar-section-label">Akun</div>
        <div class="sidebar-nav">
            <a href="{{ url('/') }}" class="sidebar-link">
                <span class="icon">🌐</span> Lihat Website
            </a>
            <form action="{{ route('logout') }}" method="POST" id="admin-logout-form">
                @csrf
                <button type="button" class="sidebar-link" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;" onclick="adminLogout()">
                    <span class="icon">🚪</span> Keluar
                </button>
            </form>
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</div>
            <div>
                <div class="sidebar-user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="sidebar-user-role">Administrator</div>
            </div>
        </div>
    </div>
</aside>

{{-- MAIN --}}
<div class="admin-main">
    <div class="admin-topbar">
        <div class="admin-topbar-title">@yield('page_title', 'Admin Panel')</div>
        <div class="admin-topbar-actions">
            <a href="{{ url('/buat-dokumen') }}" class="topbar-btn topbar-btn-gray" target="_blank">🌐 Lihat Web</a>
        </div>
    </div>

    <div class="admin-content">
        @if(session('success'))
            <div style="background:#DCFCE7;color:#166534;border:1px solid #BBF7D0;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:0.875rem;">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:#FEE2E2;color:#991B1B;border:1px solid #FECACA;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:0.875rem;">
                ❌ {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script>
function adminLogout() {
    Swal.fire({
        title: 'Keluar dari Admin Panel?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#DC2626',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Keluar',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('admin-logout-form').submit();
        }
    });
}

function confirmDelete(formId, itemName) {
    Swal.fire({
        title: 'Hapus ' + (itemName || 'item ini') + '?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DC2626',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            if (formId) {
                document.getElementById(formId).submit();
            }
        }
    });
}
</script>
@stack('scripts')
</body>
</html>
