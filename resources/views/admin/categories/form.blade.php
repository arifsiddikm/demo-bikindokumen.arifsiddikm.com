@extends('layouts.admin')

@section('title', isset($category) ? 'Edit Kategori' : 'Tambah Kategori')
@section('page_title', isset($category) ? '✏️ Edit Kategori' : '➕ Tambah Kategori')

@section('content')
<div class="admin-page-header">
    <div>
        <h1 class="admin-page-title">{{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h1>
        <p class="admin-page-sub">{{ isset($category) ? 'Ubah data kategori dokumen' : 'Tambah jenis dokumen baru ke sistem' }}</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" style="padding:10px 20px;background:#F3F4F6;color:#374151;border-radius:8px;font-weight:600;font-size:0.875rem;text-decoration:none;">
        ← Kembali
    </a>
</div>

<div class="admin-card" style="max-width:720px;">
    <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
        @csrf
        @if(isset($category)) @method('PUT') @endif

        @if($errors->any())
        <div style="background:#FEE2E2;color:#991B1B;border:1px solid #FECACA;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:0.875rem;">
            ❌ {{ $errors->first() }}
        </div>
        @endif

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
            <div class="form-group" style="grid-column:span 2;">
                <label class="form-label">Nama Kategori <span class="required">*</span></label>
                <input type="text" name="name" class="form-input" placeholder="Contoh: CV Profesional"
                       value="{{ old('name', $category->name ?? '') }}" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Grup / Kelompok <span class="required">*</span></label>
                <input type="text" name="group" class="form-input" list="group-list"
                       placeholder="Karir & Pekerjaan" value="{{ old('group', $category->group ?? '') }}" required>
                <datalist id="group-list">
                    @foreach($groups as $g)<option value="{{ $g }}">@endforeach
                </datalist>
                <div class="form-hint">Tulis grup baru atau pilih yang sudah ada</div>
            </div>

            <div class="form-group">
                <label class="form-label">Icon (Emoji)</label>
                <input type="text" name="icon" class="form-input" placeholder="📄"
                       value="{{ old('icon', $category->icon ?? '') }}" maxlength="4">
                <div class="form-hint">Ketik emoji, contoh: 📄 👤 ✉️</div>
            </div>

            <div class="form-group" style="grid-column:span 2;">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-textarea" rows="3" placeholder="Penjelasan singkat tentang jenis dokumen ini...">{{ old('description', $category->description ?? '') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Warna Tema</label>
                <div style="display:flex;align-items:center;gap:10px;">
                    <input type="color" name="color" class="form-color" value="{{ old('color', $category->color ?? '#DC2626') }}">
                    <span style="font-size:0.8rem;color:#6B7280;">Warna aksen kategori</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Urutan Tampil</label>
                <input type="number" name="sort_order" class="form-input" min="0"
                       value="{{ old('sort_order', $category->sort_order ?? 0) }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Template Tersedia (JSON array)</label>
            <input type="text" name="templates" class="form-input"
                   placeholder='["Template 1", "Template 2"]'
                   value="{{ old('templates', isset($category) ? json_encode($category->templates) : '') }}">
            <div class="form-hint">Format: ["Nama Template 1", "Nama Template 2"]</div>
        </div>

        <div class="form-group">
            <label class="form-label">Fields Form (JSON array)</label>
            <textarea name="fields" class="form-textarea" rows="3"
                      placeholder='["nama_lengkap","email","telepon","alamat"]'>{{ old('fields', isset($category) ? json_encode($category->fields) : '') }}</textarea>
            <div class="form-hint">Format JSON array nama field. Contoh: ["nama_lengkap","email","telepon"]</div>
        </div>

        <div class="form-group">
            <label class="form-check">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                <span class="form-check-label" style="font-weight:600;">Aktifkan Kategori</span>
            </label>
            <div class="form-hint">Kategori aktif akan tampil di halaman buat dokumen</div>
        </div>

        <div style="display:flex;gap:12px;padding-top:8px;">
            <button type="submit" class="btn-admin-primary">
                {{ isset($category) ? '💾 Simpan Perubahan' : '➕ Tambah Kategori' }}
            </button>
            <a href="{{ route('admin.categories.index') }}" style="padding:10px 20px;background:#F3F4F6;color:#374151;border-radius:8px;font-weight:600;font-size:0.875rem;text-decoration:none;">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
