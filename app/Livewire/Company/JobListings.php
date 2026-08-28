<?php

namespace App\Livewire\Company;

use App\Models\JobListing;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class JobListings extends Component
{
    public function markAsFilled(int $jobId): void
    {
        $job = JobListing::where('company_id', auth()->user()->company->id)
            ->findOrFail($jobId);

        $job->update(['status' => $job->status === 'filled' ? 'active' : 'filled']);

        $this->dispatch('notify', message: $job->status === 'filled'
            ? 'Lowongan ditandai sudah terisi.'
            : 'Lowongan diaktifkan kembali.');
    }

    public function render()
    {
        $jobs = auth()->user()->company
            ->jobListings()
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('livewire.company.job-listings', [
            'jobs' => $jobs,
        ])->title('Lowongan Saya — NearJob');
    }
}
