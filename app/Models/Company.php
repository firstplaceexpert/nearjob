<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'user_id', 'owner_name', 'nik', 'whatsapp',
        'company_name', 'business_field', 'nib',
        'ktp_path', 'is_verified',
        'address', 'city', 'latitude', 'longitude',
        'contact_email', 'contact_method', 'agreed_to_terms',
    ];

    protected $hidden = ['nik'];

    protected $casts = [
        'agreed_to_terms' => 'boolean',
        'is_verified'     => 'boolean',
    ];

    public function getMaskedNikAttribute(): string
    {
        $nik = (string)($this->nik ?? ($this->user->nik ?? ''));
        if (strlen($nik) < 8) {
            return $nik ? '************' : '-';
        }
        return substr($nik, 0, 4) . '********' . substr($nik, -4);
    }

    public function getKtpUrlAttribute(): ?string
    {
        if (!$this->ktp_path) return null;
        return asset('storage/' . $this->ktp_path);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobListings()
    {
        return $this->hasMany(JobListing::class);
    }

    public function isVerified(): bool
    {
        return (bool)$this->is_verified || (!empty($this->ktp_path) && !empty($this->owner_name));
    }
}
