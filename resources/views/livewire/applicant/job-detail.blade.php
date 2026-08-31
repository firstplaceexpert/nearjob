<div class="pb-24">
    {{-- Header --}}
    <div class="bg-white border-b border-slate-100 px-4 py-8">
        <div class="max-w-xl mx-auto flex items-start gap-4">
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-3xl font-black shrink-0 border border-blue-100">
                {{ substr($job->company->company_name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800 leading-tight mb-1">{{ $job->position }}</h1>
                <p class="text-slate-500 font-semibold flex items-center gap-1">
                    {{ $job->company->company_name }}
                    <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                </p>
            </div>
        </div>
    </div>

    {{-- Info Cards --}}
    <div class="max-w-xl mx-auto px-4 py-6">
        <div class="grid grid-cols-2 gap-3 mb-6">
            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center text-center">
                <span class="text-2xl mb-1"><i class='bx bx-map'></i></span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-0.5">Jarak</span>
                <span class="text-sm font-extrabold text-slate-800">{{ $job->distance }} km dari Anda</span>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center text-center">
                <span class="text-2xl mb-1"><i class='bx bx-money'></i></span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-0.5">Gaji (Bulan)</span>
                <span class="text-sm font-extrabold text-slate-800">{{ $job->salary_range }}</span>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center text-center">
                <span class="text-2xl mb-1"><i class='bx bx-time-five'></i></span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-0.5">Sistem Kerja</span>
                <span class="text-sm font-extrabold text-slate-800">{{ $job->work_type_label }}</span>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center text-center">
                <span class="text-2xl mb-1"><i class='bx bx-graduation'></i></span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-0.5">Pendidikan</span>
                <span class="text-sm font-extrabold text-slate-800">Min. {{ strtoupper($job->min_education) }}</span>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 mb-6">
            <h3 class="text-lg font-extrabold text-slate-800 mb-3 border-b border-slate-100 pb-2">Deskripsi Pekerjaan</h3>
            <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line mb-6">{{ $job->description }}</p>

            <h3 class="text-lg font-extrabold text-slate-800 mb-3 border-b border-slate-100 pb-2">Kualifikasi</h3>
            <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line mb-6">{{ $job->qualifications }}</p>

            @if($job->required_skills && count($job->required_skills) > 0)
                <h3 class="text-lg font-extrabold text-slate-800 mb-3 border-b border-slate-100 pb-2">Keahlian yang Dibutuhkan</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($job->required_skills as $skill)
                        <span class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-bold border border-blue-100">{{ $skill }}</span>
                    @endforeach
                </div>
            @endif
        </div>
        
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 mb-6">
            <h3 class="text-lg font-extrabold text-slate-800 mb-3 border-b border-slate-100 pb-2">Informasi Tambahan</h3>
            <ul class="space-y-3 text-sm text-slate-600">
                <li class="flex items-start gap-2">
                    <span class="text-lg leading-none"><i class='bx bx-buildings'></i></span> 
                    <span><strong>Alamat:</strong> {{ $job->company->address }}, {{ $job->company->city }}</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-lg leading-none"><i class='bx bx-time'></i></span> 
                    <span><strong>Durasi Kontrak:</strong> {{ $job->work_duration ?? 'Tidak disebutkan' }}</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-lg leading-none">⏰</span> 
                    <span><strong>Jam Kerja:</strong> {{ $job->work_hours ?? 'Tidak disebutkan' }}</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-lg leading-none">📞</span> 
                    <span><strong>Metode Melamar:</strong> Melalui {{ $job->contact_method === 'whatsapp' ? 'WhatsApp' : 'Email' }}</span>
                </li>
            </ul>
        </div>
    </div>

    {{-- Floating Apply Bar --}}
    <div class="fixed bottom-[env(safe-area-inset-bottom)] left-0 right-0 p-4 bg-white/80 backdrop-blur-md border-t border-slate-100 z-40 pb-20">
        <div class="max-w-xl mx-auto flex gap-3">
            <a href="{{ route('applicant.map') }}" class="w-14 h-14 shrink-0 rounded-2xl border-2 border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            
            @if($hasApplied)
                <button disabled class="flex-grow py-3.5 bg-emerald-100 text-emerald-700 font-extrabold rounded-2xl text-base flex items-center justify-center gap-2 cursor-not-allowed">
                    ✓ Sudah Dilamar
                </button>
            @else
                <button wire:click="applyForJob" class="flex-grow py-3.5 {{ $credits > 0 ? 'bg-blue-600 hover:bg-blue-700 shadow-xl shadow-blue-600/30' : 'bg-slate-300 cursor-not-allowed' }} text-white font-extrabold rounded-2xl text-base transition-colors flex items-center justify-center gap-2">
                    @if($credits > 0)
                        Lamar via {{ ucfirst($job->contact_method) }}
                        <span class="bg-white/20 text-xs px-2 py-0.5 rounded-full backdrop-blur-sm">-1 Kredit</span>
                    @else
                        Kredit Habis
                    @endif
                </button>
            @endif
        </div>
        
        @if(!$hasApplied && $credits <= 0)
            <p class="text-center mt-2 text-xs font-semibold text-red-500 max-w-xl mx-auto">
                Sisa kredit lamaran Anda 0. <a href="{{ route('applicant.profile') }}" class="underline">Beli kredit.</a>
            </p>
        @endif
    </div>
</div>
