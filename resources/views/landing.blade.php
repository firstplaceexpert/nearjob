<!DOCTYPE html>
<html lang="id">
<head>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEAR JOB — Temukan Pekerjaan di Sekitar Anda</title>
    <meta name="description" content="Near Job membantu Anda menemukan peluang kerja di sekitar berdasarkan lokasi dan keahlian. Hubungi pemberi kerja langsung via WhatsApp atau Email.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-bg { background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 60%, #1d4ed8 100%); }
        .map-mock { background: #e8f0f7; border-radius: 1.5rem; overflow: hidden; position: relative; }
        .pin { position: absolute; background: #2563eb; color: white; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; white-space: nowrap; box-shadow: 0 4px 12px rgba(37,99,235,.4); cursor: pointer; }
        .pin::after { content: ''; position: absolute; bottom: -6px; left: 50%; transform: translateX(-50%); border: 6px solid transparent; border-top-color: #2563eb; border-bottom: none; }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased">

{{-- ===== HEADER ===== --}}
<header class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-100">
    <div class="max-w-5xl mx-auto px-4 h-16 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
            </div>
            <span class="font-extrabold text-xl text-blue-700 tracking-tight">NEAR JOB</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-blue-600 transition-colors px-3 py-2">Masuk</a>
            <a href="{{ route('register.applicant') }}" class="text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl transition-colors">Daftar</a>
        </div>
    </div>
</header>

{{-- ===== HERO ===== --}}
<section class="hero-bg pt-32 pb-20 px-4 text-white text-center relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-10 w-32 h-32 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-48 h-48 bg-white rounded-full blur-3xl"></div>
    </div>
    <div class="relative max-w-2xl mx-auto">
        <div class="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 text-sm font-semibold mb-6">
            <i class='bx bx-map'></i> Lebih dari 500 lowongan di seluruh Indonesia
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-5">
            Pekerjaan yang Tepat<br>
            <span class="text-yellow-300">Mungkin Lebih Dekat</span><br>
            Dari yang Anda Kira.
        </h1>
        <p class="text-blue-100 text-lg mb-8 max-w-lg mx-auto leading-relaxed">
            Near Job membantu Anda menemukan peluang kerja di sekitar berdasarkan lokasi dan keahlian. Hubungi pemberi kerja langsung.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('register.applicant') }}" class="inline-flex items-center justify-center gap-2 bg-white text-blue-700 font-extrabold text-base px-8 py-4 rounded-2xl hover:bg-yellow-50 transition-all shadow-xl shadow-blue-900/20">
                <i class='bx bx-search'></i> Cari Pekerjaan
            </a>
            <a href="{{ route('register.company') }}" class="inline-flex items-center justify-center gap-2 bg-white/15 backdrop-blur-sm border-2 border-white/40 text-white font-bold text-base px-8 py-4 rounded-2xl hover:bg-white/25 transition-all">
                <i class='bx bx-buildings'></i> Saya Butuh Tenaga Kerja
            </a>
        </div>
    </div>

    {{-- Mock Map --}}
    <div class="max-w-2xl mx-auto mt-14 map-mock" style="height: 280px;">
        <div style="width:100%;height:100%;background:linear-gradient(135deg,#d1e8f7,#e8f4fd);position:relative;">
            {{-- Fake map grid --}}
            <svg width="100%" height="100%" style="position:absolute;opacity:.15"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="#2563eb" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(#grid)"/></svg>
            {{-- Fake roads --}}
            <svg width="100%" height="100%" style="position:absolute;opacity:.3"><line x1="0" y1="140" x2="100%" y2="140" stroke="#94a3b8" stroke-width="3"/><line x1="0" y1="180" x2="100%" y2="180" stroke="#94a3b8" stroke-width="2"/><line x1="200" y1="0" x2="200" y2="100%" stroke="#94a3b8" stroke-width="3"/><line x1="350" y1="0" x2="350" y2="100%" stroke="#94a3b8" stroke-width="2"/></svg>
            {{-- Job Pins --}}
            <div class="pin" style="top:60px;left:15%"><i class='bx bx-restaurant'></i> Kitchen Helper · 1.4 km</div>
            <div class="pin" style="top:120px;left:45%"><i class='bx bx-store'></i> Kasir · 2.1 km</div>
            <div class="pin" style="top:40px;right:15%;background:#059669"><i class='bx bx-cog'></i> Operator · 3.7 km</div>
            <div class="pin" style="bottom:60px;left:30%;background:#7c3aed"><i class='bx bx-brush'></i> Cleaning · 4.2 km</div>
            <div class="pin" style="bottom:40px;right:20%;background:#d97706"><i class='bx bx-package'></i> Helper Gudang · 5.1 km</div>
            {{-- User Location --}}
            <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)">
                <div style="width:16px;height:16px;background:#2563eb;border:3px solid white;border-radius:50%;box-shadow:0 0 0 8px rgba(37,99,235,.2);"></div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 3 LANGKAH ===== --}}
