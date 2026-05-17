# CLAUDE PROMPT — BikinDokumen Platform

> Gunakan prompt ini untuk membangun ulang website BikinDokumen dari awal di sesi baru.
> Upload prompt ini, lalu ikuti instruksi di bawah.

---

## INSTRUKSI

Bangunkan saya website Laravel lengkap bernama **BikinDokumen** — platform web untuk membuat berbagai jenis dokumen profesional secara online dan download PDF. Ikuti spesifikasi lengkap berikut:

---

## TECH STACK

- **Framework:** Laravel 13 + PHP 8.3
- **Database:** SQLite (default) / MySQL (opsional)
- **Frontend:** Tailwind CSS via CDN, Alpine.js, SweetAlert2
- **PDF:** `barryvdh/laravel-dompdf`
- **Font:** Plus Jakarta Sans (Google Fonts)
- **Auth:** Laravel built-in (tanpa Breeze/Jetstream, buat manual)

---

## KONSEP APLIKASI

User bisa:
1. Daftar dan login ke platform
2. Pilih dari 40+ kategori jenis dokumen
3. Mengisi form dinamis sesuai kategori
4. Preview dokumen secara live sebelum download
5. Download dokumen sebagai PDF
6. Lihat riwayat semua dokumen yang pernah dibuat

Admin bisa:
1. Monitoring semua aktivitas pengguna
2. Kelola kategori dokumen (CRUD + toggle aktif)
3. Lihat dan hapus dokumen pengguna
4. Kelola data user
5. Lihat laporan dan export ke PDF / CSV

---

## DATABASE SCHEMA

### Tabel `users`
```
id, name, email, password, is_admin (boolean), email_verified_at, remember_token, timestamps
```

### Tabel `document_categories`
```
id, slug (unique), name, group, icon (emoji), description, color (hex),
templates (json array), fields (json array), is_active (boolean),
sort_order (integer), timestamps
```

### Tabel `documents`
```
id, user_id (FK), category_id (FK), title, template_used,
form_data (json), color_theme, status (draft|completed),
file_path, last_downloaded_at, download_count (integer), timestamps
```

---

## ROUTES

```
GET  /                          → welcome page
GET  /login                     → halaman login
POST /login                     → proses login
GET  /register                  → halaman register
POST /register                  → proses register
POST /logout                    → logout

[auth middleware]
GET  /dashboard                 → dashboard user
GET  /buat-dokumen              → pilih kategori
GET  /buat-dokumen/{slug}       → form buat dokumen
POST /buat-dokumen/{slug}       → simpan dokumen
GET  /dokumen/{id}/preview      → preview dokumen
GET  /dokumen/{id}/download     → download PDF
PUT  /dokumen/{id}              → update dokumen
DELETE /dokumen/{id}            → hapus dokumen
POST /api/preview/{slug}        → live preview API
GET  /riwayat                   → riwayat dokumen user

[auth + admin middleware]
GET  /admin                     → dashboard admin
GET  /admin/categories          → daftar kategori
GET  /admin/categories/create   → form tambah kategori
POST /admin/categories          → simpan kategori
GET  /admin/categories/{id}/edit → form edit
PUT  /admin/categories/{id}     → update
DELETE /admin/categories/{id}   → hapus
PATCH /admin/categories/{id}/toggle → toggle aktif

GET  /admin/documents           → daftar dokumen (dengan filter)
GET  /admin/documents/{id}      → detail dokumen
DELETE /admin/documents/{id}    → hapus

GET  /admin/users               → daftar user (dengan search)
GET  /admin/reports             → halaman laporan
GET  /admin/reports/export      → export PDF atau CSV (?format=pdf|csv)
```

---

## MIDDLEWARE

Buat `AdminMiddleware` yang cek `$user->is_admin === true`, redirect ke `/dashboard` jika bukan admin.

---

## TAMPILAN & UI

### Color Palette
- Primary: `#DC2626` (merah)
- Dark: `#111827`
- Sidebar admin: `#111827` (dark)
- Card background: `white`
- Page background: `#F9FAFB`

### Font
Plus Jakarta Sans (400, 500, 600, 700, 800) dari Google Fonts.

### Layout Admin
- Sidebar fixed kiri lebar 260px, warna dark `#111827`
- Main content dengan padding dan scrollable
- Sidebar berisi: brand logo, navigasi dengan icon emoji, user info bawah

### Komponen UI yang harus ada
- Stat cards (grid 4-5 kolom) di dashboard
- Tabel dengan filter, search, paginate
- Badge status (completed = hijau, draft = kuning)
- SweetAlert2 untuk konfirmasi hapus
- Toggle button aktif/nonaktif (inline, AJAX)
- Form input dengan focus merah

