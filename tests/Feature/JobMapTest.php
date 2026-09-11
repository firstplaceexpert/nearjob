<?php

namespace Tests\Feature;

use App\Livewire\Applicant\JobMap;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class JobMapTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_map_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('njob-map');
    }

    public function test_job_map_set_location_updates_coordinates(): void
    {
        Livewire::test(JobMap::class)
            ->assertSet('hasGpsLocation', false)
            ->call('setLocation', -6.2088, 106.8456)
            ->assertSet('userLat', -6.2088)
            ->assertSet('userLon', 106.8456)
            ->assertSet('hasGpsLocation', true);
    }

    public function test_job_map_filters_jobs_by_distance(): void
    {
        $user = User::factory()->create(['role' => 'company']);
        $company = Company::create([
            'user_id' => $user->id,
            'company_name' => 'PT Maju Bersama',
            'city' => 'Jakarta Pusat',
            'address' => 'Jl. Thamrin No. 10',
            'contact_email' => 'hrd@majubersama.com',
            'latitude' => -6.2000,
            'longitude' => 106.8166,
        ]);

        $jobNear = JobListing::create([
            'company_id' => $company->id,
            'position' => 'Staff Administrasi',
            'description' => 'Mengerjakan administrasi kantor',
            'qualifications' => 'Pendidikan min SMA',
            'city' => 'Jakarta Pusat',
            'job_category' => 'administrasi',
            'work_type' => 'full_time',
            'min_education' => 'sma',
            'latitude' => -6.2000,
            'longitude' => 106.8166,
            'status' => 'active',
            'salary_min' => 4500000,
            'salary_max' => 5500000,
            'quota' => 2,
        ]);

        $jobFar = JobListing::create([
            'company_id' => $company->id,
            'position' => 'Staff Surabaya',
            'description' => 'Mengerjakan operasional cabang Surabaya',
            'qualifications' => 'Pendidikan min SMA',
            'city' => 'Surabaya',
            'job_category' => 'administrasi',
            'work_type' => 'full_time',
            'min_education' => 'sma',
            'latitude' => -7.2575,
            'longitude' => 112.7521,
            'status' => 'active',
            'salary_min' => 4500000,
            'salary_max' => 5500000,
            'quota' => 1,
        ]);

        // When user is in Jakarta (-6.2088, 106.8456) with 25km radius
        Livewire::test(JobMap::class)
            ->call('setLocation', -6.2088, 106.8456)
            ->assertSee('Staff Administrasi')
            ->assertDontSee('Staff Surabaya');
    }
}
