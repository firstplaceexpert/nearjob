<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Daftar Lowongan Perusahaan</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola lowongan aktif, lihat CV masuk, atau tandai lowongan yang sudah terisi</p>
            </div>
            <a href="{{ route('company.jobs.create') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-xs shadow-sm transition-all">
                + Pasang Lowongan Baru
            </a>
        </div>

        @if($jobs->isEmpty())
            <div class="text-center py-12 text-slate-500 space-y-3">
                <div class="text-4xl">💼</div>
                <p class="font-semibold text-base">Belum Ada Lowongan Dipasang</p>
                <p class="text-xs text-slate-400">Buat lowongan pekerjaan pertama Anda untuk menerima lamaran kandidat lokal.</p>
                <div class="pt-2">
                    <a href="{{ route('company.jobs.create') }}" class="inline-block px-6 py-2.5 bg-indigo-600 text-white font-bold text-xs rounded-xl shadow-md hover:bg-indigo-700 transition-all">
                        Buat Lowongan Pertama
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach($jobs as $job)
                    <div class="p-6 rounded-2xl border border-slate-200 bg-white hover:border-slate-300 shadow-sm transition-all flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider bg-slate-100 text-slate-700">
                                    {{ $job->work_type_label }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700">
                                    {{ $job->category_label }}
                                </span>
                                @if($job->status === 'active')
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                        ● Aktif di Swipe
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-slate-200 text-slate-700">
                                        ✓ Sudah Terisi
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-xl font-bold text-slate-900">{{ $job->position }}</h3>
                            
                            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
                                <span>📍 {{ $job->city }} (Radius {{ $job->radius_km }}km)</span>
                                <span>•</span>
                                <span>🎓 Min. {{ \App\Models\ApplicantProfile::educationLevels()[$job->min_education] ?? '' }}</span>
                                <span>•</span>
                                <span>📅 Dipasang {{ $job->created_at->format('d M Y') }}</span>
                            </div>
                        </div>

                        <!-- Actions & CV counter -->
                        <div class="flex flex-wrap items-center gap-3 shrink-0">
                            <!-- CV counter button -->
                            <a href="{{ route('company.jobs.applicants', $job->id) }}" class="px-4 py-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs rounded-xl border border-indigo-200 transition-colors flex items-center gap-2">
                                <span>📥 CV Masuk</span>
                                <span class="px-2 py-0.5 rounded-full bg-indigo-600 text-white text-[11px] font-black">
                                    {{ $job->applications_count }}
                                </span>
                            </a>

                            <!-- Edit -->
                            <a href="{{ route('company.jobs.edit', $job->id) }}" class="px-3.5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-colors">
                                Edit
                            </a>

                            <!-- Toggle Filled Status -->
                            <button type="button" wire:click="markAsFilled({{ $job->id }})" 
                                    class="px-3.5 py-2.5 rounded-xl font-semibold text-xs transition-colors {{ $job->status === 'active' ? 'bg-amber-50 text-amber-800 hover:bg-amber-100 border border-amber-200' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100 border border-emerald-200' }}">
                                {{ $job->status === 'active' ? 'Tandai Terisi' : 'Aktifkan Kembali' }}
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-4">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
</div>
