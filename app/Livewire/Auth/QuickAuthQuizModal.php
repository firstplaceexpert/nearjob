<?php

namespace App\Livewire\Auth;

use App\Models\ApplicantProfile;
use App\Models\City;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class QuickAuthQuizModal extends Component
{
    public bool $isOpen = false;
    public string $title = 'Temukan Pekerjaan di Sekitarmu';
    public string $subtitle = 'Masuk untuk melihat rincian gaji, kuota lowongan, dan langsung terhubung dengan perusahaan.';
    public ?int $targetJobId = null;

    // Steps: 'welcome', 'email', 'login', 'quiz_interest', 'quiz_location', 'quiz_profile'
    public string $step = 'welcome';

    // Form inputs
    public string $email = '';
    public string $password = '';
    public bool $isExistingUser = false;
    public string $existingUserName = '';
    public ?string $googleAvatar = null;

    // Quiz Data
    public array $selectedCategories = [];
    public string $city = 'Yogyakarta';
    public string $education_level = 'sma';
    public string $work_experience = 'fresh_graduate';
    public string $name = '';
    public string $nik = '';
    public string $whatsapp = '';

    public string $errorMessage = '';

    public function mount(): void
    {
        // 1. Cek apakah ada redirect dari Google OAuth baru atau query param onboarding kuis
        if (request()->query('onboarding') === 'google' || session()->has('pending_google_auth')) {
            $googleData = session('pending_google_auth', []);
            $this->email = $googleData['email'] ?? request()->query('email', '');
            $this->name = $googleData['name'] ?? request()->query('name', '');
            $this->googleAvatar = $googleData['avatar'] ?? null;
            $this->isOpen = true;
            $this->step = 'quiz_interest';
            return;
        }

        // 2. Otomatis buka modal saat pertama kali pengunjung (guest) membuka beranda
        if (!Auth::check() && !request()->routeIs('login') && !request()->routeIs('register*')) {
            $this->isOpen = true;
            $this->step = 'welcome';
        }
    }

    #[On('open-auth-modal')]
    #[On('open-quick-auth-modal')]
    public function openModal($payload = []): void
    {
        if (is_array($payload)) {
            $this->title = $payload['title'] ?? 'Temukan Pekerjaan di Sekitarmu';
            $this->subtitle = $payload['subtitle'] ?? 'Masuk untuk melihat rincian gaji, kuota lowongan, dan langsung terhubung dengan perusahaan.';
            $this->targetJobId = $payload['jobId'] ?? $payload['job_id'] ?? null;
        }

        $this->isOpen = true;
        $this->errorMessage = '';
        if ($this->step !== 'login' && !str_starts_with($this->step, 'quiz_')) {
            $this->step = 'welcome';
        }
    }

    public function closeModal(): void
    {
        $this->isOpen = false;
        $this->errorMessage = '';
    }

    public function startEmailFlow(): void
    {
        $this->step = 'email';
        $this->errorMessage = '';
    }

    public function goBackToWelcome(): void
    {
        session()->forget('pending_google_auth');
        $this->step = 'welcome';
        $this->errorMessage = '';
    }

    public function goBackFromQuizInterest(): void
    {
        $this->errorMessage = '';
        if (session()->has('pending_google_auth') || request()->query('onboarding') === 'google' || empty($this->password)) {
            $this->goBackToWelcome();
        } else {
            $this->step = 'email';
        }
    }

    public function checkEmail(): void
    {
        $this->errorMessage = '';
        $this->email = trim(strtolower($this->email));

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errorMessage = 'Silakan masukkan format Gmail / Email yang valid.';
            return;
        }

        $user = User::where('email', $this->email)->first();

        if ($user) {
            // Email sudah terdaftar -> minta password login
            $this->isExistingUser = true;
            $this->existingUserName = $user->name;
            $this->step = 'login';
        } else {
            // Email BELUM terdaftar -> WAJIB masuk ke kuis onboarding!
            $this->isExistingUser = false;
            $namePart = explode('@', $this->email)[0];
            $this->name = ucwords(str_replace(['.', '_', '-'], ' ', $namePart));
            $this->step = 'quiz_interest';
        }
    }

    public function toggleCategory(string $cat): void
    {
        if (in_array($cat, $this->selectedCategories)) {
            $this->selectedCategories = array_values(array_diff($this->selectedCategories, [$cat]));
        } else {
            $this->selectedCategories[] = $cat;
        }
    }

    public function goToLocationStep(): void
    {
        $this->errorMessage = '';
        if (empty($this->selectedCategories)) {
            $this->errorMessage = 'Pilih minimal 1 bidang pekerjaan yang Anda minati.';
            return;
        }
        $this->step = 'quiz_location';
    }

    public function goToProfileStep(): void
    {
        $this->errorMessage = '';
        if (empty(trim($this->city))) {
            $this->errorMessage = 'Silakan pilih kota domisili Anda.';
            return;
        }
        $this->step = 'quiz_profile';
    }

    public function login(): void
    {
        $this->errorMessage = '';

        if (empty($this->password)) {
            $this->errorMessage = 'Kata sandi wajib diisi.';
            return;
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            $this->isOpen = false;
            $this->dispatch('notify', [
                'message' => 'Selamat datang kembali, ' . Auth::user()->name . '!',
                'type' => 'success'
            ]);

            $this->finishAuthFlow();
            return;
        }

        $this->errorMessage = 'Kata sandi salah. Silakan coba lagi.';
    }

    public function completeRegistration(): void
    {
        $this->errorMessage = '';

        if (empty(trim($this->name))) {
            $this->errorMessage = 'Nama lengkap wajib diisi.';
            return;
        }

        $cleanNik = preg_replace('/[^0-9]/', '', $this->nik);
        if (empty($cleanNik) || strlen($cleanNik) !== 16) {
            $this->errorMessage = 'NIK wajib 16 digit angka sesuai KTP.';
            return;
        }

        if (User::where('nik', $cleanNik)->exists()) {
            $this->errorMessage = 'NIK ' . $cleanNik . ' sudah terdaftar pada akun lain. 1 NIK hanya berlaku untuk 1 akun.';
            return;
        }

        // Jika login via Google OAuth, password bisa auto-generated jika tidak diisi
        $finalPassword = $this->password ?: Str::random(16);

        if (strlen($finalPassword) < 6) {
            $this->errorMessage = 'Kata sandi minimal 6 karakter.';
            return;
        }

        $user = User::create([
            'name'     => trim($this->name),
            'email'    => $this->email,
            'nik'      => $cleanNik,
            'password' => Hash::make($finalPassword),
            'role'     => 'applicant',
            'whatsapp' => preg_replace('/[^0-9]/', '', $this->whatsapp),
        ]);

        $selectedLabels = array_map(function ($k) {
            return JobListing::jobCategories()[$k] ?? $k;
        }, $this->selectedCategories);

        ApplicantProfile::create([
            'user_id'               => $user->id,
            'photo'                 => $this->googleAvatar ?: null,
            'whatsapp'              => $user->whatsapp,
            'education_level'       => $this->education_level ?: 'sma',
            'education_institution' => 'Umum / SMK / Universitas',
            'field_of_study'        => implode(', ', $selectedLabels),
            'work_experience'       => $this->work_experience,
            'skills'                => $selectedLabels,
            'contact_email'         => $this->email,
            'city'                  => $this->city ?: 'Yogyakarta',
            'is_active'             => true,
            'application_credits'   => 3,
        ]);

        // Bersihkan sesi Google sementara jika ada
        session()->forget('pending_google_auth');

        Auth::login($user, true);
        session()->regenerate();

        $this->isOpen = false;
        $this->dispatch('notify', [
            'message' => 'Akun berhasil dibuat! Anda mendapatkan 3 kuota lamaran gratis.',
            'type' => 'success'
        ]);

        $this->finishAuthFlow();
    }

    protected function finishAuthFlow(): void
    {
        if ($this->targetJobId) {
            $this->redirect(route('applicant.job.detail', $this->targetJobId), navigate: true);
        } else {
            $this->redirect(route('applicant.map'), navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.auth.quick-auth-quiz-modal', [
            'categories'      => JobListing::jobCategories(),
            'cities'          => City::orderBy('name')->get(),
            'educationLevels' => ApplicantProfile::educationLevels(),
        ]);
    }
}
