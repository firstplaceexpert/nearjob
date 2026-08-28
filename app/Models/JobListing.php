<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobListing extends Model
{
    protected $fillable = [
        'company_id',
        'position',
        'description',
        'qualifications',
        'city',
        'latitude',
        'longitude',
        'work_type',
        'job_category',
        'required_skills',
        'min_education',
        'radius_km',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'required_skills' => 'array',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'radius_km' => 'integer',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function swipeHistories(): HasMany
    {
        return $this->hasMany(SwipeHistory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public static function workTypes(): array
    {
        return [
            'full_time' => 'Full Time',
            'part_time' => 'Part Time',
            'internship' => 'Magang',
        ];
    }

    public static function jobCategories(): array
    {
        return [
            'teknologi' => 'Teknologi & IT',
            'desain' => 'Desain & Kreatif',
            'marketing' => 'Marketing & Sales',
            'admin' => 'Administrasi & HR',
            'keuangan' => 'Keuangan & Akuntansi',
            'pendidikan' => 'Pendidikan',
            'kesehatan' => 'Kesehatan',
            'fnb' => 'Food & Beverage',
            'retail' => 'Retail & E-Commerce',
            'logistik' => 'Logistik & Operasional',
            'media' => 'Media & Komunikasi',
            'lainnya' => 'Lainnya',
        ];
    }

    public function getWorkTypeLabelAttribute(): string
    {
        return self::workTypes()[$this->work_type] ?? $this->work_type;
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::jobCategories()[$this->job_category] ?? $this->job_category;
    }
}
