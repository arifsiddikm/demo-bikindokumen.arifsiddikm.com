<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>{{ $document->title }}</title>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@700;900&display=swap');
*{margin:0;padding:0;box-sizing:border-box;}
:root{--c:{{ $document->color_theme ?? ($category->color ?? '#DC2626') }};}
body{font-family:'Plus Jakarta Sans',Arial,sans-serif;font-size:10.5pt;line-height:1.6;color:#1F2937;background:white;}

/* PRINT BAR */
.print-bar{position:fixed;top:0;left:0;right:0;background:#111827;color:white;padding:9px 20px;display:flex;align-items:center;justify-content:space-between;font-family:inherit;z-index:999;}
.print-bar strong{font-size:13px;}
.print-bar small{font-size:10px;color:#9CA3AF;}
.print-btn{background:var(--c);color:white;border:none;padding:8px 20px;border-radius:7px;font-weight:700;font-size:12px;cursor:pointer;font-family:inherit;}
@media print{.print-bar{display:none!important;}body{padding-top:0!important;}}

/* PAGE */
.page{width:210mm;min-height:297mm;margin:0 auto;background:white;position:relative;overflow:hidden;}

/* ======= CV KREATIF ======= */
.cv-creative .cv-sidebar{
    position:absolute;top:0;left:0;bottom:0;width:72mm;
    background:var(--c);color:white;padding:32px 20px;
}
.cv-creative .cv-main{margin-left:72mm;padding:28px 24px 32px;}
.cv-creative .sidebar-name{font-family:'Playfair Display',serif;font-size:20pt;font-weight:900;line-height:1.15;margin-bottom:4px;}
.cv-creative .sidebar-title{font-size:8.5pt;font-weight:600;opacity:0.85;letter-spacing:1px;text-transform:uppercase;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid rgba(255,255,255,0.25);}
.cv-creative .sidebar-sect{font-size:7pt;font-weight:800;text-transform:uppercase;letter-spacing:1.2px;margin:16px 0 8px;opacity:0.7;}
.cv-creative .sidebar-item{font-size:8.5pt;margin-bottom:5px;display:flex;align-items:flex-start;gap:6px;opacity:0.92;}
.cv-creative .sidebar-item .icon{opacity:0.7;flex-shrink:0;font-size:9pt;}
/* Skill bars */
.skill-bar-wrap{margin-bottom:7px;}
.skill-bar-name{font-size:8.5pt;margin-bottom:3px;display:flex;justify-content:space-between;opacity:0.92;}
.skill-bar-track{background:rgba(255,255,255,0.2);border-radius:10px;height:5px;}
.skill-bar-fill{background:rgba(255,255,255,0.9);border-radius:10px;height:5px;}
.cv-creative .main-sect-title{font-size:7.5pt;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:var(--c);border-bottom:2px solid var(--c);padding-bottom:4px;margin:0 0 10px;}
.cv-creative .main-section{margin-bottom:18px;}
.cv-creative .exp-item{margin-bottom:12px;}
.cv-creative .exp-title{font-weight:800;font-size:10pt;color:#111827;}
.cv-creative .exp-sub{font-size:8.5pt;color:var(--c);font-weight:600;margin:1px 0;}
.cv-creative .exp-period{font-size:8pt;color:#9CA3AF;margin-bottom:4px;}
.cv-creative .exp-desc{font-size:8.5pt;color:#4B5563;line-height:1.6;white-space:pre-line;}

/* ======= CV PROFESIONAL & ATS ======= */
.cv-pro .cv-header{padding:28px 32px 20px;border-bottom:3px solid var(--c);}
.cv-pro .cv-name{font-size:22pt;font-weight:900;color:#111827;margin-bottom:3px;line-height:1.1;}
.cv-pro .cv-pos{font-size:10pt;font-weight:600;color:var(--c);margin-bottom:10px;}
.cv-pro .cv-contacts{display:flex;flex-wrap:wrap;gap:14px;font-size:8.5pt;color:#6B7280;}
.cv-pro .cv-contacts span{display:flex;align-items:center;gap:4px;}
.cv-pro .cv-body{padding:20px 32px 28px;}
.cv-pro .cv-two-col{display:flex;gap:24px;}
.cv-pro .cv-col-main{flex:2;}
.cv-pro .cv-col-side{flex:1;border-left:1px solid #F3F4F6;padding-left:18px;}
.cv-pro .sect-title{font-size:7.5pt;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:var(--c);border-bottom:2px solid var(--c);padding-bottom:4px;margin:0 0 10px;}
.cv-pro .section{margin-bottom:18px;}
.cv-pro .exp-item{margin-bottom:11px;}
.cv-pro .exp-title{font-weight:800;font-size:10pt;color:#111827;}
.cv-pro .exp-sub{font-size:8.5pt;color:var(--c);font-weight:600;margin:1px 0;}
.cv-pro .exp-period{font-size:8pt;color:#9CA3AF;margin-bottom:3px;}
.cv-pro .exp-desc{font-size:8.5pt;color:#374151;line-height:1.6;white-space:pre-line;}
/* ATS skill tags */
.skill-tags{display:flex;flex-wrap:wrap;gap:5px;}
.skill-tag{background:var(--c);color:white;font-size:7.5pt;font-weight:600;padding:3px 9px;border-radius:20px;}
.skill-tag.light{background:rgba(0,0,0,0.07);color:#374151;}

/* ======= INVOICE ======= */
.inv-page{padding:28px 32px 32px;}
.inv-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:28px;padding-bottom:20px;border-bottom:3px solid var(--c);}
.inv-brand{font-size:18pt;font-weight:900;color:var(--c);}
.inv-brand-sub{font-size:8.5pt;color:#6B7280;margin-top:4px;}
.inv-badge{background:var(--c);color:white;font-size:8pt;font-weight:800;padding:4px 14px;border-radius:20px;margin-bottom:8px;display:inline-block;letter-spacing:0.5px;}
.inv-num{font-size:10pt;font-weight:700;color:#111827;}
.inv-two{display:flex;gap:20px;margin-bottom:22px;}
.inv-two .inv-block{flex:1;background:#F9FAFB;border-radius:8px;padding:13px 14px;}
.inv-block-title{font-size:7pt;font-weight:800;text-transform:uppercase;letter-spacing:1px;color:var(--c);margin-bottom:7px;}
.inv-block-val{font-size:9pt;color:#374151;line-height:1.65;}
.inv-block-val strong{color:#111827;font-weight:700;}
.inv-table{width:100%;border-collapse:collapse;font-size:9pt;margin-bottom:14px;}
.inv-table th{background:var(--c);color:white;padding:9px 12px;text-align:left;font-size:7.5pt;font-weight:700;letter-spacing:0.5px;}
.inv-table th:last-child,.inv-table td:last-child{text-align:right;}
.inv-table th:nth-child(2),.inv-table td:nth-child(2),.inv-table th:nth-child(3),.inv-table td:nth-child(3){text-align:center;}
.inv-table td{padding:9px 12px;border-bottom:1px solid #E5E7EB;}
.inv-table tr:nth-child(even) td{background:#FAFAFA;}
.inv-total-section{display:flex;justify-content:flex-end;margin-bottom:14px;}
.inv-total-box{min-width:220px;}
.inv-total-row{display:flex;justify-content:space-between;font-size:9pt;padding:3px 0;}
.inv-total-row.grand{font-size:11pt;font-weight:800;border-top:2px solid var(--c);padding-top:7px;margin-top:4px;color:#111827;}
.inv-footer{display:flex;justify-content:space-between;align-items:flex-end;margin-top:28px;padding-top:16px;border-top:1px solid #E5E7EB;}
.inv-note{font-size:8.5pt;color:#6B7280;max-width:220px;line-height:1.5;}
.inv-sig{text-align:center;}
.inv-sig-line{border-top:1.5px solid #374151;padding-top:6px;font-weight:800;font-size:9pt;margin-top:44px;}
.inv-sig-sub{font-size:8pt;color:#6B7280;}

/* ======= SURAT GENERIK ======= */
.surat-page{padding:28px 32px 32px;}
.surat-header{border-bottom:3px solid var(--c);padding-bottom:14px;margin-bottom:20px;}
.surat-type{display:inline-block;background:var(--c);color:white;font-size:7.5pt;font-weight:800;letter-spacing:0.8px;text-transform:uppercase;padding:3px 12px;border-radius:4px;margin-bottom:7px;}
.surat-mainname{font-size:18pt;font-weight:900;color:#111827;margin-bottom:6px;line-height:1.1;}
.surat-contacts{display:flex;flex-wrap:wrap;gap:12px;font-size:8pt;color:#6B7280;}
.surat-body{font-size:10pt;line-height:1.8;color:#374151;}
.surat-sect{font-size:7.5pt;font-weight:800;text-transform:uppercase;letter-spacing:0.8px;color:var(--c);border-bottom:1.5px solid var(--c);padding-bottom:3px;margin:16px 0 8px;}
.surat-kv table{width:100%;font-size:9.5pt;}
.surat-kv td:first-child{color:#6B7280;width:40%;padding:3px 0;vertical-align:top;}
.surat-kv td:last-child{color:#111827;font-weight:600;padding:3px 0;}
.sig-area{margin-top:30px;display:flex;justify-content:flex-end;}
.sig-box{text-align:center;min-width:150px;}
.sig-date{font-size:9pt;color:#6B7280;margin-bottom:42px;}
.sig-name{font-weight:800;font-size:9.5pt;color:#111827;border-top:1.5px solid #374151;padding-top:5px;}
.sig-role{font-size:8pt;color:#6B7280;margin-top:2px;}
</style>
</head>
<body style="{{ isset($isLivePreview) ? '' : 'padding-top:50px;' }}">

@unless(isset($isLivePreview))
<div class="print-bar">
    <div><strong>{{ $document->title }}</strong><br><small>{{ $category->name }} • {{ $document->template_used }}</small></div>
    <button class="print-btn" onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
</div>
@endunless

@php
    $d    = is_array($data) ? $data : ($document->form_data ?? []);
    $col  = $document->color_theme ?? $category->color ?? '#DC2626';
    $slug = $category->slug ?? '';
    $tpl  = $document->template_used ?? '';

    $isCV      = in_array($slug, ['cv-profesional','cv-kreatif','cv-ats']);
    $isInvoice = in_array($slug, ['invoice','kwitansi','penawaran-harga']);
    $isCreative= $slug === 'cv-kreatif';

    if (!function_exists('dv')) { function dv($d, ...$keys) { foreach($keys as $k) { if(!empty($d[$k])) return $d[$k]; } return null; } }

    $mainName = dv($d,'nama_lengkap','nama_pelamar','nama_karyawan','nama_pasien','nama_pengadu','nama_pembayar','nama_penerima','nama','nama_bisnis','nama_mahasiswa','nama_pemohon','nama_penyewa');

    // Parse structured CV data
    $workExps  = $d['_workExps']   ?? [];
    $eduList   = $d['_educations'] ?? [];
    $skillList = $d['_skills']     ?? [];

    // Parse invoice items
    $invItems  = $d['_invoiceItems'] ?? [];
    if (empty($invItems) && !empty($d['item_jasa'])) {
        foreach(explode("\n", $d['item_jasa']) as $line) {
            if(trim($line)) $invItems[] = ['desc'=>trim($line),'qty'=>1,'price'=>0];
        }
    }

    // Skill level → bar width
    $lvlMap = ['Pemula'=>25,'Menengah'=>55,'Mahir'=>80,'Expert'=>95];
@endphp

<div class="page">

{{-- ======= CV KREATIF ======= --}}
@if($isCV && $isCreative)
<div class="cv-creative" style="position:relative;min-height:297mm;">
    {{-- SIDEBAR --}}
    <div class="cv-sidebar">
        <div class="sidebar-name">{{ $mainName ?? 'Nama Lengkap' }}</div>
        <div class="sidebar-title">{{ $d['tagline'] ?? 'Posisi / Jabatan' }}</div>

        <div class="sidebar-sect">Kontak</div>
        @if(!empty($d['email']))  <div class="sidebar-item"><span class="icon">✉</span>{{ $d['email'] }}</div> @endif
        @if(!empty($d['telepon']))<div class="sidebar-item"><span class="icon">📱</span>{{ $d['telepon'] }}</div> @endif
        @if(!empty($d['alamat'])) <div class="sidebar-item"><span class="icon">📍</span>{{ $d['alamat'] }}</div> @endif
        @if(!empty($d['linkedin']))<div class="sidebar-item"><span class="icon">🔗</span>{{ $d['linkedin'] }}</div> @endif
        @if(!empty($d['portofolio']))<div class="sidebar-item"><span class="icon">🌐</span>{{ $d['portofolio'] }}</div> @endif
        @if(!empty($d['tanggal_lahir']))<div class="sidebar-item"><span class="icon">🎂</span>{{ $d['tanggal_lahir'] }}</div> @endif

        @if(!empty($skillList))
        <div class="sidebar-sect">Keahlian</div>
        @foreach($skillList as $s)
        @if(!empty($s['nama']))
        <div class="skill-bar-wrap">
            <div class="skill-bar-name"><span>{{ $s['nama'] }}</span><span style="font-size:7pt;opacity:0.7;">{{ $s['level']??'Menengah' }}</span></div>
            <div class="skill-bar-track"><div class="skill-bar-fill" style="width:{{ $lvlMap[$s['level']??'Menengah']??55 }}%;"></div></div>
        </div>
        @endif
        @endforeach
        @elseif(!empty($d['keahlian']))
        <div class="sidebar-sect">Keahlian</div>
        @foreach(explode(',', $d['keahlian']) as $sk)
        @if(trim($sk))
        <div class="skill-bar-wrap">
            <div class="skill-bar-name"><span>{{ trim($sk) }}</span></div>
            <div class="skill-bar-track"><div class="skill-bar-fill" style="width:75%;"></div></div>
        </div>
        @endif
        @endforeach
        @endif

        @if(!empty($d['bahasa']))
        <div class="sidebar-sect">Bahasa</div>
        <div class="sidebar-item">{{ $d['bahasa'] }}</div>
        @endif

        @if(!empty($d['hobi']))
        <div class="sidebar-sect">Minat & Hobi</div>
        <div class="sidebar-item">{{ $d['hobi'] }}</div>
        @endif

        @if(!empty($d['sertifikasi']))
        <div class="sidebar-sect">Sertifikasi</div>
        <div class="sidebar-item" style="font-size:8pt;">{{ $d['sertifikasi'] }}</div>
        @endif
    </div>

    {{-- MAIN --}}
    <div class="cv-main">
        @if(!empty($d['ringkasan']))
        <div class="main-section">
            <div class="main-sect-title">Profil</div>
            <div style="font-size:9.5pt;color:#374151;line-height:1.7;">{{ $d['ringkasan'] }}</div>
        </div>
        @endif

        @if(!empty($workExps))
        <div class="main-section">
            <div class="main-sect-title">Pengalaman Kerja</div>
            @foreach($workExps as $w)
            @if(!empty($w['posisi']) || !empty($w['perusahaan']))
            <div class="exp-item">
                <div class="exp-title">{{ $w['posisi'] ?? '' }}</div>
                <div class="exp-sub">{{ $w['perusahaan'] ?? '' }}</div>
                <div class="exp-period">{{ $w['periode'] ?? '' }}</div>
                @if(!empty($w['deskripsi']))<div class="exp-desc">{{ $w['deskripsi'] }}</div>@endif
            </div>
            @endif
            @endforeach
        </div>
        @endif

        @if(!empty($eduList))
        <div class="main-section">
            <div class="main-sect-title">Pendidikan</div>
            @foreach($eduList as $e)
            @if(!empty($e['institusi']) || !empty($e['jurusan']))
            <div class="exp-item">
                <div class="exp-title">{{ $e['jenjang']??'' }} {{ $e['jurusan']??'' }}</div>
                <div class="exp-sub">{{ $e['institusi']??'' }}</div>
                <div class="exp-period">{{ $e['tahun']??'' }}</div>
            </div>
            @endif
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- ======= CV PROFESIONAL / ATS ======= --}}
@elseif($isCV)
<div class="cv-pro">
    <div class="cv-header">
        <div class="cv-name">{{ $mainName ?? 'Nama Lengkap' }}</div>
        <div class="cv-pos">{{ $d['tagline'] ?? $d['kata_kunci_posisi'] ?? '' }}</div>
        <div class="cv-contacts">
            @if(!empty($d['email']))     <span>✉ {{ $d['email'] }}</span> @endif
            @if(!empty($d['telepon']))   <span>📱 {{ $d['telepon'] }}</span> @endif
            @if(!empty($d['alamat']))    <span>📍 {{ $d['alamat'] }}</span> @endif
            @if(!empty($d['linkedin'])|| !empty($d['media_sosial'])) <span>🔗 {{ $d['linkedin']??$d['media_sosial'] }}</span> @endif
            @if(!empty($d['portofolio'])) <span>🌐 {{ $d['portofolio'] }}</span> @endif
            @if(!empty($d['tanggal_lahir'])) <span>🎂 {{ $d['tanggal_lahir'] }}</span> @endif
        </div>
    </div>
    <div class="cv-body">
        @if(!empty($d['ringkasan'])||!empty($d['ringkasan_profesional']))
        <div class="section">
            <div class="sect-title">Profil / Ringkasan</div>
            <div style="font-size:9.5pt;color:#374151;line-height:1.7;">{{ $d['ringkasan']??$d['ringkasan_profesional'] }}</div>
        </div>
        @endif

        <div class="cv-two-col">
        <div class="cv-col-main">
            @if(!empty($workExps))
            <div class="section">
                <div class="sect-title">Pengalaman Kerja</div>
                @foreach($workExps as $w)
                @if(!empty($w['posisi'])||!empty($w['perusahaan']))
                <div class="exp-item">
                    <div class="exp-title">{{ $w['posisi']??'' }}</div>
                    <div class="exp-sub">{{ $w['perusahaan']??'' }}</div>
                    <div class="exp-period">{{ $w['periode']??'' }}</div>
                    @if(!empty($w['deskripsi']))<div class="exp-desc">{{ $w['deskripsi'] }}</div>@endif
                </div>
                @endif
                @endforeach
            </div>
            @endif

            @if(!empty($eduList))
            <div class="section">
                <div class="sect-title">Pendidikan</div>
                @foreach($eduList as $e)
                @if(!empty($e['institusi'])||!empty($e['jurusan']))
                <div class="exp-item">
                    <div class="exp-title">{{ $e['jenjang']??'' }} {{ $e['jurusan']??'' }}</div>
                    <div class="exp-sub">{{ $e['institusi']??'' }}</div>
                    <div class="exp-period">{{ $e['tahun']??'' }}</div>
                </div>
                @endif
                @endforeach
            </div>
            @endif
        </div>

        <div class="cv-col-side">
            @if(!empty($skillList))
            <div class="section">
                <div class="sect-title">Keahlian</div>
                @if($slug==='cv-ats')
                <div class="skill-tags">
                    @foreach($skillList as $s)
                        @if(!empty($s['nama']))<span class="skill-tag">{{ $s['nama'] }}</span>@endif
                    @endforeach
                </div>
                @endif
                @if($slug!=='cv-ats')
                @foreach($skillList as $s)
                    @if(!empty($s['nama']))
                    <div style="margin-bottom:7px;">
                        <div style="font-size:8.5pt;font-weight:600;color:#374151;margin-bottom:2px;display:flex;justify-content:space-between;"><span>{{ $s['nama'] }}</span><span style="color:var(--c);font-size:7.5pt;">{{ $s['level']??'Menengah' }}</span></div>
                        <div style="background:#F3F4F6;border-radius:10px;height:5px;"><div style="background:var(--c);border-radius:10px;height:5px;width:{{ $lvlMap[$s['level']??'Menengah']??55 }}%;"></div></div>
                    </div>
                    @endif
                @endforeach
                @endif
            </div>
            @endif

            @if(!empty($d['bahasa']))
            <div class="section">
                <div class="sect-title">Bahasa</div>
                <div style="font-size:9pt;color:#374151;">{{ $d['bahasa'] }}</div>
            </div>
            @endif

            @if(!empty($d['sertifikasi']))
            <div class="section">
                <div class="sect-title">Sertifikasi</div>
                <div style="font-size:9pt;color:#374151;white-space:pre-line;">{{ $d['sertifikasi'] }}</div>
            </div>
            @endif

            @if(!empty($d['kata_kunci']))
            <div class="section">
                <div class="sect-title">Keywords ATS</div>
                <div class="skill-tags">
                    @foreach(explode(',', $d['kata_kunci']) as $kw)
                    @if(trim($kw))<span class="skill-tag light">{{ trim($kw) }}</span>@endif
                    @endforeach
                </div>
            </div>
            @endif

            @if(!empty($d['hobi']))
            <div class="section">
                <div class="sect-title">Minat & Hobi</div>
                <div style="font-size:9pt;color:#374151;">{{ $d['hobi'] }}</div>
            </div>
            @endif
        </div>
        </div>
    </div>
</div>

{{-- ======= INVOICE ======= --}}
@elseif($isInvoice)
<div class="inv-page">
    <div class="inv-header">
        <div>
            <div class="inv-brand">{{ $d['nama_bisnis'] ?? 'Nama Bisnis' }}</div>
            <div class="inv-brand-sub">
                {{ $d['alamat_bisnis'] ?? '' }}<br>
                {{ $d['email_bisnis'] ?? '' }}{{ !empty($d['telepon_bisnis'])||!empty($d['telepon']) ? ' · '.($d['telepon_bisnis']??$d['telepon']) : '' }}
            </div>
        </div>
        <div style="text-align:right;">
            <div class="inv-badge">INVOICE</div>
            <div class="inv-num">#{{ $d['nomor_invoice'] ?? 'INV-001' }}</div>
            @if(!empty($d['tanggal_invoice'])) <div style="font-size:8.5pt;color:#6B7280;margin-top:3px;">Tanggal: {{ $d['tanggal_invoice'] }}</div> @endif
            @if(!empty($d['jatuh_tempo']))      <div style="font-size:8.5pt;color:#DC2626;font-weight:600;">Jatuh Tempo: {{ $d['jatuh_tempo'] }}</div> @endif
        </div>
    </div>

    <div class="inv-two">
        <div class="inv-block">
            <div class="inv-block-title">Dari</div>
            <div class="inv-block-val">
                <strong>{{ $d['nama_bisnis'] ?? '-' }}</strong><br>
                {{ $d['alamat_bisnis'] ?? '' }}<br>
                {{ $d['email_bisnis'] ?? '' }}<br>
                @if(!empty($d['rekening_bank'])) 🏦 {{ $d['rekening_bank'] }} @endif
            </div>
        </div>
        <div class="inv-block">
            <div class="inv-block-title">Kepada</div>
            <div class="inv-block-val">
                <strong>{{ $d['nama_klien'] ?? '-' }}</strong><br>
                {{ $d['alamat_klien'] ?? '' }}<br>
                {{ $d['email_klien'] ?? '' }}
            </div>
        </div>
    </div>

    <table class="inv-table">
        <thead>
            <tr>
                <th>Deskripsi Item / Jasa</th>
                <th>Qty</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($invItems))
                @foreach($invItems as $item)
                @if(!empty($item['desc']))
                <tr>
                    <td>{{ $item['desc'] }}</td>
                    <td style="text-align:center;">{{ $item['qty'] ?? 1 }}</td>
                    <td style="text-align:right;">Rp {{ number_format($item['price']??0,0,',','.') }}</td>
                    <td style="text-align:right;font-weight:600;">Rp {{ number_format(($item['qty']??1)*($item['price']??0),0,',','.') }}</td>
                </tr>
                @endif
                @endforeach
            @else
                <tr><td colspan="4" style="text-align:center;color:#9CA3AF;padding:20px;">Belum ada item</td></tr>
            @endif
        </tbody>
    </table>

    <div class="inv-total-section">
        <div class="inv-total-box">
            @php
                $sub  = collect($invItems)->sum(fn($i)=>($i['qty']??1)*($i['price']??0));
                $tax  = $sub*(($d['pajak']??0)/100);
                $disc = $d['diskon']??0;
                $tot  = $sub+$tax-$disc;
            @endphp
            <div class="inv-total-row"><span>Subtotal</span><span>Rp {{ number_format($sub,0,',','.') }}</span></div>
            @if(!empty($d['pajak']) && $d['pajak']>0)
            <div class="inv-total-row"><span>Pajak ({{ $d['pajak'] }}%)</span><span>Rp {{ number_format($tax,0,',','.') }}</span></div>
            @endif
            @if(!empty($d['diskon']) && $d['diskon']>0)
            <div class="inv-total-row"><span>Diskon</span><span>- Rp {{ number_format($disc,0,',','.') }}</span></div>
            @endif
            <div class="inv-total-row grand"><span>TOTAL</span><span>Rp {{ number_format($tot,0,',','.') }}</span></div>
        </div>
    </div>

    <div class="inv-footer">
        <div class="inv-note">
            @if(!empty($d['catatan']))<strong style="color:#374151;">Catatan:</strong><br>{{ $d['catatan'] }}@endif
            @if(!empty($d['rekening_bank']))<br><br><strong style="color:#374151;">Transfer ke:</strong><br>{{ $d['rekening_bank'] }}@endif
        </div>
        <div class="inv-sig">
            <div class="inv-sig-line">{{ $d['nama_bisnis'] ?? '' }}</div>
            <div class="inv-sig-sub">Hormat Kami</div>
        </div>
    </div>
</div>

{{-- ======= SURAT GENERIK ======= --}}
@else
<div class="surat-page">
    <div class="surat-header">
        <div class="surat-type">{{ $tpl ?: $category->name }}</div>
        <div class="surat-mainname">{{ $mainName ?? $document->title }}</div>
        @php $pos=$d['jabatan']??$d['posisi_dilamar']??''; @endphp
        @if($pos) <div style="font-size:9.5pt;color:#6B7280;font-weight:500;margin-bottom:8px;">{{ $pos }}{{ !empty($d['departemen'])?' — '.$d['departemen']:'' }}{{ !empty($d['perusahaan'])?' | '.$d['perusahaan']:'' }}</div> @endif
        <div class="surat-contacts">
            @if(!empty($d['email']))   <span>✉ {{ $d['email'] }}</span> @endif
            @if(!empty($d['telepon'])||!empty($d['no_hp'])) <span>📱 {{ $d['telepon']??$d['no_hp'] }}</span> @endif
            @if(!empty($d['alamat']))  <span>📍 {{ Str::limit($d['alamat'],50) }}</span> @endif
            @if(!empty($d['kota']) && empty($d['alamat'])) <span>📍 {{ $d['kota'] }}</span> @endif
        </div>
    </div>

    <div class="surat-body">
        {{-- Kota & tanggal --}}
        @if(!empty($d['kota'])||!empty($d['tanggal_surat'])||!empty($d['tanggal']))
        <div style="text-align:right;margin-bottom:16px;font-size:9.5pt;color:#6B7280;">
            {{ $d['kota']??'' }}{{ !empty($d['kota'])&&(!empty($d['tanggal_surat'])||!empty($d['tanggal']))?', ':'' }}{{ $d['tanggal_surat']??$d['tanggal']??'' }}
        </div>
        @endif

        {{-- Kepada --}}
        @if(!empty($d['kepada'])||!empty($d['nama_atasan'])||!empty($d['nama_perusahaan']))
        <div style="margin-bottom:16px;">
            <div style="font-size:9.5pt;color:#6B7280;">Kepada Yth.</div>
            <div style="font-weight:700;">{{ $d['kepada']??$d['nama_atasan']??$d['nama_hr']??'' }}</div>
            @if(!empty($d['jabatan_hr'])||!empty($d['jabatan_penerima'])) <div style="color:#6B7280;font-size:9pt;">{{ $d['jabatan_hr']??$d['jabatan_penerima'] }}</div> @endif
            @if(!empty($d['nama_perusahaan'])) <div>{{ $d['nama_perusahaan'] }}</div> @endif
            @if(!empty($d['alamat_perusahaan'])||!empty($d['alamat_klien'])) <div style="color:#6B7280;font-size:9pt;">{{ $d['alamat_perusahaan']??$d['alamat_klien'] }}</div> @endif
        </div>
        @endif

        {{-- Perihal --}}
        @if(!empty($d['perihal'])||!empty($d['posisi_dilamar']))
        <div style="display:flex;gap:10px;margin-bottom:14px;font-size:9.5pt;">
            <span style="color:#6B7280;width:70px;flex-shrink:0;">Perihal</span>
            <span style="font-weight:700;">: {{ $d['perihal']??(!empty($d['posisi_dilamar'])?'Lamaran Pekerjaan — '.$d['posisi_dilamar']:'') }}</span>
        </div>
        <hr style="border:none;border-top:1px solid #E5E7EB;margin-bottom:14px;">
        @endif

        {{-- Isi utama --}}
        @php $isi = $d['isi_lamaran']??$d['isi_surat']??$d['alasan_resign']??$d['kronologi']??$d['deskripsi']??$d['isi_nota']??$d['deskripsi_kinerja']??null; @endphp
        @if($isi)
        <div style="white-space:pre-line;line-height:1.85;margin-bottom:14px;">{{ $isi }}</div>
        @endif

        {{-- Extra KV --}}
        @php
            $skipKV=['nama','nama_lengkap','nama_pelamar','nama_karyawan','nama_pasien','nama_pengadu','nama_pembayar','nama_penerima','nama_bisnis','nama_mahasiswa','nama_pemohon','nama_penyewa','email','telepon','no_hp','alamat','linkedin','media_sosial','tagline','portofolio','kota','tanggal','tanggal_surat','kepada','jabatan_hr','jabatan_penerima','nama_atasan','nama_perusahaan','alamat_perusahaan','nama_hr','perihal','posisi_dilamar','jabatan','departemen','isi_lamaran','isi_surat','alasan_resign','kronologi','deskripsi','isi_nota','deskripsi_kinerja','ucapan_terima_kasih','rekomendasi','anjuran','_workExps','_educations','_skills','_invoiceItems','pengalaman_kerja','pendidikan','keahlian','sertifikasi','bahasa','ringkasan','kata_kunci'];
            $extra = array_filter($d, fn($v,$k)=>!empty($v)&&!in_array($k,$skipKV)&&!str_starts_with($k,'_'),ARRAY_FILTER_USE_BOTH);
        @endphp
        @if(!empty($extra))
        <div class="surat-sect">Detail</div>
        <div class="surat-kv"><table>
            @foreach($extra as $k=>$v)
            <tr><td>{{ ucwords(str_replace('_',' ',$k)) }}</td><td>{{ is_array($v)?implode(', ',$v):$v }}</td></tr>
            @endforeach
        </table></div>
        @endif

        {{-- Penutup --}}
        @if(!empty($d['ucapan_terima_kasih'])||!empty($d['rekomendasi'])||!empty($d['anjuran']))
        <div style="margin-top:10px;white-space:pre-line;line-height:1.85;">{{ $d['ucapan_terima_kasih']??$d['rekomendasi']??$d['anjuran'] }}</div>
        @endif
    </div>

    {{-- TTD --}}
    <div class="sig-area">
        <div class="sig-box">
            <div class="sig-date">{{ $d['kota']??'Jakarta' }}, {{ now()->isoFormat('D MMMM Y') }}</div>
            @if(!empty($d['materai'])&&$d['materai']!=='Tidak perlu')
            <div style="border:1px dashed #9CA3AF;border-radius:4px;padding:7px 14px;font-size:7pt;color:#9CA3AF;margin-bottom:7px;text-align:center;">[ MATERAI ]</div>
            @endif
            <div class="sig-name">{{ $d['ttd']??$mainName??auth()->user()?->name??'' }}</div>
            <div class="sig-role">{{ $d['jabatan']??$d['jabatan_penerima']??'' }}</div>
        </div>
    </div>
</div>
@endif

</div>{{-- /page --}}
@unless(isset($isLivePreview))
<script>if(new URLSearchParams(location.search).get('print')==='1')window.addEventListener('load',()=>setTimeout(()=>window.print(),400));</script>
@endunless
</body>
</html>
