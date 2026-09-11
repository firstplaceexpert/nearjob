<div>
    {{-- Data embed via hidden script tags --}}
    <script id="njob-map-data" type="application/json">
        {!! json_encode([
            'userLat'  => $userLat,
            'userLon'  => $userLon,
            'isAuth'   => auth()->check(),
            'credits'  => $credits,
            'jobs'     => $jobsMapDataArray ?? [],
            'jobCards' => $jobs->map(fn($j) => [
                'id'            => $j->id,
                'position'      => $j->position,
                'company'       => $j->company->company_name,
                'initial'       => substr($j->company->company_name, 0, 1),
                'city'          => $j->company->city,
                'category'      => $j->job_category,
                'categoryIcon'  => $j->category_icon,
                'categoryColor' => $j->category_color,
                'categoryBg'    => $j->category_bg,
                'categoryName'  => $j->category_name,
                'salary'        => $j->salary_range,
                'quota'         => (int) ($j->quota ?: 1),
                'distance'      => $j->distance,
                'method'        => $j->contact_method,
                'hasWa'         => !empty(trim($j->contact_whatsapp ?? '')),
                'hasEmail'      => !empty(trim($j->contact_email ?? '')),
                'education'     => strtoupper($j->min_education),
                'workType'      => $j->work_type_label,
                'applyRoute'    => route('applicant.job.detail', $j->id),
                'topupRoute'    => route('applicant.topup'),
            ])->values()->all(),
        ]) !!}
    </script>

    {{-- ── FLOATING SEARCH & FILTER BAR (GOOGLE MAPS STYLE & MINIMIZABLE) ── --}}
    <div id="njob-search-widget" style="position:fixed;top:66px;left:14px;right:14px;max-width:520px;margin:0 auto;z-index:420;pointer-events:none;transition:all .3s cubic-bezier(.16,1,.3,1);">
        
        {{-- Expanded State --}}
        <div id="njob-search-expanded" style="pointer-events:auto;background:rgba(255,255,255,0.96);backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);border-radius:18px;padding:8px 12px;box-shadow:0 8px 30px rgba(15,23,42,0.16),0 1px 3px rgba(0,0,0,0.06);border:1px solid rgba(226,232,240,0.85);transition:all .25s ease;">
            {{-- Search Bar Row --}}
            <div style="display:flex;align-items:center;gap:8px;">
                <div style="display:flex;align-items:center;justify-content:center;color:#5680d8;font-size:20px;width:24px;">
                    <i class='bx bx-search'></i>
                </div>
                <input type="text" wire:model.live.debounce.300ms="searchQuery" 
                       placeholder="Cari lowongan, posisi, atau perusahaan..." 
                       style="flex:1;border:none;outline:none;font-size:13px;font-weight:700;color:#1e293b;background:transparent;padding:6px 0;">
                
                @if($searchQuery)
                    <button wire:click="$set('searchQuery', '')" style="border:none;background:none;color:#94a3b8;cursor:pointer;padding:4px;display:flex;align-items:center;">
                        <i class='bx bx-x-circle' style="font-size:18px;"></i>
                    </button>
                @endif

                {{-- Minimize Button: Makes map wide and uncluttered --}}
                <button onclick="njobToggleSearchCard(false)" title="Kecilkan bar untuk luaskan peta"
                        style="border:none;background:#f1f5f9;color:#475569;width:32px;height:32px;border-radius:10px;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s;flex-shrink:0;">
                    <i class='bx bx-chevron-up' style="font-size:20px;"></i>
                </button>
            </div>

            {{-- Filter Chips Row --}}
            <div style="display:flex;gap:6px;overflow-x:auto;scrollbar-width:none;-webkit-overflow-scrolling:touch;padding-top:8px;margin-top:4px;border-top:1px solid #f1f5f9;align-items:center;">
                <button onclick="njobToggleFilter()" style="flex-shrink:0;display:flex;align-items:center;gap:5px;background:{{ ($filterCategory || $filterWorkType) ? '#5680d8' : '#f8fafc' }};color:{{ ($filterCategory || $filterWorkType) ? 'white' : '#334155' }};border:1.5px solid {{ ($filterCategory || $filterWorkType) ? '#5680d8' : '#e2e8f0' }};border-radius:16px;padding:4px 10px;font-size:11px;font-weight:700;cursor:pointer;">
                    <i class='bx bx-filter-alt'></i> Filter
                    @if($filterCategory || $filterWorkType)<span style="width:6px;height:6px;background:#fbbf24;border-radius:50%;"></span>@endif
                </button>
                <button onclick="njobSetWT('');njobSetCat('')" style="flex-shrink:0;background:{{ !$filterWorkType && !$filterCategory ? '#e0f2fe' : '#f8fafc' }};color:{{ !$filterWorkType && !$filterCategory ? '#0284c7' : '#64748b' }};border:1px solid {{ !$filterWorkType && !$filterCategory ? '#bae6fd' : '#e2e8f0' }};border-radius:16px;padding:4px 10px;font-size:11px;font-weight:700;cursor:pointer;">Semua</button>
                <button onclick="njobSetWT('part_time')" style="flex-shrink:0;background:{{ $filterWorkType === 'part_time' ? '#e0f2fe' : '#f8fafc' }};color:{{ $filterWorkType === 'part_time' ? '#0284c7' : '#64748b' }};border:1px solid {{ $filterWorkType === 'part_time' ? '#bae6fd' : '#e2e8f0' }};border-radius:16px;padding:4px 10px;font-size:11px;font-weight:700;cursor:pointer;">Part Time</button>
                <button onclick="njobSetWT('full_time')" style="flex-shrink:0;background:{{ $filterWorkType === 'full_time' ? '#e0f2fe' : '#f8fafc' }};color:{{ $filterWorkType === 'full_time' ? '#0284c7' : '#64748b' }};border:1px solid {{ $filterWorkType === 'full_time' ? '#bae6fd' : '#e2e8f0' }};border-radius:16px;padding:4px 10px;font-size:11px;font-weight:700;cursor:pointer;">Full Time</button>
                <button onclick="njobSetRadius(5)" style="flex-shrink:0;background:{{ $filterRadius <= 5 ? '#e0f2fe' : '#f8fafc' }};color:{{ $filterRadius <= 5 ? '#0284c7' : '#64748b' }};border:1px solid {{ $filterRadius <= 5 ? '#bae6fd' : '#e2e8f0' }};border-radius:16px;padding:4px 10px;font-size:11px;font-weight:700;cursor:pointer;">&le; 5 km</button>
            </div>
        </div>

        {{-- Minimized State: Sleek Floating Pill (Google Maps Vibe) --}}
        <div id="njob-search-minimized" style="display:none;pointer-events:auto;justify-content:center;">
            <button onclick="njobToggleSearchCard(true)"
                    style="background:rgba(255,255,255,0.96);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);border:1px solid rgba(226,232,240,0.9);box-shadow:0 6px 24px rgba(15,23,42,0.14);border-radius:30px;padding:8px 16px;display:flex;align-items:center;gap:8px;cursor:pointer;transition:all .2s;color:#1e293b;">
                <i class='bx bx-search' style="color:#5680d8;font-size:16px;"></i>
                <span style="font-size:12px;font-weight:800;color:#334155;">
                    {{ $searchQuery ? 'Cari: "'.$searchQuery.'"' : 'Cari & Filter Lowongan' }}
                </span>
                @if($filterCategory || $filterWorkType)
                    <span style="background:#5680d8;color:white;font-size:9px;font-weight:800;padding:1px 6px;border-radius:10px;">Filter Aktif</span>
                @endif
                <i class='bx bx-chevron-down' style="color:#94a3b8;font-size:18px;"></i>
            </button>
        </div>
    </div>

    {{-- ── FULLSCREEN LEAFLET MAP (WIRE:IGNORE TO PREVENT MAP DISAPPEARING ON FILTER) ── --}}
    <div id="njob-map-container" wire:ignore style="position:fixed;top:56px;bottom:64px;left:0;right:0;z-index:100;">
        <div id="njob-map" style="width:100%;height:100%;"></div>
    </div>

    {{-- ── FLOATING CONTROLS (GOOGLE MAPS STYLE: MY LOCATION / GPS BUTTON) ── --}}
    <div style="position:fixed;bottom:136px;right:16px;z-index:410;display:flex;flex-direction:column;gap:10px;">
        <button id="njob-gps-floating-btn" onclick="njobCenterOnUserGPS()" title="Pusatkan ke Lokasi Saya (GPS)"
                style="width:46px;height:46px;background:white;border:none;border-radius:50%;box-shadow:0 4px 18px rgba(15,23,42,0.18);display:flex;align-items:center;justify-content:center;color:#2563eb;cursor:pointer;transition:all .2s;">
            <i class='bx bx-target-lock' style="font-size:24px;"></i>
        </button>
    </div>

    {{-- ── FLOATING BUTTON: "LIHAT DAFTAR LOWONGAN" (FIXED DI ATAS MENU NAV) ── --}}
    <div id="njob-btn-wrapper" style="position:fixed;bottom:78px;left:0;right:0;z-index:450;display:flex;justify-content:center;pointer-events:none;">
        <button id="njob-btn-toggle-list" onclick="njobToggleHorizontalCards(true)"
            style="pointer-events:auto;background:#24427b;color:white;border:none;padding:12px 24px;border-radius:30px;font-size:13px;font-weight:800;cursor:pointer;box-shadow:0 8px 24px rgba(37,67,155,.45);display:flex;align-items:center;gap:8px;white-space:nowrap;transition:all .25s;">
            <i class='bx bx-list-ul' style="font-size:18px;"></i> Lihat Daftar Lowongan ({{ $jobs->count() }})
        </button>
    </div>

    {{-- ── HORIZONTAL CARDS POPUP (HANYA MUNCUL SAAT DIKLIK, DERET KESAMPING) ── --}}
    <div id="njob-horizontal-panel" style="position:fixed;bottom:72px;left:0;right:0;z-index:480;display:none;flex-direction:column;pointer-events:none;transform:translateY(120%);opacity:0;transition:all .35s cubic-bezier(.34,1.1,.64,1);">
        
        {{-- Tombol Tutup Kecil di Atas Carousel (Centering) --}}
        <div style="max-width:960px;margin:0 auto;width:100%;padding:0 16px 8px;display:flex;justify-content:center;pointer-events:auto;">
            <button onclick="njobToggleHorizontalCards(false)" style="background:#1e293b;color:white;border:none;padding:7px 20px;border-radius:24px;font-size:12px;font-weight:800;cursor:pointer;box-shadow:0 4px 16px rgba(0,0,0,.35);display:flex;align-items:center;gap:6px;">
                <i class='bx bx-x' style="font-size:18px;"></i> Tutup Daftar Lowongan
            </button>
        </div>

        {{-- Container Carousel Scroll Kesamping --}}
        <div id="njob-cards-carousel" style="display:flex;gap:12px;overflow-x:auto;padding:4px 16px 12px;scrollbar-width:none;-webkit-overflow-scrolling:touch;scroll-snap-type:x mandatory;pointer-events:auto;">
            @forelse($jobs as $job)
            <div class="njob-card-h"
                 data-job-id="{{ $job->id }}"
                 data-lat="{{ $job->latitude ?? 0 }}"
                 data-lon="{{ $job->longitude ?? 0 }}"
                 onclick="njobFocusCard(this)"
                 style="flex:0 0 300px;scroll-snap-align:center;background:white;border-radius:18px;padding:15px;border:2px solid #e8edf5;box-shadow:0 8px 30px rgba(0,0,0,.18);cursor:pointer;transition:all .2s;position:relative;">

                {{-- Row 1: Category Icon + Judul + Perusahaan + Gaji --}}
                <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:10px;">
                    <div style="width:46px;height:46px;flex-shrink:0;background:{{ $job->category_bg }};color:{{ $job->category_color }};border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;border:1.5px solid {{ $job->category_color }}33;" title="{{ $job->category_name }}">
                        <i class='{{ $job->category_icon }}'></i>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <h3 style="font-size:13px;font-weight:800;color:#1e293b;line-height:1.3;margin:0 0 2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $job->position }}
                        </h3>
                        <div style="display:flex;align-items:center;gap:6px;font-size:11px;color:#64748b;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            <span style="color:#5680d8;overflow:hidden;text-overflow:ellipsis;">{{ $job->company->company_name }}</span>
                            <span style="font-size:9.5px;font-weight:800;background:{{ $job->category_bg }};color:{{ $job->category_color }};padding:1px 6px;border-radius:5px;flex-shrink:0;">{{ $job->category_name }}</span>
                        </div>
                        <div style="font-size:12px;font-weight:800;color:#1e293b;margin-top:2px;">
                            {{ $job->salary_range }}
                        </div>
                    </div>
                </div>

                {{-- Row 2: Info Jarak, Kuota & Pendidikan (Wrap Garis Hitam & Tulisan Hitam) --}}
                <div style="display:flex;align-items:center;gap:6px;font-size:11px;color:#000000;font-weight:600;margin-bottom:10px;background:#ffffff;padding:6px 10px;border-radius:10px;border:1px solid rgba(0,0,0,0.18);flex-wrap:wrap;">
                    <span>📍 <b>{{ $job->distance }} km</b></span>
                    <span>•</span>
                    <span style="color:#000000;font-weight:800;background:#ffffff;padding:1px 6px;border-radius:6px;border:1px solid rgba(0,0,0,0.3);">🎯 <b>{{ $job->quota ?? 1 }} Kuota</b></span>
                    <span>•</span>
                    <span style="color:#000000;">🎓 Min. {{ strtoupper($job->min_education) }}</span>
                </div>

                {{-- Row 3: Tag WA/Email + Tombol Lamar --}}
                <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                    <div>
                        @php
                            $cardHasWa = !empty(trim($job->contact_whatsapp ?? ''));
                            $cardHasMail = !empty(trim($job->contact_email ?? ''));
                        @endphp
                        @if($cardHasWa && $cardHasMail)
                            <span style="font-size:10px;font-weight:700;background:#ffffff;color:#000000;border:1px solid rgba(0,0,0,0.3);padding:4px 9px;border-radius:8px;display:inline-flex;align-items:center;gap:3px;" title="Tersedia WhatsApp & Email">
                                <i class='bx bxl-whatsapp'></i> WA & Email
                            </span>
                        @elseif($cardHasWa)
                            <span style="font-size:10px;font-weight:700;background:#ffffff;color:#000000;border:1px solid rgba(0,0,0,0.3);padding:4px 9px;border-radius:8px;display:inline-flex;align-items:center;gap:3px;">
                                <i class='bx bxl-whatsapp'></i> WhatsApp
                            </span>
                        @elseif($cardHasMail)
                            <span style="font-size:10px;font-weight:700;background:#ffffff;color:#000000;border:1px solid rgba(0,0,0,0.3);padding:4px 9px;border-radius:8px;display:inline-flex;align-items:center;gap:3px;">
                                <i class='bx bx-envelope'></i> Email
                            </span>
                        @endif
                    </div>

                    <button onclick="event.stopPropagation(); njobOpenSheet(this.closest('.njob-card-h').dataset.jobId)"
                        style="background:#5680d8;color:white;border:none;padding:8px 16px;border-radius:10px;font-size:11px;font-weight:800;cursor:pointer;box-shadow:0 4px 12px rgba(86,128,216,.35);">
                        Lamar Sekarang
                    </button>
                </div>
            </div>
            @empty
            <div style="background:white;border-radius:16px;padding:20px;text-align:center;width:100%;">
                <div style="font-size:13px;font-weight:700;color:#64748b;">Belum ada lowongan di area ini</div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- JOB DETAIL MODAL (FULL DETAILS) --}}
    <div id="njob-sheet" style="position:fixed;bottom:64px;left:0;right:0;z-index:700;background:white;border-radius:24px 24px 0 0;box-shadow:0 -8px 40px rgba(0,0,0,.25);transform:translateY(100%);display:none;transition:transform .3s cubic-bezier(.34,1.1,.64,1);padding:0 20px 24px;max-height:65vh;overflow-y:auto;">
        <div style="width:40px;height:4px;background:#e2e8f0;border-radius:2px;margin:14px auto;"></div>
        <button onclick="njobCloseSheet()" style="position:absolute;top:12px;right:14px;background:#f1f5f9;border:none;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:18px;color:#64748b;display:flex;align-items:center;justify-content:center;font-weight:700;">×</button>
        <div id="njob-sheet-body"></div>
    </div>
    <div id="njob-overlay" onclick="njobCloseSheet()" style="display:none;position:fixed;inset:0;z-index:699;background:rgba(0,0,0,.4);"></div>

    {{-- ===== GPS LOCATION NOTICE MODAL ===== --}}
    <div id="njob-gps-modal" style="display:none;position:fixed;inset:0;z-index:999;background:rgba(0,0,0,.6);align-items:center;justify-content:center;padding:16px;">
        <div style="background:white;border-radius:24px;max-width:380px;width:100%;padding:24px;text-align:center;box-shadow:0 10px 40px rgba(0,0,0,.3);">
            <div style="width:64px;height:64px;background:#eff6ff;color:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:32px;border:3px solid #bfdbfe;">
                <i class='bx bx-current-location'></i>
            </div>
            <h3 style="font-size:16px;font-weight:900;color:#1e293b;margin:0 0 8px;">Aktifkan Lokasi / GPS Anda</h3>
            <p style="font-size:12px;color:#64748b;line-height:1.6;margin:0 0 20px;font-weight:600;">
                Aplikasi <b>NEAR JOB</b> menggunakan GPS untuk mendeteksi posisi Anda secara otomatis dan menyajikan lowongan kerja terdekat di sekitar lokasi Anda.
            </p>
            <button onclick="njobRequestGPSLocation()" style="width:100%;padding:14px;background:#2563eb;color:white;border:none;border-radius:14px;font-size:13px;font-weight:800;cursor:pointer;box-shadow:0 4px 16px rgba(37,99,235,.4);display:flex;align-items:center;justify-content:center;gap:8px;">
                <i class='bx bx-target-lock' style="font-size:18px;"></i> Izinkan Akses GPS Lokasi Saya
            </button>
            <button onclick="document.getElementById('njob-gps-modal').style.display='none'" style="margin-top:12px;background:none;border:none;color:#94a3b8;font-size:11px;font-weight:700;cursor:pointer;">Nanti Saja</button>
        </div>
    </div>

    {{-- FILTER MODAL --}}
    <div id="njob-filter" onclick="if(event.target===this)njobToggleFilter()"
         style="display:none;position:fixed;inset:0;z-index:900;background:rgba(0,0,0,.5);align-items:flex-end;">
        <div style="background:white;border-radius:24px 24px 0 0;width:100%;max-height:80vh;overflow-y:auto;padding:20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid #f1f5f9;">
                <span style="font-size:15px;font-weight:800;color:#1e293b;">Filter Lowongan</span>
                <button onclick="njobToggleFilter()" style="background:#f1f5f9;border:none;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:18px;color:#64748b;font-weight:700;">×</button>
            </div>
            <div style="margin-bottom:18px;">
                <div style="font-size:10px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;">Bidang Pekerjaan</div>
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;">
                    @foreach($categories as $k => $v)
                    <button onclick="njobSetCat('{{ $k }}')"
                        style="padding:10px 6px;border-radius:10px;font-size:11px;font-weight:700;border:1.5px solid {{ $filterCategory === $k ? '#5680d8' : '#e2e8f0' }};background:{{ $filterCategory === $k ? '#5680d8' : 'white' }};color:{{ $filterCategory === $k ? 'white' : '#64748b' }};cursor:pointer;">
                        {{ $v }}
                    </button>
                    @endforeach
                </div>
            </div>
            <div style="margin-bottom:18px;">
                <div style="font-size:10px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;">Jenis Pekerjaan</div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    @foreach($workTypes as $k => $v)
                    <button onclick="njobSetWT('{{ $k }}')"
                        style="padding:10px 16px;border-radius:10px;font-size:11px;font-weight:700;border:1.5px solid {{ $filterWorkType === $k ? '#5680d8' : '#e2e8f0' }};background:{{ $filterWorkType === $k ? '#5680d8' : 'white' }};color:{{ $filterWorkType === $k ? 'white' : '#64748b' }};cursor:pointer;">
                        {{ $v }}
                    </button>
                    @endforeach
                </div>
            </div>
            <div style="margin-bottom:20px;">
                <div style="font-size:10px;font-weight:800;color:#64748b;text-transform:uppercase;letter-spacing:.08em;margin-bottom:8px;">Jarak Maksimal</div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    @foreach([3 => '&lt; 3 km', 5 => '&lt; 5 km', 10 => '&lt; 10 km', 25 => '&lt; 25 km', 50 => 'Semua'] as $km => $label)
                    <button onclick="njobSetRadius({{ $km }})"
                        style="padding:10px 16px;border-radius:10px;font-size:11px;font-weight:700;border:1.5px solid {{ $filterRadius == $km ? '#5680d8' : '#e2e8f0' }};background:{{ $filterRadius == $km ? '#5680d8' : 'white' }};color:{{ $filterRadius == $km ? 'white' : '#64748b' }};cursor:pointer;">
                        {!! $label !!}
                    </button>
                    @endforeach
                </div>
            </div>
            <div style="display:flex;gap:10px;">
                <button onclick="njobSetWT('');njobSetCat('')" style="flex:1;padding:14px;border-radius:14px;border:1.5px solid #e2e8f0;background:white;color:#94a3b8;font-size:13px;font-weight:700;cursor:pointer;">Hapus Filter</button>
                <button onclick="njobToggleFilter()" style="flex:2;padding:14px;border-radius:14px;border:none;background:#5680d8;color:white;font-size:13px;font-weight:700;cursor:pointer;">Terapkan</button>
            </div>
        </div>
    </div>

    <style>
    .njob-card-h:hover { box-shadow:0 12px 36px rgba(86,128,216,.25)!important; border-color:#5680d8!important; transform:translateY(-2px); }
    #njob-cards-carousel::-webkit-scrollbar { display: none; }
    
    /* Google Maps Blue Pulse User Marker */
    .njob-gps-pulse-outer {
        position: relative;
        width: 22px;
        height: 22px;
    }
    .njob-gps-pulse-core {
        position: absolute;
        top: 2px;
        left: 2px;
        width: 18px;
        height: 18px;
        background: #2563eb;
        border: 3px solid #ffffff;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(0,0,0,0.35);
        z-index: 2;
    }
    .njob-gps-pulse-wave {
        position: absolute;
        top: -6px;
        left: -6px;
        width: 34px;
        height: 34px;
        background: rgba(37,99,235,0.35);
        border-radius: 50%;
        animation: njobGpsWave 2s infinite ease-out;
        z-index: 1;
    }
    @keyframes njobGpsWave {
        0% { transform: scale(0.5); opacity: 1; }
        100% { transform: scale(2.2); opacity: 0; }
    }
    </style>

    @script
    <script>
    (function(){
        const D     = JSON.parse(document.getElementById('njob-map-data').textContent);
        let ULAT    = D.userLat, ULON = D.userLon;
        const IS_AUTH = Boolean(D.isAuth);
        let JOBS = D.jobs, CARDS = D.jobCards, CRED = D.credits;
        let map = null, markers = {}, userMarker = null, selId = null, panelOpen = false;

        function boot(){
            if(typeof L==='undefined'){ setTimeout(boot,200); return; }
            const el = document.getElementById('njob-map');
            if(!el||map) return;
            map = L.map(el,{center:[ULAT,ULON],zoom:13,zoomControl:false});
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19,attribution:'© OSM'}).addTo(map);
            L.control.zoom({position:'bottomright'}).addTo(map);

            renderUserMarker(ULAT, ULON);
            drawPins();
            setTimeout(()=>map.invalidateSize(),300);

            // Check saved search card minimized preference
            const isMin = localStorage.getItem('njob_search_minimized') === 'true';
            if (isMin) {
                const exp = document.getElementById('njob-search-expanded');
                const min = document.getElementById('njob-search-minimized');
                if (exp && min) {
                    exp.style.display = 'none';
                    min.style.display = 'flex';
                }
            }

            // Automatic GPS detection on page load
            autoDetectGPS();
        }

        function renderUserMarker(lat, lon){
            if(!map) return;
            if(userMarker) map.removeLayer(userMarker);
            const ui = L.divIcon({
                html: '<div class="njob-gps-pulse-outer"><div class="njob-gps-pulse-wave"></div><div class="njob-gps-pulse-core"></div></div>',
                className: '',
                iconSize: [22, 22],
                iconAnchor: [11, 11]
            });
            userMarker = L.marker([lat, lon], {icon: ui, zIndexOffset: 2000}).addTo(map);
        }

        function autoDetectGPS(){
            if(!navigator.geolocation) return;
            navigator.geolocation.getCurrentPosition(
                function(pos){
                    const lat = pos.coords.latitude;
                    const lon = pos.coords.longitude;
                    ULAT = lat;
                    ULON = lon;
                    renderUserMarker(lat, lon);
                    if(map){
                        map.panTo([lat, lon], {animate: true, duration: 0.8});
                    }
                    // Sync with Livewire
                    const wid = document.querySelector('[wire\\:id]')?.getAttribute('wire:id');
                    if(wid && window.Livewire){
                        Livewire.find(wid).call('setLocation', lat, lon);
                    }
                },
                function(err){
                    // If not permitted yet and never notified, show notice
                    if(!localStorage.getItem('njob_gps_notified')){
                        setTimeout(window.njobPromptGPS, 1200);
                        localStorage.setItem('njob_gps_notified', 'true');
                    }
                },
                { enableHighAccuracy: true, timeout: 9000, maximumAge: 30000 }
            );
        }

        function drawPins(){
            if(!map) return;
            Object.values(markers).forEach(m=>map.removeLayer(m));
            markers={};
            JOBS.forEach(j=>{
                if(!j.latitude||!j.longitude) return;
                const sel = selId === j.id;
                const sz = sel ? 44 : 36;
                const catCol = j.categoryColor || '#5680d8';
                const catIco = j.categoryIcon || 'bx bx-briefcase';
                const borderCol = sel ? '#1e293b' : 'white';
                const borderWidth = sel ? '3px' : '2.5px';
                const quotaVal = (typeof j.quota !== 'undefined' && j.quota !== null) ? Number(j.quota) : 1;

                const pinHtml = '<div style="position:relative;display:flex;flex-direction:column;align-items:center;cursor:pointer;">'
                    + '<div style="width:'+sz+'px;height:'+sz+'px;background:'+catCol+';border:'+borderWidth+' solid '+borderCol+';border-radius:50% 50% 50% 0;transform:rotate(-45deg);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 14px rgba(0,0,0,.3);transition:transform .2s;">'
                    + '<i class=\"'+catIco+'\" style="transform:rotate(45deg);color:white;font-size:'+(sel?18:14)+'px;line-height:1;"></i>'
                    + '</div>'
                    + (quotaVal > 1 ? '<span style="position:absolute;top:-4px;right:-4px;background:#1e293b;color:#f8fafc;font-size:9px;font-weight:900;padding:1px 4px;border-radius:8px;border:1.5px solid white;line-height:1;box-shadow:0 2px 4px rgba(0,0,0,.2);">'+quotaVal+'</span>' : '')
                    + '</div>';

                const ico = L.divIcon({
                    html: pinHtml,
                    className: '',
                    iconSize: [sz, sz + 6],
                    iconAnchor: [sz / 2, sz + 6]
                });

                const m = L.marker([j.latitude, j.longitude], {icon: ico}).on('click', () => { 
                    selId = j.id; 
                    drawPins(); 
                    map.panTo([j.latitude, j.longitude], {animate: true, duration: .4}); 
                    highlightCard(j.id);
                    njobOpenSheet(j.id);
                }).addTo(map);
                markers[j.id] = m;
            });
        }

        function highlightCard(id){
            document.querySelectorAll('.njob-card-h').forEach(c=>{
                const a=Number(c.dataset.jobId)===Number(id);
                c.style.borderColor=a?'#5680d8':'#e8edf5';
                c.style.borderWidth=a?'2px':'1.5px';
                c.style.boxShadow=a?'0 12px 30px rgba(86,128,216,.25)':'0 8px 30px rgba(0,0,0,.15)';
                if(a) c.scrollIntoView({behavior:'smooth',block:'nearest',inline:'center'});
            });
        }

        window.njobToggleSearchCard = function(showExpanded){
            const exp = document.getElementById('njob-search-expanded');
            const min = document.getElementById('njob-search-minimized');
            if(!exp || !min) return;

            if(showExpanded){
                min.style.display = 'none';
                exp.style.display = 'block';
                localStorage.setItem('njob_search_minimized', 'false');
            } else {
                exp.style.display = 'none';
                min.style.display = 'flex';
                localStorage.setItem('njob_search_minimized', 'true');
            }
            if(map) setTimeout(() => map.invalidateSize(), 200);
        };

        window.njobCenterOnUserGPS = function(){
            const btn = document.getElementById('njob-gps-floating-btn');
            if(btn){
                btn.style.transform = 'scale(0.9)';
                setTimeout(() => { btn.style.transform = 'scale(1)'; }, 150);
            }

            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(
                    function(pos){
                        const lat = pos.coords.latitude;
                        const lon = pos.coords.longitude;
                        ULAT = lat;
                        ULON = lon;
                        renderUserMarker(lat, lon);
                        if(map){
                            map.setView([lat, lon], 14, {animate: true});
                        }
                        const wid = document.querySelector('[wire\\:id]')?.getAttribute('wire:id');
                        if(wid && window.Livewire){
                            Livewire.find(wid).call('setLocation', lat, lon);
                        }
                    },
                    function(err){
                        window.njobPromptGPS();
                    },
                    { enableHighAccuracy: true }
                );
            } else {
                alert('Browser Anda belum mendukung fitur GPS.');
            }
        };

        window.njobFocusCard=function(el){
            const id=Number(el.dataset.jobId), lat=parseFloat(el.dataset.lat), lon=parseFloat(el.dataset.lon);
            selId=id; drawPins(); 
            if(map&&lat&&lon) map.panTo([lat,lon],{animate:true,duration:.4}); 
            highlightCard(id);
        };

        window.njobToggleHorizontalCards=function(forceState){
            if(typeof forceState === 'boolean') panelOpen = forceState;
            else panelOpen = !panelOpen;

            const panel = document.getElementById('njob-horizontal-panel');
            const btn = document.getElementById('njob-btn-wrapper');

            if(panelOpen){
                panel.style.display = 'flex';
                requestAnimationFrame(() => {
                    panel.style.transform = 'translateY(0)';
                    panel.style.opacity = '1';
                });
                btn.style.opacity = '0';
                btn.style.pointerEvents = 'none';
            } else {
                panel.style.transform = 'translateY(120%)';
                panel.style.opacity = '0';
                setTimeout(() => {
                    if(!panelOpen) panel.style.display = 'none';
                }, 350);
                btn.style.opacity = '1';
                btn.style.pointerEvents = 'auto';
            }
        };

        window.njobOpenSheet=function(jobId){
            const j=CARDS.find(c=>String(c.id)===String(jobId)); if(!j) return;
            const html='<div style="display:flex;align-items:center;gap:14px;margin-bottom:16px;">'
                +'<div style="width:56px;height:56px;background:'+(j.categoryBg||'#eef2fb')+';color:'+(j.categoryColor||'#5680d8')+';border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:28px;border:1.5px solid '+(j.categoryColor||'#5680d8')+'33;flex-shrink:0;"><i class=\"'+(j.categoryIcon||'bx bx-briefcase')+'\"></i></div>'
                +'<div><div style="font-size:16px;font-weight:800;color:#1e293b;line-height:1.3;">'+j.position+'</div><div style="display:flex;align-items:center;gap:6px;margin-top:4px;"><span style="font-size:12px;color:#5680d8;font-weight:700;">'+j.company+' <span style=\"color:#47bfae;\">✓</span></span><span style=\"font-size:9.5px;font-weight:800;background:'+(j.categoryBg||'#eef2fb')+';color:'+(j.categoryColor||'#5680d8')+';padding:1px 6px;border-radius:5px;\">'+(j.categoryName||'Lowongan')+'</span></div></div>'
                +'</div>'
                +'<div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;background:#f8faff;border-radius:14px;padding:14px;margin-bottom:16px;border:1px solid #e8edf5;">'
                +'<div style="font-size:12px;color:#475569;font-weight:600;">📍 '+j.distance+' km dari Anda</div>'
                +'<div style="font-size:12px;color:#475569;font-weight:600;">💰 '+j.salary+'</div>'
                +'<div style="font-size:12px;color:#475569;font-weight:600;">🕐 '+j.workType+'</div>'
                +'<div style="font-size:12px;color:#475569;font-weight:600;">🎓 Min. '+j.education+'</div>'
                +'<div style="font-size:12px;color:#000000;font-weight:800;grid-column:span 2;background:#ffffff;padding:8px 12px;border-radius:10px;border:1px solid rgba(0,0,0,0.25);">🎯 Kuota: '+(j.quota||1)+' Lowongan Dibutuhkan</div>'
                +'</div>'
                +'<div style="display:flex;gap:10px;">'
                +(!IS_AUTH
                    ? '<button onclick="window.Livewire.dispatch(\'open-quick-auth-modal\', {jobId: '+j.id+', title: \'Masuk / Buat Akun untuk Melamar\', subtitle: \'Lamar lowongan '+j.position.replace(/'/g, "\\'")+' di '+j.company.replace(/'/g, "\\'")+'\'})" style="flex:1;padding:14px;text-align:center;font-size:13px;font-weight:700;color:#000000;background:white;border:2px solid #000000;border-radius:14px;cursor:pointer;">Lihat Detail</button>'
                    : '<a href="'+j.applyRoute+'" style="flex:1;padding:14px;text-align:center;font-size:13px;font-weight:700;color:#000000;background:white;border:2px solid #000000;border-radius:14px;text-decoration:none;">Detail</a>'
                )
                +(!IS_AUTH
                    ? '<button onclick="window.Livewire.dispatch(\'open-quick-auth-modal\', {jobId: '+j.id+', title: \'Masuk / Buat Akun untuk Melamar\', subtitle: \'Lamar lowongan '+j.position.replace(/'/g, "\\'")+' di '+j.company.replace(/'/g, "\\'")+'\'})" style="flex:2;padding:14px;font-size:13px;font-weight:800;color:white;background:#5680d8;border:none;border-radius:14px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 20px rgba(86,128,216,.4);"><i class=\'bx '+(j.hasWa?'bxl-whatsapp':'bx-envelope')+'\'></i> '+(j.hasWa?'Lamar via WhatsApp':'Lamar via Email')+'</button>'
                    : (CRED>0
                        ? '<button onclick="njobApply('+j.id+')" style="flex:2;padding:14px;font-size:13px;font-weight:800;color:white;background:#5680d8;border:none;border-radius:14px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 20px rgba(86,128,216,.4);"><i class=\'bx '+(j.hasWa?'bxl-whatsapp':'bx-envelope')+'\'></i> '+(j.hasWa?'Lamar via WhatsApp':'Lamar via Email')+' <span style="background:rgba(255,255,255,.25);padding:2px 8px;border-radius:20px;font-size:10px;">-1 Kuota</span></button>'
                        : '<button style="flex:2;padding:14px;font-size:13px;font-weight:800;background:#cbd5e1;color:white;border:none;border-radius:14px;cursor:not-allowed;display:flex;align-items:center;justify-content:center;">Kuota Habis</button>'
                    )
                )
                +'</div>'
                +(IS_AUTH && CRED<=0?'<div style="margin-top:12px;padding:12px;background:#ffffff;border:1px solid rgba(0,0,0,0.3);border-radius:12px;text-align:center;font-size:12px;font-weight:700;color:#000000;">Kuota lamaran habis · <a href="'+j.topupRoute+'" style="color:#5680d8;font-weight:800;text-decoration:underline;">Isi Ulang Kuota Lamaran</a></div>':'');
            document.getElementById('njob-sheet-body').innerHTML=html;
            const sheet = document.getElementById('njob-sheet');
            sheet.style.display = 'block';
            requestAnimationFrame(() => { sheet.style.transform='translateY(0)'; });
            document.getElementById('njob-overlay').style.display='block';
        };

        window.njobCloseSheet=function(){ 
            const sheet = document.getElementById('njob-sheet');
            sheet.style.transform='translateY(100%)'; 
            document.getElementById('njob-overlay').style.display='none';
            setTimeout(() => { sheet.style.display = 'none'; }, 300);
        };

        window.njobApply=function(jobId){
            const wid=document.querySelector('[wire\\:id]')?.getAttribute('wire:id');
            if(wid) Livewire.find(wid).call('selectJob',jobId).then(()=>Livewire.find(wid).call('applyForJob'));
        };

        window.njobSetWT=function(w){ @this.set('filterWorkType',w); };
        window.njobSetCat=function(c){ @this.set('filterCategory',c); };
        window.njobSetRadius=function(r){ @this.set('filterRadius',r); };
        window.njobToggleFilter=function(){ const m=document.getElementById('njob-filter'); m.style.display=m.style.display==='flex'?'none':'flex'; };

        window.njobPromptGPS = function(){
            document.getElementById('njob-gps-modal').style.display = 'flex';
        };

        window.njobRequestGPSLocation = function(){
            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(
                    function(pos){
                        const lat = pos.coords.latitude;
                        const lon = pos.coords.longitude;
                        document.getElementById('njob-gps-modal').style.display = 'none';
                        ULAT = lat;
                        ULON = lon;
                        renderUserMarker(lat, lon);
                        if(map){
                            map.setView([lat, lon], 14, {animate:true});
                        }
                        const wid = document.querySelector('[wire\\:id]')?.getAttribute('wire:id');
                        if(wid && window.Livewire){
                            Livewire.find(wid).call('setLocation', lat, lon);
                        }
                    },
                    function(err){
                        alert('Silakan aktifkan akses GPS lokasi pada pengaturan browser/HP Anda.');
                    },
                    { enableHighAccuracy: true }
                );
            } else {
                alert('Browser Anda belum mendukung fitur GPS.');
            }
        };

        function refreshDataAndPins(){
            try {
                const updatedData = JSON.parse(document.getElementById('njob-map-data').textContent);
                JOBS = updatedData.jobs || [];
                CARDS = updatedData.jobCards || [];
                CRED = updatedData.credits || 0;
            } catch(e){}
            drawPins();
        }

        if(document.readyState==='loading') document.addEventListener('DOMContentLoaded',boot);
        else setTimeout(boot,80);
        if(window.Livewire) Livewire.hook('morph.updated',()=>setTimeout(refreshDataAndPins,100));
    })();
    </script>
    @endscript
</div>
