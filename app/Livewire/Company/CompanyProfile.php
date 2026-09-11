<?php

namespace App\Livewire\Company;

use App\Models\City;
use App\Models\JobListing;
use App\Services\KtpWatermarkService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
class CompanyProfile extends Component
{
    use WithFileUploads;

    public $company;

    public string $owner_name = '';
    public string $masked_nik = '';
    public string $whatsapp = '';
    public string $company_name = '';
    public string $business_field = '';
    public string $nib = '';
    public string $address = '';
    public string $city = '';
    public string $contact_method = '';
    public $ktp_file = null;

    public function mount()
    {
        $this->company = Auth::user()->company;
        
        $this->owner_name = $this->company->owner_name ?? '';
        $this->masked_nik = $this->company->masked_nik ?? '-';
        $this->whatsapp = $this->company->whatsapp ?? '';
        $this->company_name = $this->company->company_name ?? '';
        $this->business_field = $this->company->business_field ?? '';
        $this->nib = $this->company->nib ?? '';
        $this->address = $this->company->address ?? '';
        $this->city = $this->company->city ?? '';
        $this->contact_method = $this->company->contact_method ?? 'whatsapp';
    }

    public function updatedKtpFile(): void
    {
        $this->validate([
            'ktp_file' => 'image|max:6144',
        ], [
            'ktp_file.image' => 'File KTP harus berupa gambar (JPG, PNG, WEBP).',
            'ktp_file.max'   => 'Ukuran foto KTP maksimal 6MB.',
        ]);

        $path = KtpWatermarkService::processAndSave($this->ktp_file, $this->owner_name);

        $this->company->update([
            'ktp_path'    => $path,
            'is_verified' => true,
        ]);

        $this->company->user->update([
            'is_verified' => true,
        ]);

        $this->ktp_file = null;
        $this->company->refresh();

        $this->dispatch('notify', [
            'message' => 'KTP berhasil diverifikasi dan disimpan dengan watermark resmi NEAR JOB!',
            'type'    => 'success',
        ]);
    }

    public function updatedWhatsapp($value): void
    {
        $this->whatsapp = preg_replace('/[^0-9]/', '', (string)$value);
    }

    public function updatedNib($value): void
    {
        $this->nib = preg_replace('/[^0-9]/', '', (string)$value);
    }

    public function save()
    {
        $this->whatsapp = preg_replace('/[^0-9]/', '', $this->whatsapp);
        $this->nib = preg_replace('/[^0-9]/', '', $this->nib);

        $this->validate([
            'owner_name'    => 'required|string|max:255',
            'whatsapp'      => 'required|regex:/^[0-9]+$/|min:10|max:15',
            'nib'           => 'nullable|regex:/^[0-9]+$/',
            'company_name'  => 'required|string|max:255',
            'business_field'=> 'required|string',
            'city'          => 'required|string',
            'contact_method'=> 'required|in:whatsapp,email',
        ]);

        $this->company->update([
            'owner_name'     => $this->owner_name,
            'whatsapp'       => $this->whatsapp,
            'company_name'   => $this->company_name,
            'business_field' => $this->business_field,
            'nib'            => $this->nib,
            'address'        => $this->address,
            'city'           => $this->city,
            'contact_method' => $this->contact_method,
        ]);

        $this->company->user->update([
            'name' => $this->owner_name,
            'whatsapp' => $this->whatsapp,
        ]);

        $this->dispatch('notify', ['message' => 'Profil usaha berhasil diperbarui!', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.company.company-profile', [
            'cities'     => City::orderBy('name')->get(),
            'categories' => JobListing::jobCategories(),
        ])->title('Profil Usaha — NEAR JOB');
    }
}
