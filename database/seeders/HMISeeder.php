<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use App\Models\KaryaKader;
use App\Models\Activity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HMISeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create initial admin account as specified
        $admin = User::create([
            'name' => 'Administrator HMI',
            'email' => 'admin@hmihukumbrawijaya.org',
            'password' => Hash::make('LitbangHMI.2025'),
            'role' => 'administrator',
            'status' => 'verified',
            'nomor_induk_kader' => 'HMI-ADM-001',
            'phone' => '081234567890',
            'angkatan' => '2020',
            'fakultas' => 'Hukum',
            'jurusan' => 'Ilmu Hukum',
            'profile_completed' => true,
            'email_verified_at' => now(),
        ]);

        // Create sample pengurus
        $pengurus = User::create([
            'name' => 'Ahmad Pengurus',
            'email' => 'pengurus@hmihukumbrawijaya.org',
            'password' => Hash::make('password123'),
            'role' => 'pengurus',
            'status' => 'verified',
            'nomor_induk_kader' => 'HMI-PNG-001',
            'phone' => '081234567891',
            'angkatan' => '2021',
            'fakultas' => 'Hukum',
            'jurusan' => 'Ilmu Hukum',
            'profile_completed' => true,
            'email_verified_at' => now(),
        ]);

        // Create sample kader
        $kader1 = User::create([
            'name' => 'Fatimah Kader',
            'email' => 'fatimah@student.ub.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'kader',
            'status' => 'verified',
            'nomor_induk_kader' => 'HMI-KDR-001',
            'phone' => '081234567892',
            'angkatan' => '2022',
            'fakultas' => 'Hukum',
            'jurusan' => 'Ilmu Hukum',
            'profile_completed' => true,
            'email_verified_at' => now(),
        ]);

        $kader2 = User::create([
            'name' => 'Muhammad Kader',
            'email' => 'muhammad@student.ub.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'kader',
            'status' => 'pending',
            'phone' => '081234567893',
            'angkatan' => '2023',
            'fakultas' => 'Hukum',
            'jurusan' => 'Ilmu Hukum',
            'profile_completed' => false,
            'email_verified_at' => now(),
        ]);

        // Create sample books
        $books = [
            [
                'title' => 'Fiqh Muamalah Kontemporer',
                'author' => 'Prof. Dr. Ahmad Syafi\'i',
                'description' => 'Pembahasan komprehensif tentang hukum ekonomi Islam dalam konteks modern',
                'type' => 'physical',
                'isbn' => '978-602-1234-56-7',
                'stock' => 5,
                'category' => 'islamic',
                'status' => 'available',
            ],
            [
                'title' => 'Pengantar Ilmu Hukum Indonesia',
                'author' => 'Dr. Sudikno Mertokusumo',
                'description' => 'Buku dasar untuk memahami sistem hukum Indonesia',
                'type' => 'physical',
                'isbn' => '978-602-1234-56-8',
                'stock' => 3,
                'category' => 'law',
                'status' => 'available',
            ],
            [
                'title' => 'Digital Fiqh: Hukum Islam di Era Digital',
                'author' => 'Dr. Abdullah Modern',
                'description' => 'Panduan hukum Islam untuk kehidupan digital',
                'type' => 'digital',
                'file_path' => 'books/digital-fiqh.pdf',
                'category' => 'islamic',
                'status' => 'available',
            ],
            [
                'title' => 'Metodologi Penelitian Hukum',
                'author' => 'Prof. Soerjono Soekanto',
                'description' => 'Panduan metodologi penelitian untuk mahasiswa hukum',
                'type' => 'digital',
                'file_path' => 'books/metodologi-penelitian.pdf',
                'category' => 'research',
                'status' => 'available',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }

        // Create sample karya kader
        $karyaKaders = [
            [
                'user_id' => $kader1->id,
                'title' => 'Analisis Hukum Waqf Digital di Indonesia',
                'description' => 'Penelitian tentang regulasi waqf digital dalam perspektif hukum Islam dan positif',
                'type' => 'digital',
                'category' => 'research',
                'file_path' => 'karya/waqf-digital-analysis.pdf',
                'status' => 'available',
            ],
            [
                'user_id' => $pengurus->id,
                'title' => 'Peran HMI dalam Pembangunan Karakter Bangsa',
                'description' => 'Artikel tentang kontribusi HMI dalam membentuk karakter generasi muda',
                'type' => 'digital',
                'category' => 'article',
                'file_path' => 'karya/peran-hmi-karakter.pdf',
                'status' => 'available',
            ],
        ];

        foreach ($karyaKaders as $karya) {
            KaryaKader::create($karya);
        }

        // Create sample activities
        $activities = [
            [
                'name' => 'Kajian Rutin Fiqh Kontemporer',
                'description' => 'Diskusi mingguan tentang isu-isu fiqh terkini',
                'date' => now()->addDays(7),
                'start_time' => '19:00:00',
                'end_time' => '21:00:00',
                'location' => 'Masjid Kampus UB',
                'participant_type' => 'all_kader',
                'status' => 'planned',
                'created_by' => $admin->id,
            ],
            [
                'name' => 'Rapat Pengurus Bulanan',
                'description' => 'Evaluasi program kerja dan perencanaan kegiatan',
                'date' => now()->addDays(3),
                'start_time' => '16:00:00',
                'end_time' => '18:00:00',
                'location' => 'Sekretariat HMI Hukum',
                'participant_type' => 'pengurus',
                'status' => 'planned',
                'created_by' => $pengurus->id,
            ],
            [
                'name' => 'Workshop Metodologi Penelitian',
                'description' => 'Pelatihan menulis karya ilmiah untuk kader',
                'date' => now()->subDays(15),
                'start_time' => '09:00:00',
                'end_time' => '15:00:00',
                'location' => 'Aula Fakultas Hukum',
                'participant_type' => 'all_kader',
                'status' => 'completed',
                'created_by' => $admin->id,
            ],
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }

        $this->command->info('HMI Seeder completed successfully!');
        $this->command->info('Admin credentials:');
        $this->command->info('Email: admin@hmihukumbrawijaya.org');
        $this->command->info('Password: LitbangHMI.2025');
    }
}