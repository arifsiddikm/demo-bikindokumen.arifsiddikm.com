# BikinDokumen — Platform Pembuat Dokumen Profesional

Website platform untuk membuat berbagai jenis dokumen profesional secara online dan download PDF — dilengkapi admin panel CMS untuk monitoring seluruh aktivitas pengguna.

🌐 **Live Demo:** [demo-bikindokumen.arifsiddikm.com](https://demo-bikindokumen.arifsiddikm.com)

---

## Tech Stack

- **Backend:** PHP 8.3 + Laravel 13
- **Database:** SQLite / MySQL
- **Frontend:** Tailwind CSS CDN · Alpine.js · SweetAlert2
- **PDF Generator:** DomPDF (barryvdh/laravel-dompdf)
- **Font:** Plus Jakarta Sans (Google Fonts)

---

## Fitur

**Frontend Pengguna**
- Register & Login dengan autofill demo account
- Pilih 40+ kategori dokumen (CV, Surat Lamaran, Invoice, Kwitansi, dll)
- Form dinamis per kategori dengan live preview
- Download dokumen sebagai PDF
- Riwayat dokumen pribadi

**Admin Panel** (`/admin`)
- Dashboard statistik (total user, dokumen, unduhan, kategori)
- CRUD Kategori Dokumen (dengan toggle aktif/nonaktif)
- Monitoring semua dokumen pengguna
- Manajemen user
- Laporan dengan export **PDF** dan **CSV**

---

## Instalasi

```bash
# 1. Clone repo
git clone https://github.com/arifsiddikm/bikindokumen.git
cd bikindokumen

# 2. Install dependencies
composer install

# 3. Install dompdf
composer require barryvdh/laravel-dompdf

# 4. Copy dan konfigurasi .env
cp file env to .env and setting your password
php artisan key:generate

# 5. Setup database (SQLite default)
touch database/database.sqlite
php artisan migrate
php artisan db:seed

# 6. Storage link
php artisan storage:link

# 7. Jalankan server
php artisan serve
```

Akses di `http://localhost:8000`

---

## Login Demo

| Role  | Email                   | Password   |
|-------|-------------------------|------------|
| Admin | admin@bikindokumen.id   | admin123   |
| User  | demo@bikindokumen.id    | demo123    |

> Tersedia tombol **Autofill** di halaman login untuk kemudahan testing.

---

## Konfigurasi MySQL (opsional)

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bikindokumen
DB_USERNAME=root
DB_PASSWORD=
```

Lalu jalankan ulang:
```bash
php artisan migrate
php artisan db:seed
```

---

## Struktur Kategori Dokumen (40+ jenis)

| Grup                    | Contoh Dokumen                              |
|-------------------------|---------------------------------------------|
| Karir & Pekerjaan       | CV Profesional, Surat Lamaran, Resign       |
| Bisnis & Keuangan       | Invoice, Kwitansi, Kontrak Kerja, MOU       |
| Pendidikan              | Surat Izin, Rekomendasi Akademik, Makalah   |
| Legal & Administratif   | Surat Kuasa, Domisili, Pernyataan           |
| Kesehatan               | Surat Sakit, Resume Medis                   |
| Properti & Sewa         | Surat Sewa, Jual Beli, Serah Terima         |
| Organisasi & Komunitas  | Undangan Rapat, SK, Proposal Kegiatan       |
| Personal & Sosial       | Surat Cinta, Ucapan, Izin Orang Tua         |
| Teknologi & Freelance   | Proposal IT, NDA, Katalog Produk            |
| Pemerintahan            | Surat Dinas, Pengaduan, Permohonan Beasiswa |

---

### Support me on

<a href="https://saweria.co/arifsiddikm" target="_blank"><img src="https://user-images.githubusercontent.com/26188697/180601310-e82c63e4-412b-4c36-b7b5-7ba713c80380.png" alt="Sawer me" height="41" width="174"></a>
