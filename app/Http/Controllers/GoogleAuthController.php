<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    protected function getRedirectUrl(): string
    {
        $uri = config('services.google.redirect');
        if (!empty($uri) && filter_var($uri, FILTER_VALIDATE_URL)) {
            return $uri;
        }

        return url('/auth/google/callback');
    }

    public function redirectToGoogle(): RedirectResponse
    {
        try {
            return Socialite::driver('google')
                ->redirectUrl($this->getRedirectUrl())
                ->redirect();
        } catch (\Throwable $e) {
            return redirect()->route('home')->with('notify', [
                'message' => 'Gagal menghubungkan ke Google: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl($this->getRedirectUrl())
                ->user();
        } catch (\Throwable $e) {
            return redirect()->route('home')->with('notify', [
                'message' => 'Login Google dibatalkan atau gagal.',
                'type' => 'error'
            ]);
        }

        $email = strtolower(trim($googleUser->getEmail()));
        $user = User::where('email', $email)->first();

        if ($user) {
            // Jika akun sudah terdaftar -> langsung login!
            Auth::login($user, true);
            request()->session()->regenerate();

            return redirect()->route('applicant.map')->with('notify', [
                'message' => 'Selamat datang kembali, ' . $user->name . '!',
                'type' => 'success'
            ]);
        }

        // Jika email Google BELUM terdaftar -> simpan data sementara & wajibkan kuis onboarding!
        $name = $googleUser->getName() ?: explode('@', $email)[0];
        $avatar = $googleUser->getAvatar();

        session()->put('pending_google_auth', [
            'email'  => $email,
            'name'   => $name,
            'avatar' => $avatar,
        ]);
        session()->save();

        return redirect()->route('home', [
            'onboarding' => 'google',
            'email'      => $email,
            'name'       => $name,
        ]);
    }
}
