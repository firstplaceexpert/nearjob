<?php

namespace App\Livewire\Company;

use App\Models\Application;
use App\Models\JobListing;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ApplicantList extends Component
{
    public JobListing $jobListing;

    public function mount(JobListing $jobListing): void
    {
        // Verify ownership
        if ($jobListing->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $this->jobListing = $jobListing;
    }

    public function updateStatus(int $applicationId, string $status): void
    {
        $application = Application::where('job_listing_id', $this->jobListing->id)
            ->findOrFail($applicationId);

        $application->update(['status' => $status]);

        $statusLabels = [
            'viewed' => 'ditandai sudah dilihat',
            'contacted' => 'ditandai sudah dikontak',
        ];

        $this->dispatch('notify', message: 'Lamaran ' . ($statusLabels[$status] ?? 'diperbarui') . '.');
    }

    public function markJobFilled(): void
    {
        $this->jobListing->update(['status' => 'filled']);
        $this->dispatch('notify', message: 'Lowongan ditandai sudah terisi.');
    }

    public function render()
    {
        $applications = $this->jobListing
            ->applications()
            ->with('user.applicantProfile')
            ->latest()
            ->paginate(20);

        foreach ($applications as $app) {
            $profile = $app->user?->applicantProfile;
            if ($profile && $profile->latitude && $profile->longitude && $this->jobListing->latitude && $this->jobListing->longitude) {
                $dist = \App\Services\MatchingService::haversineDistance(
                    (float) $profile->latitude,
                    (float) $profile->longitude,
                    (float) $this->jobListing->latitude,
                    (float) $this->jobListing->longitude
                );
                $app->distance_km = round($dist, 1);
            }
        }

        return view('livewire.company.applicant-list', [
            'applications' => $applications,
        ])->title($this->jobListing->position . ' — Pelamar — NearJob');
    }
}
