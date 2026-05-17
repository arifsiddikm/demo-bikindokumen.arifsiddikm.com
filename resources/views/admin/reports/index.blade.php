@extends('layouts.admin')

@section('title', 'Laporan')
@section('page_title', '📊 Laporan & Ekspor')

@section('content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Laporan Aktivitas</h1>
        <p class="admin-page-sub">Filter dan ekspor data dokumen</p>
    </div>
</div>

{{-- FILTER --}}
<form action="{{ route('admin.reports.index') }}" method="GET" class="admin-toolbar" style="background:white;border-radius:12px;padding:18px 20px;border:1px solid #E5E7EB;margin-bottom:20px;">
    <div style="display:flex;align-items:center;gap:8px;flex:1;flex-wrap:wrap;">
        <label style="font-size:0.875rem;font-weight:600;color:#374151;">Dari:</label>
        <input type="date" name="from" value="{{ $from }}" class="admin-search-input" style="flex:none;width:auto;">
        <label style="font-size:0.875rem;font-weight:600;color:#374151;">Sampai:</label>
        <input type="date" name="to" value="{{ $to }}" class="admin-search-input" style="flex:none;width:auto;">
    </div>
    <button type="submit" class="btn-admin-primary">🔍 Filter</button>
    <a href="{{ route('admin.reports.export') }}?from={{ $from }}&to={{ $to }}"
       class="btn-admin-primary" style="background:#059669;">
        ⬇️ Ekspor CSV
    </a>
</form>

{{-- SUMMARY --}}
<div class="stat-cards" style="margin-bottom:24px;">
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#FEE2E2;">📄</div>
        <div>
            <div class="stat-card-value">{{ $summary['total_documents'] }}</div>
            <div class="stat-card-label">Dokumen Dibuat</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#DCFCE7;">⬇️</div>
        <div>
            <div class="stat-card-value">{{ $summary['total_downloads'] }}</div>
            <div class="stat-card-label">Total Unduhan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#DBEAFE;">👥</div>
        <div>
            <div class="stat-card-value">{{ $summary['unique_users'] }}</div>
            <div class="stat-card-label">Pengguna Aktif</div>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-title">📋 Detail Dokumen ({{ $from }} — {{ $to }})</div>
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Pengguna</th>
                    <th>Kategori</th>
                    <th>Template</th>
                    <th>Status</th>
                    <th>Unduhan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                <tr>
                    <td style="color:#9CA3AF;">{{ $documents->firstItem() + $loop->index }}</td>
                    <td style="font-weight:600;max-width:180px;">{{ Str::limit($doc->title, 30) }}</td>
                    <td>
                        <div style="font-size:0.85rem;font-weight:600;">{{ $doc->user->name ?? '-' }}</div>
                        <div style="font-size:0.75rem;color:#9CA3AF;">{{ $doc->user->email ?? '' }}</div>
                    </td>
                    <td><span class="badge badge-red">{{ $doc->category->name ?? '-' }}</span></td>
                    <td style="color:#6B7280;font-size:0.8rem;">{{ $doc->template_used ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $doc->status === 'completed' ? 'badge-green' : 'badge-yellow' }}">
                            {{ $doc->status === 'completed' ? 'Selesai' : 'Draft' }}
                        </span>
                    </td>
                    <td style="text-align:center;">{{ $doc->download_count }}</td>
                    <td style="font-size:0.8rem;color:#9CA3AF;white-space:nowrap;">{{ $doc->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;padding:48px;color:#9CA3AF;">Tidak ada data dalam rentang tanggal ini</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($documents->hasPages())
    <div style="padding:16px 0 0;">
        {{ $documents->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
