<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">
    
    <!-- Search & Filter Banner -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-black/15 shadow-sm space-y-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-black">Jelajahi Lowongan Kerja Lokal</h1>
            <p class="text-black text-sm mt-1 font-medium">Cari lowongan aktif dari perusahaan dan UMKM di sekitar Anda</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-black mb-1">Cari Kata Kunci</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Posisi atau nama perusahaan..." class="w-full px-4 py-2.5 rounded-xl border border-black/25 focus:ring-2 focus:ring-black text-sm text-black">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-black mb-1">Kota / Lokasi</label>
                <select wire:model.live="city" class="w-full px-4 py-2.5 rounded-xl border border-black/25 focus:ring-2 focus:ring-black text-sm text-black">
                    <option value="">Semua Kota</option>
                    @foreach($cities as $c)
                        <option value="{{ $c->name }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-black mb-1">Tipe Kerja</label>
                <select wire:model.live="work_type" class="w-full px-4 py-2.5 rounded-xl border border-black/25 focus:ring-2 focus:ring-black text-sm text-black">
                    <option value="">Semua Tipe</option>
                    @foreach($workTypes as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-black mb-1">Kategori</label>
                <select wire:model.live="category" class="w-full px-4 py-2.5 rounded-xl border border-black/25 focus:ring-2 focus:ring-black text-sm text-black">
                    <option value="">Semua Kategori</option>
                    @foreach($jobCategories as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Jobs Grid -->
    @if($jobs->isEmpty())
        <div class="text-center py-16 bg-white rounded-3xl border border-black/15 text-black space-y-2">
            <div class="text-3xl text-black flex justify-center"><i class='bx bx-search'></i></div>
            <p class="font-bold text-base text-black">Tidak ada lowongan yang sesuai kriteria filter Anda.</p>
            <p class="text-xs text-black font-medium">Coba ubah kata kunci atau bersihkan filter pencarian.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($jobs as $job)
                <div class="bg-white p-6 rounded-3xl border border-black/15 hover:border-black hover:shadow-lg transition-all flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider border border-black text-black bg-white">
                                {{ $job->work_type_label }}
                            </span>
                            <span class="text-xs text-black font-medium inline-flex items-center gap-1">
                                <i class='bx bx-map-pin text-[#5680d8]'></i> {{ $job->city }}
                            </span>
                        </div>

                        <h3 class="text-xl font-extrabold text-black leading-snug">{{ $job->position }}</h3>
                        <p class="text-sm font-bold text-black">{{ $job->company->company_name }}</p>

                        <p class="text-xs text-black font-medium line-clamp-3 leading-relaxed">{{ $job->description }}</p>
                    </div>

                    <div class="pt-4 border-t border-black/10 flex items-center justify-between gap-2">
                        <span class="text-xs font-bold text-black">Min. {{ \App\Models\ApplicantProfile::educationLevels()[$job->min_education] ?? '' }}</span>
                        <a href="{{ route('register.applicant') }}" class="px-4 py-2 text-white font-bold rounded-xl text-xs shadow-sm transition-all text-decoration-none" style="background: #5680d8;">
                            Daftar & Swipe →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pt-4">
            {{ $jobs->links() }}
        </div>
    @endif
</div>
