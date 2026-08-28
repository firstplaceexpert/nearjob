<?php

namespace App\Livewire\Company;

use App\Models\Application;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $company = auth()->user()->company;
        $jobIds = $company->jobListings()->pluck('id');

        $stats = [
            'total_jobs' => $company->jobListings()->count(),
            'active_jobs' => $company->activeJobListings()->count(),
            'total_applications' => Application::whereIn('job_listing_id', $jobIds)->count(),
            'unviewed_applications' => Application::whereIn('job_listing_id', $jobIds)
                ->where('status', 'applied')
                ->count(),
        ];

        $recentApplications = Application::whereIn('job_listing_id', $jobIds)
            ->with(['user.applicantProfile', 'jobListing'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.company.dashboard', [
            'stats' => $stats,
            'recentApplications' => $recentApplications,
            'company' => $company,
        ])->title('Dashboard — NearJob');
    }
}
