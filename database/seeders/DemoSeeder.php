<?php

namespace Database\Seeders;

use App\Models\ApplicantProfile;
use App\Models\Application;
use App\Models\City;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\SwipeHistory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Demo Companies
        $c1User = User::create([
            'name' => 'Budi Rekruter',
            'email' => 'hr@KopiLokal.id',
            'password' => Hash::make('password'),
            'role' => 'company',
        ]);

        $jogjaCity = City::findByName('Kota Yogyakarta');
        $slemanCity = City::findByName('Kab. Sleman');
        $bantulCity = City::findByName('Kab. Bantul');
        $klatenCity = City::findByName('Kab. Klaten');

        $c1 = Company::create([
            'user_id' => $c1User->id,
            'company_name' => 'Kopi Lokal & Resto Jogja',
            'address' => 'Jl. Malioboro No. 45',
            'city' => 'Kota Yogyakarta',
            'latitude' => $jogjaCity?->latitude,
            'longitude' => $jogjaCity?->longitude,
            'contact_email' => 'recruitment@kopilokal.id',
            'agreed_to_terms' => true,
        ]);

        $c2User = User::create([
            'name' => 'Siti HRD',
            'email' => 'hrd@creativestudio.com',
            'password' => Hash::make('password'),
            'role' => 'company',
        ]);

        $c2 = Company::create([
            'user_id' => $c2User->id,
            'company_name' => 'Nusantara Tech & Creative Studio',
            'address' => 'Jl. Kaliurang KM 7, Depok',
            'city' => 'Kab. Sleman',
            'latitude' => $slemanCity?->latitude,
            'longitude' => $slemanCity?->longitude,
            'contact_email' => 'careers@creativestudio.com',
            'agreed_to_terms' => true,
        ]);

        // 2. Create Demo Job Listings
        $j1 = JobListing::create([
            'company_id' => $c1->id,
            'position' => 'Head Barista & Customer Service',
            'description' => 'Mencari barista berpengalaman untuk meracik kopi espresso base dan manual brew, serta melayani pengunjung dengan ramah.',
            'qualifications' => 'Pria/Wanita max 25 tahun, memiliki keahlian latte art, rapi, komunikatif, dan siap kerja shift weekend.',
            'city' => 'Kota Yogyakarta',
            'latitude' => $jogjaCity?->latitude,
            'longitude' => $jogjaCity?->longitude,
            'work_type' => 'full_time',
            'job_category' => 'fnb',
            'required_skills' => ['Espresso', 'Latte Art', 'Customer Service', 'Kasir'],
            'min_education' => 'sma',
            'radius_km' => 25,
            'status' => 'active',
        ]);

        $j2 = JobListing::create([
            'company_id' => $c1->id,
            'position' => 'Staff Social Media & Content Creator',
            'description' => 'Membuat konten Reels/TikTok harian, foto produk menu cafe, dan membalas DM/komentar pelanggan.',
            'qualifications' => 'Menguasai CapCut, Canva, foto produk dengan HP, mengerti tren Gen Z, kreatif.',
            'city' => 'Kota Yogyakarta',
            'latitude' => $jogjaCity?->latitude,
            'longitude' => $jogjaCity?->longitude,
            'work_type' => 'part_time',
            'job_category' => 'desain',
            'required_skills' => ['Canva', 'CapCut', 'Instagram Reels', 'TikTok'],
            'min_education' => 'sma',
            'radius_km' => 30,
            'status' => 'active',
        ]);

        $j3 = JobListing::create([
            'company_id' => $c2->id,
            'position' => 'Junior Web Developer (Laravel / Livewire)',
            'description' => 'Membantu tim merancang dan mengembangkan fitur web dashboard aplikasi klien menggunakan Laravel & Tailwind CSS.',
            'qualifications' => 'Mahasiswa tingkat akhir / fresh graduate Informatika/Ilmu Komputer, memahami Git, HTML, CSS, PHP Laravel.',
            'city' => 'Kab. Sleman',
            'latitude' => $slemanCity?->latitude,
            'longitude' => $slemanCity?->longitude,
            'work_type' => 'full_time',
            'job_category' => 'teknologi',
            'required_skills' => ['Laravel', 'PHP', 'Tailwind CSS', 'Git'],
            'min_education' => 'd3',
            'radius_km' => 30,
            'status' => 'active',
        ]);

        $j4 = JobListing::create([
            'company_id' => $c2->id,
            'position' => 'Magang UI/UX Designer',
            'description' => 'Program magang 3 bulan membuat wireframe dan visual prototype aplikasi mobile/web menggunakan Figma.',
            'qualifications' => 'Memiliki portofolio desain di Figma, memahami konsep dasar Design System & Responsive Layout.',
            'city' => 'Kab. Sleman',
            'latitude' => $slemanCity?->latitude,
            'longitude' => $slemanCity?->longitude,
            'work_type' => 'internship',
            'job_category' => 'desain',
            'required_skills' => ['Figma', 'Wireframing', 'UI Design'],
            'min_education' => 'sma',
            'radius_km' => 50,
            'status' => 'active',
        ]);

        // 3. Create Demo Applicants in different locations (for distance calculation)

        // Applicant 1: Kota Yogyakarta (~0 km to Kopi Lokal, ~9.4 km to Sleman)
        $a1User = User::create([
            'name' => 'Rizky Pratama (Gen Z Demo)',
            'email' => 'applicant@demo.com',
            'password' => Hash::make('password'),
            'role' => 'applicant',
        ]);

        ApplicantProfile::create([
            'user_id' => $a1User->id,
            'photo' => null,
            'education_level' => 's1',
            'education_institution' => 'Universitas Gadjah Mada',
            'field_of_study' => 'Teknologi Informasi',
            'work_experience' => "• Magang Web Developer di Studio Kreatif (6 bulan)\n• Anggota Divisi IT Himpunan Mahasiswa",
            'skills' => ['Laravel', 'PHP', 'Tailwind CSS', 'CapCut', 'Figma'],
            'contact_email' => 'rizky.pratama@gmail.com',
            'city' => 'Kota Yogyakarta',
            'latitude' => $jogjaCity?->latitude,
            'longitude' => $jogjaCity?->longitude,
            'is_active' => true,
        ]);

        // Applicant 2: Kab. Sleman (~9.4 km to Kota Jogja, ~0 km to Sleman Tech)
        $a2User = User::create([
            'name' => 'Dian Sastro Wibowo',
            'email' => 'dian@demo.com',
            'password' => Hash::make('password'),
            'role' => 'applicant',
        ]);

        ApplicantProfile::create([
            'user_id' => $a2User->id,
            'photo' => null,
            'education_level' => 'sma',
            'education_institution' => 'SMA Negeri 1 Sleman',
            'field_of_study' => 'IPA',
            'work_experience' => "• Part-time Barista Cafe Sleman (1 tahun)\n• Cashier Resto (6 bulan)",
            'skills' => ['Espresso', 'Latte Art', 'Customer Service', 'Kasir', 'Canva'],
            'contact_email' => 'dian.sastro@gmail.com',
            'city' => 'Kab. Sleman',
            'latitude' => $slemanCity?->latitude,
            'longitude' => $slemanCity?->longitude,
            'is_active' => true,
        ]);

        // Applicant 3: Kab. Bantul (~11.1 km to Kota Jogja, ~19.7 km to Sleman)
        $a3User = User::create([
            'name' => 'Andi Wijaya',
            'email' => 'andi@demo.com',
            'password' => Hash::make('password'),
            'role' => 'applicant',
        ]);

        ApplicantProfile::create([
            'user_id' => $a3User->id,
            'photo' => null,
            'education_level' => 'd3',
            'education_institution' => 'Politeknik Negeri Yogyakarta',
            'field_of_study' => 'Desain Grafis',
            'work_experience' => "• Freelance Content Creator (2 tahun)\n• Designer Poster & Reels Instagram",
            'skills' => ['Canva', 'CapCut', 'Instagram Reels', 'TikTok', 'Figma', 'UI Design'],
            'contact_email' => 'andi.wijaya@gmail.com',
            'city' => 'Kab. Bantul',
            'latitude' => $bantulCity?->latitude,
            'longitude' => $bantulCity?->longitude,
            'is_active' => true,
        ]);

        // Applicant 4: Kab. Klaten (~27.4 km to Sleman, ~27.8 km to Kota Jogja)
        $a4User = User::create([
            'name' => 'Bagus Satria',
            'email' => 'bagus@demo.com',
            'password' => Hash::make('password'),
            'role' => 'applicant',
        ]);

        ApplicantProfile::create([
            'user_id' => $a4User->id,
            'photo' => null,
            'education_level' => 's1',
            'education_institution' => 'Universitas Amikom Yogyakarta',
            'field_of_study' => 'Informatika',
            'work_experience' => "• Junior PHP Developer (1 tahun)\n• Project Web Profile & Portal Berita",
            'skills' => ['Laravel', 'PHP', 'Tailwind CSS', 'Git', 'MySQL'],
            'contact_email' => 'bagus.satria@gmail.com',
            'city' => 'Kab. Klaten',
            'latitude' => $klatenCity?->latitude,
            'longitude' => $klatenCity?->longitude,
            'is_active' => true,
        ]);

        // 4. Create Demo Applications (Lamaran) & Swipe Histories

        // Applications for Job 1: Head Barista (Kopi Lokal - Kota Jogja)
        $applicationsJob1 = [
            ['user' => $a2User, 'status' => 'applied'], // Dian (Sleman -> ~9.4 km)
            ['user' => $a1User, 'status' => 'viewed'],  // Rizky (Kota Jogja -> ~0 km)
        ];

        foreach ($applicationsJob1 as $app) {
            SwipeHistory::create(['user_id' => $app['user']->id, 'job_listing_id' => $j1->id, 'direction' => 'right']);
            Application::create(['user_id' => $app['user']->id, 'job_listing_id' => $j1->id, 'status' => $app['status']]);
        }

        // Applications for Job 2: Staff Social Media (Kopi Lokal - Kota Jogja)
        $applicationsJob2 = [
            ['user' => $a3User, 'status' => 'contacted'], // Andi (Bantul -> ~11.1 km)
            ['user' => $a2User, 'status' => 'applied'],   // Dian (Sleman -> ~9.4 km)
        ];

        foreach ($applicationsJob2 as $app) {
            SwipeHistory::create(['user_id' => $app['user']->id, 'job_listing_id' => $j2->id, 'direction' => 'right']);
            Application::create(['user_id' => $app['user']->id, 'job_listing_id' => $j2->id, 'status' => $app['status']]);
        }

        // Applications for Job 3: Junior Web Developer (Nusantara Tech - Sleman)
        $applicationsJob3 = [
            ['user' => $a1User, 'status' => 'applied'],  // Rizky (Kota Jogja -> ~9.4 km)
            ['user' => $a4User, 'status' => 'contacted'],// Bagus (Klaten -> ~27.4 km)
        ];

        foreach ($applicationsJob3 as $app) {
            SwipeHistory::create(['user_id' => $app['user']->id, 'job_listing_id' => $j3->id, 'direction' => 'right']);
            Application::create(['user_id' => $app['user']->id, 'job_listing_id' => $j3->id, 'status' => $app['status']]);
        }

        // Applications for Job 4: Magang UI/UX (Nusantara Tech - Sleman)
        $applicationsJob4 = [
            ['user' => $a3User, 'status' => 'applied'],  // Andi (Bantul -> ~19.7 km)
        ];

        foreach ($applicationsJob4 as $app) {
            SwipeHistory::create(['user_id' => $app['user']->id, 'job_listing_id' => $j4->id, 'direction' => 'right']);
            Application::create(['user_id' => $app['user']->id, 'job_listing_id' => $j4->id, 'status' => $app['status']]);
        }
    }
}