<section class="py-20 px-4 bg-white">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-extrabold text-slate-800 mb-3">Cara Kerja Near Job</h2>
            <p class="text-slate-500">Tiga langkah mudah untuk mendapatkan pekerjaan di sekitar Anda.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl"><i class='bx bx-map'></i></div>
                <div class="text-blue-600 font-black text-sm tracking-widest mb-2">LANGKAH 01</div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Temukan</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Lihat lowongan pekerjaan di sekitar Anda langsung di peta interaktif.</p>
            </div>
            <div class="text-center p-6 relative">
                <div class="hidden md:block absolute top-8 -left-4 w-8 h-0.5 bg-slate-200"></div>
                <div class="hidden md:block absolute top-8 -right-4 w-8 h-0.5 bg-slate-200"></div>
                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl"><i class='bx bx-filter-alt'></i></div>
                <div class="text-emerald-600 font-black text-sm tracking-widest mb-2">LANGKAH 02</div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Pilih</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Filter berdasarkan keahlian, jarak, jenis kerja, dan kisaran gaji yang Anda inginkan.</p>
            </div>
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl"><i class='bx bxl-whatsapp'></i></div>
                <div class="text-orange-600 font-black text-sm tracking-widest mb-2">LANGKAH 03</div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Lamar</h3>
                <p class="text-slate-500 text-sm leading-relaxed">Hubungi pemberi kerja langsung melalui WhatsApp atau Email. Tanpa perantara.</p>
            </div>
        </div>
    </div>
</section>

{{-- ===== KENAPA NEAR JOB ===== --}}
<section class="py-20 px-4 bg-slate-50">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-extrabold text-slate-800 mb-3">Kenapa Near Job?</h2>
            <p class="text-slate-500">Dirancang untuk pencari kerja dan pemberi kerja lokal Indonesia.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            @foreach([
                ["<i class='bx bx-map'></i>", 'Lowongan di Sekitar Anda', 'Temukan pekerjaan berdasarkan jarak terdekat dari lokasi Anda sekarang.'],
                ["<i class='bx bx-user-plus'></i>", 'Tanpa Perlu Relasi', 'Tidak perlu kenalan atau jaringan profesional. Semua orang punya kesempatan yang sama.'],
                ["<i class='bx bx-gift'></i>", '3 Lamaran Gratis', 'Setiap akun mendapatkan 3 kesempatan melamar secara gratis. Hemat dan mudah.'],
                ["<i class='bx bxl-whatsapp'></i>", 'Kontak Langsung', 'Lamar langsung ke pemberi kerja via WhatsApp atau Email. Tidak ada perantara.'],
                ["<i class='bx bx-file'></i>", 'CV ATS Otomatis', 'Buat CV profesional siap ATS dari data profil Anda kapan pun dibutuhkan.'],
                ["<i class='bx bx-store'></i>", 'Untuk Usaha Lokal', 'Cocok untuk warung, toko, hotel, pabrik, dan usaha lokal lainnya yang butuh karyawan.'],
            ] as [$icon, $title, $desc])
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-start gap-4">
                <div class="text-2xl shrink-0">{!! $icon !!}</div>
                <div>
                    <h4 class="font-bold text-slate-800 mb-1">{{ $title }}</h4>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ===== CONTOH LOWONGAN ===== --}}
