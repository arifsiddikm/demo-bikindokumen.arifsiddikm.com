@extends('layouts.admin')

@section('title', 'Detail Dokumen')
@section('page_title', '📄 Detail Dokumen')

@section('content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">{{ $document->title }}</h1>
        <p class="admin-page-sub">Dokumen oleh {{ $document->user->name ?? '-' }}</p>
    </div>
    <a href="{{ route('admin.documents.index') }}" style="padding:10px 20px;background:#F3F4F6;color:#374151;border-radius:8px;font-weight:600;font-size:0.875rem;text-decoration:none;">← Kembali</a>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:900px;">
    <div class="admin-card">
        <div class="admin-card-title">📋 Info Dokumen</div>
        <table style="width:100%;font-size:0.875rem;">
            <tr><td style="padding:8px 0;color:#6B7280;width:130px;">ID</td><td style="font-weight:600;">#{{ $document->id }}</td></tr>
            <tr><td style="padding:8px 0;color:#6B7280;">Judul</td><td style="font-weight:600;">{{ $document->title }}</td></tr>
            <tr><td style="padding:8px 0;color:#6B7280;">Kategori</td><td><span class="badge badge-red">{{ $document->category->name ?? '-' }}</span></td></tr>
            <tr><td style="padding:8px 0;color:#6B7280;">Template</td><td>{{ $document->template_used ?? '-' }}</td></tr>
            <tr><td style="padding:8px 0;color:#6B7280;">Status</td>
                <td><span class="badge {{ $document->status === 'completed' ? 'badge-green' : 'badge-yellow' }}">{{ $document->status }}</span></td>
            </tr>
            <tr><td style="padding:8px 0;color:#6B7280;">Unduhan</td><td>{{ $document->download_count }}x</td></tr>
            <tr><td style="padding:8px 0;color:#6B7280;">Dibuat</td><td>{{ $document->created_at->format('d M Y H:i') }}</td></tr>
        </table>
    </div>
    <div class="admin-card">
        <div class="admin-card-title">👤 Info Pengguna</div>
        <table style="width:100%;font-size:0.875rem;">
            <tr><td style="padding:8px 0;color:#6B7280;width:80px;">Nama</td><td style="font-weight:600;">{{ $document->user->name ?? '-' }}</td></tr>
            <tr><td style="padding:8px 0;color:#6B7280;">Email</td><td>{{ $document->user->email ?? '-' }}</td></tr>
            <tr><td style="padding:8px 0;color:#6B7280;">Role</td>
                <td>@if($document->user?->is_admin)<span class="badge badge-red">Admin</span>@else<span class="badge badge-gray">User</span>@endif</td>
            </tr>
            <tr><td style="padding:8px 0;color:#6B7280;">Daftar</td><td>{{ $document->user?->created_at?->format('d M Y') ?? '-' }}</td></tr>
        </table>
    </div>
</div>

<div class="admin-card" style="max-width:900px;">
    <div class="admin-card-title">📝 Data Form</div>
    <div style="background:#F9FAFB;border-radius:8px;padding:16px;font-size:0.8rem;color:#374151;font-family:monospace;white-space:pre-wrap;overflow-x:auto;max-height:400px;overflow-y:auto;">{{ json_encode($document->form_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</div>
</div>
@endsection
