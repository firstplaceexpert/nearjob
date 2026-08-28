<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'NearJob — Job Matching Platform' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full text-slate-900 flex flex-col font-sans selection:bg-indigo-500 selection:text-white">

    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <!-- Left: Logo & Role Indicator -->
            <div class="flex items-center gap-6">
                <a href="{{ auth()->user()->isCompany() ? route('company.dashboard') : route('applicant.swipe') }}" class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white shadow-md shadow-indigo-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-slate-900">NearJob</span>
                </a>

                @if(auth()->user()->isApplicant())
                    <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                        Pencari Kerja
                    </span>
                @else
                    <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                        Portal Perusahaan
                    </span>
                @endif
            </div>

            <!-- Middle Navigation Links -->
            <nav class="hidden md:flex items-center gap-1">
                @if(auth()->user()->isApplicant())
                    <a href="{{ route('applicant.swipe') }}" 
                       class="px-3.5 py-2 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('applicant.swipe') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        🔥 Swipe Card
                    </a>
                    <a href="{{ route('applicant.applications') }}" 
                       class="px-3.5 py-2 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('applicant.applications') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        📋 Lamaran Saya
                    </a>
                    <a href="{{ route('applicant.profile') }}" 
                       class="px-3.5 py-2 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('applicant.profile') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        👤 Profil Saya
                    </a>
                @else
                    <a href="{{ route('company.dashboard') }}" 
                       class="px-3.5 py-2 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('company.dashboard') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        📊 Dashboard
                    </a>
                    <a href="{{ route('company.jobs') }}" 
                       class="px-3.5 py-2 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('company.jobs*') ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        💼 Lowongan
                    </a>
                @endif
            </nav>

            <!-- Right Profile Dropdown & Logout -->
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <div class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-slate-500">{{ auth()->user()->email }}</div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-xl transition-colors" title="Keluar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation bar (Bottom Sticky) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-slate-200 px-4 py-2 flex justify-around">
        @if(auth()->user()->isApplicant())
            <a href="{{ route('applicant.swipe') }}" class="flex flex-col items-center gap-0.5 text-xs {{ request()->routeIs('applicant.swipe') ? 'text-indigo-600 font-bold' : 'text-slate-500' }}">
                <span class="text-lg">🔥</span> Swipe
            </a>
            <a href="{{ route('applicant.applications') }}" class="flex flex-col items-center gap-0.5 text-xs {{ request()->routeIs('applicant.applications') ? 'text-indigo-600 font-bold' : 'text-slate-500' }}">
                <span class="text-lg">📋</span> Lamaran
            </a>
            <a href="{{ route('applicant.profile') }}" class="flex flex-col items-center gap-0.5 text-xs {{ request()->routeIs('applicant.profile') ? 'text-indigo-600 font-bold' : 'text-slate-500' }}">
                <span class="text-lg">👤</span> Profil
            </a>
        @else
            <a href="{{ route('company.dashboard') }}" class="flex flex-col items-center gap-0.5 text-xs {{ request()->routeIs('company.dashboard') ? 'text-indigo-600 font-bold' : 'text-slate-500' }}">
                <span class="text-lg">📊</span> Dashboard
            </a>
            <a href="{{ route('company.jobs') }}" class="flex flex-col items-center gap-0.5 text-xs {{ request()->routeIs('company.jobs*') ? 'text-indigo-600 font-bold' : 'text-slate-500' }}">
                <span class="text-lg">💼</span> Lowongan
            </a>
            <a href="{{ route('company.jobs.create') }}" class="flex flex-col items-center gap-0.5 text-xs {{ request()->routeIs('company.jobs.create') ? 'text-indigo-600 font-bold' : 'text-slate-500' }}">
                <span class="text-lg">➕</span> Pasang
            </a>
        @endif
    </nav>

    <!-- Main Content Area -->
    <main class="flex-grow pb-16 md:pb-6">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
