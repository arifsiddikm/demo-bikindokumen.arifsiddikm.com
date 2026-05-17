@extends('layouts.app')

@section('title', 'Dashboard')
@section('meta_description', 'Dashboard BikinDokumen — kelola semua dokumen Anda')

@push('styles')
<style>
.dash-hero {
    background: linear-gradient(135deg, #DC2626 0%, #991B1B 100%);
    padding: 36px 0 60px;
    color: white;
}
.dash-hero-inner {
    max-width: 1280px; margin: 0 auto; padding: 0 24px;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;
}
.dash-greeting { font-size: 1.6rem; font-weight: 800; margin: 0 0 6px; }
.dash-sub { opacity: 0.85; font-size: 0.9rem; margin: 0; }

.dash-body { max-width: 1280px; margin: -36px auto 0; padding: 0 24px 60px; position: relative; }

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 32px;
}
@media(max-width:900px){ .stats-grid{ grid-template-columns: repeat(2,1fr); } }
@media(max-width:480px){ .stats-grid{ grid-template-columns: 1fr; } }

.stat-box {
    background: white;
    border-radius: 14px;
    padding: 20px 22px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    border: 1px solid #F3F4F6;
    display: flex; align-items: center; gap: 16px;
}
.stat-box-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; flex-shrink: 0;
}
.stat-box-val { font-size: 1.7rem; font-weight: 800; color: #111827; line-height: 1; }
.stat-box-lbl { font-size: 0.78rem; color: #6B7280; margin-top: 4px; }

.section-title {
    font-size: 1.1rem; font-weight: 800; color: #111827;
    margin: 0 0 16px;
    display: flex; align-items: center; gap: 8px;
}

.doc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px;
    margin-bottom: 32px;
}
.doc-card {
    background: white;
    border-radius: 14px;
    padding: 20px;
    border: 1px solid #F3F4F6;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: all 0.25s;
}
.doc-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); border-color: #FEE2E2; }
.doc-card-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px; }
.doc-cat-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 50px;
    font-size: 0.72rem; font-weight: 600;
    background: #FEE2E2; color: #DC2626;
}
.doc-card-title { font-weight: 700; font-size: 0.9rem; color: #111827; margin: 0 0 6px; }
.doc-card-meta { font-size: 0.78rem; color: #9CA3AF; display: flex; align-items: center; gap: 12px; }
.doc-card-actions { display: flex; gap: 8px; margin-top: 14px; padding-top: 14px; border-top: 1px solid #F3F4F6; }
.doc-card-btn {
    flex: 1;
    padding: 7px 0;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    display: flex; align-items: center; justify-content: center; gap: 4px;
}
.doc-btn-preview { background: #F3F4F6; color: #374151; }
.doc-btn-preview:hover { background: #E5E7EB; }
.doc-btn-download { background: #DC2626; color: white; }
.doc-btn-download:hover { background: #B91C1C; }

.cat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 12px;
    margin-bottom: 32px;
}
.cat-card {
    background: white;
    border-radius: 12px;
    padding: 18px 16px;
    border: 1.5px solid #F3F4F6;
    text-align: center;
    text-decoration: none;
    transition: all 0.25s;
    display: block;
}
.cat-card:hover { border-color: #DC2626; background: #FEF2F2; transform: translateY(-2px); }
.cat-card-icon { font-size: 1.8rem; margin-bottom: 8px; }
.cat-card-name { font-size: 0.8rem; font-weight: 700; color: #374151; }

.empty-state {
    text-align: center;
    padding: 48px 24px;
    color: #9CA3AF;
}
.empty-state-icon { font-size: 3rem; margin-bottom: 12px; }
.empty-state-title { font-size: 1rem; font-weight: 700; color: #374151; margin: 0 0 6px; }
.empty-state-sub { font-size: 0.85rem; margin: 0 0 20px; }
</style>
@endpush

@section('content')
{{-- HERO --}}
<div class="dash-hero">
    <div class="dash-hero-inner">
        <div>
            <h1 class="dash-greeting">Halo, {{ explode(' ', $user->name)[0] }}! 👋</h1>
            <p class="dash-sub">Apa dokumen yang mau kamu buat hari ini?</p>
        </div>
        <a href="{{ route('documents.index') }}"
           style="background:white;color:#DC2626;padding:12px 24px;border-radius:50px;font-weight:700;font-size:0.9rem;text-decoration:none;display:flex;align-items:center;gap:8px;transition:all 0.2s;"
           onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
            ➕ Buat Dokumen Baru
        </a>
    </div>
</div>

<div class="dash-body">
    {{-- STATS --}}
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-box-icon" style="background:#FEE2E2;">📄</div>
            <div>
                <div class="stat-box-val">{{ $stats['total_documents'] }}</div>
                <div class="stat-box-lbl">Total Dokumen</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-box-icon" style="background:#DCFCE7;">⬇️</div>
            <div>
                <div class="stat-box-val">{{ $stats['total_downloads'] }}</div>
                <div class="stat-box-lbl">Total Unduhan</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-box-icon" style="background:#DBEAFE;">🗂️</div>
            <div>
                <div class="stat-box-val">{{ $stats['total_categories'] }}</div>
                <div class="stat-box-lbl">Kategori Dipakai</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-box-icon" style="background:#FEF3C7;">📅</div>
            <div>
                <div class="stat-box-val">{{ $stats['this_month'] }}</div>
                <div class="stat-box-lbl">Bulan Ini</div>
            </div>
        </div>
    </div>

    {{-- RECENT DOCS --}}
    <div class="section-title">📂 Dokumen Terakhir</div>
    @if($recentDocuments->isEmpty())
        <div class="empty-state" style="background:white;border-radius:16px;margin-bottom:32px;border:1px solid #F3F4F6;">
            <div class="empty-state-icon">📄</div>
            <div class="empty-state-title">Belum ada dokumen</div>
            <p class="empty-state-sub">Mulai buat dokumen pertamamu sekarang!</p>
            <a href="{{ route('documents.index') }}" style="background:#DC2626;color:white;padding:10px 24px;border-radius:50px;font-weight:700;font-size:0.875rem;text-decoration:none;display:inline-flex;align-items:center;gap:8px;">
                ➕ Buat Dokumen
            </a>
        </div>
    @else
        <div class="doc-grid">
            @foreach($recentDocuments as $doc)
            <div class="doc-card">
                <div class="doc-card-header">
                    <span class="doc-cat-badge">{{ $doc->category->icon ?? '📄' }} {{ $doc->category->name ?? 'Dokumen' }}</span>
                    <span style="font-size:0.75rem;color:#9CA3AF;">{{ $doc->created_at->diffForHumans() }}</span>
                </div>
                <div class="doc-card-title">{{ $doc->title }}</div>
                <div class="doc-card-meta">
                    <span>📐 {{ $doc->template_used }}</span>
                    <span>⬇️ {{ $doc->download_count }}x</span>
                </div>
                <div class="doc-card-actions">
                    <a href="{{ route('documents.preview', $doc->id) }}" class="doc-card-btn doc-btn-preview">👁️ Preview</a>
                    <a href="{{ route('documents.download', $doc->id) }}" class="doc-card-btn doc-btn-download">⬇️ PDF</a>
                </div>
            </div>
            @endforeach
        </div>
        <div style="text-align:center;margin-bottom:32px;">
            <a href="{{ route('documents.history') }}" style="color:#DC2626;font-weight:600;font-size:0.875rem;text-decoration:none;">
                Lihat semua riwayat →
            </a>
        </div>
    @endif

    {{-- QUICK CATEGORIES --}}
    <div class="section-title">🗂️ Buat Dokumen Baru</div>
    <div class="cat-grid">
        @foreach($categories as $cat)
        <a href="{{ route('documents.create', $cat->slug) }}" class="cat-card">
            <div class="cat-card-icon">{{ $cat->icon ?? '📄' }}</div>
            <div class="cat-card-name">{{ $cat->name }}</div>
        </a>
        @endforeach
        <a href="{{ route('documents.index') }}" class="cat-card" style="border-style:dashed;">
            <div class="cat-card-icon">➕</div>
            <div class="cat-card-name" style="color:#DC2626;">Lihat Semua</div>
        </a>
    </div>
</div>
@endsection
