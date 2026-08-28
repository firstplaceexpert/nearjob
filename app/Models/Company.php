<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'address',
        'city',
        'latitude',
        'longitude',
        'contact_email',
        'agreed_to_terms',
    ];

    protected function casts(): array
    {
        return [
            'agreed_to_terms' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobListings(): HasMany
    {
        return $this->hasMany(JobListing::class);
    }

    public function activeJobListings(): HasMany
    {
        return $this->hasMany(JobListing::class)->where('status', 'active');
    }
}
