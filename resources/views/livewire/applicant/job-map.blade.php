<div class="h-[calc(100vh-112px)] flex flex-col relative bg-slate-50 overflow-hidden" x-data="{
    initMap() {
        if(this.map) return;
        this.map = L.map('map-container', {zoomControl: false}).setView([{{ $userLat }}, {{ $userLon }}], 14);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href=\'https://www.openstreetmap.org/copyright\'>OpenStreetMap</a>'
        }).addTo(this.map);
        
        // User marker
        const userIcon = L.divIcon({
            html: '<div style=\'width:16px;height:16px;background:#2563eb;border:3px solid white;border-radius:50%;box-shadow:0 0 0 8px rgba(37,99,235,.2);\'></div>',
            className: '', iconSize: [16,16], iconAnchor: [8,8]
        });
        L.marker([{{ $userLat }}, {{ $userLon }}], {icon: userIcon, zIndexOffset: 1000}).addTo(this.map);
        
        this.renderJobMarkers();
        
        // Watch for Livewire updates
        Livewire.hook('morph.updated', ({ component }) => {
            if(this.map) this.renderJobMarkers();
        });
    },
    renderJobMarkers() {
        if(this.markers) this.markers.forEach(m => this.map.removeLayer(m));
        this.markers = [];
        
        const jobsDataEl = document.getElementById('jobs-data-element');
        const jobs = jobsDataEl ? JSON.parse(jobsDataEl.getAttribute('data-jobs') || '[]') : [];
        
        jobs.forEach(job => {
            const isSelected = $wire.selectedJobId === job.id;
            const bgClass = isSelected ? 'bg-orange-500' : 'bg-blue-600';
            const icon = L.divIcon({
                html: `<div class='${bgClass} text-white px-2 py-1 rounded-full text-[10px] font-bold whitespace-nowrap shadow-md border border-white/20 transition-all ${isSelected ? 'scale-110 z-50' : ''}'><i class='bx bx-briefcase'></i> ${job.position}</div>`,
                className: '', iconSize: null
            });
            const m = L.marker([job.latitude, job.longitude], {icon: icon})
                .on('click', () => {
                    $wire.selectJob(job.id);
                    this.map.setView([job.latitude, job.longitude], 15);
                })
                .addTo(this.map);
            this.markers.push(m);
        });
    }
}">

    {{-- HIDDEN DATA --}}
    <div id="jobs-data-element" class="hidden" data-jobs="{{ json_encode($jobs->map->only(['id', 'position', 'latitude', 'longitude'])->values()) }}"></div>

    {{-- TOP CONTROLS --}}
    <div class="absolute top-4 left-4 right-4 z-[1000] flex flex-col gap-2 pointer-events-none">
        <div class="flex items-center gap-2 pointer-events-auto">
            <div class="bg-white rounded-2xl shadow-lg border border-slate-100 flex p-1 h-12 w-32">
                <button wire:click="$set('viewMode', 'map')" class="flex-1 flex items-center justify-center gap-1.5 rounded-xl text-sm font-bold transition-colors {{ $viewMode === 'map' ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-slate-50' }}">
                    <i class='bx bx-map-alt'></i> Peta
                </button>
                <button wire:click="$set('viewMode', 'list')" class="flex-1 flex items-center justify-center gap-1.5 rounded-xl text-sm font-bold transition-colors {{ $viewMode === 'list' ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-slate-50' }}">
                    <i class='bx bx-list-ul'></i> List
                </button>
            </div>
            
            <div class="flex-grow bg-white rounded-2xl shadow-lg border border-slate-100 h-12 flex items-center px-3 overflow-x-auto hide-scrollbar gap-2">
                <select wire:model.live="filterCategory" class="text-xs font-bold text-slate-700 bg-slate-50 rounded-lg border-none px-3 py-1.5 min-w-[120px] focus:ring-0 cursor-pointer">
                    <option value="">Semua Bidang</option>
                    @foreach($categories as $k => $v) <option value="{{ $k }}">{{ $v }}</option> @endforeach
                </select>
                <select wire:model.live="filterWorkType" class="text-xs font-bold text-slate-700 bg-slate-50 rounded-lg border-none px-3 py-1.5 min-w-[110px] focus:ring-0 cursor-pointer">
                    <option value="">Semua Waktu</option>
                    @foreach($workTypes as $k => $v) <option value="{{ $k }}">{{ $v }}</option> @endforeach
                </select>
                <select wire:model.live="filterRadius" class="text-xs font-bold text-slate-700 bg-slate-50 rounded-lg border-none px-3 py-1.5 min-w-[100px] focus:ring-0 cursor-pointer">
                    <option value="5">&lt; 5 km</option>
                    <option value="10">&lt; 10 km</option>
                    <option value="25">&lt; 25 km</option>
                    <option value="50">&lt; 50 km</option>
                </select>
            </div>
        </div>
    </div>

    {{-- MAIN AREA --}}
    <div class="flex-grow relative h-full">
        @if($viewMode === 'map')
            <div wire:ignore id="map-container" class="w-full h-full" x-init="initMap()"></div>
        @else
            <div class="h-full overflow-y-auto bg-slate-50 p-4 pt-20 pb-24">
                <div class="max-w-md mx-auto space-y-4">
                    <h2 class="text-lg font-extrabold text-slate-800 mb-2">Ditemukan {{ $jobs->count() }} lowongan</h2>
                    @forelse($jobs as $job)
                        <div wire:click="selectJob({{ $job->id }})" class="bg-white rounded-2xl p-4 border border-slate-100 shadow-sm cursor-pointer hover:border-blue-300 transition-colors">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl shrink-0 font-black">
                                    {{ substr($job->company->company_name, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-extrabold text-slate-800 truncate">{{ $job->position }}</h4>
                                    <p class="text-xs text-slate-500 truncate">{{ $job->company->company_name }} ✓</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-xs text-slate-500 mb-3 font-medium">
                                <div class="flex items-center gap-1"><i class='bx bx-map'></i> {{ $job->distance }} km</div>
                                <div class="flex items-center gap-1"><i class='bx bx-time-five'></i> {{ $job->work_type_label }}</div>
                                <div class="flex items-center gap-1 col-span-2"><i class='bx bx-money'></i> {{ $job->salary_range }}</div>
                            </div>
                            <div class="flex gap-2">
                                <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2 py-1 rounded-md">{{ \App\Models\JobListing::jobCategories()[$job->job_category] }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 bg-white rounded-2xl border border-slate-100">
                            <div class="text-4xl mb-3"><i class='bx bx-ghost'></i></div>
                            <h3 class="text-sm font-bold text-slate-700">Tidak ada lowongan</h3>
                            <p class="text-xs text-slate-400 mt-1">Coba ubah filter pencarian Anda</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif
    </div>

    {{-- BOTTOM SHEET: JOB DETAIL PREVIEW --}}
    @if($selectedJob)
    <div class="absolute bottom-0 left-0 right-0 bg-white border-t border-slate-100 shadow-[0_-10px_30px_rgba(0,0,0,0.1)] z-[1000] rounded-t-3xl transition-transform duration-300 transform translate-y-0">
        
        <button wire:click="closeJobDetails" class="absolute top-4 right-4 w-8 h-8 bg-slate-100 text-slate-500 rounded-full flex items-center justify-center hover:bg-slate-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="p-5 max-w-lg mx-auto w-full">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-3xl font-black shrink-0">
                    {{ substr($selectedJob->company->company_name, 0, 1) }}
                </div>
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800 leading-tight mb-1">{{ $selectedJob->position }}</h3>
                    <p class="text-sm text-slate-500 font-semibold flex items-center gap-1">
                        {{ $selectedJob->company->company_name }}
                        <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-y-3 gap-x-2 text-sm text-slate-600 font-medium mb-5 bg-slate-50 p-3 rounded-xl border border-slate-100">
                <div class="flex items-center gap-2"><span class="text-lg"><i class='bx bx-map'></i></span> {{ $selectedJob->distance }} km dari Anda</div>
                <div class="flex items-center gap-2"><span class="text-lg"><i class='bx bx-money'></i></span> {{ $selectedJob->salary_range }}</div>
                <div class="flex items-center gap-2"><span class="text-lg"><i class='bx bx-time-five'></i></span> {{ $selectedJob->work_type_label }}</div>
                <div class="flex items-center gap-2"><span class="text-lg"><i class='bx bx-graduation'></i></span> Min. {{ strtoupper($selectedJob->min_education) }}</div>
            </div>

            <div class="flex gap-3 items-center">
                <a href="{{ route('applicant.job.detail', $selectedJob->id) }}" class="flex-1 py-3.5 border-2 border-slate-200 text-slate-700 font-extrabold rounded-xl text-center text-sm hover:bg-slate-50 transition-colors">
                    Lihat Detail
                </a>
                
                <button wire:click="applyForJob" class="flex-[2] py-3.5 {{ $credits > 0 ? 'bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-600/20' : 'bg-slate-300 cursor-not-allowed' }} text-white font-extrabold rounded-xl text-sm transition-colors flex items-center justify-center gap-2">
                    @if($credits > 0)
                        Lamar Sekarang
                        <span class="bg-blue-800/50 text-[10px] px-2 py-0.5 rounded-full">-1 Kredit</span>
                    @else
                        Kredit Habis
                    @endif
                </button>
            </div>
            
            @if($credits <= 0)
                <p class="text-center mt-3 text-xs font-semibold text-red-500">
                    Sisa kredit lamaran Anda 0. <a href="{{ route('applicant.profile') }}" class="underline">Beli kredit.</a>
                </p>
            @endif
        </div>
    </div>
    @endif
    
    <style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</div>
