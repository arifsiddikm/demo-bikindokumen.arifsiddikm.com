<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BikinDokumen — Buat CV, Surat Lamaran, Invoice, Kontrak, dan 40+ jenis dokumen profesional online. Preview langsung, unduh PDF gratis.">
    <meta name="keywords" content="buat cv online, surat lamaran kerja, invoice generator, template dokumen, download pdf gratis">
    <meta property="og:title" content="BikinDokumen — Buat Dokumen Profesional Online">
    <meta property="og:description" content="40+ jenis dokumen siap pakai. Isi form, preview langsung, unduh PDF.">
    <meta property="og:type" content="website">
    <title>BikinDokumen — Buat Dokumen Profesional Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        .hero-bg {
            background: linear-gradient(135deg, #DC2626 0%, #991B1B 50%, #1F2937 100%);
        }
        .hero-pattern {
            background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.05) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(255,255,255,0.07) 0%, transparent 40%);
        }
        .card-hover {
            transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(220, 38, 38, 0.15);
            border-color: #DC2626;
        }
        .floating {
            animation: float 3s ease-in-out infinite;
        }
        .floating-delay {
            animation: float 3s ease-in-out infinite 1.5s;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .gradient-text {
            background: linear-gradient(90deg, #DC2626, #FBBF24);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .step-line::after {
            content: '';
            position: absolute;
            top: 24px;
            left: calc(50% + 28px);
            width: calc(100% - 56px);
            height: 2px;
            background: linear-gradient(90deg, #DC2626, #FCA5A5);
        }
        .nav-link { transition: color 0.2s; }
        .nav-link:hover { color: #DC2626; }
        .btn-primary {
            background: #DC2626;
            color: white;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover { background: #B91C1C; transform: translateY(-1px); box-shadow: 0 8px 25px rgba(220,38,38,0.4); }
        .btn-secondary {
            background: white;
            color: #DC2626;
            padding: 14px 32px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            border: 2px solid rgba(255,255,255,0.5);
        }
        .btn-secondary:hover { background: rgba(255,255,255,0.9); transform: translateY(-1px); }
        .category-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 600;
            background: #FEF2F2;
            color: #DC2626;
            border: 1px solid #FECACA;
            transition: all 0.2s;
        }
        .category-pill:hover { background: #DC2626; color: white; border-color: #DC2626; text-decoration: none; }
        .faq-item details summary { cursor: pointer; list-style: none; }
        .faq-item details summary::-webkit-details-marker { display: none; }
        .faq-item details[open] summary .faq-arrow { transform: rotate(180deg); }
        .faq-arrow { transition: transform 0.2s; }
    </style>
</head>
<body class="bg-white">

{{-- NAVBAR --}}
<nav class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-black text-sm">BD</span>
                </div>
                <span class="font-black text-gray-900 text-lg">Bikin<span class="text-red-600">Dokumen</span></span>
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a href="#fitur" class="nav-link text-gray-600 font-medium text-sm">Fitur</a>
                <a href="#kategori" class="nav-link text-gray-600 font-medium text-sm">Kategori</a>
                <a href="#cara-kerja" class="nav-link text-gray-600 font-medium text-sm">Cara Kerja</a>
                <a href="#faq" class="nav-link text-gray-600 font-medium text-sm">FAQ</a>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary py-2 px-5 text-sm">Dashboard →</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 font-semibold text-sm hover:text-red-600 transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary py-2 px-5 text-sm">Daftar Gratis</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="hero-bg hero-pattern py-20 md:py-28 overflow-hidden relative" style="background: linear-gradient(135deg, #DC2626 0%, #991B1B 50%, #1F2937 100%) !important;">
    {{-- Decorative floating docs --}}
    <div class="absolute top-12 right-8 md:right-24 floating opacity-20 hidden md:block">
        <div class="w-20 h-24 bg-white rounded-lg shadow-xl flex flex-col p-3 gap-1">
            <div class="h-2 bg-gray-300 rounded w-3/4"></div>
            <div class="h-1.5 bg-gray-200 rounded w-full"></div>
            <div class="h-1.5 bg-gray-200 rounded w-5/6"></div>
            <div class="h-1.5 bg-gray-200 rounded w-full"></div>
            <div class="h-4 bg-red-200 rounded mt-1"></div>
        </div>
    </div>
    <div class="absolute bottom-16 left-8 md:left-16 floating-delay opacity-20 hidden md:block">
        <div class="w-16 h-20 bg-white rounded-lg shadow-xl flex flex-col p-2 gap-1">
            <div class="h-1.5 bg-gray-300 rounded w-2/3"></div>
            <div class="h-1 bg-gray-200 rounded w-full"></div>
            <div class="h-1 bg-gray-200 rounded w-4/5"></div>
            <div class="h-3 bg-yellow-200 rounded mt-1"></div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center relative z-10">
        <div class="inline-flex items-center gap-2 bg-white/15 text-white text-sm font-semibold px-4 py-2 rounded-full mb-6 border border-white/20">
            <span>🎉</span> 40+ Jenis Dokumen Siap Pakai
        </div>
        <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-6">
            Buat Dokumen<br>
            <span class="text-yellow-300">Profesional</span> dalam<br>
            Hitungan Menit
        </h1>
        <p class="text-white/80 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
            CV, Surat Lamaran, Invoice, Kontrak, dan 40+ jenis dokumen lainnya.
            Isi form, preview langsung, unduh PDF — gratis!
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            @auth
                <a href="{{ route('documents.index') }}" class="btn-primary text-lg px-8 py-4">
                    🚀 Buat Dokumen Sekarang
                </a>
            @else
                <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-4">
                    🚀 Mulai Gratis
                </a>
                <a href="{{ route('login') }}" class="btn-secondary text-lg px-8 py-4">
                    Sudah punya akun? Masuk
                </a>
            @endauth
        </div>

        {{-- Stats --}}
        <div class="flex flex-wrap items-center justify-center gap-8 mt-14">
            <div class="text-center">
                <div class="text-3xl font-black text-white">40+</div>
                <div class="text-white/60 text-sm">Jenis Dokumen</div>
            </div>
            <div class="w-px h-10 bg-white/20 hidden sm:block"></div>
            <div class="text-center">
                <div class="text-3xl font-black text-white">80+</div>
                <div class="text-white/60 text-sm">Template</div>
            </div>
            <div class="w-px h-10 bg-white/20 hidden sm:block"></div>
            <div class="text-center">
                <div class="text-3xl font-black text-white">⚡</div>
                <div class="text-white/60 text-sm">Unduh PDF Instan</div>
            </div>
            <div class="w-px h-10 bg-white/20 hidden sm:block"></div>
            <div class="text-center">
                <div class="text-3xl font-black text-white">🤖</div>
                <div class="text-white/60 text-sm">AI Generate</div>
            </div>
        </div>
    </div>
</section>

{{-- KATEGORI PREVIEW --}}
<section id="kategori" class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-3">Semua Jenis Dokumen</h2>
            <p class="text-gray-500 text-lg">Dari karir, bisnis, pendidikan, hingga personal — semua ada.</p>
        </div>

        <div class="flex flex-wrap gap-3 justify-center mb-10">
            <a href="{{ route('documents.index') }}" class="category-pill">👤 CV Profesional</a>
            <a href="{{ route('documents.index') }}" class="category-pill">✉️ Surat Lamaran</a>
            <a href="{{ route('documents.index') }}" class="category-pill">🧾 Invoice</a>
            <a href="{{ route('documents.index') }}" class="category-pill">🚪 Surat Resign</a>
            <a href="{{ route('documents.index') }}" class="category-pill">⚖️ Surat Kuasa</a>
            <a href="{{ route('documents.index') }}" class="category-pill">🤝 Kontrak Kerja</a>
            <a href="{{ route('documents.index') }}" class="category-pill">📜 MOU / PKS</a>
            <a href="{{ route('documents.index') }}" class="category-pill">🏥 Surat Sakit</a>
            <a href="{{ route('documents.index') }}" class="category-pill">🎓 Rekomendasi Akademik</a>
            <a href="{{ route('documents.index') }}" class="category-pill">🏘️ Sewa Menyewa</a>
            <a href="{{ route('documents.index') }}" class="category-pill">📅 Undangan Rapat</a>
            <a href="{{ route('documents.index') }}" class="category-pill">✈️ Surat Tugas</a>
            <a href="{{ route('documents.index') }}" class="category-pill">💻 Proposal IT</a>
            <a href="{{ route('documents.index') }}" class="category-pill">🔒 NDA</a>
            <a href="{{ route('documents.index') }}" class="category-pill">📢 Surat Pengaduan</a>
            <a href="{{ route('documents.index') }}" class="category-pill">+ 25 lainnya</a>
        </div>

        <div class="text-center">
            <a href="{{ route('documents.index') }}" class="btn-primary">
                Lihat Semua Kategori →
            </a>
        </div>
    </div>
</section>

{{-- FITUR --}}
<section id="fitur" class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-14">
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-3">Kenapa BikinDokumen?</h2>
            <p class="text-gray-500 text-lg">Dirancang untuk kemudahan dan kecepatan.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="card-hover bg-white border-2 border-gray-100 rounded-2xl p-8">
                <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-2xl mb-5">📝</div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">Form Mudah & Cepat</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Cukup isi form yang sudah tersedia, dokumen langsung terbentuk sesuai kategori yang dipilih.</p>
            </div>
            <div class="card-hover bg-white border-2 border-gray-100 rounded-2xl p-8">
                <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-2xl mb-5">👁️</div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">Live Preview Real-time</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Preview dokumen update otomatis saat Anda mengisi form. Tampilan split 50/50 untuk kenyamanan.</p>
            </div>
            <div class="card-hover bg-white border-2 border-gray-100 rounded-2xl p-8">
                <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-2xl mb-5">📥</div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">Unduh PDF Langsung</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Dokumen siap diunduh dalam format PDF berkualitas tinggi, langsung dari browser tanpa software tambahan.</p>
            </div>
            <div class="card-hover bg-white border-2 border-gray-100 rounded-2xl p-8">
                <div class="w-14 h-14 bg-yellow-50 rounded-2xl flex items-center justify-center text-2xl mb-5">🤖</div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">AI Generate & Review</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Isi dokumen otomatis dengan AI. Review CV Anda dan dapatkan saran perbaikan dari kecerdasan buatan.</p>
            </div>
            <div class="card-hover bg-white border-2 border-gray-100 rounded-2xl p-8">
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-2xl mb-5">🎨</div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">Ganti Template & Warna</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Pilih dari 2+ template per kategori. Ganti warna tema untuk CV kreatif sesuai kepribadian Anda.</p>
            </div>
            <div class="card-hover bg-white border-2 border-gray-100 rounded-2xl p-8">
                <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-2xl mb-5">📂</div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">Riwayat Tersimpan</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Semua dokumen yang pernah dibuat tersimpan di akun. Edit ulang atau unduh kapan saja.</p>
            </div>
        </div>
    </div>
</section>

{{-- CARA KERJA --}}
<section id="cara-kerja" class="py-20 bg-red-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-14">
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-3">Cara Kerjanya Simpel</h2>
            <p class="text-gray-500 text-lg">3 langkah, dokumen jadi.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 relative">
            <div class="text-center relative">
                <div class="w-14 h-14 bg-red-600 text-white rounded-full flex items-center justify-center text-xl font-black mx-auto mb-5 shadow-lg shadow-red-200">1</div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">Pilih Kategori</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Pilih dari 40+ jenis dokumen yang tersedia. CV, Invoice, Surat Lamaran, Kontrak, dan banyak lagi.</p>
            </div>
            <div class="text-center relative">
                <div class="w-14 h-14 bg-red-600 text-white rounded-full flex items-center justify-center text-xl font-black mx-auto mb-5 shadow-lg shadow-red-200">2</div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">Isi Form</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Isi data di form sebelah kiri. Preview dokumen langsung muncul di sebelah kanan secara real-time.</p>
            </div>
            <div class="text-center">
                <div class="w-14 h-14 bg-red-600 text-white rounded-full flex items-center justify-center text-xl font-black mx-auto mb-5 shadow-lg shadow-red-200">3</div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">Unduh PDF</h3>
                <p class="text-gray-500 text-sm leading-relaxed">Pilih template favorit, sesuaikan warna, lalu klik unduh. Dokumen PDF siap digunakan!</p>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('register') }}" class="btn-primary text-lg px-10 py-4">
                Coba Sekarang — Gratis! 🎉
            </a>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section id="faq" class="py-20 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-3">Pertanyaan Umum</h2>
        </div>

        <div class="space-y-4">
            @foreach([
                ['q' => 'Apakah BikinDokumen gratis?', 'a' => 'Ya! Fitur dasar BikinDokumen sepenuhnya gratis. Anda bisa membuat dan mengunduh dokumen tanpa biaya.'],
                ['q' => 'Dokumen apa saja yang tersedia?', 'a' => 'Tersedia 40+ jenis dokumen dalam 11 grup: Karir & Pekerjaan, Bisnis & Keuangan, Pendidikan, Legal & Administratif, Kesehatan, Properti & Sewa, Organisasi & Komunitas, Personal & Sosial, Perjalanan, Teknologi & Freelance, dan Pemerintahan.'],
                ['q' => 'Apakah dokumen saya tersimpan?', 'a' => 'Ya, semua dokumen yang Anda buat tersimpan di akun. Anda bisa mengakses, mengedit, dan mengunduh ulang kapan saja.'],
                ['q' => 'Apa itu fitur AI Generate?', 'a' => 'Fitur AI Generate membantu mengisi form dokumen secara otomatis berdasarkan prompt yang Anda berikan. Sangat berguna untuk CV dan surat lamaran.'],
                ['q' => 'Bisakah saya mengubah desain dokumen?', 'a' => 'Ya! Setiap kategori memiliki 2+ template pilihan. Untuk CV kreatif, Anda juga bisa mengganti warna tema sesuai keinginan.'],
            ] as $faq)
            <div class="faq-item border border-gray-200 rounded-xl overflow-hidden">
                <details>
                    <summary class="flex items-center justify-between p-5 font-semibold text-gray-900 hover:bg-gray-50 transition-colors">
                        {{ $faq['q'] }}
                        <span class="faq-arrow text-red-500 ml-4 flex-shrink-0">▼</span>
                    </summary>
                    <div class="px-5 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100 pt-4">
                        {{ $faq['a'] }}
                    </div>
                </details>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="hero-bg py-20" style="background: linear-gradient(135deg, #DC2626 0%, #991B1B 50%, #1F2937 100%) !important;">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Siap Buat Dokumen Pertama Anda?</h2>
        <p class="text-white/70 text-lg mb-10">Daftar gratis, tidak perlu kartu kredit.</p>
        @auth
            <a href="{{ route('documents.index') }}" class="btn-secondary text-lg px-10 py-4">
                Buat Dokumen Sekarang →
            </a>
        @else
            <a href="{{ route('register') }}" class="btn-secondary text-lg px-10 py-4">
                Daftar Gratis Sekarang →
            </a>
        @endauth
    </div>
</section>

{{-- FOOTER --}}
<footer class="bg-gray-900 text-gray-400 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-black text-sm">BD</span>
                </div>
                <span class="font-black text-white text-lg">Bikin<span class="text-red-400">Dokumen</span></span>
            </div>
            <p class="text-sm text-center">Buat dokumen profesional dengan mudah dan cepat.</p>
            <div class="flex gap-6 text-sm">
                <a href="{{ route('documents.index') }}" class="hover:text-white transition-colors">Buat Dokumen</a>
                <a href="{{ route('login') }}" class="hover:text-white transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="hover:text-white transition-colors">Daftar</a>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-xs">
            © {{ date('Y') }} BikinDokumen. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>
