<?php

namespace App\Livewire\Auth;

use App\Models\City;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class RegisterCompany extends Component
{
    #[Rule('required|string|max:255')]
    public string $name = '';

    #[Rule('required|email|unique:users,email')]
    public string $email = '';

    #[Rule('required|min:8|confirmed')]
    public string $password = '';

    public string $password_confirmation = '';

    #[Rule('required|string|max:255')]
    public string $company_name = '';

    #[Rule('required|string')]
    public string $address = '';

    #[Rule('required|string')]
    public string $city = '';

    #[Rule('required|email')]
    public string $contact_email = '';

    #[Rule('accepted')]
    public bool $agreed_to_terms = false;

    public function register(): void
    {
        $this->validate();

        // Resolve city coordinates
        $cityModel = City::findByName($this->city);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => 'company',
        ]);

        Company::create([
            'user_id' => $user->id,
            'company_name' => $this->company_name,
            'address' => $this->address,
            'city' => $this->city,
            'latitude' => $cityModel?->latitude,
            'longitude' => $cityModel?->longitude,
            'contact_email' => $this->contact_email,
            'agreed_to_terms' => true,
        ]);

        Auth::login($user);

        $this->redirect(route('company.dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register-company', [
            'cities' => City::orderBy('name')->get(),
        ])->title('Daftar Perusahaan — NearJob');
    }
}
