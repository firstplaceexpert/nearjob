<div class="p-4 bg-slate-50 min-h-full pb-8">
    <div class="max-w-xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800 mb-1">Semua Lowongan</h1>
                <p class="text-slate-500 text-sm">Kelola lowongan yang Anda posting.</p>
            </div>
            <a href="{{ route('company.jobs.create') }}" class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center text-xl shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition-colors">+</a>
        </div>

        @if($jobs->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-100 shadow-sm mt-4">
                <div class="text-5xl mb-4"><i class='bx bx-mail-send'></i></div>
                <h3 class="text-lg font-extrabold text-slate-700">Belum ada lowongan</h3>
                <p class="text-sm text-slate-500 mt-2 max-w-[250px] mx-auto">Anda belum membuat lowongan apapun. Mulai cari karyawan sekarang!</p>
                <a href="{{ route('company.jobs.create') }}" class="inline-block mt-6 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors">
                    Pasang Lowongan Pertama
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($jobs as $job)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 relative">
                        <div class="absolute top-4 right-4 text-slate-400">
                            <a href="{{ route('company.jobs.edit', $job->id) }}" class="p-2 hover:bg-slate-50 rounded-lg transition-colors"><i class='bx bx-edit-alt'></i> Edit</a>
                        </div>

                        <div class="pr-16 mb-4">
                            <h3 class="font-extrabold text-lg text-slate-800">{{ $job->position }}</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 bg-{{ $job->status === 'active' ? 'emerald' : ($job->status === 'filled' ? 'blue' : 'slate') }}-100 text-{{ $job->status === 'active' ? 'emerald' : ($job->status === 'filled' ? 'blue' : 'slate') }}-700 text-[10px] font-bold rounded uppercase tracking-wider">
                                    {{ $job->status === 'active' ? 'Aktif' : ($job->status === 'filled' ? 'Terisi' : 'Ditutup') }}
                                </span>
                                <span class="text-xs text-slate-500">Dibuat {{ $job->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-2 text-xs font-semibold text-slate-600 mb-4 bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <div class="flex flex-col gap-1">
                                <span class="text-slate-400 uppercase tracking-widest text-[9px] font-bold">Total Pelamar</span>
                                <span class="text-sm text-blue-600 font-extrabold"><i class='bx bx-group'></i> {{ $job->applications_count }}</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-slate-400 uppercase tracking-widest text-[9px] font-bold">Kategori</span>
                                <span class="truncate">{{ \App\Models\JobListing::jobCategories()[$job->job_category] }}</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('company.jobs.applicants', $job->id) }}" class="block w-full py-3 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold rounded-xl text-center text-sm transition-colors border border-blue-100">
                            Lihat {{ $job->applications_count }} Pelamar →
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
