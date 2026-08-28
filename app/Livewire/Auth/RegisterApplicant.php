<?php

namespace App\Livewire\Auth;

use App\Models\ApplicantProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class RegisterApplicant extends Component
{
    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|email|unique:users,email')]
    public string $email = '';

    #[Rule('required|min:8|confirmed')]
    public string $password = '';

    public string $password_confirmation = '';

    public function register(): void
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => 'applicant',
        ]);

        // Create empty profile with contact email
        ApplicantProfile::create([
            'user_id' => $user->id,
            'contact_email' => $this->email,
        ]);

        Auth::login($user);

        $this->redirect(route('applicant.profile'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register-applicant')
            ->title('Daftar Pencari Kerja — NearJob');
    }
}
