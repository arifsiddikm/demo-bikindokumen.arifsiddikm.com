@extends('layouts.app')

@section('title', 'Pilih Kategori Dokumen – BikinDokumen')
@section('meta_description', 'Buat berbagai dokumen profesional: CV, Surat Lamaran, Invoice, Kontrak, dan 40+ kategori lainnya dengan mudah dan cepat.')

@section('content')
<div class="categories-hero">
    <div class="container">
        <div class="hero-text">
            <h1>Buat Dokumen <span class="highlight">Profesional</span><br>dalam Hitungan Menit</h1>
            <p>Pilih dari <strong>40+ kategori</strong> dokumen siap pakai. Form mudah, preview langsung, unduh PDF.</p>
            <div class="search-wrapper">
                <span class="search-icon">🔍</span>
                <input type="text" id="searchDoc" placeholder="Cari jenis dokumen... (CV, Invoice, Surat Kuasa, dll)" autocomplete="off">
            </div>
        </div>
    </div>
</div>

<div class="container categories-container">

    {{-- Stats Bar --}}
    <div class="stats-bar">
        <div class="stat-item">
            <span class="stat-num">{{ $stats['total_categories'] }}</span>
            <span class="stat-label">Jenis Dokumen</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">{{ $stats['total_groups'] }}</span>
            <span class="stat-label">Kategori Grup</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">80+</span>
            <span class="stat-label">Template Tersedia</span>
        </div>
        <div class="stat-item">
            <span class="stat-num">{{ number_format($stats['total_documents']) }}</span>
            <span class="stat-label">Dokumen Dibuat</span>
        </div>
    </div>

    {{-- Group Filter Tabs --}}
    <div class="group-tabs" id="groupTabs">
        <button class="group-tab active" data-group="all">🗂️ Semua</button>
        @foreach($categories->groupBy('group') as $group => $items)
            <button class="group-tab" data-group="{{ Str::slug($group) }}">
                {{ $items->first()->icon ?? '📁' }} {{ $group }}
                <span class="tab-count">{{ $items->count() }}</span>
            </button>
        @endforeach
    </div>

    {{-- Categories Grid by Group --}}
    <div id="categoriesGrid">
        @foreach($categories->groupBy('group') as $group => $groupItems)
        <div class="category-group" data-group="{{ Str::slug($group) }}">
            <div class="group-header">
                <h2 class="group-title">
                    <span class="group-icon">{{ $groupItems->first()->icon ?? '📁' }}</span>
                    {{ $group }}
                </h2>
                <span class="group-count">{{ $groupItems->count() }} dokumen</span>
            </div>
            <div class="docs-grid">
                @foreach($groupItems as $cat)
                <a href="{{ route('documents.create', $cat->slug) }}"
                   class="doc-card"
                   data-name="{{ strtolower($cat->name) }}"
                   data-group="{{ Str::slug($group) }}"
                   style="--card-color: {{ $cat->color }}">
                    <div class="card-icon">{{ $cat->icon }}</div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $cat->name }}</h3>
                        <p class="card-desc">{{ $cat->description }}</p>
                        <div class="card-footer">
                            {{-- FIX: templates sudah di-cast array oleh model, tidak perlu json_decode --}}
                            @php $tplCount = is_array($cat->templates) ? count($cat->templates) : 0; @endphp
                            <span class="template-count">{{ $tplCount }} template</span>
                            <span class="card-arrow">→</span>
                        </div>
                    </div>
                    <div class="card-accent" style="background: {{ $cat->color }}"></div>
                </a>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    {{-- Empty state for search --}}
    <div class="empty-search" id="emptySearch" style="display:none">
        <div class="empty-icon">🔍</div>
        <h3>Dokumen tidak ditemukan</h3>
        <p>Coba kata kunci lain atau <a href="{{ route('documents.request') }}">request kategori baru</a></p>
    </div>

</div>

