<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'NearJob — Job Matching Lokal Berbasis Swipe' }}</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full text-slate-900 flex flex-col font-sans selection:bg-indigo-500 selection:text-white">

    <!-- Header Navigation -->
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white shadow-md shadow-indigo-200 group-hover:scale-105 transition-transform duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-slate-900 via-indigo-950 to-indigo-700 bg-clip-text text-transparent">NearJob</span>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-indigo-600 -mt-1">Job Swipe Beta</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Beranda</a>
                <a href="{{ route('browse') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Cari Lowongan</a>
            </nav>

            <!-- Auth CTA -->
            <div class="flex items-center gap-3">
                @auth
                    @if(auth()->user()->isApplicant())
                        <a href="{{ route('applicant.swipe') }}" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition-all">Masuk Aplikasi</a>
                    @else
                        <a href="{{ route('company.dashboard') }}" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition-all">Dashboard HR</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">Masuk</a>
                    <a href="{{ route('register.applicant') }}" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-200 transition-all hover:shadow-lg hover:shadow-indigo-300">Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-auto py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">N</div>
                <span class="text-sm font-semibold text-slate-700">NearJob &copy; {{ date('Y') }}</span>
                <span class="text-xs text-slate-400">— Platform Matching Kerja Lokal Gen Z</span>
            </div>
            <div class="flex items-center gap-6 text-xs font-medium text-slate-500">
                <a href="{{ route('browse') }}" class="hover:text-indigo-600">Lowongan Terkini</a>
                <a href="{{ route('register.company') }}" class="hover:text-indigo-600">Untuk Perusahaan / UMKM</a>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
