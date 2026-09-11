<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' — NEAR JOB' : 'Masuk / Daftar — NEAR JOB' }}</title>
    <meta name="description" content="Masuk atau daftar di NEAR JOB untuk menemukan lowongan kerja terdekat di sekitar tempat tinggal Anda.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bx, .bxs, .bxl, [class^="bx-"], [class*=" bx-"] { font-family: 'boxicons' !important; }
    </style>
    @livewireStyles
</head>
<body class="min-h-screen bg-slate-50 flex flex-col">

    @unless($hideHeader ?? false)
    <header class="bg-white border-b border-slate-100 px-4 h-14 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-decoration-none">
            <img src="{{ asset('logo.png') }}" alt="NEAR JOB" class="w-8 h-8 rounded-xl object-contain shadow-xs border border-black/10">
            <span class="font-black text-black tracking-tight text-lg">NEAR JOB</span>
        </a>
        <div class="flex items-center gap-2 text-sm text-black">
            <a href="{{ route('login') }}" class="font-bold text-black hover:opacity-80 transition-opacity text-decoration-none">Masuk</a>
        </div>
    </header>
    @endunless

    <main class="flex-grow">
        {{ $slot }}
    </main>

    @livewireScripts
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>lucide.createIcons();</script>
</body>
</html>
