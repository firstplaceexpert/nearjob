{{-- Detail Lowongan Pekerjaan --}}
@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "JobPosting",
  "title": "{{ addslashes($job->position) }}",
  "description": "{{ addslashes(strip_tags($job->description ?: $job->position . ' di ' . $job->company->company_name)) }}",
  "datePosted": "{{ $job->created_at ? $job->created_at->toIso8601String() : date('c') }}",
  "validThrough": "{{ $job->expires_at ? $job->expires_at->toIso8601String() : date('c', strtotime('+3 months')) }}",
  "employmentType": "{{ strtoupper($job->work_type ?? 'FULL_TIME') }}",
  "hiringOrganization": {
    "@type": "Organization",
    "name": "{{ addslashes($job->company->company_name) }}",
    "sameAs": "{{ url('/') }}",
    "logo": "{{ asset('img/logo.png') }}"
  },
  "jobLocation": {
    "@type": "Place",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "{{ addslashes($job->company->city ?? 'Yogyakarta') }}",
      "addressRegion": "{{ addslashes($job->company->province ?? 'DI Yogyakarta') }}",
      "addressCountry": "ID"
    }
  },
  "baseSalary": {
    "@type": "MonetaryAmount",
    "currency": "IDR",
    "value": {
      "@type": "QuantitativeValue",
      "value": {{ $job->salary_min ?: 2000000 }},
      "minValue": {{ $job->salary_min ?: 2000000 }},
      "maxValue": {{ $job->salary_max ?: 5000000 }},
      "unitText": "MONTH"
    }
  }
}
</script>
@endpush

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
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl font-black shrink-0 border shadow-sm" 
                     style="background: {{ $job->category_bg }}; color: {{ $job->category_color }}; border-color: {{ $job->category_color }}44;">
                    <i class='{{ $job->category_icon }}'></i>
                </div>
                <div class="min-w-0 flex-1">
                    <h1 class="text-xl sm:text-2xl font-black text-black leading-snug mb-2">{{ $job->position }}</h1>
                    <div class="flex items-center gap-2.5 flex-wrap mb-3">
                        <span class="text-sm font-extrabold text-black">{{ $job->company->company_name }}</span>
                        <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-0.5 rounded-full" style="background: {{ $job->category_bg }}; color: {{ $job->category_color }};">
                            <i class='{{ $job->category_icon }} text-sm'></i> {{ $job->category_name }}
                        </span>
                        @if($job->company->is_verified || $job->company->ktp_path)
                        <span class="inline-flex items-center gap-1 text-xs font-bold px-2 py-0.5 rounded border border-black text-black bg-white">
                            <i class='bx bxs-badge-check text-sm text-black'></i> Terverifikasi
                        </span>
                        @endif
                    </div>
                    
                    {{-- Badges Lokasi, Kategori & Kuota Lowongan (Wrap Garis Hitam & Tulisan Hitam) --}}
                    <div class="flex items-center gap-2 flex-wrap text-xs font-bold text-black">
                        <span class="inline-flex items-center gap-1.5 bg-white border border-black/25 px-2.5 py-1 rounded-md text-black">
                            <i class='bx bx-map-pin text-[#5680d8]'></i> {{ $job->company->city }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-white border border-black/25 px-2.5 py-1 rounded-md text-black">
                            <i class='bx bx-buildings text-[#5680d8]'></i> {{ $job->company->business_field ?? 'Usaha Lokal' }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 bg-white border border-black/25 px-2.5 py-1 rounded-md text-black font-extrabold">
                            <i class='bx bx-target-lock text-black'></i> Kuota: {{ $job->quota ?? 1 }} Orang Dibutuhkan
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
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-black mb-1.5">JARAK LOKASI</span>
                <span class="text-xs font-extrabold text-black">{{ $job->distance }} km dari Anda</span>
            </div>

            <div class="bg-white rounded-2xl flex flex-col items-center text-center border shadow-sm" style="border-color: #e2e8f0; padding: 22px 16px; border-radius: 20px;">
                <div class="w-12 h-12 rounded-xl mb-3 flex items-center justify-center text-xl shadow-xs" style="background: #eef2fb; color: #5680d8;">
                    <i class='bx bx-money'></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-black mb-1.5">RENTANG GAJI</span>
                <span class="text-xs font-extrabold text-black">{{ $job->salary_range }}</span>
            </div>

            <div class="bg-white rounded-2xl flex flex-col items-center text-center border shadow-sm" style="border-color: #e2e8f0; padding: 22px 16px; border-radius: 20px;">
                <div class="w-12 h-12 rounded-xl mb-3 flex items-center justify-center text-xl shadow-xs" style="background: #eef2fb; color: #5680d8;">
                    <i class='bx bx-time-five'></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-black mb-1.5">SISTEM KERJA</span>
                <span class="text-xs font-extrabold text-black">{{ $job->work_type_label }}</span>
            </div>

            <div class="bg-white rounded-2xl flex flex-col items-center text-center border shadow-sm" style="border-color: #e2e8f0; padding: 22px 16px; border-radius: 20px;">
                <div class="w-12 h-12 rounded-xl mb-3 flex items-center justify-center text-xl shadow-xs" style="background: #eef2fb; color: #5680d8;">
                    <i class='bx bx-graduation'></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-black mb-1.5">PENDIDIKAN</span>
                <span class="text-xs font-extrabold text-black">Min. {{ strtoupper($job->min_education) }}</span>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 28px;">
            {{-- ===== DESCRIPTION ===== --}}
            <div class="bg-white rounded-3xl border shadow-sm" style="border-color: #e2e8f0; padding: 28px 24px;">
                <div class="flex items-center gap-2.5 mb-4 pb-3 border-b" style="border-color: #f1f5f9;">
                    <i class='bx bx-detail text-xl' style="color: #5680d8;"></i>
                    <h3 class="font-black text-base text-black">Deskripsi Pekerjaan</h3>
                </div>
                <div class="text-black text-xs sm:text-sm leading-relaxed whitespace-pre-line font-medium pt-1">
                    {{ $job->description }}
                </div>
            </div>

            {{-- ===== QUALIFICATIONS ===== --}}
            <div class="bg-white rounded-3xl border shadow-sm" style="border-color: #e2e8f0; padding: 28px 24px;">
                <div class="flex items-center gap-2.5 mb-4 pb-3 border-b" style="border-color: #f1f5f9;">
                    <i class='bx bx-list-check text-2xl' style="color: #5680d8;"></i>
                    <h3 class="font-black text-base text-black">Kualifikasi Pelamar</h3>
                </div>
                <div class="text-black text-xs sm:text-sm leading-relaxed whitespace-pre-line font-medium pt-1">
                    {{ $job->qualifications }}
                </div>
            </div>

            {{-- ===== REQUIRED SKILLS ===== --}}
            @if($job->required_skills && count($job->required_skills) > 0)
            <div class="bg-white rounded-3xl border shadow-sm" style="border-color: #e2e8f0; padding: 28px 24px;">
                <div class="flex items-center gap-2.5 mb-4 pb-3 border-b" style="border-color: #f1f5f9;">
                    <i class='bx bx-wrench text-xl' style="color: #5680d8;"></i>
                    <h3 class="font-black text-base text-black">Keahlian yang Dibutuhkan</h3>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 12px; padding-top: 6px;">
                    @foreach($job->required_skills as $skill)
                        <span class="text-xs font-bold" style="padding: 10px 18px; border-radius: 14px; background: #ffffff; color: #000000; border: 1px solid rgba(0,0,0,0.3);">
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
                    <h3 class="font-black text-base text-black">Informasi Lengkap Usaha</h3>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <div style="background: #f8faff; border: 1.5px solid #e8edf5; border-radius: 16px; padding: 16px 18px; display: flex; align-items: flex-start; gap: 14px;">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 mt-0.5 shadow-2xs" style="background: #eef2fb; color: #5680d8; border: 1px solid #c7d6f5;">
                            <i class='bx bx-building text-lg'></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-black block mb-1">ALAMAT TEMPAT KERJA</span>
                            <p class="text-black font-extrabold text-xs sm:text-sm leading-relaxed">{{ $job->company->address }}, {{ $job->company->city }}</p>
                        </div>
                    </div>

                    <div style="background: #f8faff; border: 1.5px solid #e8edf5; border-radius: 16px; padding: 16px 18px; display: flex; align-items: flex-start; gap: 14px;">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 mt-0.5 shadow-2xs" style="background: #eef2fb; color: #5680d8; border: 1px solid #c7d6f5;">
                            <i class='bx bx-calendar-event text-lg'></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-black block mb-1">DURASI KONTRAK / KERJA</span>
                            <p class="text-black font-extrabold text-xs sm:text-sm">{{ $job->work_duration ?? 'Tidak disebutkan' }}</p>
                        </div>
                    </div>

                    @if($job->work_hours)
                    <div style="background: #f8faff; border: 1.5px solid #e8edf5; border-radius: 16px; padding: 16px 18px; display: flex; align-items: flex-start; gap: 14px;">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 mt-0.5 shadow-2xs" style="background: #eef2fb; color: #5680d8; border: 1px solid #c7d6f5;">
                            <i class='bx bx-time text-lg'></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-black block mb-1">JAM KERJA</span>
                            <p class="text-black font-extrabold text-xs sm:text-sm">{{ $job->work_hours }}</p>
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
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-black block mb-1">METODE KOMUNIKASI & KONTAK</span>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @if($hasWa)
                                    <span class="inline-flex items-center gap-1 text-xs font-extrabold px-2.5 py-1 rounded-lg bg-white text-black border border-black/30">
                                        <i class='bx bxl-whatsapp text-sm'></i> WhatsApp: {{ $job->contact_whatsapp }}
                                    </span>
                                @endif
                                @if($hasMail)
                                    <span class="inline-flex items-center gap-1 text-xs font-extrabold px-2.5 py-1 rounded-lg bg-white text-black border border-black/30">
                                        <i class='bx bx-envelope text-sm'></i> Email: {{ $job->contact_email }}
                                    </span>
                                @endif
                            </div>
                            @if($hasWa && $hasMail)
                                <span class="text-[11px] text-black font-medium block mt-1.5">
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
                <div class="w-full py-3.5 rounded-xl text-center font-bold text-sm flex items-center justify-center gap-2 bg-white text-black border-2 border-black">
                    <i class='bx bx-check-circle text-xl'></i> Anda Sudah Melamar Lowongan Ini
                </div>
            @else
                @php
                    $isGuest = !auth()->check();
                    $canApply = $isGuest || $credits > 0;
                @endphp
                <button wire:click="applyForJob"
                    class="w-full py-4 text-white font-black rounded-2xl text-sm flex items-center justify-center gap-2 transition-all shadow-lg hover:opacity-95 cursor-pointer"
                    style="{{ $canApply ? ($hasWa ? 'background: #25D366; box-shadow: 0 6px 25px rgba(37,211,102,.35);' : 'background: #5680d8; box-shadow: 0 6px 25px rgba(86,128,216,.35);') : 'background: #cbd5e1; cursor: not-allowed;' }}">
                    @if($canApply)
                        <i class='bx {{ $hasWa ? "bxl-whatsapp" : "bx-envelope" }} text-xl'></i>
                        {{ $hasWa ? 'LAMAR VIA WHATSAPP' : 'LAMAR VIA EMAIL' }}
                        @auth
                            <span class="text-xs px-2.5 py-0.5 rounded-full font-bold border border-white/40 text-white">-1 Kuota</span>
                        @endauth
                    @else
                        <i class='bx bx-lock text-lg'></i> Kuota Melamar Habis
                    @endif
                </button>

                @auth
                    @if($credits <= 0)
                    <div class="mt-2.5 p-3 rounded-xl flex items-center justify-between border border-black/20 bg-white">
                        <p class="text-xs font-bold text-black">Kuota lamaran Anda habis (0 kuota)</p>
                        <a href="{{ route('applicant.topup') }}" class="text-xs font-bold text-white px-3.5 py-1.5 rounded-lg shadow-sm hover:opacity-95 text-decoration-none cursor-pointer" style="background: #5680d8;">
                            <i class='bx bx-plus-circle'></i> Isi Kuota
                        </a>
                    </div>
                    @endif
                @endauth
            @endif
        </div>
    </div>

</div>
