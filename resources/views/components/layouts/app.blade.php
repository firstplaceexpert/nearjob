<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    {{-- Primary SEO Meta Tags --}}
    <title>{{ isset($title) ? $title . ' — NEAR JOB' : 'Lowongan Kerja Terdekat & Info Loker Terbaru — NEAR JOB' }}</title>
    <meta name="description" content="Temukan ribuan lowongan kerja terdekat di sekitar lokasi Anda dengan mudah di NEAR JOB. Portal pencarian loker part-time, full-time, fresh graduate, SMA/SMK langsung terhubung ke HRD perusahaan.">
    <meta name="keywords" content="lowongan kerja, cari loker, loker terdekat, info loker, loker yogyakarta, loker jakarta, loker surabaya, loker bandung, kerja part time, kerja freelance, lowongan kerja sma smk, portal karir, near job">
    <meta name="author" content="NEAR JOB">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="google-site-verification" content="RKLJDnOXuHbLSkcXrvG-6NPID4IztA0WMdMT9Ywlb-I">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Geo Tags for Local SEO --}}
    <meta name="geo.region" content="ID">
    <meta name="geo.placename" content="Indonesia">

    {{-- Open Graph / Facebook / WhatsApp --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ isset($title) ? $title . ' — NEAR JOB' : 'Lowongan Kerja Terdekat & Info Loker Terbaru — NEAR JOB' }}">
    <meta property="og:description" content="Temukan ribuan lowongan kerja terdekat di sekitar lokasi Anda. Akses cepat dan terhubung langsung ke perusahaan terpercaya.">
    <meta property="og:image" content="{{ asset('img/og-preview.jpg') }}">
    <meta property="og:site_name" content="NEAR JOB">
    <meta property="og:locale" content="id_ID">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ isset($title) ? $title . ' — NEAR JOB' : 'Lowongan Kerja Terdekat & Info Loker Terbaru — NEAR JOB' }}">
    <meta name="twitter:description" content="Temukan ribuan lowongan kerja terdekat di sekitar lokasi Anda dengan mudah di NEAR JOB.">
    <meta name="twitter:image" content="{{ asset('img/og-preview.jpg') }}">

    {{-- Schema.org Structured Data (Google Knowledge Graph & Sitelinks Searchbox) --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@graph": [
        {
          "@@type": "WebSite",
          "@@id": "{{ url('/') }}/#website",
          "url": "{{ url('/') }}",
          "name": "NEAR JOB",
          "description": "Portal Lowongan Kerja Terdekat Berbasis Peta GPS",
          "inLanguage": "id-ID",
          "potentialAction": {
            "@@type": "SearchAction",
            "target": "{{ url('/') }}?q={search_term_string}",
            "query-input": "required name=search_term_string"
          }
        },
        {
          "@@type": "Organization",
          "@@id": "{{ url('/') }}/#organization",
          "name": "NEAR JOB Indonesia",
          "url": "{{ url('/') }}",
          "logo": "{{ asset('img/logo.png') }}",
          "sameAs": [
            "https://www.facebook.com",
            "https://www.instagram.com"
          ]
        }
      ]
    }
    </script>

    <link href='https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #5680d8;
            --primary-dark: #24427b;
            --primary-light: #eef2fb;
            --teal: #47bfae;
            --bg: #f0f4f9;
        }
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg); }

        /* ── Bottom Nav ── */
        .bottom-nav { background: #fff; border-top: 1px solid #e8edf5; box-shadow: 0 -4px 20px rgba(37,67,155,.06); }
        .nav-item {
            display: flex; flex-direction: column; align-items: center;
            gap: 3px; padding: 8px 12px; font-size: 10px; font-weight: 700;
            color: #94a3b8; text-decoration: none; transition: color .2s; flex: 1;
            position: relative;
        }
        .nav-item i { font-size: 22px; line-height: 1; }
        .nav-item.active { color: var(--primary); }
        .nav-item.active::before {
            content: '';
            position: absolute; top: 0; left: 50%; transform: translateX(-50%);
            width: 28px; height: 3px;
            background: var(--primary); border-radius: 0 0 4px 4px;
        }
        .nav-badge {
            position: absolute; top: 5px; right: calc(50% - 16px);
            background: #ef4444; color: white; font-size: 8px; font-weight: 800;
            width: 14px; height: 14px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid white;
        }

        /* ── Header ── */
        .app-header {
            background: #fff;
            border-bottom: 1px solid #e8edf5;
            box-shadow: 0 2px 12px rgba(37,67,155,.05);
        }

        /* ── Cards & UI ── */
        .card { background: #fff; border-radius: 1.25rem; border: 1px solid #e8edf5; }
        .card-lg { background: #fff; border-radius: 1.5rem; border: 1px solid #e8edf5; }
        .btn-primary {
            background: var(--primary); color: #fff; font-weight: 700;
            border-radius: .875rem; transition: all .2s;
            box-shadow: 0 4px 15px rgba(86,128,216,.3);
        }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }
        .badge-primary { background: #ffffff; color: #000000; border: 1px solid #000000; font-weight: 700; }
        .badge-teal { background: #ffffff; color: #000000; border: 1px solid #000000; font-weight: 700; }

        /* ── Scrollbar hide ── */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* ── Leaflet ── */
        .leaflet-container { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bx, .bxs, .bxl, [class^="bx-"], [class*=" bx-"], .leaflet-container .bx { font-family: 'boxicons' !important; }
        .leaflet-control-attribution { font-size: 9px !important; }

        /* ── Transitions ── */
        .slide-up { animation: slideUp .3s ease; }
        @@keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    </style>
    @livewireStyles

    {{-- Midtrans Snap JS (Only loaded on topup route with defer to eliminate delay on other pages) --}}
    @if(request()->routeIs('applicant.topup'))
        @php
            $snapJsUrl = config('services.midtrans.is_production')
                ? 'https://app.midtrans.com/snap/snap.js'
                : 'https://app.sandbox.midtrans.com/snap/snap.js';
            $clientKey = config('services.midtrans.client_key') ?: env('MIDTRANS_CLIENT_KEY', '');
        @endphp
        <script src="{{ $snapJsUrl }}" data-client-key="{{ $clientKey }}" defer></script>
    @endif
    @stack('head')
</head>
<body class="min-h-screen flex flex-col" style="font-family: 'Plus Jakarta Sans', sans-serif;">

    {{-- ===== TOP HEADER ===== --}}
    <header class="app-header px-3 sm:px-6 h-14 flex items-center justify-between fixed top-0 left-0 right-0 z-50">
        <a href="{{ auth()->user()?->isCompany() ? route('company.dashboard') : route('applicant.map') }}" class="flex items-center gap-2 text-decoration-none shrink-0">
            <img src="{{ asset('logo.png') }}" alt="NEAR JOB" class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl object-contain shadow-xs border border-black/10">
            <span class="font-black tracking-tight text-base sm:text-lg text-black">NEAR JOB</span>
        </a>

        <div class="flex items-center gap-1.5 sm:gap-2">
            @auth
            @if(auth()->user()->isApplicant())
                @php $credits = auth()->user()->applicantProfile?->fresh()->application_credits ?? 0; @endphp
                <a href="{{ route('applicant.topup') }}"
                   x-data="{ credits: {{ $credits }} }"
                   @credits-updated.window="credits = ($event.detail && typeof $event.detail.credits !== 'undefined') ? $event.detail.credits : ($event.detail ?? credits)"
                   class="flex items-center gap-1.5 text-xs font-bold px-2.5 sm:px-3 py-1.5 rounded-full border hover:shadow-sm hover:scale-105 transition-all text-decoration-none"
                   style="background: #ffffff; color: #000000; border: 1px solid rgba(0,0,0,0.3);" title="Isi ulang kuota lamaran">
                    <i class='bx bx-coin-stack text-sm'></i> <span x-text="`${credits} kuota`">{{ $credits }} kuota</span>
                    <span class="w-4 h-4 rounded-full bg-[#5680d8] text-white flex items-center justify-center text-[10px] font-black leading-none">+</span>
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-xs font-semibold text-black hover:text-black transition-colors px-2 py-1 rounded-lg hover:bg-red-50" title="Keluar">
                    <i class='bx bx-log-out-circle text-lg'></i>
                </button>
            </form>
            @else
            <div class="flex items-center gap-1.5 sm:gap-2.5" x-data>
                <button type="button" 
                   @click="$dispatch('open-quick-auth-modal')"
                   class="text-xs sm:text-sm font-extrabold px-2 sm:px-3 py-1.5 rounded-xl text-black hover:bg-black/5 transition-all border-none bg-transparent cursor-pointer">
                    Masuk
                </button>
                <a href="{{ route('register.company') }}" 
                   class="text-xs sm:text-sm font-extrabold px-2 sm:px-3 py-1.5 rounded-xl border border-black/25 text-black hover:bg-black/5 transition-all text-decoration-none whitespace-nowrap">
                    Untuk Perusahaan
                </a>
            </div>
            @endauth
        </div>
    </header>

    {{-- ===== MAIN CONTENT (GUARANTEED CLEARANCE FROM FIXED HEADER 56px & BOTTOM NAV 64px) ===== --}}
    <main class="flex-grow" style="padding-top: 76px; padding-bottom: 96px;">
        {{ $slot }}
    </main>

    {{-- ===== BOTTOM NAVIGATION ===== --}}
    @auth
    <nav class="bottom-nav fixed bottom-0 left-0 right-0 z-50 flex items-center" style="padding-bottom: env(safe-area-inset-bottom);">
        @if(auth()->user()->isApplicant())
            <a href="{{ route('applicant.map') }}" class="nav-item {{ request()->routeIs('applicant.map') || request()->routeIs('home') ? 'active' : '' }}">
                <i class='bx {{ request()->routeIs('applicant.map') || request()->routeIs('home') ? "bxs-home" : "bx-home" }}'></i>
                <span>Beranda</span>
            </a>
            <a href="{{ route('applicant.applications') }}" class="nav-item {{ request()->routeIs('applicant.applications') ? 'active' : '' }}">
                <i class='bx {{ request()->routeIs('applicant.applications') ? "bxs-briefcase-alt-2" : "bx-briefcase-alt-2" }}'></i>
                <span>Lamaran</span>
            </a>
            <a href="{{ route('applicant.profile') }}" class="nav-item {{ request()->routeIs('applicant.profile') ? 'active' : '' }}">
                <i class='bx {{ request()->routeIs('applicant.profile') ? "bxs-user" : "bx-user" }}'></i>
                <span>Profil</span>
            </a>
        @else
            <a href="{{ route('company.dashboard') }}" class="nav-item {{ request()->routeIs('company.dashboard') ? 'active' : '' }}">
                <i class='bx {{ request()->routeIs('company.dashboard') ? "bxs-home" : "bx-home" }}'></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('company.jobs') }}" class="nav-item {{ request()->routeIs('company.jobs*') ? 'active' : '' }}">
                <i class='bx {{ request()->routeIs('company.jobs*') ? "bxs-briefcase" : "bx-briefcase" }}'></i>
                <span>Lowongan</span>
            </a>
            <a href="{{ route('company.profile') }}" class="nav-item {{ request()->routeIs('company.profile') ? 'active' : '' }}">
                <i class='bx {{ request()->routeIs('company.profile') ? "bxs-user" : "bx-user" }}'></i>
                <span>Profil</span>
            </a>
        @endif
    </nav>
    @else
    <nav class="bottom-nav fixed bottom-0 left-0 right-0 z-50 flex items-center" style="padding-bottom: env(safe-area-inset-bottom);" x-data>
        <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') || request()->routeIs('applicant.map') ? 'active' : '' }}">
            <i class='bx {{ request()->routeIs('home') || request()->routeIs('applicant.map') ? "bxs-map" : "bx-map" }}'></i>
            <span>Peta Lowongan</span>
        </a>
        <a href="{{ route('login') }}" @click.prevent="$dispatch('open-quick-auth-modal')" class="nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
            <i class='bx {{ request()->routeIs('login') ? "bxs-log-in-circle" : "bx-log-in-circle" }}'></i>
            <span>Masuk</span>
        </a>
        <a href="{{ route('register.applicant') }}" @click.prevent="$dispatch('open-quick-auth-modal')" class="nav-item {{ request()->routeIs('register.applicant') ? 'active' : '' }}">
            <i class='bx {{ request()->routeIs('register.applicant') ? "bxs-user-plus" : "bx-user-plus" }}'></i>
            <span>Daftar Pelamar</span>
        </a>
        <a href="{{ route('register.company') }}" class="nav-item {{ request()->routeIs('register.company') ? 'active' : '' }}">
            <i class='bx {{ request()->routeIs('register.company') ? "bxs-buildings" : "bx-buildings" }}'></i>
            <span>Perusahaan</span>
        </a>
    </nav>
    @endauth

    {{-- Global Quick Auth & Onboarding Quiz Modal --}}
    @livewire('auth.quick-auth-quiz-modal')

    @livewireScripts

    {{-- Toast notifications --}}
    <div id="toast-container" class="fixed bottom-24 left-0 right-0 flex flex-col items-center gap-2 z-[200] pointer-events-none px-4"></div>
    <script>
    window.addEventListener('notify', e => {
        const msg = e.detail.message || e.detail[0]?.message || e.detail;
        const type = e.detail.type || 'info';
        const t = document.createElement('div');
        const colors = { success: '#059669', error: '#dc2626', info: '#1e293b' };
        t.style.cssText = `background:${colors[type]||colors.info};color:white;padding:12px 20px;border-radius:12px;box-shadow:0 8px 30px rgba(0,0,0,.2);font-size:13px;font-weight:600;pointer-events:auto;transform:translateY(16px);opacity:0;transition:all .3s;max-width:320px;text-align:center;`;
        t.textContent = msg;
        document.getElementById('toast-container').appendChild(t);
        requestAnimationFrame(() => { t.style.transform = ''; t.style.opacity = '1'; });
        setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateY(1rem)'; setTimeout(() => t.remove(), 300); }, 3500);
    });
    </script>
</body>
</html>