---

## KATEGORI DOKUMEN (40+)

Buat minimal kategori berikut, dikelompokkan per grup:

**Karir & Pekerjaan:** CV Profesional, CV Kreatif, CV ATS, Surat Lamaran Kerja, Surat Pengunduran Diri, Surat Referensi Kerja, Surat Keterangan Kerja, Surat Pengalaman Kerja

**Bisnis & Keuangan:** Invoice/Faktur, Kwitansi Pembayaran, Surat Penawaran Harga, Purchase Order, Nota Dinas, Proposal Bisnis, Kontrak Kerja, MOU/Perjanjian Kerjasama, Laporan Keuangan Sederhana

**Pendidikan:** Surat Izin Tidak Masuk Sekolah, Surat Rekomendasi Akademik, Cover Makalah, Proposal Penelitian, Surat Pernyataan Mahasiswa, Biodata Siswa

**Legal & Administratif:** Surat Kuasa, Surat Pernyataan Umum, Surat Keterangan Domisili, Surat Keterangan Kematian, Surat Nikah Adat, Surat Izin Keramaian

**Kesehatan:** Surat Keterangan Sakit, Resume Medis

**Properti & Sewa:** Surat Perjanjian Sewa Menyewa, Surat Jual Beli, Berita Acara Serah Terima

**Organisasi & Komunitas:** Surat Undangan Rapat, Surat Keputusan (SK), Laporan Kegiatan, Proposal Kegiatan, Surat Permohonan Donasi

**Personal & Sosial:** Surat Cinta/Personal, Surat Permohonan Maaf, Surat/Kartu Ucapan, Surat Izin Orang Tua

**Perjalanan & Akomodasi:** Surat Tugas/Perintah Jalan, Itinerary Perjalanan

**Teknologi & Freelance:** Proposal Proyek IT/Freelance, NDA/Perjanjian Kerahasiaan, Deskripsi Produk/Katalog

**Pemerintahan & Instansi:** Surat Resmi Dinas, Surat Pengaduan/Komplain, Surat Permohonan Beasiswa

Setiap kategori punya: slug unik, nama, group, icon emoji, description, color hex, `templates` (json array nama template), `fields` (json array nama field form).

---

## SEEDER

Buat `DatabaseSeeder` yang memanggil `DocumentCategorySeeder` dan juga membuat:
- 1 admin: `admin@bikindokumen.id` / `admin123`
- 1 demo user: `demo@bikindokumen.id` / `demo123`
- 15 dummy user dengan nama Indonesia
- Dummy dokumen banyak (tiap user buat 3-7 dokumen dari kategori random)

---

## HALAMAN LOGIN

- Styling card putih di tengah, background gradient merah muda
- Tombol autofill **2 tombol**: Admin Demo dan User Demo (side by side)
- Teks kecil di bawah menampilkan email masing-masing akun demo

---

## ADMIN CATEGORIES INDEX

Halaman `/admin/categories` harus menampilkan:
- Summary pills (filter per grup, klik untuk filter tabel)
- Search input + dropdown filter status (aktif/nonaktif)
- Tabel: no, kategori (icon + nama + deskripsi), grup (badge warna), jumlah dokumen (link), status (toggle inline AJAX), urutan, aksi (edit, hapus)
- Konfirmasi hapus pakai SweetAlert2

---

## EXPORT LAPORAN

Di `/admin/reports/export`:
- Parameter `?format=pdf` → download PDF via dompdf, landscape A4
- Parameter `?format=csv` → download CSV
- PDF berisi: header merah dengan periode & tanggal cetak, summary boxes (total dokumen, selesai, draft, unduhan, pengguna aktif), tabel detail semua dokumen

---

## IDENTITAS WEBSITE

- **Nama:** BikinDokumen
- **Tagline:** "Buat Dokumen Profesional dalam Menit"
- **Domain demo:** https://demo-bikindokumen.arifsiddikm.com
- **Logo:** ikon dokumen SVG sederhana di kotak merah
- **Brand color:** #DC2626

---

## URUTAN BUILD

1. Migration + Model (User, DocumentCategory, Document)
2. Middleware (AdminMiddleware)
3. AuthController (login, register, logout)
4. Seeder (DatabaseSeeder + DocumentCategorySeeder)
5. Routes (web.php)
6. Layout views (layouts/app.blade.php, layouts/admin.blade.php)
7. Auth views (login, register)
8. User dashboard + riwayat
9. Document flow (categories, create, preview, download)
10. Admin controllers + views (dashboard, categories CRUD, documents, users, reports)
11. Export PDF + CSV

Bangun semua file sekaligus lengkap. Jangan skip file apapun.
