<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| NearJob Web Routes
|--------------------------------------------------------------------------
*/

// Landing & Browse (public)
Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/browse', App\Livewire\Browse\JobBoard::class)->name('browse');

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', App\Livewire\Auth\Login::class)->name('login');
    Route::get('/register/applicant', App\Livewire\Auth\RegisterApplicant::class)->name('register.applicant');
    Route::get('/register/company', App\Livewire\Auth\RegisterCompany::class)->name('register.company');
});

// Logout
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->middleware('auth')->name('logout');

// Applicant routes
Route::middleware(['auth', 'role:applicant'])->prefix('applicant')->name('applicant.')->group(function () {
    Route::get('/profile', App\Livewire\Applicant\ProfileForm::class)->name('profile');
    Route::get('/swipe', App\Livewire\Applicant\SwipeCards::class)->name('swipe');
    Route::get('/applications', App\Livewire\Applicant\ApplicationHistory::class)->name('applications');
});

// Company routes
Route::middleware(['auth', 'role:company'])->prefix('company')->name('company.')->group(function () {
    Route::get('/dashboard', App\Livewire\Company\Dashboard::class)->name('dashboard');
    Route::get('/jobs', App\Livewire\Company\JobListings::class)->name('jobs');
    Route::get('/jobs/create', App\Livewire\Company\JobListingForm::class)->name('jobs.create');
    Route::get('/jobs/{jobListing}/edit', App\Livewire\Company\JobListingForm::class)->name('jobs.edit');
    Route::get('/jobs/{jobListing}/applicants', App\Livewire\Company\ApplicantList::class)->name('jobs.applicants');
});
