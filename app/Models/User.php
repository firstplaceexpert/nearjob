<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isApplicant(): bool
    {
        return $this->role === 'applicant';
    }

    public function isCompany(): bool
    {
        return $this->role === 'company';
    }

    public function applicantProfile()
    {
        return $this->hasOne(ApplicantProfile::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function swipeHistories()
    {
        return $this->hasMany(SwipeHistory::class);
    }
}
