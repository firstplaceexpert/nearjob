<?php

namespace App\Livewire\Applicant;

use App\Models\Application;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ApplicationHistory extends Component
{
    public function render()
    {
        $applications = Application::where('user_id', auth()->id())
            ->with('jobListing.company')
            ->latest()
            ->paginate(20);

        return view('livewire.applicant.application-history', [
            'applications' => $applications,
        ])->title('Riwayat Lamaran — NearJob');
    }
}
