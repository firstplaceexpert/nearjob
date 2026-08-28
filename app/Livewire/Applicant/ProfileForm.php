<?php

namespace App\Livewire\Applicant;

use App\Models\ApplicantProfile;
use App\Models\City;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
class ProfileForm extends Component
{
    use WithFileUploads;

    public $photo;
    public ?string $existing_photo = null;

    #[Rule('nullable|string')]
    public ?string $education_level = null;

    #[Rule('nullable|string|max:255')]
    public ?string $education_institution = null;

    #[Rule('nullable|string|max:255')]
    public ?string $field_of_study = null;

    #[Rule('nullable|string')]
    public ?string $work_experience = null;

    public array $skills = [];
    public string $newSkill = '';

    #[Rule('required|email')]
    public string $contact_email = '';

    #[Rule('required|string')]
    public string $city = '';

    public bool $is_active = true;

    public function mount(): void
    {
        $profile = auth()->user()->applicantProfile;

        if ($profile) {
            $this->existing_photo = $profile->photo;
            $this->education_level = $profile->education_level;
            $this->education_institution = $profile->education_institution;
            $this->field_of_study = $profile->field_of_study;
            $this->work_experience = $profile->work_experience;
            $this->skills = $profile->skills ?? [];
            $this->contact_email = $profile->contact_email ?? auth()->user()->email;
            $this->city = $profile->city ?? '';
            $this->is_active = $profile->is_active;
        } else {
            $this->contact_email = auth()->user()->email;
        }
    }

    public function addSkill(): void
    {
        $skill = trim($this->newSkill);
        if ($skill && !in_array($skill, $this->skills)) {
            $this->skills[] = $skill;
        }
        $this->newSkill = '';
    }

    public function removeSkill(int $index): void
    {
        unset($this->skills[$index]);
        $this->skills = array_values($this->skills);
    }

    public function toggleActive(): void
    {
        $this->is_active = !$this->is_active;
        $profile = auth()->user()->applicantProfile;
        if ($profile) {
            $profile->update(['is_active' => $this->is_active]);
        }

        $this->dispatch('notify', message: $this->is_active
            ? 'Profil diaktifkan kembali!'
            : 'Profil dinonaktifkan. Anda tidak akan muncul di pencarian.');
    }

    public function save(): void
    {
        $this->validate([
            'photo' => 'nullable|image|max:2048',
            'education_level' => 'required|in:sma,d3,s1,s2,s3',
            'education_institution' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'city' => 'required|string',
        ]);

        $profile = auth()->user()->applicantProfile ?? new ApplicantProfile(['user_id' => auth()->id()]);

        // Handle photo upload
        if ($this->photo) {
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            $profile->photo = $this->photo->store('photos', 'public');
            $this->existing_photo = $profile->photo;
        }

        // Resolve city coordinates
        $cityModel = City::findByName($this->city);

        $profile->fill([
            'education_level' => $this->education_level,
            'education_institution' => $this->education_institution,
            'field_of_study' => $this->field_of_study,
            'work_experience' => $this->work_experience,
            'skills' => $this->skills,
            'contact_email' => $this->contact_email,
            'city' => $this->city,
            'latitude' => $cityModel?->latitude,
            'longitude' => $cityModel?->longitude,
            'is_active' => $this->is_active,
        ]);

        $profile->save();

        $this->dispatch('notify', message: 'Profil berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.applicant.profile-form', [
            'educationLevels' => ApplicantProfile::educationLevels(),
            'cities' => City::orderBy('name')->get(),
        ])->title('Profil Saya — NearJob');
    }
}
