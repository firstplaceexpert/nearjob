<?php

namespace App\Livewire\Company;

use App\Models\City;
use App\Models\JobListing;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.app')]
class JobListingForm extends Component
{
    public ?JobListing $jobListing = null;
    public bool $isEditing = false;

    #[Rule('required|string|max:255')]
    public string $position = '';

    #[Rule('required|string|min:20')]
    public string $description = '';

    #[Rule('required|string|min:10')]
    public string $qualifications = '';

    #[Rule('required|string')]
    public string $city = '';

    #[Rule('required|in:full_time,part_time,internship')]
    public string $work_type = 'full_time';

    #[Rule('required|string')]
    public string $job_category = 'lainnya';

    public array $required_skills = [];
    public string $newSkill = '';

    #[Rule('required|in:sma,d3,s1,s2,s3')]
    public string $min_education = 'sma';

    #[Rule('required|integer|min:5|max:100')]
    public int $radius_km = 25;

    public function mount(?JobListing $jobListing = null): void
    {
        if ($jobListing && $jobListing->exists) {
            // Verify ownership
            if ($jobListing->company_id !== auth()->user()->company->id) {
                abort(403);
            }

            $this->jobListing = $jobListing;
            $this->isEditing = true;
            $this->position = $jobListing->position;
            $this->description = $jobListing->description;
            $this->qualifications = $jobListing->qualifications;
            $this->city = $jobListing->city;
            $this->work_type = $jobListing->work_type;
            $this->job_category = $jobListing->job_category;
            $this->required_skills = $jobListing->required_skills ?? [];
            $this->min_education = $jobListing->min_education;
            $this->radius_km = $jobListing->radius_km;
        }
    }

    public function addSkill(): void
    {
        $skill = trim($this->newSkill);
        if ($skill && !in_array($skill, $this->required_skills)) {
            $this->required_skills[] = $skill;
        }
        $this->newSkill = '';
    }

    public function removeSkill(int $index): void
    {
        unset($this->required_skills[$index]);
        $this->required_skills = array_values($this->required_skills);
    }

    public function save(): void
    {
        $this->validate();

        $cityModel = City::findByName($this->city);
        $company = auth()->user()->company;

        $data = [
            'company_id' => $company->id,
            'position' => $this->position,
            'description' => $this->description,
            'qualifications' => $this->qualifications,
            'city' => $this->city,
            'latitude' => $cityModel?->latitude,
            'longitude' => $cityModel?->longitude,
            'work_type' => $this->work_type,
            'job_category' => $this->job_category,
            'required_skills' => $this->required_skills,
            'min_education' => $this->min_education,
            'radius_km' => $this->radius_km,
        ];

        if ($this->isEditing && $this->jobListing) {
            $this->jobListing->update($data);
        } else {
            JobListing::create($data);
        }

        $this->redirect(route('company.jobs'), navigate: true);
    }

    public function render()
    {
        return view('livewire.company.job-listing-form', [
            'cities' => City::orderBy('name')->get(),
            'workTypes' => JobListing::workTypes(),
            'jobCategories' => JobListing::jobCategories(),
            'educationLevels' => \App\Models\ApplicantProfile::educationLevels(),
        ])->title(($this->isEditing ? 'Edit' : 'Buat') . ' Lowongan — NearJob');
    }
}
