<div class="min-h-screen pb-36 pt-16" style="background: #f0f4f9;">
    <div class="max-w-xl mx-auto px-4 pt-5">

        {{-- ===== HEADER ===== --}}
        <div class="flex items-center gap-3 mb-5">
            <a href="{{ route('company.jobs') }}"
               class="w-10 h-10 bg-white rounded-xl flex items-center justify-center transition-all"
               style="border: 1px solid #e8edf5; color: #5680d8; box-shadow: 0 2px 8px rgba(0,0,0,.04);">
                <i class='bx bx-arrow-back'></i>
            </a>
            <div>
                <h1 class="text-xl font-extrabold text-black">Daftar Pelamar</h1>
                <p class="text-black text-sm truncate max-w-[240px]">{{ $job->position }}</p>
            </div>
        </div>

        @if($applications->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl" style="border: 1px dashed #c7d6f5;">
                <i class='bx bx-group text-5xl mb-4' style="color: #c7d6f5;"></i>
                <h3 class="font-extrabold text-black mb-1">Belum ada pelamar</h3>
                <p class="text-sm text-black mt-1 max-w-[220px] mx-auto">Tetap bersabar menunggu kandidat yang tepat.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($applications as $app)
                @php $profile = $app->user->applicantProfile; @endphp

                <div class="bg-white rounded-3xl overflow-hidden" style="border: 1px solid #e8edf5; box-shadow: 0 2px 12px rgba(0,0,0,.04);">
                    {{-- Top Section --}}
                    <div class="p-4 pb-3">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                @if($profile?->photo_url)
                                    <img src="{{ $profile->photo_url }}" alt="{{ $app->user->name }}" class="w-11 h-11 rounded-full object-cover border border-slate-200 shadow-sm shrink-0">
                                @else
                                    <div class="w-11 h-11 rounded-full flex items-center justify-center text-sm font-black text-white shrink-0 shadow-sm" style="background: #5680d8;">
                                        {{ substr($app->user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <h3 class="font-extrabold text-lg text-black">{{ $app->user->name }}</h3>
                                        @if($app->user->isIdentityVerified() || $profile?->is_verified)
                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded border border-black text-black bg-white" title="Identitas KTP Pelamar Terverifikasi">
                                                <i class='bx bxs-badge-check text-black'></i> KTP Terverifikasi
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-black mt-0.5">
                                        Usia: {{ $app->user->age }} thn &bull; Lulusan {{ strtoupper($profile?->education_level ?? '-') }}
                                        &bull; <span class="font-mono text-black">NIK: {{ $app->user->masked_nik }}</span>
                                    </p>
                                </div>
                            </div>

                            {{-- Status dropdown (Wrap Garis Hitam & Tulisan Hitam) --}}
                            <select wire:change="updateStatus({{ $app->id }}, $event.target.value)"
                                class="text-[10px] font-bold uppercase tracking-wider rounded-xl border border-black bg-white text-black appearance-none px-3 py-2 focus:ring-0 focus:outline-none cursor-pointer">
                                @foreach($statuses as $val => $label)
                                    <option value="{{ $val }}" {{ $app->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Profile Info --}}
                        <div class="grid grid-cols-2 gap-3 p-3 rounded-xl mb-3 bg-white border border-black/15">
                            <div>
                                <p class="text-[9px] font-bold uppercase tracking-wider text-black mb-0.5">Pengalaman</p>
                                <p class="text-xs font-semibold text-black line-clamp-2">{{ $profile?->work_experience ?: ($profile?->education_institution ?? '-') }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold uppercase tracking-wider text-black mb-0.5">Domisili</p>
                                <p class="text-xs font-semibold text-black">{{ $profile?->city ?? '-' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-[9px] font-bold uppercase tracking-wider text-black mb-1">Keahlian</p>
                                <div class="flex flex-wrap gap-1">
                                    @forelse($profile?->skills ?? [] as $skill)
                                        <span class="text-[9px] font-bold px-2 py-0.5 rounded border border-black/30 text-black bg-white">{{ $skill }}</span>
                                    @empty
                                        <span class="text-xs text-black">-</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Contact Actions (Tombol Biru Anchor) --}}
                    <div class="flex gap-2 px-4 pb-4 pt-0">
                        @if($app->contact_method === 'whatsapp')
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $app->user->whatsapp)) }}"
                               target="_blank"
                               class="flex-1 py-2.5 text-center text-xs font-extrabold rounded-xl transition-all text-white shadow-sm flex items-center justify-center gap-1.5 cursor-pointer"
                               style="background: #5680d8; box-shadow: 0 4px 12px rgba(86,128,216,.3);">
                                <i class='bx bxl-whatsapp text-sm'></i> Hubungi WA
                            </a>
                        @else
                            <a href="mailto:{{ $app->user->email }}"
                               target="_blank"
                               class="flex-1 py-2.5 text-center text-xs font-extrabold rounded-xl transition-all text-white shadow-sm flex items-center justify-center gap-1.5 cursor-pointer"
                               style="background: #5680d8; box-shadow: 0 4px 12px rgba(86,128,216,.3);">
                                <i class='bx bx-envelope text-sm'></i> Hubungi Email
                            </a>
                        @endif

                        @if($profile?->cv_generated)
                            <a href="#" class="flex-1 py-2.5 text-center text-xs font-bold rounded-xl transition-all"
                               style="background: #ffffff; color: #000000; border: 1px solid #000000;">
                                <i class='bx bx-file'></i> Lihat CV
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
