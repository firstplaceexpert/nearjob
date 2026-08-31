<?php

namespace App\Livewire\Applicant;

use App\Models\ApplicantProfile;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ProfileForm extends Component
{
    public ApplicantProfile $profile;

    // Form fields
    public string $name = '';
    public string $whatsapp = '';
    public string $email = '';
    public string $city = '';
    public string $education_level = '';
    public string $education_institution = '';
    public string $field_of_study = '';
    public string $work_experience = '';
    public string $salary_expectation = '';
    
    public array $skills = [];
    public string $newSkill = '';

    public function mount()
    {
        $user = Auth::user();
        $this->profile = $user->applicantProfile ?? new ApplicantProfile();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->whatsapp = $this->profile->whatsapp ?? $user->whatsapp ?? '';
        $this->city = $this->profile->city ?? '';
        $this->education_level = $this->profile->education_level ?? 'sma';
        $this->education_institution = $this->profile->education_institution ?? '';
        $this->field_of_study = $this->profile->field_of_study ?? '';
        $this->work_experience = $this->profile->work_experience ?? '';
        $this->salary_expectation = $this->profile->salary_expectation ?? '';
        $this->skills = $this->profile->skills ?? [];
    }

    public function addSkill(): void
    {
        $s = trim($this->newSkill);
        if ($s && !in_array($s, $this->skills)) {
            $this->skills[] = $s;
        }
        $this->newSkill = '';
    }

    public function removeSkill(int $i): void
    {
        unset($this->skills[$i]);
        $this->skills = array_values($this->skills);
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string',
            'city' => 'required|string',
            'education_level' => 'required|string',
            'education_institution' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $this->name,
            'whatsapp' => $this->whatsapp,
        ]);

        $this->profile->update([
            'whatsapp' => $this->whatsapp,
            'city' => $this->city,
            'education_level' => $this->education_level,
            'education_institution' => $this->education_institution,
            'field_of_study' => $this->field_of_study,
            'work_experience' => $this->work_experience,
            'salary_expectation' => $this->salary_expectation,
            'skills' => $this->skills,
        ]);

        $this->dispatch('notify', 'Profil berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.applicant.profile-form', [
            'cities' => City::orderBy('name')->get(),
            'educationLevels' => ApplicantProfile::educationLevels(),
            'credits' => $this->profile->application_credits ?? 0,
            'cv_generated' => $this->profile->cv_generated ?? false,
        ])->title('Profil Pelamar — NEAR JOB');
    }
}
