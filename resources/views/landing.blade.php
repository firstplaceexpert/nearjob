<x-layouts.guest>
    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-28 bg-gradient-to-b from-indigo-50/50 via-white to-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto space-y-6">
                
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-100/80 border border-indigo-200 text-indigo-700 text-xs font-semibold uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                    Platform Matching Kerja Gen Z & UMKM Lokal
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.15]">
                    Cari Kerja Lokal Cuma Lewat <span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Swipe Kartu</span>
                </h1>

                <p class="text-lg sm:text-xl text-slate-600 font-normal leading-relaxed">
                    Swipe kanan untuk melamar lowongan di sekitar lokasi Anda. Kirim CV langsung ke HR perusahaan dan UMKM lokal tanpa proses ribet!
                </p>

                <!-- Dual Action CTAs -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <a href="{{ route('register.applicant') }}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300 transition-all flex items-center justify-center gap-2 text-base">
                        <span>Lamar Pekerjaan (Swipe)</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                    
                    <a href="{{ route('register.company') }}" class="w-full sm:w-auto px-8 py-4 bg-white hover:bg-slate-50 text-slate-800 font-bold rounded-2xl border border-slate-300 shadow-sm transition-all flex items-center justify-center gap-2 text-base">
                        <span>Pasang Lowongan (Perusahaan)</span>
                    </a>
                </div>

                <!-- Live stats badges -->
                <div class="pt-10 flex flex-wrap items-center justify-center gap-8 text-slate-500 text-sm font-medium">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <span>Filter Radius Lokasi (Haversine)</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>100% Bebas Biaya Pelamar</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>Kandidat Langsung ke Email HR</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-16 bg-white border-y border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-3xl font-extrabold text-slate-900">Cara Kerja NearJob</h2>
                <p class="text-slate-600 mt-2">3 langkah mudah menemukan pekerjaan lokal impian Anda</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 flex flex-col items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white font-black text-xl flex items-center justify-center shadow-md shadow-indigo-200">
                        1
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Isi Profil Ringkas</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Lengkapi pendidikan, pengalaman, skill, dan lokasi Anda. Tanpa formulir rumit yang memakan waktu.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 flex flex-col items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white font-black text-xl flex items-center justify-center shadow-md shadow-indigo-200">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Swipe Kartu Lowongan</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Lihat kartu lowongan kerja lokal yang sudah difilter sesuai radius lokasi Anda. Swipe kanan untuk melamar, swipe kiri untuk lewati.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200 flex flex-col items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white font-black text-xl flex items-center justify-center shadow-md shadow-indigo-200">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Perusahaan Contact Anda</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        CV lengkap Anda akan terkirim ke dashboard HR. Jika cocok, perusahaan akan menghubungi via email untuk interview.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Public Job Preview Section -->
    <section class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900">Lowongan Kerja Terbaru</h2>
                    <p class="text-slate-600 text-sm mt-1">Jelajahi berbagai peluang karir dari UMKM dan perusahaan lokal</p>
                </div>
                <a href="{{ route('browse') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm flex items-center gap-1">
                    Lihat Semua Lowongan →
                </a>
            </div>

            <div class="text-center py-12 bg-white rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-slate-500 font-medium">Buka menu <b>Cari Lowongan</b> atau daftarkan akun untuk langsung swipe kartu!</p>
                <div class="mt-4">
                    <a href="{{ route('browse') }}" class="px-6 py-2.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 font-semibold rounded-xl text-sm transition-colors inline-block">
                        Jelajahi Lowongan
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.guest>
