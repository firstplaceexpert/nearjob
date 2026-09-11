<div class="min-h-screen pb-36 pt-16" style="background: #f0f4f9;">
    <div class="max-w-xl mx-auto px-4 pt-5">

        {{-- ===== HEADER ===== --}}
        <div class="flex items-center justify-between mb-5">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-800">Lowongan Saya</h1>
                <p class="text-slate-400 text-sm mt-0.5">Kelola lowongan yang Anda posting</p>
            </div>
            <a href="{{ route('company.jobs.create') }}"
               class="w-11 h-11 text-white rounded-xl flex items-center justify-center text-xl transition-all"
               style="background: #5680d8; box-shadow: 0 4px 15px rgba(86,128,216,.3);">
                <i class='bx bx-plus'></i>
            </a>
        </div>

        @if($jobs->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl" style="border: 1px dashed #c7d6f5;">
                <i class='bx bx-mail-send text-5xl mb-4' style="color: #c7d6f5;"></i>
                <h3 class="text-lg font-extrabold text-slate-600 mb-1">Belum ada lowongan</h3>
                <p class="text-sm text-slate-400 mb-5 max-w-[220px] mx-auto">Mulai cari karyawan untuk usaha Anda sekarang</p>
                <a href="{{ route('company.jobs.create') }}"
                   class="inline-flex items-center gap-2 text-white text-sm font-bold px-6 py-3 rounded-xl"
                   style="background: #5680d8;">
                    <i class='bx bx-plus'></i> Pasang Lowongan Pertama
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($jobs as $job)
                <div class="bg-white rounded-2xl p-4 relative" style="border: 1px solid #e8edf5; box-shadow: 0 2px 10px rgba(0,0,0,.04);">
                    {{-- Edit button (Wrap Garis Hitam & Tulisan Hitam) --}}
                    <div class="absolute top-4 right-4">
                        <a href="{{ route('company.jobs.edit', $job->id) }}"
                           class="flex items-center gap-1 text-xs font-bold px-3 py-1.5 rounded-lg transition-all border border-black text-black bg-white hover:opacity-75">
                            <i class='bx bx-edit-alt'></i> Edit
                        </a>
                    </div>

                    <div class="pr-16 mb-3">
                        <h3 class="font-extrabold text-lg text-slate-800">{{ $job->position }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            @php
                                $statusLabel = $job->status === 'active' ? 'Aktif' : ($job->status === 'filled' ? 'Terisi' : 'Ditutup');
                            @endphp
                            <span class="text-[10px] font-bold px-2.5 py-0.5 rounded border border-black text-black uppercase tracking-wider bg-white">
                                {{ $statusLabel }}
                            </span>
                            <span class="text-xs text-slate-400">{{ $job->created_at->format('d M Y') }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-4 gap-2 p-3 rounded-xl mb-3 text-center bg-white border border-black/15">
                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-0.5">Pelamar</p>
                            <p class="text-base font-black text-black">{{ $job->applications_count }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-0.5">Kuota</p>
                            <p class="text-base font-black text-black">{{ $job->quota ?? 1 }} Org</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-0.5">Bidang</p>
                            <p class="text-xs font-bold text-black truncate">{{ \App\Models\JobListing::jobCategories()[$job->job_category] ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mb-0.5">Jenis</p>
                            <p class="text-xs font-bold text-black">{{ \App\Models\JobListing::workTypes()[$job->work_type] ?? '-' }}</p>
                        </div>
                    </div>

                    <a href="{{ route('company.jobs.applicants', $job->id) }}"
                       class="block w-full py-3 font-bold rounded-xl text-center text-sm transition-all text-white cursor-pointer"
                       style="background: #5680d8; box-shadow: 0 4px 12px rgba(86,128,216,.3);">
                        Lihat {{ $job->applications_count }} Pelamar →
                    </a>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
