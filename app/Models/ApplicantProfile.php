<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantProfile extends Model
{
    protected $fillable = [
        'user_id', 'photo', 'whatsapp',
        'education_level', 'education_institution', 'field_of_study',
        'work_experience', 'skills', 'salary_expectation',
        'contact_email', 'city', 'latitude', 'longitude',
        'is_active', 'application_credits', 'cv_generated', 'cv_data',
    ];

    protected $casts = [
        'skills'   => 'array',
        'cv_data'  => 'array',
        'is_active' => 'boolean',
        'cv_generated' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isComplete(): bool
    {
        return !empty($this->education_level)
            && !empty($this->education_institution)
            && !empty($this->city);
    }

    public function hasCredits(): bool
    {
        return $this->application_credits > 0;
    }

    public function deductCredit(): bool
    {
        if ($this->application_credits <= 0) return false;
        $this->decrement('application_credits');
        return true;
    }

    public static function educationLevels(): array
    {
        return [
            'sd'  => 'SD',
            'smp' => 'SMP',
            'sma' => 'SMA / SMK',
            'd3'  => 'D3 (Diploma)',
            's1'  => 'S1 (Sarjana)',
            's2'  => 'S2 (Magister)',
            's3'  => 'S3 (Doktor)',
        ];
    }
}
