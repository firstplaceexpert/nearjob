<div class="max-w-7xl mx-auto px-4 py-8 space-y-6">
    
    <!-- Job Header Info -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('company.jobs') }}" class="text-xs font-bold text-indigo-600 hover:underline inline-flex items-center gap-1 mb-2">
                ← Kembali ke Daftar Lowongan
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $jobListing->position }}</h1>
            <p class="text-slate-500 text-sm mt-1">
                📍 {{ $jobListing->city }} • {{ $jobListing->work_type_label }} • Status: 
                <span class="font-bold {{ $jobListing->status === 'active' ? 'text-emerald-600' : 'text-slate-500' }}">
                    {{ $jobListing->status === 'active' ? 'Aktif di Swipe' : 'Sudah Terisi' }}
                </span>
            </p>
        </div>

        @if($jobListing->status === 'active')
            <button type="button" wire:click="markJobFilled" 
                    class="px-5 py-2.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold border border-emerald-200 rounded-xl text-xs transition-colors shrink-0">
                ✓ Tandai Lowongan Sudah Terisi
            </button>
        @endif
    </div>

    <!-- Applicants CV List -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <h2 class="text-lg font-bold text-slate-900">Daftar Pelamar (Swiped Right)</h2>

        @if($applications->isEmpty())
            <div class="text-center py-12 text-slate-500 space-y-2">
                <div class="text-3xl">📭</div>
                <p class="font-semibold text-base">Belum Ada Pelamar</p>
                <p class="text-xs text-slate-400">Belum ada pelamar yang swipe kanan pada posisi lowongan ini.</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($applications as $app)
                    @php
                        $profile = $app->user->applicantProfile;
                    @endphp
                    <div class="p-6 rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:shadow-md transition-all space-y-4">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200/80">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-indigo-600 text-white font-black text-xl flex items-center justify-center shadow-md overflow-hidden shrink-0">
                                    @if($profile?->photo)
                                        <img src="{{ asset('storage/' . $profile->photo) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr($app->user->name, 0, 1)) }}
                                    @endif
                                </div>

                                <div>
                                    <h3 class="text-lg font-bold text-slate-900">{{ $app->user->name }}</h3>
                                    <p class="text-xs text-slate-500 flex flex-wrap items-center gap-1.5 mt-0.5">
                                        <span>📍 {{ $profile?->city ?? '-' }}</span>
                                        @if(isset($app->distance_km))
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                ⚡ ~{{ $app->distance_km }} km
                                            </span>
                                        @endif
                                        <span>• 🎓 {{ \App\Models\ApplicantProfile::educationLevels()[$profile?->education_level ?? ''] ?? '-' }} ({{ $profile?->education_institution ?? '-' }})</span>
                                    </p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">Dilamar pada {{ $app->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>

                            <!-- Direct Email Contact CTA -->
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="mailto:{{ $profile?->contact_email ?? $app->user->email }}?subject=Lamaran%20Kerja%20Posisi%20{{ urlencode($jobListing->position) }}%20di%20{{ urlencode($jobListing->company->company_name) }}" 
                                   wire:click="updateStatus({{ $app->id }}, 'contacted')"
                                   class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow-md shadow-indigo-200 transition-all flex items-center gap-1.5">
                                    <span>✉️ Contact via Email</span>
                                </a>

                                <button type="button" wire:click="updateStatus({{ $app->id }}, 'viewed')" class="px-3 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-xl text-xs">
                                    Tandai Dilihat
                                </button>
                            </div>
                        </div>

                        <!-- Full CV Details (Skills & Experience) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-700">
                            <div>
                                <h4 class="font-bold text-slate-500 uppercase tracking-wider mb-1">Bidang Studi & Jurusan</h4>
                                <p class="font-medium text-slate-900">{{ $profile?->field_of_study ?? '-' }}</p>
                                
                                <h4 class="font-bold text-slate-500 uppercase tracking-wider mt-3 mb-1">Email Kontak Direct</h4>
                                <p class="font-medium text-slate-900 select-all">{{ $profile?->contact_email ?? $app->user->email }}</p>
                            </div>

                            <div>
                                <h4 class="font-bold text-slate-500 uppercase tracking-wider mb-1">Skills & Keahlian</h4>
                                <div class="flex flex-wrap gap-1">
                                    @if(!empty($profile?->skills))
                                        @foreach($profile->skills as $sk)
                                            <span class="px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 font-semibold border border-indigo-100">{{ $sk }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-slate-400">Tidak ada skill terdaftar</span>
                                    @endif
                                </div>
                            </div>

                            <div class="md:col-span-2 pt-2 border-t border-slate-100">
                                <h4 class="font-bold text-slate-500 uppercase tracking-wider mb-1">Pengalaman Kerja / Organisasi</h4>
                                <p class="text-slate-600 leading-relaxed whitespace-pre-line">{{ $profile?->work_experience ?? 'Belum ada pengalaman tercantum' }}</p>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="pt-4">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</div>
