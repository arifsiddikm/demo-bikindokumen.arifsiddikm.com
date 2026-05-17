@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('page_title', '👥 Pengguna')

@section('content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Kelola Pengguna</h1>
        <p class="admin-page-sub">Total {{ $users->total() }} pengguna terdaftar</p>
    </div>
</div>

<form action="{{ route('admin.users.index') }}" method="GET" class="admin-toolbar">
    <input type="text" name="search" class="admin-search-input" placeholder="🔍 Cari nama atau email..." value="{{ request('search') }}">
    <button type="submit" class="btn-admin-primary">Cari</button>
    @if(request('search'))
        <a href="{{ route('admin.users.index') }}" style="padding:9px 16px;background:#F3F4F6;color:#374151;border-radius:8px;font-weight:600;font-size:0.875rem;text-decoration:none;">Reset</a>
    @endif
</form>

<div class="admin-card">
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pengguna</th>
                    <th>Role</th>
                    <th>Dokumen Dibuat</th>
                    <th>Terdaftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td style="color:#9CA3AF;">{{ $users->firstItem() + $loop->index }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:36px;height:36px;background:{{ $user->is_admin ? '#DC2626' : '#EDE9FE' }};border-radius:8px;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:0.875rem;color:{{ $user->is_admin ? 'white' : '#6D28D9' }};flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:700;font-size:0.875rem;">{{ $user->name }}</div>
                                <div style="color:#9CA3AF;font-size:0.78rem;">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($user->is_admin)
                            <span class="badge badge-red">⚙️ Admin</span>
                        @else
                            <span class="badge badge-gray">👤 User</span>
                        @endif
                    </td>
                    <td>
                        <span style="font-weight:700;color:#111827;">{{ $user->documents_count }}</span>
                        <span style="color:#9CA3AF;font-size:0.78rem;"> dokumen</span>
                    </td>
                    <td style="font-size:0.8rem;color:#9CA3AF;">{{ $user->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;padding:48px;color:#9CA3AF;">Tidak ada pengguna ditemukan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div style="padding:16px 0 0;">
        {{ $users->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