<style>
.categories-hero {
    background: linear-gradient(135deg, #DC2626 0%, #991B1B 60%, #1F2937 100%);
    padding: 60px 0 80px;
    position: relative;
    overflow: hidden;
}
.categories-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
    pointer-events: none;
}
.categories-hero::after {
    content: '';
    position: absolute;
    bottom: -20%;
    left: -5%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.04) 0%, transparent 70%);
    pointer-events: none;
}
.categories-hero .container { position: relative; z-index: 1; }
.hero-text { text-align: center; color: white; }
.hero-text h1 { font-size: 2.4rem; font-weight: 900; line-height: 1.2; margin-bottom: 1rem; }
.hero-text h1 .highlight {
    background: linear-gradient(90deg, #FCD34D, #FBBF24);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hero-text p { font-size: 1.05rem; opacity: 0.9; margin-bottom: 2rem; }
.search-wrapper {
    position: relative;
    max-width: 560px;
    margin: 0 auto;
}
.search-wrapper .search-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.1rem;
    z-index: 1;
}
.search-wrapper input {
    width: 100%;
    padding: 16px 20px 16px 50px;
    border-radius: 50px;
    border: none;
    font-size: 1rem;
    background: white;
    box-shadow: 0 8px 30px rgba(0,0,0,0.25);
    outline: none;
    transition: box-shadow 0.2s;
    box-sizing: border-box;
    color: #111827;
}
.search-wrapper input:focus { box-shadow: 0 8px 40px rgba(0,0,0,0.4); }

.categories-container { padding: 0 20px 80px; margin-top: 30px; }

.stats-bar {
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 40px;
}
.stat-item {
    background: white;
    border-radius: 14px;
    padding: 16px 24px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.09);
    min-width: 120px;
    border: 1px solid #F3F4F6;
}
.stat-num { display: block; font-size: 1.6rem; font-weight: 800; color: #DC2626; }
.stat-label { font-size: 0.78rem; color: #6B7280; font-weight: 500; }

.group-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 40px;
}
.group-tab {
    padding: 8px 16px;
    border-radius: 50px;
    border: 2px solid #E5E7EB;
    background: white;
    font-size: 0.85rem;
    font-weight: 600;
    color: #6B7280;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: inherit;
}
.group-tab:hover { border-color: #DC2626; color: #DC2626; }
.group-tab.active { background: #DC2626; border-color: #DC2626; color: white; }
.tab-count {
    background: rgba(255,255,255,0.25);
    padding: 1px 7px;
    border-radius: 20px;
    font-size: 0.75rem;
}
.group-tab:not(.active) .tab-count { background: #F3F4F6; color: #9CA3AF; }

.category-group { margin-bottom: 50px; }
.group-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #F3F4F6;
}
.group-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0;
}
.group-icon { font-size: 1.4rem; }
.group-count {
    font-size: 0.82rem;
    color: #9CA3AF;
    background: #F3F4F6;
    padding: 4px 12px;
    border-radius: 20px;
}

.docs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 16px;
}

.doc-card {
    background: white;
    border-radius: 16px;
    border: 2px solid #F3F4F6;
    overflow: hidden;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    transition: all 0.25s;
    position: relative;
    cursor: pointer;
}
.doc-card:hover {
    border-color: var(--card-color);
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.12);
}
.doc-card .card-accent {
    height: 4px;
    width: 100%;
    transition: height 0.2s;
}
.doc-card:hover .card-accent { height: 6px; }
.card-icon {
    font-size: 2.2rem;
    padding: 20px 20px 8px;
}
.card-body { padding: 0 20px 16px; flex: 1; display: flex; flex-direction: column; }
.card-title {
    font-size: 0.95rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 6px;
    line-height: 1.3;
}
.card-desc {
    font-size: 0.8rem;
    color: #6B7280;
    line-height: 1.5;
    flex: 1;
    margin: 0 0 12px;
}
.card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
}
.template-count {
    font-size: 0.75rem;
    color: var(--card-color, #DC2626);
    font-weight: 600;
    background: #FEE2E2;
    padding: 3px 10px;
    border-radius: 20px;
}
.card-arrow {
    color: var(--card-color, #DC2626);
    font-weight: 700;
    font-size: 1.1rem;
    transition: transform 0.2s;
}
.doc-card:hover .card-arrow { transform: translateX(4px); }

.empty-search { text-align: center; padding: 80px 20px; }
.empty-icon { font-size: 3rem; margin-bottom: 1rem; }
.empty-search h3 { font-size: 1.3rem; color: #374151; margin-bottom: 0.5rem; }
.empty-search p { color: #9CA3AF; }
.empty-search a { color: #DC2626; font-weight: 600; }

.category-group.hidden { display: none; }
.doc-card.hidden { display: none; }

@media (max-width: 768px) {
    .categories-hero { padding: 40px 0 60px; }
    .hero-text h1 { font-size: 1.7rem; }
    .docs-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 12px; }
    .card-icon { font-size: 1.6rem; padding: 14px 14px 6px; }
    .card-body { padding: 0 14px 12px; }
    .stats-bar { gap: 8px; }
    .stat-item { padding: 12px 16px; min-width: 90px; }
}
</style>

<script>
const searchInput = document.getElementById('searchDoc');
const groupTabs   = document.querySelectorAll('.group-tab');
const allGroups   = document.querySelectorAll('.category-group');
let activeGroup   = 'all';

function filterCards() {
    const q = searchInput.value.toLowerCase().trim();
    let totalVisible = 0;

    allGroups.forEach(group => {
        const groupSlug = group.dataset.group;
        const cards = group.querySelectorAll('.doc-card');
        let groupVisible = 0;

        cards.forEach(card => {
            const matchGroup = activeGroup === 'all' || card.dataset.group === activeGroup;
            const matchSearch = !q || (card.dataset.name || '').includes(q);
            if (matchGroup && matchSearch) {
                card.classList.remove('hidden');
                groupVisible++;
                totalVisible++;
            } else {
                card.classList.add('hidden');
            }
        });

        const hideGroup = groupVisible === 0 || (activeGroup !== 'all' && groupSlug !== activeGroup && !q);
        group.classList.toggle('hidden', groupVisible === 0);
    });

    document.getElementById('emptySearch').style.display = totalVisible === 0 ? 'block' : 'none';
}

searchInput.addEventListener('input', filterCards);

groupTabs.forEach(tab => {
    tab.addEventListener('click', function() {
        groupTabs.forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        activeGroup = this.dataset.group;
        filterCards();
    });
});
</script>
@endsection
