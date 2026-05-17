@extends('layouts.app')

@section('title', 'Preview: ' . $document->title)

@push('styles')
<style>
.preview-page { max-width: 800px; margin: 40px auto; padding: 0 24px 80px; }
.preview-actions-bar {
    display: flex; align-items: center; justify-content: space-between;
    background: white; border-radius: 12px; padding: 14px 20px;
    border: 1px solid #E5E7EB; margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.preview-doc-paper {
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.1);
    padding: 48px 52px;
    min-height: 841px;
}
.doc-color { --doc-color: {{ $document->color_theme ?? '#DC2626' }}; }
.doc-header { border-bottom: 3px solid var(--doc-color); padding-bottom: 20px; margin-bottom: 28px; }
.doc-name { font-size: 1.6rem; font-weight: 900; color: #111827; margin: 0 0 4px; }
.doc-type { background: var(--doc-color); color: white; padding: 3px 12px; border-radius: 4px; display: inline-block; font-size: 0.7rem; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 10px; }
.doc-contact { display: flex; gap: 20px; flex-wrap: wrap; font-size: 0.8rem; color: #6B7280; }
.doc-section { margin-bottom: 22px; }
.doc-section-title { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: var(--doc-color); margin: 0 0 8px; padding-bottom: 4px; border-bottom: 1.5px solid var(--doc-color); }
.doc-section p { font-size: 0.85rem; color: #374151; line-height: 1.7; margin: 0; white-space: pre-line; }
</style>
@endpush

@section('content')
<div class="preview-page">
    <div class="preview-actions-bar">
        <div>
            <div style="font-weight:700;color:#111827;">{{ $document->title }}</div>
            <div style="font-size:0.78rem;color:#9CA3AF;">{{ $category->name ?? '' }} • {{ $document->template_used }}</div>
        </div>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('documents.create', $category->slug) }}" style="padding:8px 16px;background:#F3F4F6;color:#374151;border-radius:8px;font-weight:600;font-size:0.8rem;text-decoration:none;">
                ✏️ Edit Lagi
            </a>
            <a href="{{ route('documents.download', $document->id) }}" target="_blank"
               style="padding:8px 16px;background:#DC2626;color:white;border-radius:8px;font-weight:600;font-size:0.8rem;text-decoration:none;">
                ⬇️ Unduh PDF
            </a>
        </div>
    </div>

    @php $data = $document->form_data ?? []; @endphp
    <div class="preview-doc-paper doc-color">
        <div class="doc-header">
            <div class="doc-type">{{ $document->template_used ?? $category->name }}</div>
            <div class="doc-name">{{ $data['nama_lengkap'] ?? $data['nama'] ?? $data['nama_pelamar'] ?? $document->title }}</div>
            <div class="doc-contact">
                @if(!empty($data['email'])) <span>✉️ {{ $data['email'] }}</span> @endif
                @if(!empty($data['telepon'])) <span>📱 {{ $data['telepon'] }}</span> @endif
                @if(!empty($data['alamat'])) <span>📍 {{ $data['alamat'] }}</span> @endif
                @if(!empty($data['linkedin'])) <span>💼 {{ $data['linkedin'] }}</span> @endif
            </div>
        </div>

        @if(!empty($data['ringkasan']) || !empty($data['ringkasan_profesional']))
        <div class="doc-section">
            <div class="doc-section-title">Profil / Ringkasan</div>
            <p>{{ $data['ringkasan'] ?? $data['ringkasan_profesional'] }}</p>
        </div>
        @endif

        @if(!empty($data['pengalaman_kerja']))
        <div class="doc-section">
            <div class="doc-section-title">Pengalaman Kerja</div>
            <p>{{ $data['pengalaman_kerja'] }}</p>
        </div>
        @endif

        @if(!empty($data['pendidikan']))
        <div class="doc-section">
            <div class="doc-section-title">Pendidikan</div>
            <p>{{ $data['pendidikan'] }}</p>
        </div>
        @endif

        @if(!empty($data['keahlian']) || !empty($data['keahlian_teknis']))
        <div class="doc-section">
            <div class="doc-section-title">Keahlian</div>
            <p>{{ $data['keahlian'] ?? $data['keahlian_teknis'] }}</p>
        </div>
        @endif

        @if(!empty($data['sertifikasi']))
        <div class="doc-section">
            <div class="doc-section-title">Sertifikasi</div>
            <p>{{ $data['sertifikasi'] }}</p>
        </div>
        @endif

        @if(!empty($data['isi_lamaran']))
        <div class="doc-section">
            <div class="doc-section-title">Surat Lamaran</div>
            <p>{{ $data['isi_lamaran'] }}</p>
        </div>
        @endif

        @if(!empty($data['alasan_resign']))
        <div class="doc-section">
            <div class="doc-section-title">Pengunduran Diri</div>
            <p>{{ $data['alasan_resign'] }}</p>
        </div>
        @endif

        @if(!empty($data['item_jasa']))
        <div class="doc-section">
            <div class="doc-section-title">Rincian Invoice</div>
            <p>{{ $data['item_jasa'] }}</p>
        </div>
        @endif

        @foreach($data as $key => $val)
            @if($val && !in_array($key, ['nama_lengkap','nama','nama_pelamar','email','telepon','alamat','linkedin','ringkasan','ringkasan_profesional','pengalaman_kerja','pendidikan','keahlian','keahlian_teknis','sertifikasi','isi_lamaran','alasan_resign','item_jasa','warna_tema']))
            <div class="doc-section">
                <div class="doc-section-title">{{ ucwords(str_replace('_', ' ', $key)) }}</div>
                <p>{{ $val }}</p>
            </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
