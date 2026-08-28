<div class="min-h-[calc(100vh-8rem)] flex flex-col items-center justify-center p-4">
    
    @if(!$profileComplete)
        <!-- Warning Banner if Profile Incomplete -->
        <div class="max-w-md w-full bg-white p-8 rounded-3xl border border-amber-200 shadow-xl text-center space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center mx-auto text-3xl font-extrabold">
                ⚠️
            </div>
            <h2 class="text-xl font-extrabold text-slate-900">Profil Anda Belum Lengkap</h2>
            <p class="text-sm text-slate-600 leading-relaxed">
                Untuk mulai swipe kartu lowongan di sekitar lokasi Anda, silakan lengkapi riwayat pendidikan, domisili kota, dan email kontak terlebih dahulu.
            </p>
            <a href="{{ route('applicant.profile') }}" class="inline-block w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition-all text-sm">
                Lengkapi Profil Sekarang →
            </a>
        </div>
    @elseif($noMoreJobs || !$currentJob)
        <!-- Empty State - No Matching Jobs -->
        <div class="max-w-md w-full bg-white p-8 rounded-3xl border border-slate-200 shadow-xl text-center space-y-5">
            <div class="w-20 h-20 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto text-4xl animate-bounce">
                🎉
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900">Lowongan Sudah Habis!</h2>
            <p class="text-sm text-slate-600 leading-relaxed">
                Anda sudah melihat semua lowongan yang cocok di sekitar radius lokasi Anda. Coba perbarui profil atau cek riwayat lamaran Anda.
            </p>
            <div class="flex flex-col gap-2 pt-2">
                <button wire:click="loadJobs" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition-all text-sm">
                    🔄 Muat Ulang Lowongan
                </button>
                <a href="{{ route('applicant.applications') }}" class="w-full py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-colors text-sm">
                    Lihat Riwayat Lamaran
                </a>
            </div>
        </div>
    @else
        <!-- Swipe Cards Container -->
        <div class="flex flex-col items-center space-y-6">
            
            <!-- Instructions Header -->
            <div class="text-center">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Swipe Kanan (Lamar) • Swipe Kiri (Lewati)</span>
            </div>

            <!-- Card Stack physics area -->
            <div class="card-stack">
                
                <!-- Background Next Card Preview -->
                @if($nextJob)
                    <div class="swipe-card scale-95 opacity-60 translate-y-3 pointer-events-none">
                        <div class="p-6 bg-slate-100 border-b border-slate-200 flex justify-between items-start">
                            <div>
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-200 text-slate-700">
                                    {{ $nextJob['work_type'] }}
                                </span>
                                <h3 class="text-xl font-bold text-slate-900 mt-2">{{ $nextJob['position'] }}</h3>
                                <p class="text-sm font-semibold text-slate-600">{{ $nextJob['company_name'] }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Active Top Card (Draggable / Swipable) -->
                <div id="active-swipe-card" 
                     wire:key="job-card-{{ $currentJob['id'] }}"
                     x-data="{}"
                     x-init="window.initSwipeCard($el, {{ $currentJob['id'] }}, $wire)"
                     class="swipe-card">
                    
                    <!-- Swipe Badges (OVERLAY) -->
                    <div class="swipe-badge swipe-badge-like">LAMAR ✓</div>
                    <div class="swipe-badge swipe-badge-nope">LEWATI ✕</div>

                    <!-- Card Header (Indigo gradient bar) -->
                    <div class="p-6 bg-gradient-to-r from-slate-900 to-indigo-950 text-white relative">
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-500/30 text-indigo-200 border border-indigo-400/30">
                                {{ $currentJob['work_type'] }}
                            </span>
                            @if(isset($currentJob['distance_km']))
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-500/30 text-emerald-200 border border-emerald-400/30 flex items-center gap-1">
                                    📍 {{ $currentJob['distance_km'] }} km
                                </span>
                            @endif
                        </div>

                        <h2 class="text-2xl font-black text-white leading-tight">{{ $currentJob['position'] }}</h2>
                        <p class="text-base font-semibold text-indigo-200 mt-0.5">{{ $currentJob['company_name'] }}</p>
                        
                        <div class="flex items-center gap-2 mt-3 text-xs text-slate-300">
                            <span>📍 {{ $currentJob['city'] }}</span>
                            <span>•</span>
                            <span>🎓 Min. {{ $currentJob['min_education'] }}</span>
                        </div>
                    </div>

                    <!-- Card Body (Scrollable details) -->
                    <div class="p-6 flex-grow overflow-y-auto space-y-4 text-slate-700 text-sm">
                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Deskripsi Pekerjaan</h4>
                            <p class="leading-relaxed text-slate-600">{{ $currentJob['description'] }}</p>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Kualifikasi</h4>
                            <p class="leading-relaxed text-slate-600">{{ $currentJob['qualifications'] }}</p>
                        </div>

                        @if(!empty($currentJob['required_skills']))
                            <div>
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Skill Dibutuhkan</h4>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($currentJob['required_skills'] as $skill)
                                        <span class="px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-700 text-xs font-semibold border border-indigo-100">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Programmatic Swipe Control Buttons (Fallback for Touch/Mouse) -->
            <div class="flex items-center justify-center gap-6 pt-2">
                <!-- Swipe Left (Pass / Reject) -->
                <button type="button" 
                        onclick="document.getElementById('active-swipe-card')?.triggerSwipe('left')"
                        class="w-16 h-16 rounded-full bg-white text-red-500 hover:bg-red-50 border-2 border-red-200 shadow-lg flex items-center justify-center text-2xl transition-all hover:scale-110 active:scale-95 group">
                    <span class="group-hover:scale-125 transition-transform">✕</span>
                </button>

                <!-- Swipe Right (Apply / Right) -->
                <button type="button" 
                        onclick="document.getElementById('active-swipe-card')?.triggerSwipe('right')"
                        class="w-16 h-16 rounded-full bg-indigo-600 text-white hover:bg-indigo-700 shadow-xl shadow-indigo-300 flex items-center justify-center text-2xl transition-all hover:scale-110 active:scale-95 group">
                    <span class="group-hover:scale-125 transition-transform">✓</span>
                </button>
            </div>

        </div>
    @endif
</div>
