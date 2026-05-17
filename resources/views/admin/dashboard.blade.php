@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title', '📊 Dashboard')

@push('styles')
<style>
.chart-wrap { position: relative; height: 220px; }
.quick-actions { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; margin-bottom: 24px; }
.quick-card {
    background: white; border-radius: 12px; padding: 20px;
    border: 1px solid #E5E7EB; text-decoration: none;
    display: flex; flex-direction: column; align-items: center; text-align: center;
    gap: 10px; transition: all 0.2s;
}
.quick-card:hover { border-color: #DC2626; background: #FEF2F2; transform: translateY(-2px); }
.quick-card-icon { font-size: 1.8rem; }
.quick-card-label { font-size: 0.8rem; font-weight: 700; color: #374151; }
.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
@media(max-width:800px){ .two-col{ grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
{{-- STATS --}}
<div class="stat-cards">
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#FEE2E2;">👥</div>
        <div>
            <div class="stat-card-value">{{ number_format($stats['total_users']) }}</div>
            <div class="stat-card-label">Total Pengguna</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#DBEAFE;">📄</div>
        <div>
            <div class="stat-card-value">{{ number_format($stats['total_documents']) }}</div>
            <div class="stat-card-label">Total Dokumen</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#DCFCE7;">⬇️</div>
        <div>
            <div class="stat-card-value">{{ number_format($stats['total_downloads']) }}</div>
            <div class="stat-card-label">Total Unduhan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#FEF3C7;">🗂️</div>
        <div>
            <div class="stat-card-value">{{ $stats['total_categories'] }}</div>
            <div class="stat-card-label">Kategori Aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#EDE9FE;">📅</div>
        <div>
            <div class="stat-card-value">{{ $stats['today_documents'] }}</div>
            <div class="stat-card-label">Dokumen Hari Ini</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon" style="background:#FCE7F3;">📈</div>
        <div>
            <div class="stat-card-value">{{ $stats['this_month'] }}</div>
            <div class="stat-card-label">Dokumen Bulan Ini</div>
        </div>
    </div>
</div>

{{-- QUICK ACTIONS --}}
<div class="admin-card-title" style="margin-bottom:12px;">⚡ Aksi Cepat</div>
<div class="quick-actions" style="margin-bottom:28px;">
    <a href="{{ route('admin.categories.create') }}" class="quick-card">
        <div class="quick-card-icon">➕</div>
        <div class="quick-card-label">Tambah Kategori</div>
    </a>
    <a href="{{ route('admin.documents.index') }}" class="quick-card">
        <div class="quick-card-icon">📄</div>
        <div class="quick-card-label">Semua Dokumen</div>
    </a>
    <a href="{{ route('admin.users.index') }}" class="quick-card">
        <div class="quick-card-icon">👥</div>
        <div class="quick-card-label">Kelola Pengguna</div>
    </a>
    <a href="{{ route('admin.reports.index') }}" class="quick-card">
        <div class="quick-card-icon">📊</div>
        <div class="quick-card-label">Laporan</div>
    </a>
</div>

<div class="two-col">
    {{-- CHART --}}
    <div class="admin-card">
        <div class="admin-card-title">📈 Dokumen 6 Bulan Terakhir</div>
        <div class="chart-wrap">
            <canvas id="monthChart"></canvas>
        </div>
    </div>

    {{-- TOP CATEGORIES --}}
    <div class="admin-card">
        <div class="admin-card-title">🏆 Kategori Terpopuler</div>
        @foreach($categoryStats as $i => $cat)
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
            <div style="width:28px;height:28px;background:{{ $i===0?'#FEE2E2':($i===1?'#DBEAFE':'#F3F4F6') }};border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:800;color:{{ $i===0?'#DC2626':($i===1?'#1D4ED8':'#6B7280') }};">
                {{ $i + 1 }}
            </div>
            <div style="flex:1;min-width:0;">
                <div style="font-size:0.85rem;font-weight:600;color:#111827;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ $cat->icon ?? '📄' }} {{ $cat->name }}
                </div>
                <div style="height:5px;background:#F3F4F6;border-radius:10px;margin-top:4px;">
                    @php $max = $categoryStats->first()->documents_count ?: 1; @endphp
                    <div style="height:5px;background:#DC2626;border-radius:10px;width:{{ round(($cat->documents_count/$max)*100) }}%;"></div>
                </div>
            </div>
            <div style="font-size:0.8rem;font-weight:700;color:#374151;white-space:nowrap;">{{ $cat->documents_count }}</div>
        </div>
        @endforeach
    </div>
</div>

{{-- RECENT DOCUMENTS --}}
<div class="admin-card">
    <div class="admin-card-title" style="display:flex;justify-content:space-between;align-items:center;">
        📄 Dokumen Terbaru
        <a href="{{ route('admin.documents.index') }}" style="font-size:0.8rem;font-weight:600;color:#DC2626;text-decoration:none;">Lihat semua →</a>
    </div>
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Dokumen</th>
                    <th>User</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentDocuments as $doc)
                <tr>
                    <td style="font-weight:600;">{{ Str::limit($doc->title, 40) }}</td>
                    <td style="color:#6B7280;">{{ $doc->user->name ?? '-' }}</td>
                    <td>
                        <span class="badge badge-red">{{ $doc->category->name ?? '-' }}</span>
                    </td>
                    <td>
                        <span class="badge {{ $doc->status === 'completed' ? 'badge-green' : 'badge-yellow' }}">
                            {{ $doc->status === 'completed' ? 'Selesai' : 'Draft' }}
                        </span>
                    </td>
                    <td style="color:#9CA3AF;font-size:0.8rem;">{{ $doc->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('monthChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($chartData, 'label')) !!},
        datasets: [{
            label: 'Dokumen Dibuat',
            data: {!! json_encode(array_column($chartData, 'count')) !!},
            backgroundColor: 'rgba(220, 38, 38, 0.15)',
            borderColor: '#DC2626',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, grid: { color: '#F3F4F6' }, ticks: { font: { size: 11 } } },
            x: { grid: { display: false }, ticks: { font: { size: 11 } } }
        }
    }
});
</script>
@endpush
