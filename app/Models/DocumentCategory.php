<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DocumentCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'name', 'group', 'icon', 'description',
        'color', 'templates', 'fields', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'templates' => 'array',
        'fields'    => 'array',
        'is_active' => 'boolean',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class, 'category_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Semua grup kategori yang aktif
     */
    public static function groups(): array
    {
        return static::where('is_active', true)
            ->distinct('group')
            ->pluck('group')
            ->toArray();
    }

    /**
     * Label fields yang human-readable
     */
    public function fieldLabels(): array
    {
        $map = [
            'nama_lengkap'          => 'Nama Lengkap',
            'foto'                  => 'Foto / Avatar',
            'email'                 => 'Email',
            'telepon'               => 'Nomor Telepon',
            'alamat'                => 'Alamat',
            'ringkasan'             => 'Ringkasan / Profil',
            'pengalaman_kerja'      => 'Pengalaman Kerja',
            'pendidikan'            => 'Pendidikan',
            'keahlian'              => 'Keahlian / Skills',
            'sertifikasi'           => 'Sertifikasi',
            'bahasa'                => 'Kemampuan Bahasa',
            'media_sosial'          => 'Media Sosial / LinkedIn',
            'tagline'               => 'Tagline / Headline',
            'portofolio'            => 'Link Portofolio',
            'warna_tema'            => 'Warna Tema CV',
            'kata_kunci'            => 'Kata Kunci (ATS Keywords)',
            'nama_pelamar'          => 'Nama Pelamar',
            'nama_perusahaan'       => 'Nama Perusahaan / Instansi',
            'alamat_perusahaan'     => 'Alamat Perusahaan',
            'posisi_dilamar'        => 'Posisi yang Dilamar',
            'asal_info_lowongan'    => 'Sumber Info Lowongan',
            'isi_lamaran'           => 'Isi Surat Lamaran',
            'pengalaman_relevan'    => 'Pengalaman Relevan',
            'jabatan'               => 'Jabatan',
            'departemen'            => 'Departemen / Divisi',
            'nama_atasan'           => 'Nama Atasan Langsung',
            'tanggal_surat'         => 'Tanggal Surat',
            'tanggal_efektif'       => 'Tanggal Efektif Resign',
            'alasan_resign'         => 'Alasan Pengunduran Diri',
            'ucapan_terima_kasih'   => 'Ucapan Terima Kasih',
            'tanggal'               => 'Tanggal',
            'nama'                  => 'Nama',
            'nama_bisnis'           => 'Nama Bisnis / Toko',
            'logo'                  => 'Logo',
            'alamat_bisnis'         => 'Alamat Bisnis',
            'email_bisnis'          => 'Email Bisnis',
            'nomor_invoice'         => 'Nomor Invoice',
            'tanggal_invoice'       => 'Tanggal Invoice',
            'jatuh_tempo'           => 'Jatuh Tempo',
            'nama_klien'            => 'Nama Klien',
            'alamat_klien'          => 'Alamat Klien',
            'item_jasa'             => 'Daftar Item / Jasa',
            'subtotal'              => 'Subtotal',
            'pajak'                 => 'Pajak (%)',
            'diskon'                => 'Diskon',
            'total'                 => 'Total',
            'catatan'               => 'Catatan',
            'rekening_bank'         => 'Rekening Bank',
            'nomor_kwitansi'        => 'Nomor Kwitansi',
            'nama_pembayar'         => 'Nama Pembayar',
            'alamat_pembayar'       => 'Alamat Pembayar',
            'jumlah'                => 'Jumlah (Rp)',
            'terbilang'             => 'Terbilang',
            'untuk_pembayaran'      => 'Untuk Pembayaran',
            'nama_penerima'         => 'Nama Penerima',
            'jabatan_penerima'      => 'Jabatan Penerima',
            'nik'                   => 'NIK',
            'ttd'                   => 'Nama Penandatangan',
            'materai'               => 'Ada Materai?',
            'kota'                  => 'Kota',
        ];

        $fields = $this->fields ?? [];
        $result = [];
        foreach ($fields as $f) {
            $result[$f] = $map[$f] ?? ucwords(str_replace('_', ' ', $f));
        }
        return $result;
    }

    /**
     * Tentukan type input untuk field
     */
    public function fieldType(string $field): string
    {
        $textareaFields = ['isi_lamaran','ringkasan','pengalaman_relevan','deskripsi','isi_surat','isi_nota','alasan_resign','ucapan_terima_kasih','kronologi','tuntutan','catatan','pengalaman_kerja','pendidikan','keahlian','sertifikasi'];
        $dateFields     = ['tanggal','tanggal_surat','tanggal_efektif','tanggal_invoice','jatuh_tempo','tanggal_mulai','tanggal_berakhir','tanggal_masuk','tanggal_keluar','tanggal_lahir','tanggal_meninggal'];
        $numberFields   = ['jumlah','total','subtotal','pajak','diskon','harga','harga_sewa'];
        $fileFields     = ['foto','logo','foto_produk'];
        $selectFields   = ['jenis_kelamin','agama','status_karyawan','materai'];

        if (in_array($field, $textareaFields)) return 'textarea';
        if (in_array($field, $dateFields)) return 'date';
        if (in_array($field, $numberFields)) return 'number';
        if (in_array($field, $fileFields)) return 'file';
        if (in_array($field, $selectFields)) return 'select';
        if ($field === 'email' || $field === 'email_bisnis') return 'email';
        if ($field === 'telepon' || $field === 'no_hp') return 'tel';
        if (str_contains($field, 'warna') || str_contains($field, 'color')) return 'color';

        return 'text';
    }

    /**
     * Options untuk select fields
     */
    public function fieldOptions(string $field): array
    {
        return match($field) {
            'jenis_kelamin' => ['Laki-laki', 'Perempuan'],
            'agama'         => ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'],
            'status_karyawan' => ['Karyawan Tetap', 'Karyawan Kontrak', 'Magang', 'Probation'],
            'materai'       => ['Ya, sertakan materai', 'Tidak perlu'],
            default         => [],
        };
    }
}
