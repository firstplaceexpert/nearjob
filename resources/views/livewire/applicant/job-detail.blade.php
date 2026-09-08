{{-- Detail Lowongan Pekerjaan --}}
<div style="background: #f0f4f9; min-height: calc(100vh - 172px); padding: 16px 0 240px;">
    <div class="max-w-2xl mx-auto px-4">

        {{-- ===== TOP HEADER CARD (CONTAINED, LEGA & SEIMBANG) ===== --}}
        <div class="bg-white rounded-3xl border shadow-sm mb-6" style="border-color: #e2e8f0; padding: 28px 24px;">
            <a href="{{ route('applicant.map') }}" 
               class="inline-flex items-center gap-2 text-xs font-extrabold px-3.5 py-2 rounded-xl mb-6 transition-all shadow-sm hover:opacity-90" 
               style="background: #eef2fb; color: #5680d8; border: 1px solid #c7d6f5;">
                <i class='bx bx-arrow-back text-sm'></i> Kembali ke Beranda Peta
            </a>

            <div class="flex items-start gap-4">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-2xl font-black shrink-0 border shadow-sm" 
                     style="background: #eef2fb; color: #5680d8; border-color: #c7d6f5;">
                    {{ substr($job->company->company_name, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <h1 class="text-xl sm:text-2xl font-black text-slate-800 leading-snug mb-2">{{ $job->position }}</h1>
                    <div class="flex items-center gap-2.5 flex-wrap mb-3">
                        <span class="text-sm font-extrabold text-slate-700">{{ $job->company->company_name }}</span>
                        <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-0.5 rounded-full" style="background: #e6f8f6; color: #2a9d8f;">
                            <i class='bx bx-check-circle text-sm'></i> Terverifikasi
                        </span>
                    </div>
                    
                    {{-- Badges Lokasi, Kategori & Kuota Lowongan --}}
                    <div class="flex items-center gap-2.5 flex-wrap text-xs font-bold text-slate-500">
                        <span class="inline-flex items-center gap-1.5 bg-slate-100 px-3 py-1.5 rounded-lg text-slate-700">
                            📍 {{ $job->company->city }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-blue-50 px-3 py-1.5 rounded-lg text-blue-700">
                            🏢 {{ $job->company->business_field ?? 'Usaha Lokal' }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg font-extrabold" style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;">
                            🎯 Kuota: {{ $job->quota ?? 1 }} Orang Dibutuhkan
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== 4 KEY METRICS GRID (PUNYAI SPACE PEMISAH CLEAR DARI HEADER) ===== --}}
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 30px;">
            <div class="bg-white rounded-2xl flex flex-col items-center text-center border shadow-sm" style="border-color: #e2e8f0; padding: 22px 16px; border-radius: 20px;">
                <div class="w-12 h-12 rounded-xl mb-3 flex items-center justify-center text-xl shadow-xs" style="background: #eef2fb; color: #5680d8;">
                    <i class='bx bx-map-pin'></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-1.5">JARAK LOKASI</span>
                <span class="text-xs font-extrabold text-slate-800">{{ $job->distance }} km dari Anda</span>
            </div>

            <div class="bg-white rounded-2xl flex flex-col items-center text-center border shadow-sm" style="border-color: #e2e8f0; padding: 22px 16px; border-radius: 20px;">
                <div class="w-12 h-12 rounded-xl mb-3 flex items-center justify-center text-xl shadow-xs" style="background: #eef2fb; color: #5680d8;">
                    <i class='bx bx-money'></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-1.5">RENTANG GAJI</span>
                <span class="text-xs font-extrabold text-slate-800">{{ $job->salary_range }}</span>
            </div>

            <div class="bg-white rounded-2xl flex flex-col items-center text-center border shadow-sm" style="border-color: #e2e8f0; padding: 22px 16px; border-radius: 20px;">
                <div class="w-12 h-12 rounded-xl mb-3 flex items-center justify-center text-xl shadow-xs" style="background: #eef2fb; color: #5680d8;">
                    <i class='bx bx-time-five'></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-1.5">SISTEM KERJA</span>
                <span class="text-xs font-extrabold text-slate-800">{{ $job->work_type_label }}</span>
            </div>

            <div class="bg-white rounded-2xl flex flex-col items-center text-center border shadow-sm" style="border-color: #e2e8f0; padding: 22px 16px; border-radius: 20px;">
                <div class="w-12 h-12 rounded-xl mb-3 flex items-center justify-center text-xl shadow-xs" style="background: #eef2fb; color: #5680d8;">
                    <i class='bx bx-graduation'></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-1.5">PENDIDIKAN</span>
                <span class="text-xs font-extrabold text-slate-800">Min. {{ strtoupper($job->min_education) }}</span>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 28px;">
            {{-- ===== DESCRIPTION ===== --}}
            <div class="bg-white rounded-3xl border shadow-sm" style="border-color: #e2e8f0; padding: 28px 24px;">
                <div class="flex items-center gap-2.5 mb-4 pb-3 border-b" style="border-color: #f1f5f9;">
                    <i class='bx bx-detail text-xl' style="color: #5680d8;"></i>
                    <h3 class="font-black text-base text-slate-800">Deskripsi Pekerjaan</h3>
                </div>
                <div class="text-slate-600 text-xs sm:text-sm leading-relaxed whitespace-pre-line font-medium pt-1">
                    {{ $job->description }}
                </div>
            </div>

            {{-- ===== QUALIFICATIONS ===== --}}
            <div class="bg-white rounded-3xl border shadow-sm" style="border-color: #e2e8f0; padding: 28px 24px;">
                <div class="flex items-center gap-2.5 mb-4 pb-3 border-b" style="border-color: #f1f5f9;">
                    <i class='bx bx-list-check text-2xl' style="color: #5680d8;"></i>
                    <h3 class="font-black text-base text-slate-800">Kualifikasi Pelamar</h3>
                </div>
                <div class="text-slate-600 text-xs sm:text-sm leading-relaxed whitespace-pre-line font-medium pt-1">
                    {{ $job->qualifications }}
                </div>
            </div>

            {{-- ===== REQUIRED SKILLS ===== --}}
            @if($job->required_skills && count($job->required_skills) > 0)
            <div class="bg-white rounded-3xl border shadow-sm" style="border-color: #e2e8f0; padding: 28px 24px;">
                <div class="flex items-center gap-2.5 mb-4 pb-3 border-b" style="border-color: #f1f5f9;">
                    <i class='bx bx-wrench text-xl' style="color: #5680d8;"></i>
                    <h3 class="font-black text-base text-slate-800">Keahlian yang Dibutuhkan</h3>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 12px; padding-top: 6px;">
                    @foreach($job->required_skills as $skill)
                        <span class="text-xs font-bold" style="padding: 10px 18px; border-radius: 14px; background: #eef2fb; color: #5680d8; border: 1.5px solid #c7d6f5;">
                            {{ $skill }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ===== ADDITIONAL INFORMATION (DENGAN WRAP KOTAK MASING-MASING) ===== --}}
            <div class="bg-white rounded-3xl border shadow-sm" style="border-color: #e2e8f0; padding: 28px 24px;">
                <div class="flex items-center gap-2.5 mb-5 pb-3.5 border-b" style="border-color: #f1f5f9;">
                    <i class='bx bx-info-circle text-xl' style="color: #5680d8;"></i>
                    <h3 class="font-black text-base text-slate-800">Informasi Lengkap Usaha</h3>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <div style="background: #f8faff; border: 1.5px solid #e8edf5; border-radius: 16px; padding: 16px 18px; display: flex; align-items: flex-start; gap: 14px;">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 mt-0.5 shadow-2xs" style="background: #eef2fb; color: #5680d8; border: 1px solid #c7d6f5;">
                            <i class='bx bx-building text-lg'></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-1">ALAMAT TEMPAT KERJA</span>
                            <p class="text-slate-800 font-extrabold text-xs sm:text-sm leading-relaxed">{{ $job->company->address }}, {{ $job->company->city }}</p>
                        </div>
                    </div>

                    <div style="background: #f8faff; border: 1.5px solid #e8edf5; border-radius: 16px; padding: 16px 18px; display: flex; align-items: flex-start; gap: 14px;">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 mt-0.5 shadow-2xs" style="background: #eef2fb; color: #5680d8; border: 1px solid #c7d6f5;">
                            <i class='bx bx-calendar-event text-lg'></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-1">DURASI KONTRAK / KERJA</span>
                            <p class="text-slate-800 font-extrabold text-xs sm:text-sm">{{ $job->work_duration ?? 'Tidak disebutkan' }}</p>
                        </div>
                    </div>

                    @if($job->work_hours)
                    <div style="background: #f8faff; border: 1.5px solid #e8edf5; border-radius: 16px; padding: 16px 18px; display: flex; align-items: flex-start; gap: 14px;">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 mt-0.5 shadow-2xs" style="background: #eef2fb; color: #5680d8; border: 1px solid #c7d6f5;">
                            <i class='bx bx-time text-lg'></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-1">JAM KERJA</span>
                            <p class="text-slate-800 font-extrabold text-xs sm:text-sm">{{ $job->work_hours }}</p>
                        </div>
                    </div>
                    @endif

                    @php
                        $hasWa = !empty(trim($job->contact_whatsapp ?? ''));
                        $hasMail = !empty(trim($job->contact_email ?? ''));
                    @endphp

                    <div style="background: #f8faff; border: 1.5px solid #e8edf5; border-radius: 16px; padding: 16px 18px; display: flex; align-items: flex-start; gap: 14px;">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 mt-0.5 shadow-2xs" style="background: {{ $hasWa ? '#dcfce7' : '#eef2fb' }}; color: {{ $hasWa ? '#16a34a' : '#5680d8' }}; border: 1px solid {{ $hasWa ? '#bbf7d0' : '#c7d6f5' }};">
                            <i class='bx {{ $hasWa ? "bxl-whatsapp" : "bx-envelope" }} text-lg'></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 block mb-1">METODE KOMUNIKASI & KONTAK</span>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @if($hasWa)
                                    <span class="inline-flex items-center gap-1 text-xs font-extrabold px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class='bx bxl-whatsapp text-sm'></i> WhatsApp: {{ $job->contact_whatsapp }}
                                    </span>
                                @endif
                                @if($hasMail)
                                    <span class="inline-flex items-center gap-1 text-xs font-extrabold px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-200">
                                        <i class='bx bx-envelope text-sm'></i> Email: {{ $job->contact_email }}
                                    </span>
                                @endif
                            </div>
                            @if($hasWa && $hasMail)
                                <span class="text-[11px] text-slate-500 font-medium block mt-1.5">
                                    <i class='bx bx-check text-emerald-600 font-bold'></i> Tersedia 2 opsi. Pelamar otomatis diarahkan ke <strong>WhatsApp</strong> perusahaan secara prioritas.
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ===== FLOATING CTA BAR (ABOVE BOTTOM NAV 64px) ===== --}}
    <div class="fixed left-0 right-0 px-4 py-3.5 bg-white/95 backdrop-blur-md border-t" 
         style="bottom: 64px; z-index: 45; border-color: #e2e8f0; box-shadow: 0 -6px 20px rgba(0,0,0,.08);">
        <div class="max-w-2xl mx-auto">
            @if($hasApplied)
                <div class="w-full py-4 rounded-2xl text-center font-black text-sm flex items-center justify-center gap-2" 
                     style="background: #e6f8f6; color: #2a9d8f; border: 2px solid #47bfae;">
                    <i class='bx bx-check-circle text-xl'></i> Anda Sudah Melamar Lowongan Ini
                </div>
            @else
                <button wire:click="applyForJob"
                    class="w-full py-4 text-white font-black rounded-2xl text-sm flex items-center justify-center gap-2 transition-all shadow-lg hover:opacity-95 cursor-pointer"
                    style="{{ $credits > 0 ? ($hasWa ? 'background: #16a34a; box-shadow: 0 6px 25px rgba(22,163,74,.4);' : 'background: #2563eb; box-shadow: 0 6px 25px rgba(37,99,235,.4);') : 'background: #cbd5e1; cursor: not-allowed;' }}">
                    @if($credits > 0)
                        <i class='bx {{ $hasWa ? "bxl-whatsapp" : "bx-envelope" }} text-xl'></i>
                        {{ $hasWa ? 'LAMAR VIA WHATSAPP' : 'LAMAR VIA EMAIL' }}
                        <span class="text-xs px-2.5 py-0.5 rounded-full font-bold" style="background: rgba(255,255,255,.25);">-1 Kuota</span>
                    @else
                        <i class='bx bx-lock text-lg'></i> Kuota Melamar Habis
                    @endif
                </button>

                @if($credits <= 0)
                <div class="mt-2.5 p-3 rounded-xl flex items-center justify-between" style="background: #fff5f5; border: 1px solid #fecaca;">
                    <p class="text-xs font-bold text-red-600">Kuota lamaran Anda habis (0 kuota)</p>
                    <a href="{{ route('applicant.topup') }}" class="text-xs font-bold text-white px-3.5 py-1.5 rounded-lg shadow-sm hover:opacity-95 text-decoration-none" style="background: #ef4444;">
                        <i class='bx bx-plus-circle'></i> Isi Kuota
                    </a>
                </div>
                @endif
            @endif
        </div>
    </div>

</div>
