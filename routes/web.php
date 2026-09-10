<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| NEAR JOB Web Routes
|--------------------------------------------------------------------------
*/

// ========================
// PUBLIC ROUTES
// ========================
Route::get('/', App\Livewire\Applicant\JobMap::class)->name('home');
Route::get('/pelamar/beranda', App\Livewire\Applicant\JobMap::class)->name('applicant.map');
Route::get('/pelamar/lowongan/{jobListing}', App\Livewire\Applicant\JobDetail::class)->name('applicant.job.detail');

// Auth routes (guest only)
Route::redirect('/login', '/masuk');
Route::redirect('/register', '/daftar/pelamar');
Route::redirect('/daftar', '/daftar/pelamar');

Route::middleware('guest')->group(function () {
    Route::get('/masuk', App\Livewire\Auth\Login::class)->name('login');
    Route::get('/daftar/pelamar', App\Livewire\Auth\RegisterApplicant::class)->name('register.applicant');
    Route::get('/daftar/pemberi-kerja', App\Livewire\Auth\RegisterCompany::class)->name('register.company');
    
    // Google OAuth Routes
    Route::get('/auth/google', [App\Http\Controllers\GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [App\Http\Controllers\GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

// Logout
Route::post('/keluar', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->middleware('auth')->name('logout');

// ========================
// MIDTRANS PAYMENT WEBHOOK & API
// ========================
Route::post('/api/midtrans/webhook', [App\Http\Controllers\MidtransWebhookController::class, 'handle'])->name('midtrans.webhook');
Route::get('/api/orders/{order}/check-status', [App\Http\Controllers\MidtransWebhookController::class, 'checkStatus'])->name('orders.check-status');

// ========================
// APPLICANT PROTECTED ROUTES
// ========================
Route::middleware(['auth', 'role:applicant'])
    ->prefix('pelamar')
    ->name('applicant.')
    ->group(function () {
        Route::get('/lamaran', App\Livewire\Applicant\ApplicationHistory::class)->name('applications');
        Route::get('/profil', App\Livewire\Applicant\ProfileForm::class)->name('profile');
        Route::get('/cv-generator', App\Livewire\Applicant\CvGenerator::class)->name('cv.generator');
        Route::get('/isi-kuota', App\Livewire\Applicant\CreditTopup::class)->name('topup');
    });

// ========================
// EMPLOYER ROUTES
// ========================
Route::middleware(['auth', 'role:company'])
    ->prefix('pemberi-kerja')
    ->name('company.')
    ->group(function () {
        Route::get('/dashboard', App\Livewire\Company\Dashboard::class)->name('dashboard');
        Route::get('/lowongan', App\Livewire\Company\JobListings::class)->name('jobs');
        Route::get('/lowongan/buat', App\Livewire\Company\JobListingForm::class)->name('jobs.create');
        Route::get('/lowongan/{jobListing}/edit', App\Livewire\Company\JobListingForm::class)->name('jobs.edit');
        Route::get('/lowongan/{jobListing}/pelamar', App\Livewire\Company\ApplicantList::class)->name('jobs.applicants');
        Route::get('/profil', App\Livewire\Company\CompanyProfile::class)->name('profile');
    });
