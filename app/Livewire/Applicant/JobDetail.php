<?php

namespace App\Livewire\Applicant;

use App\Models\JobListing;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class JobDetail extends Component
{
    public JobListing $job;

    public function mount(JobListing $jobListing)
    {
        $this->job = $jobListing;
        
        // Calculate distance from default Banyuwangi center
        $this->job->distance = $this->calculateDistance(-8.2192, 114.3692, $this->job->latitude, $this->job->longitude);
    }

    public function applyForJob(): void
    {
        if (!Auth::check()) {
            $companyName = $this->job->company->company_name ?? 'perusahaan';
            $this->dispatch('open-auth-modal', [
                'title' => 'Masuk / Daftar untuk Melamar',
                'subtitle' => 'Masuk atau jawab kuis singkat untuk langsung melamar ke ' . $companyName . '.',
                'jobId' => $this->job->id,
            ]);
            return;
        }

        $user = Auth::user();
        if ($user->isCompany()) {
            $this->dispatch('notify', ['message' => 'Akun pemberi kerja tidak dapat melamar lowongan.', 'type' => 'error']);
            return;
        }

        $profile = $user->applicantProfile;
        if (!$profile) {
            $this->dispatch('notify', ['message' => 'Lengkapi data profil Anda terlebih dahulu.', 'type' => 'info']);
            $this->redirect(route('applicant.profile'), navigate: true);
            return;
        }

        // Cek apakah sudah pernah melamar
        if (Application::where('user_id', $user->id)->where('job_listing_id', $this->job->id)->exists()) {
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
        $hasWhatsapp = !empty(trim($this->job->contact_whatsapp ?? ''));
        $hasEmail = !empty(trim($this->job->contact_email ?? ''));
        $appliedVia = $hasWhatsapp ? 'whatsapp' : ($hasEmail ? 'email' : 'whatsapp');

        // Kurangi kredit & buat lamaran secara atomik
        \Illuminate\Support\Facades\DB::transaction(function () use ($profile, $user, $appliedVia) {
            $profile->decrement('application_credits');

            Application::create([
                'user_id' => $user->id,
                'job_listing_id' => $this->job->id,
                'status' => 'menunggu',
                'contact_method' => $appliedVia,
                'application_date' => now(),
            ]);
        });

        $this->dispatch('credits-updated', credits: $profile->fresh()->application_credits);

        $edu = strtoupper($profile->education_level ?? 'SMA/SMK');
        $city = $profile->city ?? 'Area Sekitar';
        $companyName = $this->job->company->company_name;
        $ownerName = $this->job->company->owner_name ?: 'Bapak/Ibu HRD';

        // Generate pesan WhatsApp / Email yang terstruktur & profesional
        if ($appliedVia === 'whatsapp' && $hasWhatsapp) {
            $message = "Halo Yth. {$ownerName} ({$companyName}),\n\n"
                     . "Perkenalkan saya *{$user->name}* (Domisili: {$city}, Pend. Terakhir: {$edu}).\n"
                     . "Saya menemukan informasi lowongan *{$this->job->position}* melalui platform *Near Job*.\n\n"
                     . "Saya memiliki minat dan kualifikasi yang sesuai untuk posisi ini. Apakah lowongan masih terbuka untuk proses interview?\n\n"
                     . "Terima kasih atas perhatian dan kesempatannya.\n"
                     . "Salam hormat,\n"
                     . "{$user->name}";

            $waNumber = preg_replace('/[^0-9]/', '', $this->job->contact_whatsapp);
            if (str_starts_with($waNumber, '0')) {
                $waNumber = '62' . substr($waNumber, 1);
            }
            $url = "https://wa.me/{$waNumber}?text=" . urlencode($message);
            $this->redirect($url);
            return;
        } else {
            $subject = "Lamaran Pekerjaan: {$this->job->position} - {$user->name}";
            $body = "Yth. {$ownerName} ({$companyName}),\n\n"
                  . "Perkenalkan saya {$user->name} (Domisili: {$city}, Pendidikan Terakhir: {$edu}).\n\n"
                  . "Saya mendapatkan informasi lowongan pekerjaan untuk posisi {$this->job->position} melalui platform Near Job.\n\n"
                  . "Saya sangat tertarik dan berminat untuk mengisi posisi tersebut. Bersama pesan ini saya mengajukan diri untuk dapat mengikuti tahapan rekrutmen selanjutnya.\n\n"
                  . "Terima kasih atas waktu dan kesempatan yang diberikan.\n\n"
                  . "Hormat saya,\n"
                  . "{$user->name}";
            $url = "mailto:{$this->job->contact_email}?subject=" . rawurlencode($subject) . "&body=" . rawurlencode($body);
            $this->redirect($url);
            return;
        }
    }
    
    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        if (!$lat1 || !$lon1 || !$lat2 || !$lon2) return 0;
        
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        
        return round($miles * 1.609344, 1);
    }

    public function render()
    {
        $hasApplied = Auth::check() ? Application::where('user_id', Auth::id())->where('job_listing_id', $this->job->id)->exists() : false;
        $credits = Auth::user()?->applicantProfile?->application_credits ?? 0;
        
        return view('livewire.applicant.job-detail', compact('hasApplied', 'credits'))
            ->title($this->job->position . ' — ' . $this->job->company->company_name);
    }
}
