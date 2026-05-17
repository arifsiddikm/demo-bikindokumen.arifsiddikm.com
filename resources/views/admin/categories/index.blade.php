@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('page_title', '🗂️ Kelola Kategori')

@push('styles')
<style>
.group-badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 3px 10px; border-radius: 20px;
    font-size: 0.72rem; font-weight: 700;
    background: #F3F4F6; color: #374151;
}
.cat-icon { font-size: 1.3rem; line-height: 1; }
.color-dot {
    width: 10px; height: 10px; border-radius: 50%; display: inline-block; flex-shrink: 0;
}
.toggle-btn {
    padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 700;
    border: none; cursor: pointer; transition: all 0.2s;
}
.toggle-btn.active   { background: #DCFCE7; color: #16A34A; }
.toggle-btn.inactive { background: #FEE2E2; color: #DC2626; }

.filter-bar { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; margin-bottom: 20px; }
.filter-select {
    padding: 8px 12px; border: 1.5px solid #E5E7EB; border-radius: 8px;
    font-size: 0.85rem; font-family: inherit; background: white; color: #111827;
    outline: none; cursor: pointer;
}
.filter-select:focus { border-color: #DC2626; }
.search-input {
    padding: 8px 14px; border: 1.5px solid #E5E7EB; border-radius: 8px;
    font-size: 0.85rem; font-family: inherit; outline: none; min-width: 220px;
}
.search-input:focus { border-color: #DC2626; box-shadow: 0 0 0 3px rgba(220,38,38,0.08); }

.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
thead th {
    padding: 12px 14px; text-align: left;
    font-size: 0.75rem; font-weight: 700; color: #6B7280;
    text-transform: uppercase; letter-spacing: 0.5px;
    background: #F9FAFB; border-bottom: 1px solid #E5E7EB;
}
tbody td {
    padding: 12px 14px; border-bottom: 1px solid #F3F4F6;
    font-size: 0.875rem; color: #374151; vertical-align: middle;
}
tbody tr:hover { background: #FAFAFA; }
tbody tr:last-child td { border-bottom: none; }

.btn-sm {
    padding: 5px 10px; border-radius: 6px; font-size: 0.78rem;
    font-weight: 600; border: none; cursor: pointer; text-decoration: none;
    display: inline-flex; align-items: center; gap: 4px; transition: all 0.15s;
}
.btn-edit   { background: #EFF6FF; color: #2563EB; }
.btn-edit:hover { background: #DBEAFE; }
.btn-delete { background: #FEF2F2; color: #DC2626; }
.btn-delete:hover { background: #FEE2E2; }

.summary-pills { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px; }
.summary-pill {
    padding: 6px 14px; border-radius: 20px;
    background: white; border: 1.5px solid #E5E7EB;
    font-size: 0.8rem; font-weight: 600; color: #374151;
    cursor: pointer; transition: all 0.15s;
}
.summary-pill:hover, .summary-pill.active { border-color: #DC2626; color: #DC2626; background: #FEF2F2; }
.summary-pill .pill-count {
    display: inline-flex; align-items: center; justify-content: center;
    width: 20px; height: 20px; border-radius: 50%;
    background: #F3F4F6; font-size: 0.7rem; margin-left: 4px;
}
.summary-pill.active .pill-count { background: #FEE2E2; }
</style>
@endpush

@section('content')

@if(session('success'))
<div style="background:#F0FDF4;color:#166534;border:1px solid #BBF7D0;padding:12px 16px;border-radius:10px;margin-bottom:20px;display:flex;align-items:center;gap:8px;">
    ✅ {{ session('success') }}
</div>
@endif

{{-- SUMMARY PILLS --}}
<div class="summary-pills" id="groupPills">
    <span class="summary-pill active" onclick="filterGroup('all', this)">
        Semua <span class="pill-count">{{ $categories->count() }}</span>
    </span>
    @foreach($groups as $groupName => $count)
    <span class="summary-pill" onclick="filterGroup('{{ $groupName }}', this)">
        {{ $groupName }} <span class="pill-count">{{ $count }}</span>
    </span>
    @endforeach
</div>

{{-- CARD --}}
<div class="admin-card">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
        <h2 style="font-size:1rem;font-weight:700;color:#111827;margin:0;">
            Daftar Kategori Dokumen
            <span style="font-size:0.8rem;font-weight:500;color:#9CA3AF;margin-left:8px;" id="countLabel">
                ({{ $categories->count() }} kategori)
            </span>
        </h2>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary" style="text-decoration:none;">
            + Tambah Kategori
        </a>
    </div>

    {{-- FILTER BAR --}}
    <div class="filter-bar">
        <input type="text" class="search-input" id="searchInput" placeholder="🔍 Cari nama kategori..." oninput="filterTable()">
        <select class="filter-select" id="statusFilter" onchange="filterTable()">
            <option value="">Semua Status</option>
            <option value="active">✅ Aktif</option>
            <option value="inactive">❌ Nonaktif</option>
        </select>
    </div>

    <div class="table-wrap">
        <table id="catTable">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Kategori</th>
                    <th>Grup</th>
                    <th style="text-align:center;">Dokumen</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;">Urutan</th>
                    <th style="text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody id="catBody">
                @forelse($categories as $i => $cat)
                <tr data-group="{{ $cat->group }}" data-name="{{ strtolower($cat->name) }}" data-status="{{ $cat->is_active ? 'active' : 'inactive' }}">
                    <td style="color:#9CA3AF;font-size:0.8rem;">{{ $i + 1 }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:36px;height:36px;border-radius:10px;background:{{ $cat->color ?? '#E5E7EB' }}22;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <span class="cat-icon">{{ $cat->icon ?? '📄' }}</span>
                            </div>
                            <div>
                                <div style="font-weight:600;color:#111827;">{{ $cat->name }}</div>
                                @if($cat->description)
                                <div style="font-size:0.75rem;color:#9CA3AF;margin-top:1px;max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $cat->description }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="group-badge">
                            <span class="color-dot" style="background:{{ $cat->color ?? '#9CA3AF' }};"></span>
                            {{ $cat->group }}
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <a href="{{ route('admin.documents.index') }}?category={{ $cat->id }}"
                           style="font-weight:700;color:{{ $cat->documents_count > 0 ? '#2563EB' : '#9CA3AF' }};text-decoration:none;">
                            {{ $cat->documents_count }}
                        </a>
                    </td>
                    <td style="text-align:center;">
                        <button class="toggle-btn {{ $cat->is_active ? 'active' : 'inactive' }}"
                                onclick="toggleStatus({{ $cat->id }}, this)"
                                id="toggleBtn{{ $cat->id }}">
                            {{ $cat->is_active ? '✅ Aktif' : '❌ Nonaktif' }}
                        </button>
                    </td>
                    <td style="text-align:center;color:#6B7280;">{{ $cat->sort_order }}</td>
                    <td style="text-align:right;">
                        <div style="display:flex;gap:6px;justify-content:flex-end;">
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn-sm btn-edit">
                                ✏️ Edit
                            </a>
                            <button class="btn-sm btn-delete" onclick="deleteCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}')">
                                🗑️ Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:40px;color:#9CA3AF;">
                        <div style="font-size:2rem;margin-bottom:8px;">🗂️</div>
                        Belum ada kategori. <a href="{{ route('admin.categories.create') }}" style="color:#DC2626;">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<form id="deleteForm" method="POST" style="display:none;">
    @csrf @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
let activeGroup = 'all';

function filterGroup(group, el) {
    activeGroup = group;
    document.querySelectorAll('.summary-pill').forEach(p => p.classList.remove('active'));
    el.classList.add('active');
    filterTable();
}

function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const status = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('#catBody tr[data-name]');
    let visible = 0;

    rows.forEach(row => {
        const matchGroup  = activeGroup === 'all' || row.dataset.group === activeGroup;
        const matchSearch = row.dataset.name.includes(search);
        const matchStatus = !status || row.dataset.status === status;

        if (matchGroup && matchSearch && matchStatus) {
            row.style.display = '';
            visible++;
        } else {
            row.style.display = 'none';
        }
    });

    document.getElementById('countLabel').textContent = `(${visible} kategori)`;
}

function toggleStatus(id, btn) {
    fetch(`/admin/categories/${id}/toggle`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const row = btn.closest('tr');
            if (data.is_active) {
                btn.className = 'toggle-btn active';
                btn.textContent = '✅ Aktif';
                row.dataset.status = 'active';
            } else {
                btn.className = 'toggle-btn inactive';
                btn.textContent = '❌ Nonaktif';
                row.dataset.status = 'inactive';
            }
        }
    });
}

function deleteCategory(id, name) {
    Swal.fire({
        title: 'Hapus Kategori?',
        html: `Kategori <strong>${name}</strong> akan dihapus permanen.<br><small style="color:#9CA3AF;">Dokumen terkait tidak akan terhapus.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DC2626',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then(result => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/categories/${id}`;
            form.submit();
        }
    });
}
</script>
@endpush
