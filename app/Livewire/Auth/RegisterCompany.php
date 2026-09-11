<?php

namespace App\Livewire\Auth;

use App\Models\City;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\KtpWatermarkService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.guest', ['hideHeader' => true])]
class RegisterCompany extends Component
{
    use WithFileUploads;

    public string $mode = 'register'; // 'register' atau 'login'

    // Form Buat Akun Perusahaan (SEEK style)
    public string $company_name = '';
    public string $country = 'Indonesia';
    public string $city = 'Yogyakarta';
    public string $phone_code = '+62';
    public string $phone_number = '';
    public string $email = '';
    public string $first_name = '';
    public string $last_name = '';
    public string $nik = '';
    public $ktp_file = null;
    public string $nikError = '';
    public string $password = '';
    public string $business_field = 'retail';
    public bool $showPassword = false;

    // Form Masuk Perusahaan (SEEK style)
    public string $login_email = '';
    public string $login_password = '';
    public bool $login_show_password = false;
    public string $login_error = '';

    public function mount(): void
    {
        if (request()->query('mode') === 'login' || request()->routeIs('login.company')) {
            $this->mode = 'login';
        } else {
            $this->mode = 'register';
        }
    }

    public function setMode(string $newMode): void
    {
        $this->mode = $newMode;
        $this->resetErrorBag();
        $this->login_error = '';
    }

    public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    public function toggleLoginPassword(): void
    {
        $this->login_show_password = !$this->login_show_password;
    }

    public function updatedPhoneNumber($value): void
    {
        $this->phone_number = preg_replace('/[^0-9]/', '', (string)$value);
    }

    public function updatedNik($value): void
    {
        $this->nik = preg_replace('/[^0-9]/', '', (string)$value);
        $this->nikError = '';
    }

    public function register(): void
    {
        $this->nik = preg_replace('/[^0-9]/', '', (string)$this->nik);
        $this->phone_number = preg_replace('/[^0-9]/', '', (string)$this->phone_number);
        if (str_starts_with($this->phone_number, '0')) {
            $this->phone_number = substr($this->phone_number, 1);
        }

        $this->validate([
            'company_name'   => 'required|string|max:255',
            'country'        => 'required|string',
            'city'           => 'required|string',
            'phone_number'   => 'required|numeric|min_digits:8|max_digits:14',
            'email'          => 'required|email|unique:users,email',
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'nullable|string|max:100',
            'nik'            => 'required|digits:16',
            'ktp_file'       => 'nullable|image|max:6144',
            'password'       => 'required|min:6',
            'business_field' => 'nullable|string',
        ], [
            'company_name.required'   => 'Wajib diisi',
            'phone_number.required'   => 'Wajib diisi',
            'phone_number.min_digits' => 'Nomor telepon minimal 8 digit.',
            'email.required'          => 'Wajib diisi',
            'email.email'             => 'Format alamat email tidak valid.',
            'email.unique'            => 'Email ini sudah terdaftar sebagai akun perusahaan.',
            'first_name.required'     => 'Wajib diisi',
            'nik.required'            => 'NIK pemilik usaha wajib diisi.',
            'nik.digits'              => 'NIK harus berupa 16 digit angka.',
            'ktp_file.image'          => 'File KTP harus berupa gambar (JPG, PNG, WEBP).',
            'ktp_file.max'            => 'Ukuran foto KTP maksimal 6MB.',
            'password.required'       => 'Wajib diisi',
            'password.min'            => 'Kata sandi minimal 6 karakter.',
        ]);

        // Cek NIK unik
        if (User::where('nik', $this->nik)->exists()) {
            $this->addError('nik', 'NIK ini sudah terdaftar. Silakan masuk menggunakan akun yang sudah ada.');
            return;
        }

        $fullName = trim($this->first_name . ' ' . $this->last_name);
        $fullPhone = '0' . $this->phone_number;

        // Proses Watermark KTP jika diunggah
        $ktpPath = null;
        $isVerified = false;
        if ($this->ktp_file) {
            $ktpPath = KtpWatermarkService::processAndSave($this->ktp_file, $fullName);
            $isVerified = true;
        }

        $user = User::create([
            'name'        => $fullName,
            'email'       => $this->email,
            'password'    => Hash::make($this->password),
            'role'        => 'company',
            'nik'         => $this->nik,
            'whatsapp'    => $fullPhone,
            'is_verified' => $isVerified,
        ]);

        Company::create([
            'user_id'        => $user->id,
            'owner_name'     => $fullName,
            'nik'            => $this->nik,
            'whatsapp'       => $fullPhone,
            'company_name'   => $this->company_name,
            'business_field' => $this->business_field ?: 'retail',
            'ktp_path'       => $ktpPath,
            'is_verified'    => $isVerified,
            'address'        => $this->city . ', ' . $this->country,
            'city'           => $this->city ?: 'Yogyakarta',
            'contact_email'  => $this->email,
            'contact_method' => 'whatsapp',
            'agreed_to_terms'=> true,
        ]);

        Auth::login($user);
        session()->regenerate();
        $this->redirect(route('company.dashboard'), navigate: true);
    }

    public function companyLogin(): void
    {
        $this->login_error = '';
        $this->validate([
            'login_email'    => 'required|email',
            'login_password' => 'required',
        ], [
            'login_email.required'    => 'Wajib diisi',
            'login_email.email'       => 'Format alamat email tidak valid.',
            'login_password.required' => 'Wajib diisi',
        ]);

        if (Auth::attempt(['email' => $this->login_email, 'password' => $this->login_password])) {
            session()->regenerate();
            $user = Auth::user();
            if ($user->isCompany()) {
                $this->redirect(route('company.dashboard'), navigate: true);
            } else {
                $this->redirect(route('applicant.map'), navigate: true);
            }
            return;
        }

        $this->login_error = 'Permintaan login tidak valid dan tidak dapat diselesaikan demi keamanan Anda. Silakan coba lagi.';
    }

    public function render()
    {
        return view('livewire.auth.register-company', [
            'cities'     => City::orderBy('name')->get(),
            'categories' => JobListing::jobCategories(),
        ])->title($this->mode === 'login' ? 'Masuk Perusahaan — NEAR JOB' : 'Buat Akun Perusahaan — NEAR JOB');
    }
}
