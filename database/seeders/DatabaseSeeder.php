<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Document;
use App\Models\DocumentCategory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =============================================
        // 1. USERS
        // =============================================

        // Admin
        User::firstOrCreate(
            ['email' => 'admin@bikindokumen.id'],
            [
                'name'               => 'Admin BikinDokumen',
                'password'           => Hash::make('admin123'),
                'is_admin'           => true,
                'email_verified_at'  => now(),
            ]
        );

        // Demo user
        User::firstOrCreate(
            ['email' => 'demo@bikindokumen.id'],
            [
                'name'               => 'Demo User',
                'password'           => Hash::make('demo123'),
                'is_admin'           => false,
                'email_verified_at'  => now(),
            ]
        );

        // Dummy users
        $dummyUsers = [
            ['name' => 'Budi Santoso',      'email' => 'budi@gmail.com',      'password' => 'password123'],
            ['name' => 'Siti Rahayu',       'email' => 'siti@gmail.com',      'password' => 'password123'],
            ['name' => 'Ahmad Fauzi',       'email' => 'ahmad@yahoo.com',     'password' => 'password123'],
            ['name' => 'Dewi Kusuma',       'email' => 'dewi@gmail.com',      'password' => 'password123'],
            ['name' => 'Rizky Pratama',     'email' => 'rizky@gmail.com',     'password' => 'password123'],
            ['name' => 'Rina Wati',         'email' => 'rina@hotmail.com',    'password' => 'password123'],
            ['name' => 'Dodi Hermawan',     'email' => 'dodi@gmail.com',      'password' => 'password123'],
            ['name' => 'Lena Marlina',      'email' => 'lena@gmail.com',      'password' => 'password123'],
            ['name' => 'Wahyu Nugroho',     'email' => 'wahyu@gmail.com',     'password' => 'password123'],
            ['name' => 'Putri Anggraini',   'email' => 'putri@gmail.com',     'password' => 'password123'],
            ['name' => 'Eko Prasetyo',      'email' => 'eko@gmail.com',       'password' => 'password123'],
            ['name' => 'Hana Safitri',      'email' => 'hana@gmail.com',      'password' => 'password123'],
            ['name' => 'Irwan Setiawan',    'email' => 'irwan@gmail.com',     'password' => 'password123'],
            ['name' => 'Mega Puspitasari',  'email' => 'mega@gmail.com',      'password' => 'password123'],
            ['name' => 'Fajar Sidik',       'email' => 'fajar@gmail.com',     'password' => 'password123'],
        ];

        foreach ($dummyUsers as $u) {
            User::firstOrCreate(
                ['email' => $u['email']],
                [
                    'name'              => $u['name'],
                    'password'          => Hash::make($u['password']),
                    'is_admin'          => false,
                    'email_verified_at' => now()->subDays(rand(1, 90)),
                ]
            );
        }

        // =============================================
        // 2. DOCUMENT CATEGORIES (40+ types)
        // =============================================
        $this->call(DocumentCategorySeeder::class);

        // =============================================
        // 3. DUMMY DOCUMENTS
        // =============================================
        $userIds     = User::where('is_admin', false)->pluck('id')->toArray();
        $categories  = DocumentCategory::where('is_active', true)->get();

        if ($categories->isEmpty() || empty($userIds)) {
            return;
        }

        $statuses    = ['draft', 'completed', 'completed', 'completed']; // lebih banyak completed
        $colorThemes = ['merah', 'biru', 'hijau', 'ungu', 'hitam'];

        // Data dummy per kategori
        $sampleData = [
            'cv-profesional' => [
                ['nama_lengkap' => 'Budi Santoso', 'email' => 'budi@gmail.com', 'telepon' => '08123456789', 'alamat' => 'Jakarta Selatan', 'ringkasan' => 'Software engineer berpengalaman 5 tahun', 'keahlian' => 'PHP, Laravel, MySQL, Docker'],
                ['nama_lengkap' => 'Siti Rahayu', 'email' => 'siti@gmail.com', 'telepon' => '08987654321', 'alamat' => 'Bandung', 'ringkasan' => 'Marketing specialist dengan pengalaman digital', 'keahlian' => 'SEO, Social Media, Google Ads'],
                ['nama_lengkap' => 'Ahmad Fauzi', 'email' => 'ahmad@yahoo.com', 'telepon' => '08112233445', 'alamat' => 'Surabaya', 'ringkasan' => 'Akuntan junior dengan sertifikasi ACCA', 'keahlian' => 'Akuntansi, Excel, SAP, ERP'],
            ],
            'surat-lamaran' => [
                ['nama_pelamar' => 'Dewi Kusuma', 'posisi_dilamar' => 'Frontend Developer', 'nama_perusahaan' => 'PT Teknologi Maju', 'isi_lamaran' => 'Dengan hormat, saya Dewi Kusuma ingin melamar posisi Frontend Developer...'],
                ['nama_pelamar' => 'Rizky Pratama', 'posisi_dilamar' => 'Data Analyst', 'nama_perusahaan' => 'PT Data Insights', 'isi_lamaran' => 'Bersama surat ini saya mengajukan lamaran untuk posisi Data Analyst...'],
            ],
            'invoice' => [
                ['nama_bisnis' => 'CV Digital Kreatif', 'nama_klien' => 'PT Maju Bersama', 'nomor_invoice' => 'INV-2025-001', 'total' => 'Rp 15.000.000', 'item_jasa' => 'Pembuatan Website Company Profile'],
                ['nama_bisnis' => 'Studio Desain Arif', 'nama_klien' => 'Toko Online Laris', 'nomor_invoice' => 'INV-2025-002', 'total' => 'Rp 3.500.000', 'item_jasa' => 'Desain Logo dan Brand Identity'],
                ['nama_bisnis' => 'Konsultan IT Prima', 'nama_klien' => 'UD Sumber Rejeki', 'nomor_invoice' => 'INV-2025-003', 'total' => 'Rp 8.000.000', 'item_jasa' => 'Implementasi Sistem POS'],
            ],
            'surat-sakit' => [
                ['nama_pasien' => 'Eko Prasetyo', 'diagnosis' => 'Influenza ringan', 'istirahat_mulai' => '2025-01-15', 'istirahat_selesai' => '2025-01-17', 'nama_dokter' => 'dr. Hendra Wijaya'],
                ['nama_pasien' => 'Mega Puspitasari', 'diagnosis' => 'Demam tifoid', 'istirahat_mulai' => '2025-02-01', 'istirahat_selesai' => '2025-02-07', 'nama_dokter' => 'dr. Anisa Putri'],
            ],
            'surat-resign' => [
                ['nama' => 'Irwan Setiawan', 'jabatan' => 'Staff IT', 'perusahaan' => 'PT Global Tech', 'tanggal_efektif' => '2025-02-28', 'alasan_resign' => 'Kesempatan karir yang lebih baik'],
            ],
            'kwitansi' => [
                ['nomor_kwitansi' => 'KWT-001', 'nama_pembayar' => 'Fajar Sidik', 'jumlah' => 'Rp 2.500.000', 'untuk_pembayaran' => 'Uang muka jasa website'],
                ['nomor_kwitansi' => 'KWT-002', 'nama_pembayar' => 'Hana Safitri', 'jumlah' => 'Rp 750.000', 'untuk_pembayaran' => 'Biaya kursus online'],
            ],
        ];

        // Buat dokumen dummy
        $documentsToInsert = [];
        $now = now();

        foreach ($userIds as $userId) {
            // Setiap user buat 3-7 dokumen
            $count = rand(3, 7);
            $selectedCats = $categories->random(min($count, $categories->count()));

            foreach ($selectedCats as $cat) {
                $sampleFormData = $sampleData[$cat->slug] ?? null;
                $formData = $sampleFormData
                    ? $sampleFormData[array_rand($sampleFormData)]
                    : ['judul' => $cat->name, 'nama' => 'User ' . $userId, 'tanggal' => now()->subDays(rand(1, 60))->format('d/m/Y')];

                $status        = $statuses[array_rand($statuses)];
                $downloadCount = $status === 'completed' ? rand(1, 25) : 0;
                $createdAt     = $now->copy()->subDays(rand(1, 180))->subHours(rand(0, 23));
                // $cat->templates sudah di-cast array oleh Eloquent, handle keduanya
                $templates = is_array($cat->templates) ? $cat->templates : json_decode($cat->templates ?? '[]', true);

                $documentsToInsert[] = [
                    'user_id'            => $userId,
                    'category_id'        => $cat->id,
                    'title'              => $cat->name . ' - ' . ($formData['nama_lengkap'] ?? $formData['nama'] ?? $formData['nama_pelamar'] ?? $formData['nama_pembayar'] ?? $formData['nama_pasien'] ?? 'User'),
                    'template_used'      => !empty($templates) ? $templates[array_rand($templates)] : 'Default',
                    'form_data'          => json_encode($formData),
                    'color_theme'        => $colorThemes[array_rand($colorThemes)],
                    'status'             => $status,
                    'file_path'          => $status === 'completed' ? 'documents/' . Str::uuid() . '.pdf' : null,
                    'last_downloaded_at' => $downloadCount > 0 ? $createdAt->copy()->addDays(rand(0, 5)) : null,
                    'download_count'     => $downloadCount,
                    'created_at'         => $createdAt,
                    'updated_at'         => $createdAt,
                ];
            }
        }

        // Insert dalam batch biar cepat
        foreach (array_chunk($documentsToInsert, 50) as $chunk) {
            DB::table('documents')->insert($chunk);
        }

        $this->command->info('✅ Seeder selesai!');
        $this->command->info('   👥 Users: ' . User::count() . ' (termasuk admin + demo + ' . count($dummyUsers) . ' dummy)');
        $this->command->info('   🗂️  Kategori: ' . DocumentCategory::count());
        $this->command->info('   📄 Dokumen: ' . Document::count());
    }
}
