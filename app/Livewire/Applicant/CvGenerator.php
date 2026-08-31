<?php

namespace App\Livewire\Applicant;

use App\Models\ApplicantProfile;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class CvGenerator extends Component
{
    public bool $isPaid = false;
    public ApplicantProfile $profile;
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->profile = $this->user->applicantProfile;
        
        if ($this->profile->cv_generated) {
            $this->isPaid = true;
        }
    }

    public function processPayment()
    {
        // Mock payment process
        sleep(1);
        
        $this->profile->update([
            'cv_generated' => true,
            'cv_data' => [
                'generated_at' => now()->toIso8601String(),
                'version' => 1
            ]
        ]);
        
        $this->isPaid = true;
        $this->dispatch('notify', 'Pembayaran berhasil! CV ATS Anda sudah siap.');
    }

    public function render()
    {
        return view('livewire.applicant.cv-generator')->title('Generator CV ATS — NEAR JOB');
    }
}
