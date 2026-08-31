<div class="p-4 bg-slate-50 min-h-full pb-8">
    <div class="max-w-xl mx-auto">
        <h1 class="text-2xl font-extrabold text-slate-800 mb-2">Dashboard</h1>
        <p class="text-slate-500 text-sm mb-6">Selamat datang kembali, <strong>{{ $company->owner_name }}</strong> dari {{ $company->company_name }}.</p>

        {{-- Stats --}}
        <div class="grid grid-cols-2 gap-3 mb-6">
            <div class="bg-blue-600 rounded-3xl p-5 text-white shadow-lg shadow-blue-600/20 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-6xl opacity-10"><i class='bx bx-briefcase'></i></div>
                <p class="text-xs font-bold text-blue-200 uppercase tracking-widest mb-1">Total Lowongan</p>
                <p class="text-4xl font-black">{{ $totalJobs }}</p>
            </div>
            <div class="bg-emerald-500 rounded-3xl p-5 text-white shadow-lg shadow-emerald-500/20 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-6xl opacity-10"><i class='bx bx-group'></i></div>
                <p class="text-xs font-bold text-emerald-200 uppercase tracking-widest mb-1">Total Pelamar</p>
                <p class="text-4xl font-black">{{ $totalApplicants }}</p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-4 mb-6 flex gap-3">
            <a href="{{ route('company.jobs.create') }}" class="flex-1 py-3 bg-blue-50 text-blue-700 font-extrabold rounded-xl text-center text-sm hover:bg-blue-100 transition-colors">
                + Pasang Lowongan
            </a>
            <a href="{{ route('company.jobs') }}" class="flex-1 py-3 border border-slate-200 text-slate-700 font-bold rounded-xl text-center text-sm hover:bg-slate-50 transition-colors">
                Semua Lowongan
            </a>
        </div>

        {{-- Recent Jobs --}}
        <h2 class="text-lg font-extrabold text-slate-800 mb-4 border-b border-slate-100 pb-2">Lowongan Terbaru</h2>
        
        @if($recentJobs->isEmpty())
            <div class="text-center py-10 bg-white rounded-2xl border border-slate-100 border-dashed">
                <p class="text-sm text-slate-500">Anda belum memiliki lowongan.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach($recentJobs as $job)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-extrabold text-slate-800">{{ $job->position }}</h3>
                                <p class="text-xs text-slate-500">{{ $job->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-2 py-1 bg-{{ $job->status === 'active' ? 'emerald' : ($job->status === 'filled' ? 'blue' : 'slate') }}-100 text-{{ $job->status === 'active' ? 'emerald' : ($job->status === 'filled' ? 'blue' : 'slate') }}-700 text-[10px] font-bold rounded uppercase tracking-wider">
                                {{ $job->status === 'active' ? 'Aktif' : ($job->status === 'filled' ? 'Terisi' : 'Ditutup') }}
                            </span>
                        </div>
                        
                        <div class="flex items-center gap-4 text-xs font-semibold text-slate-600 mb-4">
                            <span class="flex items-center gap-1"><i class='bx bx-group'></i> {{ $job->applications_count }} Pelamar</span>
                            <span class="flex items-center gap-1"><i class='bx bx-map'></i> {{ $job->city }}</span>
                        </div>
                        
                        <a href="{{ route('company.jobs.applicants', $job->id) }}" class="block w-full py-2.5 bg-slate-50 text-slate-700 hover:text-blue-600 font-bold rounded-xl text-center text-xs border border-slate-200 hover:border-blue-200 transition-colors">
                            Kelola Pelamar →
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
