<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantProfile extends Model
{
    protected $fillable = [
        'user_id',
        'photo',
        'education_level',
        'education_institution',
        'field_of_study',
        'work_experience',
        'skills',
        'contact_email',
        'city',
        'latitude',
        'longitude',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'skills' => 'array',
            'is_active' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isComplete(): bool
    {
        return $this->education_level
            && $this->education_institution
            && $this->contact_email
            && $this->city
            && $this->latitude
            && $this->longitude;
    }

    public static function educationLevels(): array
    {
        return [
            'sma' => 'SMA/SMK/Sederajat',
            'd3' => 'Diploma (D3)',
            's1' => 'Sarjana (S1)',
            's2' => 'Magister (S2)',
            's3' => 'Doktor (S3)',
        ];
    }

    public static function educationRank(string $level): int
    {
        return match ($level) {
            'sma' => 1,
            'd3' => 2,
            's1' => 3,
            's2' => 4,
            's3' => 5,
            default => 0,
        };
    }
}
