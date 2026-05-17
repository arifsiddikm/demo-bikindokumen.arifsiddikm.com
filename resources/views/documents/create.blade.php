@extends('layouts.app')

@section('title', 'Buat ' . $category->name)

@push('styles')
<style>
.maker-layout { display:flex; height:calc(100vh - 64px); overflow:hidden; }
.maker-left { width:50%; border-right:1px solid #E5E7EB; display:flex; flex-direction:column; overflow:hidden; background:white; }
.maker-left-header { padding:14px 22px; border-bottom:1px solid #E5E7EB; flex-shrink:0; display:flex; align-items:center; gap:10px; }
.maker-left-header h2 { font-size:0.95rem; font-weight:800; color:#111827; margin:0 0 2px; }
.maker-left-header p  { font-size:0.75rem; color:#6B7280; margin:0; }
.maker-left-body  { flex:1; overflow-y:auto; padding:18px 22px; }
.maker-left-footer { padding:12px 22px; border-top:1px solid #E5E7EB; background:white; flex-shrink:0; display:flex; gap:8px; }
.saved-badge { display:none; align-items:center; gap:4px; background:#DCFCE7; color:#166534; font-size:0.72rem; font-weight:700; padding:3px 9px; border-radius:50px; flex-shrink:0; }

/* TEMPLATE */
.template-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(120px,1fr)); gap:8px; margin-bottom:18px; }
.template-card { border:2px solid #E5E7EB; border-radius:10px; padding:11px 8px; cursor:pointer; transition:all 0.2s; text-align:center; background:white; }
.template-card:hover,.template-card.selected { border-color:#DC2626; background:#FEF2F2; }
.template-icon { font-size:1.4rem; margin-bottom:4px; }
.template-name { font-size:0.7rem; font-weight:700; color:#374151; line-height:1.3; }
.template-check { display:none; width:15px; height:15px; background:#DC2626; border-radius:50%; align-items:center; justify-content:center; margin:3px auto 0; font-size:0.5rem; color:white; }
.template-card.selected .template-check { display:flex; }

/* SECTION TITLE */
.fsect { font-size:0.68rem; font-weight:800; color:#9CA3AF; text-transform:uppercase; letter-spacing:0.8px; margin:18px 0 10px; padding-bottom:7px; border-bottom:1px solid #F3F4F6; }

/* FORM */
.form-group { margin-bottom:12px; }
.form-label { display:block; font-weight:600; font-size:0.78rem; color:#374151; margin-bottom:4px; }
.form-label .req { color:#DC2626; }
.fi,.fs,.ft {
    width:100%; padding:8px 11px; border:1.5px solid #E5E7EB; border-radius:8px;
    font-size:0.83rem; color:#111827; background:white; transition:border-color 0.2s,box-shadow 0.2s;
    outline:none; box-sizing:border-box; font-family:inherit;
}
.fi:focus,.fs:focus,.ft:focus { border-color:#DC2626; box-shadow:0 0 0 3px rgba(220,38,38,0.08); }
.fi::placeholder,.ft::placeholder { color:#D1D5DB; }
.ft { resize:vertical; min-height:76px; }
.fs { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 9px center; padding-right:28px; cursor:pointer; }
.frow { display:grid; grid-template-columns:1fr 1fr; gap:10px; }

/* COLOR */
.color-palette { display:flex; gap:6px; flex-wrap:wrap; align-items:center; }
.color-dot { width:24px; height:24px; border-radius:50%; cursor:pointer; border:2px solid transparent; transition:all 0.2s; }
.color-dot.active,.color-dot:hover { border-color:#374151; transform:scale(1.18); }

/* INVOICE */
.inv-item-header { display:grid; grid-template-columns:1fr 68px 90px 90px 28px; gap:5px; margin-bottom:3px; }
.inv-item-header span { font-size:0.64rem; font-weight:700; color:#9CA3AF; text-transform:uppercase; padding:0 2px; }
.inv-item { display:grid; grid-template-columns:1fr 68px 90px 90px 28px; gap:5px; align-items:center; margin-bottom:5px; }
.inv-item input { padding:7px 9px; border:1.5px solid #E5E7EB; border-radius:7px; font-size:0.8rem; outline:none; transition:border-color 0.2s; font-family:inherit; width:100%; box-sizing:border-box; }
.inv-item input:focus { border-color:#DC2626; }
.btn-add { display:flex; align-items:center; justify-content:center; gap:5px; padding:7px 14px; background:#F3F4F6; color:#374151; border:1.5px dashed #D1D5DB; border-radius:8px; font-size:0.78rem; font-weight:600; cursor:pointer; transition:all 0.2s; font-family:inherit; width:100%; margin-top:3px; }
.btn-add:hover { background:#FEE2E2; border-color:#DC2626; color:#DC2626; }
.btn-del { width:26px; height:26px; background:#FEE2E2; color:#DC2626; border:none; border-radius:6px; cursor:pointer; font-size:0.7rem; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.btn-del:hover { background:#FECACA; }
.inv-totals { background:#F9FAFB; border-radius:8px; padding:10px 12px; margin-top:7px; }
.inv-total-row { display:flex; justify-content:space-between; align-items:center; font-size:0.8rem; padding:2px 0; }
.inv-total-row.grand { font-size:0.9rem; font-weight:800; color:#111827; border-top:1.5px solid #E5E7EB; padding-top:7px; margin-top:3px; }

/* CV blocks */
.cv-block { background:#F9FAFB; border:1px solid #E5E7EB; border-radius:10px; padding:11px 13px; margin-bottom:7px; position:relative; }
.skill-row { display:flex; gap:7px; margin-bottom:5px; align-items:center; }
.skill-row input { flex:1; padding:7px 9px; border:1.5px solid #E5E7EB; border-radius:7px; font-size:0.8rem; outline:none; font-family:inherit; }
.skill-row input:focus { border-color:#DC2626; }
.skill-row select { width:88px; padding:7px 4px; border:1.5px solid #E5E7EB; border-radius:7px; font-size:0.78rem; outline:none; }

/* BUTTONS */
.pbtn { display:inline-flex; align-items:center; gap:5px; padding:7px 13px; border-radius:7px; font-size:0.78rem; font-weight:600; border:none; cursor:pointer; transition:all 0.2s; font-family:inherit; text-decoration:none; }
.pbtn-gray  { background:#F3F4F6; color:#374151; } .pbtn-gray:hover  { background:#E5E7EB; }
.pbtn-red   { background:#DC2626; color:white;  } .pbtn-red:hover   { background:#B91C1C; }
.pbtn-green { background:#059669; color:white;  } .pbtn-green:hover { background:#047857; }

/* RIGHT PANEL */
.maker-right { width:50%; display:flex; flex-direction:column; background:#F0F0F0; overflow:hidden; }
.maker-right-header { padding:12px 18px; background:white; border-bottom:1px solid #E5E7EB; display:flex; align-items:center; justify-content:space-between; flex-shrink:0; }
.maker-right-header h3 { font-size:0.875rem; font-weight:700; color:#374151; margin:0; }
.maker-right-body { flex:1; overflow-y:auto; padding:18px; display:flex; flex-direction:column; align-items:center; }
.preview-paper { background:white; width:100%; max-width:600px; min-height:841px; border-radius:4px; box-shadow:0 4px 24px rgba(0,0,0,0.13); overflow:hidden; }

@media(max-width:900px){
    .maker-layout { flex-direction:column; height:auto; }
    .maker-left,.maker-right { width:100%; }
    .maker-right { min-height:600px; }
    .frow { grid-template-columns:1fr; }
    .inv-item,.inv-item-header { grid-template-columns:1fr 55px 75px 75px 26px; }
}
</style>
@endpush

@section('content')
<div class="maker-layout">

{{-- ===== LEFT ===== --}}
<div class="maker-left">
    <div class="maker-left-header">
        <a href="{{ route('documents.index') }}" style="color:#9CA3AF;text-decoration:none;font-size:1rem;flex-shrink:0;">←</a>
        <div style="flex:1;min-width:0;">
            <h2>{{ $category->icon ?? '📄' }} {{ $category->name }}</h2>
            <p>{{ Str::limit($category->description ?? '', 55) }}</p>
        </div>
        <span class="saved-badge" id="savedBadge">✅ Tersimpan</span>
    </div>

    <div class="maker-left-body">
    <form id="docForm">@csrf

    {{-- JUDUL --}}
    <div class="form-group">
        <label class="form-label">Judul Dokumen <span class="req">*</span></label>
        <input type="text" id="field_title" class="fi"
               placeholder="{{ $category->name }} - Nama Kamu"
               value="{{ ($recentDocs->first()?->title) ?? ($category->name . ' - ' . auth()->user()->name) }}" required>
    </div>

    {{-- TEMPLATE --}}
    @if(!empty($templates))
    <div class="fsect">📐 Template</div>
    <div class="template-grid">
        @foreach($templates as $i => $tpl)
        <div class="template-card {{ $i===0?'selected':'' }}" onclick="selectTpl('{{ addslashes($tpl) }}',this)">
            <div class="template-icon">{{ ['📄','📋','📝','🗒️','📃','🖊️'][$i%6] }}</div>
            <div class="template-name">{{ $tpl }}</div>
            <div class="template-check">✓</div>
        </div>
        @endforeach
    </div>
    <input type="hidden" id="template_used" value="{{ $templates[0] ?? '' }}">
    @endif

    @php
        $isCV      = in_array($category->slug, ['cv-profesional','cv-kreatif','cv-ats']);
        $isInvoice = in_array($category->slug, ['invoice','kwitansi','penawaran-harga']);
    @endphp

    {{-- ======= CV FORM ======= --}}
    @if($isCV)

    <div class="fsect">🎨 Warna Tema</div>
    <div class="color-palette" style="margin-bottom:14px;">
        @foreach(['#DC2626','#2563EB','#059669','#7C3AED','#D97706','#0891B2','#DB2777','#111827','#EA580C','#0D9488'] as $c)
        <div class="color-dot {{ $c==='#DC2626'?'active':'' }}" style="background:{{ $c }};"
             onclick="selectColor('{{ $c }}',this)"></div>
        @endforeach
        <input type="color" value="#DC2626" style="width:24px;height:24px;padding:1px;border:2px solid #E5E7EB;border-radius:50%;cursor:pointer;" oninput="selectColor(this.value)">
    </div>
    <input type="hidden" id="color_theme" value="#DC2626">

    <div class="fsect">👤 Data Diri</div>
    <div class="frow">
        <div class="form-group"><label class="form-label">Nama Lengkap <span class="req">*</span></label><input class="fi" data-key="nama_lengkap" placeholder="John Doe" oninput="dp()"></div>
        <div class="form-group"><label class="form-label">Tagline / Posisi</label><input class="fi" data-key="tagline" placeholder="Software Engineer" oninput="dp()"></div>
    </div>
    <div class="frow">
        <div class="form-group"><label class="form-label">Email</label><input type="email" class="fi" data-key="email" placeholder="kamu@email.com" oninput="dp()"></div>
        <div class="form-group"><label class="form-label">Telepon</label><input type="tel" class="fi" data-key="telepon" placeholder="08xx" oninput="dp()"></div>
    </div>
    <div class="frow">
        <div class="form-group"><label class="form-label">Kota / Lokasi</label><input class="fi" data-key="alamat" placeholder="Jakarta, Indonesia" oninput="dp()"></div>
        <div class="form-group"><label class="form-label">Tanggal Lahir</label><input type="date" class="fi" data-key="tanggal_lahir" oninput="dp()"></div>
    </div>
    <div class="frow">
        <div class="form-group"><label class="form-label">LinkedIn</label><input class="fi" data-key="linkedin" placeholder="linkedin.com/in/nama" oninput="dp()"></div>
        <div class="form-group"><label class="form-label">Portofolio / GitHub</label><input class="fi" data-key="portofolio" placeholder="github.com/nama" oninput="dp()"></div>
    </div>

    <div class="fsect">📝 Ringkasan Profil</div>
    <textarea class="ft" data-key="ringkasan" rows="4" placeholder="Profesional berpengalaman di bidang... dengan keahlian utama..." oninput="dp()"></textarea>

    <div class="fsect">💼 Pengalaman Kerja</div>
    <div id="workList"></div>
    <button type="button" class="btn-add" onclick="addWork()">+ Tambah Pengalaman</button>

    <div class="fsect">🎓 Pendidikan</div>
    <div id="eduList"></div>
    <button type="button" class="btn-add" onclick="addEdu()">+ Tambah Pendidikan</button>

    <div class="fsect">⚡ Keahlian / Skills</div>
    <div id="skillList"></div>
    <button type="button" class="btn-add" onclick="addSkill()">+ Tambah Keahlian</button>

    <div class="fsect">🏆 Sertifikasi & Penghargaan</div>
    <textarea class="ft" data-key="sertifikasi" rows="3" placeholder="AWS Solutions Architect (2023)&#10;Google Analytics Certified" oninput="dp()"></textarea>

    <div class="frow">
        <div>
            <div class="fsect">🌐 Bahasa</div>
            <input class="fi" data-key="bahasa" placeholder="Indonesia (Native), English (Fluent)" oninput="dp()">
        </div>
        @if($category->slug==='cv-kreatif')
        <div>
            <div class="fsect">🎯 Hobi & Minat</div>
            <input class="fi" data-key="hobi" placeholder="Fotografi, Coding, Traveling" oninput="dp()">
        </div>
        @endif
    </div>

    @if($category->slug==='cv-ats')
    <div class="fsect">🤖 Kata Kunci ATS</div>
    <textarea class="ft" data-key="kata_kunci" rows="3" placeholder="project management, agile, scrum, SQL, Python..." oninput="dp()"></textarea>
    <p style="font-size:0.68rem;color:#9CA3AF;margin-top:3px;">Pisah koma. Sesuaikan dengan job description target.</p>
    @endif

    {{-- ======= INVOICE FORM ======= --}}
    @elseif($isInvoice)

    <div class="fsect">🏢 Informasi Bisnis</div>
    <div class="frow">
        <div class="form-group"><label class="form-label">Nama Bisnis</label><input class="fi" data-key="nama_bisnis" placeholder="PT. Nama Bisnis" oninput="dp()"></div>
        <div class="form-group"><label class="form-label">No. Invoice</label><input class="fi" data-key="nomor_invoice" placeholder="INV-001" oninput="dp()"></div>
    </div>
    <div class="form-group"><label class="form-label">Alamat Bisnis</label><input class="fi" data-key="alamat_bisnis" placeholder="Jl. Nama Jalan No.1, Jakarta" oninput="dp()"></div>
    <div class="frow">
        <div class="form-group"><label class="form-label">Email Bisnis</label><input type="email" class="fi" data-key="email_bisnis" placeholder="bisnis@email.com" oninput="dp()"></div>
        <div class="form-group"><label class="form-label">Telepon</label><input class="fi" data-key="telepon_bisnis" placeholder="08xx" oninput="dp()"></div>
    </div>
    <div class="form-group"><label class="form-label">Rekening Bank</label><input class="fi" data-key="rekening_bank" placeholder="BCA 1234567890 a.n. Nama" oninput="dp()"></div>

    <div class="fsect">👤 Informasi Klien</div>
    <div class="frow">
        <div class="form-group"><label class="form-label">Nama Klien</label><input class="fi" data-key="nama_klien" placeholder="Nama / Perusahaan" oninput="dp()"></div>
        <div class="form-group"><label class="form-label">Email Klien</label><input type="email" class="fi" data-key="email_klien" placeholder="klien@email.com" oninput="dp()"></div>
    </div>
    <div class="form-group"><label class="form-label">Alamat Klien</label><input class="fi" data-key="alamat_klien" placeholder="Alamat lengkap klien" oninput="dp()"></div>
    <div class="frow">
        <div class="form-group"><label class="form-label">Tanggal Invoice</label><input type="date" class="fi" data-key="tanggal_invoice" oninput="dp()"></div>
        <div class="form-group"><label class="form-label">Jatuh Tempo</label><input type="date" class="fi" data-key="jatuh_tempo" oninput="dp()"></div>
    </div>

    <div class="fsect">📦 Item / Jasa</div>
    <div class="inv-item-header">
        <span>Deskripsi</span><span>Qty</span><span>Harga (Rp)</span><span>Total (Rp)</span><span></span>
    </div>
    <div id="invList"></div>
    <button type="button" class="btn-add" onclick="addItem()">+ Tambah Item</button>
    <div class="inv-totals">
        <div class="inv-total-row"><span>Subtotal</span><span id="subDisp">Rp 0</span></div>
        <div class="inv-total-row" style="gap:8px;">
            <span>Pajak (%)</span>
            <input type="number" id="taxIn" min="0" max="100" value="0" style="width:55px;padding:4px 7px;border:1.5px solid #E5E7EB;border-radius:6px;font-size:0.78rem;text-align:center;" oninput="recalc()">
        </div>
        <div class="inv-total-row" style="gap:8px;">
            <span>Diskon (Rp)</span>
            <input type="number" id="discIn" min="0" value="0" style="width:95px;padding:4px 7px;border:1.5px solid #E5E7EB;border-radius:6px;font-size:0.78rem;text-align:right;" oninput="recalc()">
        </div>
        <div class="inv-total-row grand"><span>TOTAL</span><span id="totDisp">Rp 0</span></div>
    </div>
    <div class="form-group" style="margin-top:12px;"><label class="form-label">Catatan</label><textarea class="ft" data-key="catatan" rows="2" placeholder="Terima kasih atas kepercayaan Anda..." oninput="dp()"></textarea></div>

    {{-- ======= GENERIC FIELDS ======= --}}
    @else
    @if(!empty($fields))
    <div class="fsect">📝 Informasi Dokumen</div>
    @foreach($fields as $field)
    @php $label=$category->fieldLabels()[$field]??ucwords(str_replace('_',' ',$field)); $type=$category->fieldType($field); $opts=$category->fieldOptions($field); @endphp
    <div class="form-group">
        <label class="form-label">{{ $label }}</label>
        @if($type==='textarea') <textarea class="ft" data-key="{{ $field }}" oninput="dp()" placeholder="{{ $label }}..."></textarea>
        @elseif($type==='select') <select class="fs" data-key="{{ $field }}" onchange="dp()"><option value="">-- Pilih --</option>@foreach($opts as $o)<option>{{ $o }}</option>@endforeach</select>
        @elseif($type==='file') <input type="file" class="fi" accept="image/*" onchange="handleFile(this,'{{ $field }}')"><input type="hidden" id="hf_{{ $field }}" data-key="{{ $field }}">
        @else <input type="{{ $type }}" class="fi" data-key="{{ $field }}" placeholder="{{ $label }}" oninput="dp()">
        @endif
    </div>
    @endforeach
    @endif
    @endif

    </form>
    </div>

    <div class="maker-left-footer">
        <button type="button" class="pbtn pbtn-gray" onclick="loadPreview()" style="flex:1;">🔄 Preview</button>
        <button type="button" class="pbtn pbtn-red" onclick="saveDoc()" id="saveBtn" style="flex:2;">💾 Simpan</button>
        <button type="button" class="pbtn pbtn-green" onclick="downloadDoc()" id="dlBtn" {{ !$recentDocs->first() ? 'disabled' : '' }}>⬇️ PDF</button>
    </div>
</div>

{{-- ===== RIGHT PREVIEW ===== --}}
<div class="maker-right">
    <div class="maker-right-header">
        <h3>👁️ Preview Langsung</h3>
        <div style="display:flex;gap:8px;">
            <button class="pbtn pbtn-gray" onclick="loadPreview()">🔄 Reload</button>
            <button class="pbtn pbtn-green" onclick="downloadDoc()" id="dlBtn2" {{ !$recentDocs->first() ? 'disabled' : '' }}>⬇️ Unduh PDF</button>
        </div>
    </div>
    <div class="maker-right-body">
        <div class="preview-paper">
            <div id="pp-placeholder" style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:500px;color:#D1D5DB;gap:10px;">
                <div style="font-size:3rem;">📄</div>
                <div style="font-weight:700;color:#9CA3AF;">Preview akan muncul di sini</div>
                <div style="font-size:0.75rem;">Isi form lalu klik 🔄 Preview</div>
            </div>
            <iframe id="pp-iframe" style="width:100%;min-height:841px;border:none;display:none;"
                sandbox="allow-same-origin allow-scripts allow-popups"></iframe>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
// ===== STATE =====
let docId    = {!! $recentDocs->first()?->id ?? 'null' !!};
let tpl      = {!! json_encode($templates[0] ?? '') !!};
let color    = '#DC2626';
let ptimer   = null;
let items    = [];   // invoice items
let works    = [];   // cv work exp
let edus     = [];   // cv education
let sklls    = [];   // cv skills
const slug   = {!! json_encode($category->slug) !!};
const isCV   = {!! $isCV ? 'true' : 'false' !!};
const isInv  = {!! $isInvoice ? 'true' : 'false' !!};
const CSRF   = document.querySelector('meta[name="csrf-token"]').content;

// Saved data from server (for editing)
const SAVED = @json($recentDocs->first()?->form_data ?? []);
const SAVED_COLOR = {!! json_encode($recentDocs->first()?->color_theme ?? '#DC2626') !!};
const SAVED_TPL   = {!! json_encode($recentDocs->first()?->template_used ?? ($templates[0] ?? '')) !!};

// ===== INIT =====
window.addEventListener('DOMContentLoaded', () => {
    // Restore color
    color = SAVED_COLOR;
    document.getElementById('color_theme') && (document.getElementById('color_theme').value = color);
    document.querySelectorAll('.color-dot').forEach(d => {
        if (d.getAttribute('onclick')?.includes(color)) d.classList.add('active');
        else d.classList.remove('active');
    });

    // Restore template
    tpl = SAVED_TPL;
    document.getElementById('template_used') && (document.getElementById('template_used').value = tpl);
    document.querySelectorAll('.template-card').forEach(c => {
        c.classList.toggle('selected', c.querySelector('.template-name')?.textContent?.trim() === tpl);
    });

    // Restore plain [data-key] fields
    document.querySelectorAll('[data-key]').forEach(el => {
        const k = el.dataset.key;
        if (SAVED[k] !== undefined && SAVED[k] !== null) el.value = SAVED[k];
    });

    // Restore structured data
    if (isCV) {
        works  = SAVED._workExps   || [];
        edus   = SAVED._educations || [];
        sklls  = SAVED._skills     || [];
        if (!works.length)  works.push({ posisi:'', perusahaan:'', periode:'', deskripsi:'' });
        if (!edus.length)   edus.push({ jenjang:'', jurusan:'', institusi:'', tahun:'' });
        if (!sklls.length)  sklls.push({ nama:'', level:'Menengah' });
        renderWorks(); renderEdus(); renderSkills();
    }
    if (isInv) {
        items = SAVED._invoiceItems || [];
        if (!items.length) items.push({ desc:'', qty:1, price:0 });
        renderItems(); recalc();
        if (SAVED.pajak)  document.getElementById('taxIn').value  = SAVED.pajak;
        if (SAVED.diskon) document.getElementById('discIn').value = SAVED.diskon;
        recalc();
    }

    if (docId) setTimeout(loadPreview, 400);
});

// ===== TEMPLATE =====
function selectTpl(name, el) {
    tpl = name;
    document.getElementById('template_used').value = name;
    document.querySelectorAll('.template-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    loadPreview();
}

// ===== COLOR =====
function selectColor(hex, el) {
    color = hex;
    const ci = document.getElementById('color_theme');
    if (ci) ci.value = hex;
    document.querySelectorAll('.color-dot').forEach(d => d.classList.remove('active'));
    if (el) el.classList.add('active');
    loadPreview();
}

// ===== COLLECT DATA =====
function getData() {
    const d = {};
    document.querySelectorAll('[data-key]').forEach(el => {
        if (el.type === 'file') return;
        d[el.dataset.key] = el.value;
    });
    if (isCV) {
        d._workExps   = works;
        d._educations = edus;
        d._skills     = sklls;
        d.pengalaman_kerja = works.map(w => `${w.posisi}${w.perusahaan?' di '+w.perusahaan:''}${w.periode?' ('+w.periode+')':''}\n${w.deskripsi}`).join('\n\n');
        d.pendidikan       = edus.map(e  => `${e.jenjang} ${e.jurusan} — ${e.institusi}${e.tahun?' ('+e.tahun+')':''}`).join('\n');
        d.keahlian         = sklls.map(s => `${s.nama} (${s.level})`).filter(x=>x.trim()!='()').join(', ');
    }
    if (isInv) {
        d._invoiceItems = items;
        d.item_jasa     = items.map(i=>`${i.desc}|Qty:${i.qty}|@Rp${nf(i.price)}|Total:Rp${nf((i.qty||0)*(i.price||0))}`).join('\n');
        const sub = items.reduce((s,i)=>s+(i.qty||0)*(i.price||0),0);
        const tax = sub*((parseFloat(document.getElementById('taxIn')?.value)||0)/100);
        const dsc = parseFloat(document.getElementById('discIn')?.value)||0;
        d.subtotal = sub; d.pajak = document.getElementById('taxIn')?.value||0;
        d.diskon = document.getElementById('discIn')?.value||0;
        d.total  = sub+tax-dsc;
    }
    return d;
}

// ===== PREVIEW =====
function dp() { clearTimeout(ptimer); ptimer = setTimeout(loadPreview, 700); }

async function loadPreview() {
    const iframe      = document.getElementById('pp-iframe');
    const placeholder = document.getElementById('pp-placeholder');
    try {
        const r = await fetch(`/api/preview/${slug}`, {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
            body: JSON.stringify({ form_data:getData(), template:tpl, color_theme:color })
        });
        if (!r.ok) {
            const errText = await r.text();
            console.error('Preview error', r.status, errText);
            placeholder.style.display = 'flex';
            placeholder.innerHTML = `<div style="font-size:1.8rem;">⚠️</div><div style="color:#EF4444;font-size:0.82rem;text-align:center;">Preview error ${r.status}<br><small>Cek console untuk detail</small></div>`;
            return;
        }
        const html = await r.text();
        // Set srcdoc on a fresh iframe to avoid stale state
        iframe.srcdoc = html;
        iframe.style.display = 'block';
        placeholder.style.display = 'none';
        iframe.onload = () => {
            try {
                const h = iframe.contentDocument?.documentElement?.scrollHeight || 841;
                iframe.style.minHeight = Math.max(841, h) + 'px';
            } catch(e) {}
        };
    } catch(e) {
        console.error('Preview fetch failed:', e);
        placeholder.style.display = 'flex';
        placeholder.innerHTML = `<div style="font-size:1.8rem;">⚠️</div><div style="color:#EF4444;font-size:0.82rem;">Gagal koneksi ke server</div>`;
    }
}

// ===== SAVE =====
async function saveDoc() {
    const title = document.getElementById('field_title').value.trim();
    if (!title) { Swal.fire({title:'Judul wajib diisi!',icon:'warning',confirmButtonColor:'#DC2626'}); return; }
    const btn = document.getElementById('saveBtn');
    btn.innerHTML = '⏳...'; btn.disabled = true;

    try {
        let url = `/buat-dokumen/${slug}`, method = 'POST';
        let body = { title, template_used:tpl, form_data:getData(), color_theme:color };
        if (docId) { url=`/dokumen/${docId}`; method='PUT'; body={ form_data:getData(), color_theme:color, title }; }

        const r = await fetch(url,{ method, headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF}, body:JSON.stringify(body) });
        const j = await r.json();
        if (j.success) {
            if (!docId && j.document_id) docId = j.document_id;
            ['dlBtn','dlBtn2'].forEach(id => { const el=document.getElementById(id); if(el)el.disabled=false; });
            const b = document.getElementById('savedBadge');
            b.style.display='flex'; setTimeout(()=>b.style.display='none',3000);
        }
    } catch(e) {
        Swal.fire({title:'Gagal menyimpan',icon:'error',confirmButtonColor:'#DC2626'});
    } finally { btn.innerHTML='💾 Simpan'; btn.disabled=false; }
}

// ===== DOWNLOAD =====
function downloadDoc() {
    if (!docId) { Swal.fire({title:'Simpan dulu!',text:'Klik Simpan terlebih dahulu.',icon:'info',confirmButtonColor:'#DC2626'}); return; }
    window.open(`/dokumen/${docId}/download`,'_blank');
}

// ===== FILE =====
function handleFile(input, field) {
    const f = input.files[0]; if(!f) return;
    const r = new FileReader();
    r.onload = e => { const h=document.getElementById('hf_'+field); if(h){h.value=e.target.result;h.dataset.key=field;} dp(); };
    r.readAsDataURL(f);
}

// ===== INVOICE =====
function addItem()  { items.push({desc:'',qty:1,price:0}); renderItems(); }
function delItem(i) { items.splice(i,1); renderItems(); recalc(); dp(); }
function renderItems() {
    document.getElementById('invList').innerHTML = items.map((it,i)=>`
        <div class="inv-item">
            <input placeholder="Deskripsi jasa/produk" value="${esc(it.desc)}" oninput="items[${i}].desc=this.value;dp()">
            <input type="number" min="1" value="${it.qty}" oninput="items[${i}].qty=parseFloat(this.value)||0;recalc();dp()">
            <input type="number" min="0" value="${it.price}" oninput="items[${i}].price=parseFloat(this.value)||0;recalc();dp()">
            <input readonly value="Rp ${nf((it.qty||0)*(it.price||0))}" style="background:#F9FAFB;font-weight:600;">
            <button type="button" class="btn-del" onclick="delItem(${i})">✕</button>
        </div>`).join('');
}
function recalc() {
    const sub = items.reduce((s,i)=>s+(i.qty||0)*(i.price||0),0);
    const tax = sub*((parseFloat(document.getElementById('taxIn')?.value)||0)/100);
    const dsc = parseFloat(document.getElementById('discIn')?.value)||0;
    document.getElementById('subDisp').textContent='Rp '+nf(sub);
    document.getElementById('totDisp').textContent='Rp '+nf(sub+tax-dsc);
}

// ===== CV: WORK =====
function addWork()  { works.push({posisi:'',perusahaan:'',periode:'',deskripsi:''}); renderWorks(); }
function delWork(i) { works.splice(i,1); renderWorks(); dp(); }
function renderWorks() {
    const el = document.getElementById('workList'); if(!el) return;
    el.innerHTML = works.map((w,i)=>`
        <div class="cv-block">
            <button type="button" class="btn-del" onclick="delWork(${i})" style="position:absolute;top:10px;right:10px;">✕</button>
            <div class="frow" style="margin-bottom:8px;">
                <div><label class="form-label">Posisi</label><input class="fi" placeholder="Software Engineer" value="${esc(w.posisi)}" oninput="works[${i}].posisi=this.value;dp()"></div>
                <div><label class="form-label">Perusahaan</label><input class="fi" placeholder="PT. Nama" value="${esc(w.perusahaan)}" oninput="works[${i}].perusahaan=this.value;dp()"></div>
            </div>
            <div class="form-group"><label class="form-label">Periode</label><input class="fi" placeholder="Jan 2022 – Des 2023" value="${esc(w.periode)}" oninput="works[${i}].periode=this.value;dp()"></div>
            <div class="form-group" style="margin:0;"><label class="form-label">Deskripsi & Pencapaian</label><textarea class="ft" rows="2" placeholder="- Memimpin tim 5 orang&#10;- Meningkatkan konversi 20%" oninput="works[${i}].deskripsi=this.value;dp()">${esc(w.deskripsi)}</textarea></div>
        </div>`).join('');
}

// ===== CV: EDUCATION =====
function addEdu()  { edus.push({jenjang:'',jurusan:'',institusi:'',tahun:''}); renderEdus(); }
function delEdu(i) { edus.splice(i,1); renderEdus(); dp(); }
function renderEdus() {
    const el = document.getElementById('eduList'); if(!el) return;
    el.innerHTML = edus.map((e,i)=>`
        <div class="cv-block">
            <button type="button" class="btn-del" onclick="delEdu(${i})" style="position:absolute;top:10px;right:10px;">✕</button>
            <div class="frow" style="margin-bottom:8px;">
                <div><label class="form-label">Jenjang</label>
                    <select class="fs" onchange="edus[${i}].jenjang=this.value;dp()">
                        <option value="">Pilih...</option>
                        ${['SD','SMP','SMA/SMK','D3','S1','S2','S3'].map(j=>`<option ${e.jenjang===j?'selected':''}>${j}</option>`).join('')}
                    </select>
                </div>
                <div><label class="form-label">Tahun Lulus</label><input class="fi" placeholder="2020" value="${esc(e.tahun)}" oninput="edus[${i}].tahun=this.value;dp()"></div>
            </div>
            <div class="form-group"><label class="form-label">Institusi / Sekolah</label><input class="fi" placeholder="Universitas Indonesia" value="${esc(e.institusi)}" oninput="edus[${i}].institusi=this.value;dp()"></div>
            <div class="form-group" style="margin:0;"><label class="form-label">Jurusan / Prodi</label><input class="fi" placeholder="Teknik Informatika" value="${esc(e.jurusan)}" oninput="edus[${i}].jurusan=this.value;dp()"></div>
        </div>`).join('');
}

// ===== CV: SKILLS =====
function addSkill()  { sklls.push({nama:'',level:'Menengah'}); renderSkills(); }
function delSkill(i) { sklls.splice(i,1); renderSkills(); dp(); }
function renderSkills() {
    const el = document.getElementById('skillList'); if(!el) return;
    el.innerHTML = sklls.map((s,i)=>`
        <div class="skill-row">
            <input placeholder="React.js, Python, Figma, dll" value="${esc(s.nama)}" oninput="sklls[${i}].nama=this.value;dp()">
            <select onchange="sklls[${i}].level=this.value;dp()">
                ${['Pemula','Menengah','Mahir','Expert'].map(l=>`<option ${s.level===l?'selected':''}>${l}</option>`).join('')}
            </select>
            <button type="button" class="btn-del" onclick="delSkill(${i})">✕</button>
        </div>`).join('');
}

// ===== UTILS =====
function nf(n) { return Number(n||0).toLocaleString('id-ID'); }
function esc(s) { return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
</script>
@endpush
