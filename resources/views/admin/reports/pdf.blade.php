<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan BikinDokumen</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #1F2937; background: white; }

    .header {
        background: #DC2626; color: white;
        padding: 18px 24px; margin-bottom: 20px;
        display: flex; justify-content: space-between; align-items: center;
    }
    .header-logo { font-size: 18px; font-weight: 700; }
    .header-logo span { opacity: 0.7; }
    .header-sub { font-size: 10px; opacity: 0.85; margin-top: 3px; }
    .header-right { text-align: right; font-size: 9px; opacity: 0.85; }

    .summary-row {
        display: flex; gap: 12px; margin: 0 24px 20px; flex-wrap: wrap;
    }
    .summary-box {
        flex: 1; min-width: 120px;
        border: 1.5px solid #E5E7EB; border-radius: 8px;
        padding: 12px 16px; text-align: center;
    }
    .summary-value { font-size: 22px; font-weight: 700; color: #DC2626; }
    .summary-label { font-size: 9px; color: #6B7280; margin-top: 3px; }

    .section-title {
        padding: 8px 24px; background: #F9FAFB;
        border-top: 2px solid #E5E7EB; border-bottom: 2px solid #E5E7EB;
        font-weight: 700; font-size: 11px; color: #374151;
        margin-bottom: 0;
    }

    table { width: 100%; border-collapse: collapse; margin: 0; }
    thead th {
        padding: 8px 10px; background: #F3F4F6;
        font-size: 8.5px; font-weight: 700; color: #6B7280;
        text-transform: uppercase; letter-spacing: 0.4px;
        border-bottom: 1.5px solid #E5E7EB; text-align: left;
    }
    tbody td {
        padding: 7px 10px; border-bottom: 1px solid #F3F4F6;
        font-size: 9px; color: #374151; vertical-align: middle;
    }
    tbody tr:nth-child(even) td { background: #FAFAFA; }
    tbody tr:last-child td { border-bottom: none; }

    .badge {
        display: inline-block; padding: 2px 7px; border-radius: 10px;
        font-size: 8px; font-weight: 700;
    }
    .badge-completed { background: #DCFCE7; color: #166534; }
    .badge-draft     { background: #FEF3C7; color: #92400E; }

    .footer {
        margin-top: 20px; padding: 12px 24px;
        border-top: 1px solid #E5E7EB;
        font-size: 8.5px; color: #9CA3AF;
        display: flex; justify-content: space-between;
    }

    .px24 { padding: 0 24px; }
</style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    <div>
        <div class="header-logo">📄 Bikin<span>Dokumen</span></div>
        <div class="header-sub">Laporan Dokumen Platform</div>
    </div>
    <div class="header-right">
        Periode: {{ \Carbon\Carbon::parse($from)->format('d M Y') }} — {{ \Carbon\Carbon::parse($to)->format('d M Y') }}<br>
        Dibuat: {{ now()->format('d M Y, H:i') }} WIB<br>
        Admin: BikinDokumen.id
    </div>
</div>

{{-- SUMMARY --}}
<div class="summary-row">
    <div class="summary-box">
        <div class="summary-value">{{ number_format($summary['total_documents']) }}</div>
        <div class="summary-label">Total Dokumen</div>
    </div>
    <div class="summary-box">
        <div class="summary-value">{{ number_format($summary['completed']) }}</div>
        <div class="summary-label">Selesai</div>
    </div>
    <div class="summary-box">
        <div class="summary-value">{{ number_format($summary['draft']) }}</div>
        <div class="summary-label">Draft</div>
    </div>
    <div class="summary-box">
        <div class="summary-value">{{ number_format($summary['total_downloads']) }}</div>
        <div class="summary-label">Total Unduhan</div>
    </div>
    <div class="summary-box">
        <div class="summary-value">{{ number_format($summary['unique_users']) }}</div>
        <div class="summary-label">Pengguna Aktif</div>
    </div>
</div>

{{-- TABLE --}}
<div class="section-title">Detail Dokumen ({{ $documents->count() }} data)</div>
<table>
    <thead>
        <tr>
            <th style="width:30px;">#</th>
            <th>Judul Dokumen</th>
            <th>Kategori</th>
            <th>Pengguna</th>
            <th>Email</th>
            <th>Template</th>
            <th style="text-align:center;">Status</th>
            <th style="text-align:center;">Download</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($documents as $i => $doc)
        <tr>
            <td style="color:#9CA3AF;">{{ $i + 1 }}</td>
            <td style="max-width:180px;">{{ Str::limit($doc->title, 45) }}</td>
            <td>{{ $doc->category->name ?? '-' }}</td>
            <td>{{ $doc->user->name ?? '-' }}</td>
            <td style="color:#6B7280;">{{ $doc->user->email ?? '-' }}</td>
            <td style="color:#6B7280;">{{ $doc->template_used ?? '-' }}</td>
            <td style="text-align:center;">
                <span class="badge {{ $doc->status === 'completed' ? 'badge-completed' : 'badge-draft' }}">
                    {{ $doc->status === 'completed' ? 'Selesai' : 'Draft' }}
                </span>
            </td>
            <td style="text-align:center;font-weight:700;color:{{ $doc->download_count > 0 ? '#2563EB' : '#9CA3AF' }};">
                {{ $doc->download_count }}
            </td>
            <td style="color:#6B7280;">{{ $doc->created_at->format('d/m/Y') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="9" style="text-align:center;padding:30px;color:#9CA3AF;">
                Tidak ada dokumen pada periode ini.
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- FOOTER --}}
<div class="footer">
    <span>BikinDokumen.id — Platform Pembuatan Dokumen Profesional</span>
    <span>Laporan ini dibuat otomatis oleh sistem</span>
</div>

</body>
</html>
