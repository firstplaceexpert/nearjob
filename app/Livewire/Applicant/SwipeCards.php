<?php

namespace App\Livewire\Applicant;

use App\Models\Application;
use App\Models\SwipeHistory;
use App\Services\MatchingService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class SwipeCards extends Component
{
    public array $jobs = [];
    public int $currentIndex = 0;
    public bool $profileComplete = false;
    public bool $noMoreJobs = false;

    public function mount(MatchingService $matchingService): void
    {
        $user = auth()->user();
        $profile = $user->applicantProfile;

        $this->profileComplete = $profile && $profile->isComplete();

        if (!$this->profileComplete) {
            return;
        }

        if (!$profile->is_active) {
            return;
        }

        $this->loadJobs($matchingService);
    }

    public function loadJobs(?MatchingService $matchingService = null): void
    {
        $matchingService = $matchingService ?? new MatchingService();
        $matched = $matchingService->getMatchingJobs(auth()->user(), 15);

        $this->jobs = $matched->map(function ($job) {
            return [
                'id' => $job->id,
                'position' => $job->position,
                'company_name' => $job->company->company_name,
                'city' => $job->city,
                'work_type' => $job->work_type_label,
                'job_category' => $job->category_label,
                'description' => \Illuminate\Support\Str::limit($job->description, 200),
                'qualifications' => \Illuminate\Support\Str::limit($job->qualifications, 150),
                'required_skills' => $job->required_skills ?? [],
                'distance_km' => $job->distance_km ?? null,
                'min_education' => \App\Models\ApplicantProfile::educationLevels()[$job->min_education] ?? '',
            ];
        })->toArray();

        $this->currentIndex = 0;
        $this->noMoreJobs = empty($this->jobs);
    }

    public function swipe(int $jobId, string $direction): void
    {
        // Record swipe history
        SwipeHistory::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'job_listing_id' => $jobId,
            ],
            ['direction' => $direction]
        );

        // If swiped right, create application
        if ($direction === 'right') {
            Application::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'job_listing_id' => $jobId,
                ],
                ['status' => 'applied']
            );

            $this->dispatch('notify', message: 'Lamaran terkirim! 🎉');
        }

        // Move to next card
        $this->currentIndex++;

        // If we've gone through all loaded jobs, try to load more
        if ($this->currentIndex >= count($this->jobs)) {
            $this->loadJobs();
        }
    }

    public function render()
    {
        $currentJob = $this->jobs[$this->currentIndex] ?? null;
        $nextJob = $this->jobs[$this->currentIndex + 1] ?? null;

        return view('livewire.applicant.swipe-cards', [
            'currentJob' => $currentJob,
            'nextJob' => $nextJob,
        ])->title('Swipe Lowongan — NearJob');
    }
}
