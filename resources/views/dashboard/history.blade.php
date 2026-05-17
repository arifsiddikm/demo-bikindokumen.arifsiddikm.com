@extends('layouts.app')

@section('title', 'Riwayat Dokumen')

@push('styles')
<style>
.page-header {
    background: white; border-bottom: 1px solid #E5E7EB;
    padding: 28px 0;
}
.page-header-inner { max-width: 1280px; margin: 0 auto; padding: 0 24px; }
.page-header h1 { font-size: 1.4rem; font-weight: 800; color: #111827; margin: 0 0 4px; }
.page-header p { color: #6B7280; font-size: 0.875rem; margin: 0; }
.history-body { max-width: 1280px; margin: 0 auto; padding: 32px 24px 60px; }

.filter-bar {
    background: white; border-radius: 12px; padding: 18px 20px;
    border: 1px solid #E5E7EB; margin-bottom: 24px;
    display: flex; gap: 12px; flex-wrap: wrap; align-items: center;
}
.filter-bar input, .filter-bar select {
    padding: 9px 14px;
    border: 1.5px solid #E5E7EB;
    border-radius: 8px;
    font-size: 0.875rem;
    outline: none;
    transition: border-color 0.2s;
    background: white;
}
.filter-bar input:focus, .filter-bar select:focus { border-color: #DC2626; }
.filter-bar input { flex: 1; min-width: 200px; }
.filter-bar select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 10px center; padding-right: 34px; cursor: pointer; }

.doc-table-wrap { background: white; border-radius: 14px; border: 1px solid #E5E7EB; overflow: hidden; }
.doc-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
.doc-table th { background: #F9FAFB; padding: 12px 16px; text-align: left; font-weight: 700; color: #6B7280; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #E5E7EB; }
.doc-table td { padding: 14px 16px; border-bottom: 1px solid #F3F4F6; color: #374151; vertical-align: middle; }
.doc-table tr:last-child td { border-bottom: none; }
.doc-table tr:hover td { background: #FAFAFA; }

.status-badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 50px; font-size: 0.72rem; font-weight: 600; }
.status-draft { background: #FEF9C3; color: #854D0E; }
.status-completed { background: #DCFCE7; color: #166534; }

.action-btn { display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; text-decoration: none; border: none; cursor: pointer; transition: all 0.2s; }
.action-preview { background: #F3F4F6; color: #374151; }
.action-preview:hover { background: #E5E7EB; }
.action-download { background: #FEE2E2; color: #DC2626; }
.action-download:hover { background: #FECACA; }
.action-delete { background: #FEE2E2; color: #DC2626; }
.action-delete:hover { background: #FECACA; }
</style>
@endpush

@section('content')
<div class="page-header">
    <div class="page-header-inner">
        <h1>📂 Riwayat Dokumen</h1>
        <p>Semua dokumen yang pernah kamu buat</p>
    </div>
</div>

<div class="history-body">
    <form action="{{ route('documents.history') }}" method="GET" class="filter-bar">
        <input type="text" name="search" placeholder="🔍 Cari judul dokumen..." value="{{ request('search') }}">
        <select name="category">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->icon }} {{ $cat->name }}
                </option>
            @endforeach
        </select>
        <button type="submit" style="padding:9px 20px;background:#DC2626;color:white;border:none;border-radius:8px;font-weight:600;font-size:0.875rem;cursor:pointer;">
            Filter
        </button>
        @if(request()->hasAny(['search','category']))
            <a href="{{ route('documents.history') }}" style="padding:9px 16px;background:#F3F4F6;color:#374151;border-radius:8px;font-weight:600;font-size:0.875rem;text-decoration:none;">
                Reset
            </a>
        @endif
    </form>

    @if($documents->isEmpty())
        <div style="background:white;border-radius:16px;border:1px solid #E5E7EB;padding:60px 24px;text-align:center;">
            <div style="font-size:3rem;margin-bottom:12px;">📂</div>
            <div style="font-weight:700;color:#374151;margin-bottom:6px;">Belum ada dokumen</div>
            <p style="color:#9CA3AF;font-size:0.875rem;margin-bottom:20px;">Mulai buat dokumen pertamamu!</p>
            <a href="{{ route('documents.index') }}" style="background:#DC2626;color:white;padding:10px 24px;border-radius:50px;font-weight:700;font-size:0.875rem;text-decoration:none;">
                ➕ Buat Dokumen
            </a>
        </div>
    @else
        <div class="doc-table-wrap">
            <div style="overflow-x:auto;">
                <table class="doc-table">
                    <thead>
                        <tr>
                            <th>Dokumen</th>
                            <th>Kategori</th>
                            <th>Template</th>
                            <th>Status</th>
                            <th>Unduhan</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $doc)
                        <tr>
                            <td>
                                <div style="font-weight:700;color:#111827;">{{ $doc->title }}</div>
                            </td>
                            <td>
                                <span style="display:inline-flex;align-items:center;gap:5px;background:#FEE2E2;color:#DC2626;padding:3px 10px;border-radius:50px;font-size:0.72rem;font-weight:600;">
                                    {{ $doc->category->icon ?? '📄' }} {{ $doc->category->name ?? '-' }}
                                </span>
                            </td>
                            <td style="color:#6B7280;">{{ $doc->template_used ?? '-' }}</td>
                            <td>
                                <span class="status-badge {{ $doc->status === 'completed' ? 'status-completed' : 'status-draft' }}">
                                    {{ $doc->status === 'completed' ? '✅ Selesai' : '📝 Draft' }}
                                </span>
                            </td>
                            <td style="text-align:center;">{{ $doc->download_count }}</td>
                            <td style="color:#6B7280;white-space:nowrap;">{{ $doc->created_at->format('d M Y') }}</td>
                            <td>
                                <div style="display:flex;gap:6px;flex-wrap:nowrap;">
                                    <a href="{{ route('documents.preview', $doc->id) }}" class="action-btn action-preview">👁️</a>
                                    <a href="{{ route('documents.download', $doc->id) }}" class="action-btn action-download">⬇️</a>
                                    <button type="button" class="action-btn action-delete"
                                            onclick="deleteDoc({{ $doc->id }}, '{{ addslashes($doc->title) }}')">🗑️</button>
                                    <form id="del-{{ $doc->id }}" action="{{ route('documents.destroy', $doc->id) }}" method="POST" style="display:none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        @if($documents->hasPages())
        <div style="display:flex;justify-content:center;padding:20px 0;">
            {{ $documents->withQueryString()->links() }}
        </div>
        @endif
    @endif
</div>
@endsection

@push('scripts')
<script>
function deleteDoc(id, title) {
    Swal.fire({
        title: 'Hapus dokumen ini?',
        text: '"' + title + '" akan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DC2626',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('del-' + id).submit();
        }
    });
}
</script>
@endpush
