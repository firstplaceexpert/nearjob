<!DOCTYPE html>
<html lang="id">
<head>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' — NEAR JOB' : 'NEAR JOB' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #f0f4f9; }
        .nav-item { display: flex; flex-direction: column; align-items: center; gap: 2px; padding: 8px 16px; font-size: 11px; font-weight: 600; color: #64748b; transition: color .2s; text-decoration: none; }
        .nav-item.active { color: #2563eb; }
        .nav-item svg { width: 22px; height: 22px; }
        .leaflet-container { font-family: 'Plus Jakarta Sans', sans-serif !important; }
    </style>
    @livewireStyles
</head>
<body class="min-h-screen flex flex-col" style="font-family: 'Plus Jakarta Sans', sans-serif;">

    {{-- ===== TOP HEADER ===== --}}
    <header class="bg-white border-b border-slate-100 px-4 h-14 flex items-center justify-between fixed top-0 left-0 right-0 z-50 shadow-sm">
        <a href="{{ auth()->user()?->isCompany() ? route('company.dashboard') : route('applicant.map') }}" class="flex items-center gap-2">
            <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
            </div>
            <span class="font-extrabold text-blue-700 tracking-tight text-lg">NEAR JOB</span>
        </a>

        <div class="flex items-center gap-3">
            @auth
            @if(auth()->user()->isApplicant())
                @php $credits = auth()->user()->applicantProfile?->application_credits ?? 0; @endphp
                <div class="flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-bold px-3 py-1.5 rounded-full border border-blue-100">
                    🎫 {{ $credits }} kredit
                </div>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-xs font-semibold text-slate-500 hover:text-red-500 transition-colors px-2 py-1">
                    Keluar
                </button>
            </form>
            @endauth
        </div>
    </header>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="flex-grow mt-14 mb-16">
        {{ $slot }}
    </main>

    {{-- ===== BOTTOM NAVIGATION ===== --}}
    @auth
    <nav class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-slate-100 flex items-center justify-around shadow-lg" style="padding-bottom: env(safe-area-inset-bottom);">
        @if(auth()->user()->isApplicant())
            <a href="{{ route('applicant.map') }}" class="nav-item {{ request()->routeIs('applicant.map') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <a href="{{ route('applicant.applications') }}" class="nav-item {{ request()->routeIs('applicant.applications') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Lamaran
            </a>
            <a href="{{ route('applicant.profile') }}" class="nav-item {{ request()->routeIs('applicant.profile') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profil
            </a>
        @else
            <a href="{{ route('company.dashboard') }}" class="nav-item {{ request()->routeIs('company.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('company.jobs') }}" class="nav-item {{ request()->routeIs('company.jobs*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Lowongan
            </a>
            <a href="{{ route('company.profile') }}" class="nav-item {{ request()->routeIs('company.profile') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profil
            </a>
        @endif
    </nav>
    @endauth

    @livewireScripts
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>lucide.createIcons();</script>
    
    {{-- Toast notifications --}}
    <div id="toast-container" class="fixed bottom-20 left-0 right-0 flex flex-col items-center gap-2 z-[100] pointer-events-none px-4"></div>
    <script>
    window.addEventListener('notify', e => {
        const msg = e.detail.message || e.detail;
        const t = document.createElement('div');
        t.className = 'bg-slate-900 text-white px-5 py-3 rounded-xl shadow-2xl text-sm font-semibold pointer-events-auto transform translate-y-4 opacity-0 transition-all duration-300';
        t.textContent = msg;
        document.getElementById('toast-container').appendChild(t);
        requestAnimationFrame(() => { t.style.transform = ''; t.style.opacity = '1'; });
        setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateY(1rem)'; setTimeout(() => t.remove(), 300); }, 3500);
    });
    </script>
</body>
</html>
