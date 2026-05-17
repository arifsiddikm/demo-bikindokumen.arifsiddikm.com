@extends('layouts.admin')

@section('title', 'Semua Dokumen')
@section('page_title', '📄 Semua Dokumen')

@section('content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">Semua Dokumen</h1>
        <p class="admin-page-sub">Total {{ $documents->total() }} dokumen dari seluruh pengguna</p>
    </div>
    <a href="{{ route('admin.reports.index') }}" class="btn-admin-primary">📊 Lihat Laporan</a>
</div>

<form action="{{ route('admin.documents.index') }}" method="GET" class="admin-toolbar">
    <input type="text" name="search" class="admin-search-input" placeholder="🔍 Cari judul dokumen..." value="{{ request('search') }}">
    <select name="category" class="admin-select">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
    </select>
    <select name="status" class="admin-select">
        <option value="">Semua Status</option>
        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
    </select>
    <button type="submit" class="btn-admin-primary">Filter</button>
    @if(request()->hasAny(['search','category','status']))
        <a href="{{ route('admin.documents.index') }}" style="padding:9px 16px;background:#F3F4F6;color:#374151;border-radius:8px;font-weight:600;font-size:0.875rem;text-decoration:none;">Reset</a>
    @endif
</form>

<div class="admin-card">
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                <tr>
                    <td style="color:#9CA3AF;">{{ $documents->firstItem() + $loop->index }}</td>
                    <td style="font-weight:600;max-width:200px;">{{ Str::limit($doc->title, 35) }}</td>
                    <td>
                        <div style="font-weight:600;font-size:0.85rem;">{{ $doc->user->name ?? '-' }}</div>
                        <div style="color:#9CA3AF;font-size:0.75rem;">{{ $doc->user->email ?? '' }}</div>
                    </td>
                    <td><span class="badge badge-red">{{ $doc->category->name ?? '-' }}</span></td>
                    <td style="color:#6B7280;font-size:0.8rem;">{{ $doc->template_used ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $doc->status === 'completed' ? 'badge-green' : 'badge-yellow' }}">
                            {{ $doc->status === 'completed' ? 'Selesai' : 'Draft' }}
                        </span>
                    </td>
                    <td style="text-align:center;">{{ $doc->download_count }}</td>
                    <td style="font-size:0.8rem;color:#9CA3AF;white-space:nowrap;">{{ $doc->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex;gap:6px;">
                            <a href="{{ route('admin.documents.show', $doc->id) }}" class="btn-admin-sm btn-view">👁️</a>
                            <button type="button" class="btn-admin-sm btn-delete"
                                    onclick="deleteDoc({{ $doc->id }}, '{{ addslashes($doc->title) }}')">🗑️</button>
                            <form id="adel-{{ $doc->id }}" action="{{ route('admin.documents.destroy', $doc->id) }}" method="POST" style="display:none;">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" style="text-align:center;padding:48px;color:#9CA3AF;">Tidak ada dokumen ditemukan</td></tr>
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

@push('scripts')
<script>
function deleteDoc(id, title) {
    Swal.fire({
        title: 'Hapus dokumen?',
        text: '"' + title + '" akan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DC2626',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
    }).then((r) => { if (r.isConfirmed) document.getElementById('adel-' + id).submit(); });
}
</script>
@endpush