<section class="py-20 px-4 bg-white">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-slate-800 mb-3">Contoh Lowongan Tersedia</h2>
            <p class="text-slate-500">Ribuan lowongan untuk berbagai bidang dan keahlian.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-10">
            @foreach([
                ["<i class='bx bx-restaurant'></i>",'Kitchen Helper','Warung Makan ABC','1.4 km','Rp2,5–3 juta','Full-time','whatsapp'],
                ["<i class='bx bx-store'></i>",'Kasir','Toko Makmur','2.1 km','Rp2,3–2,8 juta','Full-time','whatsapp'],
                ["<i class='bx bx-cog'></i>",'Operator Produksi','CV Maju Bersama','3.7 km','Rp3–3,5 juta','Full-time','email'],
                ["<i class='bx bx-brush'></i>",'Cleaning Service','Hotel Banyuwangi','4.2 km','Rp2,5–3 juta','Full-time','whatsapp'],
                ["<i class='bx bx-package'></i>",'Helper Gudang','PT Logistik Jaya','5.1 km','Rp2,8–3,4 juta','Full-time','email'],
                ["<i class='bx bx-car'></i>",'Driver','CV Jasa Antar','3.2 km','Rp3–4 juta','Full-time','whatsapp'],
            ] as [$icon, $pos, $emp, $dist, $gaji, $type, $contact])
            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-xl shrink-0">{!! $icon !!}</div>
                    <div class="min-w-0">
                        <h4 class="font-bold text-slate-800 text-sm truncate">{{ $pos }}</h4>
                        <p class="text-xs text-slate-500 truncate">{{ $emp }} ✓</p>
                    </div>
                </div>
                <div class="space-y-1 mb-3">
                    <div class="flex items-center gap-1 text-xs text-slate-500"><span><i class='bx bx-map'></i></span> {{ $dist }} dari Anda</div>
                    <div class="flex items-center gap-1 text-xs text-slate-500"><span><i class='bx bx-money'></i></span> {{ $gaji }}/bulan</div>
                    <div class="flex items-center gap-1 text-xs text-slate-500"><span><i class='bx bx-time-five'></i></span> {{ $type }}</div>
                </div>
                <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-1 rounded-lg {{ $contact === 'whatsapp' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                    {!! $contact === 'whatsapp' ? "<i class='bx bxl-whatsapp'></i> WhatsApp" : "<i class='bx bx-envelope'></i> Email" !!}
                </span>
            </div>
            @endforeach
        </div>
        <div class="text-center">
            <a href="{{ route('register.applicant') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white font-bold text-base px-8 py-4 rounded-2xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/20">
                <i class='bx bx-search'></i> Lihat Semua Lowongan — Daftar Gratis
            </a>
        </div>
    </div>
</section>

{{-- ===== CTA EMPLOYER ===== --}}
<section class="py-20 px-4 bg-gradient-to-br from-slate-800 to-slate-900 text-white">
    <div class="max-w-2xl mx-auto text-center">
        <div class="text-4xl mb-4"><i class='bx bx-buildings'></i></div>
        <h2 class="text-3xl font-extrabold mb-4">Butuh Tenaga Kerja?</h2>
        <p class="text-slate-300 text-lg mb-8 leading-relaxed">Posting lowongan gratis dan temukan karyawan yang tinggal di dekat usaha Anda. Cocok untuk warung, toko, hotel, dan semua jenis usaha lokal.</p>
        <a href="{{ route('register.company') }}" class="inline-flex items-center gap-2 bg-white text-slate-900 font-extrabold text-base px-8 py-4 rounded-2xl hover:bg-yellow-50 transition-all">
            <i class='bx bx-rocket'></i> Mulai Posting Lowongan — Gratis
        </a>
    </div>
</section>

{{-- ===== FOOTER ===== --}}
<footer class="bg-slate-900 text-slate-400 py-10 px-4">
    <div class="max-w-4xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
            </div>
            <span class="font-extrabold text-white">NEAR JOB</span>
        </div>
        <p class="text-sm">Temukan pekerjaan di sekitar Anda. Hubungi pemberi kerja secara langsung.</p>
        <p class="text-xs">© 2026 Near Job. Prototype demo.</p>
    </div>
</footer>

</body>
</html>
