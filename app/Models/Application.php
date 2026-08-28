<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'job_listing_id',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobListing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class);
    }

    public function applicantProfile()
    {
        return $this->hasOneThrough(
            ApplicantProfile::class,
            User::class,
            'id',        // users.id
            'user_id',   // applicant_profiles.user_id
            'user_id',   // applications.user_id
            'id'         // users.id
        );
    }
}
