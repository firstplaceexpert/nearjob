<?php

namespace App\Livewire\Applicant;

use App\Models\JobListing;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class JobMap extends Component
{
    public string $viewMode = 'map'; // 'map' atau 'list'
    public ?int $selectedJobId = null;
    
    // Search & Filters
    public string $searchQuery = '';
    public string $filterCategory = '';
    public string $filterWorkType = '';
    public int $filterRadius = 25; // km
    public ?int $filterMinSalary = null;

    // Lokasi pengguna (dari profil, default Yogyakarta)
    protected float $userLat = -7.7956;
    protected float $userLon = 110.3695;

    public function selectJob(int $id): void
    {
        $this->selectedJobId = $id;
    }

    public function closeJobDetails(): void
    {
        $this->selectedJobId = null;
    }

    public function resetFilters(): void
    {
        $this->searchQuery = '';
        $this->filterCategory = '';
        $this->filterWorkType = '';
        $this->filterRadius = 25;
        $this->filterMinSalary = null;
        $this->selectedJobId = null;
    }

    public function applyForJob(): void
    {
        if (!$this->selectedJobId) return;

        if (!Auth::check()) {
            $job = JobListing::find($this->selectedJobId);
            $companyName = $job?->company->company_name ?? 'perusahaan';
            $this->dispatch('open-auth-modal', [
                'title' => 'Masuk / Daftar untuk Melamar',
                'subtitle' => 'Masuk atau jawab kuis singkat untuk langsung melamar ke ' . $companyName . '.',
                'jobId' => $this->selectedJobId,
            ]);
            return;
        }

        $user = Auth::user();
        if ($user->isCompany()) {
            $this->dispatch('notify', ['message' => 'Akun pemberi kerja tidak dapat melamar lowongan.', 'type' => 'error']);
            return;
        }

        $profile = $user->applicantProfile;
        $job = JobListing::find($this->selectedJobId);

        if (!$job) return;

        if (!$profile) {
            $this->dispatch('notify', ['message' => 'Lengkapi data profil Anda terlebih dahulu.', 'type' => 'info']);
            $this->redirect(route('applicant.profile'), navigate: true);
            return;
        }

        // Cek apakah sudah pernah melamar
        if (Application::where('user_id', $user->id)->where('job_listing_id', $job->id)->exists()) {
            $this->dispatch('notify', 'Anda sudah melamar pekerjaan ini.');
            return;
        }

        // Cek kredit lamaran
        if ($profile->application_credits <= 0) {
            $this->dispatch('notify', [
                'message' => 'Kuota lamaran habis. Mengalihkan ke isi ulang kuota...',
                'type' => 'error'
            ]);
            $this->redirect(route('applicant.topup'), navigate: true);
            return;
        }

        // Tentukan metode kontak direct (prioritas WhatsApp jika tersedia, atau Email jika hanya ada email)
        $hasWhatsapp = !empty(trim($job->contact_whatsapp ?? ''));
        $hasEmail = !empty(trim($job->contact_email ?? ''));
        $appliedVia = $hasWhatsapp ? 'whatsapp' : ($hasEmail ? 'email' : 'whatsapp');

        // Kurangi kredit & buat lamaran secara atomik
        \Illuminate\Support\Facades\DB::transaction(function () use ($profile, $user, $job, $appliedVia) {
            $profile->decrement('application_credits');

            Application::create([
                'user_id' => $user->id,
                'job_listing_id' => $job->id,
                'status' => 'menunggu',
                'contact_method' => $appliedVia,
                'application_date' => now(),
            ]);
        });

        $this->dispatch('credits-updated', credits: $profile->fresh()->application_credits);

        $edu = strtoupper($profile->education_level ?? 'SMA/SMK');
        $city = $profile->city ?? 'Area Sekitar';
        $companyName = $job->company->company_name;
        $ownerName = $job->company->owner_name ?: 'Bapak/Ibu HRD';

        // Generate pesan WhatsApp / Email yang terstruktur & profesional
        if ($appliedVia === 'whatsapp' && $hasWhatsapp) {
            $message = "Halo Yth. {$ownerName} ({$companyName}),\n\n"
                     . "Perkenalkan saya *{$user->name}* (Domisili: {$city}, Pend. Terakhir: {$edu}).\n"
                     . "Saya menemukan informasi lowongan *{$job->position}* melalui platform *Near Job*.\n\n"
                     . "Saya memiliki minat dan kualifikasi yang sesuai untuk posisi ini. Apakah lowongan masih terbuka untuk proses interview?\n\n"
                     . "Terima kasih atas perhatian dan kesempatannya.\n"
                     . "Salam hormat,\n"
                     . "{$user->name}";

            $waNumber = preg_replace('/[^0-9]/', '', $job->contact_whatsapp);
            if (str_starts_with($waNumber, '0')) {
                $waNumber = '62' . substr($waNumber, 1);
            }
            $url = "https://wa.me/{$waNumber}?text=" . urlencode($message);
            $this->redirect($url);
            return;
        } else {
            $subject = "Lamaran Pekerjaan: {$job->position} - {$user->name}";
            $body = "Yth. {$ownerName} ({$companyName}),\n\n"
                  . "Perkenalkan saya {$user->name} (Domisili: {$city}, Pendidikan Terakhir: {$edu}).\n\n"
                  . "Saya mendapatkan informasi lowongan pekerjaan untuk posisi {$job->position} melalui platform Near Job.\n\n"
                  . "Saya sangat tertarik dan berminat untuk mengisi posisi tersebut. Bersama pesan ini saya mengajukan diri untuk dapat mengikuti tahapan rekrutmen selanjutnya.\n\n"
                  . "Terima kasih atas waktu dan kesempatan yang diberikan.\n\n"
                  . "Hormat saya,\n"
                  . "{$user->name}";
            $url = "mailto:{$job->contact_email}?subject=" . rawurlencode($subject) . "&body=" . rawurlencode($body);
            $this->redirect($url);
            return;
        }
    }

    public function getFilteredJobsProperty()
    {
        $query = JobListing::with('company')->where('status', 'active');

        if ($this->searchQuery) {
            $term = '%' . trim($this->searchQuery) . '%';
            $query->where(function($sub) use ($term) {
                $sub->where('position', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhereHas('company', function($c) use ($term) {
                        $c->where('company_name', 'like', $term)
                          ->orWhere('city', 'like', $term);
                    });
            });
        }

        if ($this->filterCategory) {
            $query->where('job_category', $this->filterCategory);
        }

        if ($this->filterWorkType) {
            $query->where('work_type', $this->filterWorkType);
        }

        if ($this->filterMinSalary) {
            $query->where(function($q) {
                $q->whereNull('salary_min')
                  ->orWhere('salary_min', '>=', $this->filterMinSalary);
            });
        }

        $jobs = $query->get();

        // Calculate distance for each job
        $jobs->each(function ($job) {
            $job->distance = $this->calculateDistance($this->userLat, $this->userLon, $job->latitude, $job->longitude);
        });

        // Filter by radius and sort by distance
        return $jobs->filter(function ($job) {
            return $job->distance <= $this->filterRadius;
        })->sortBy('distance')->values();
    }
    
    public function getSelectedJobProperty()
    {
        if (!$this->selectedJobId) return null;
        return $this->filteredJobs->firstWhere('id', $this->selectedJobId);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        if (!$lat1 || !$lon1 || !$lat2 || !$lon2) return 0;
        
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        
        return round($miles * 1.609344, 1); // convert to kilometers
    }

    public function mount(): void
    {
        $profile = Auth::user()?->applicantProfile;
        if ($profile && $profile->latitude && $profile->longitude) {
            $this->userLat = (float) $profile->latitude;
            $this->userLon = (float) $profile->longitude;
        }
    }

    public function render()
    {
        $jobsMapData = $this->filteredJobs->map(function ($j) {
            return [
                'id' => $j->id,
                'position' => $j->position,
                'latitude' => (float) $j->latitude,
                'longitude' => (float) $j->longitude,
                'quota' => (int) ($j->quota ?: 1),
            ];
        })->values()->all();

        return view('livewire.applicant.job-map', [
            'jobs' => $this->filteredJobs,
            'jobsMapData' => json_encode($jobsMapData),
            'jobsMapDataArray' => $jobsMapData,
            'selectedJob' => $this->selectedJob,
            'categories' => JobListing::jobCategories(),
            'workTypes' => JobListing::workTypes(),
            'userLat' => $this->userLat,
            'userLon' => $this->userLon,
            'credits' => Auth::user()?->applicantProfile?->application_credits ?? 0,
        ])->title('Peta Lowongan — NEAR JOB');
    }
}
