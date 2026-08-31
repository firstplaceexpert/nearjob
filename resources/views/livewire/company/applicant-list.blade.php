<div class="p-4 bg-slate-50 min-h-full pb-8">
    <div class="max-w-xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('company.jobs') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-500 hover:bg-slate-100 transition-colors border border-slate-200">
                ←
            </a>
            <div>
                <h1 class="text-xl font-extrabold text-slate-800 leading-tight">Daftar Pelamar</h1>
                <p class="text-slate-500 text-sm truncate max-w-[250px]">{{ $job->position }}</p>
            </div>
        </div>

        @if($applications->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-100 shadow-sm mt-4">
                <div class="text-5xl mb-4"><i class='bx bx-group'></i></div>
                <h3 class="text-lg font-extrabold text-slate-700">Belum ada pelamar</h3>
                <p class="text-sm text-slate-500 mt-2 max-w-[250px] mx-auto">Lowongan ini belum menerima lamaran. Tetap bersabar menunggu kandidat yang tepat.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($applications as $app)
                    @php
                        $profile = $app->user->applicantProfile;
                    @endphp
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-5 relative overflow-hidden">
                        {{-- Top Section: Name & Contact --}}
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="font-extrabold text-lg text-slate-800">{{ $app->user->name }}</h3>
                                <p class="text-xs text-slate-500 mb-2">Usia: {{ $app->user->age }} thn • Lulusan {{ strtoupper($profile->education_level ?? '-') }}</p>
                            </div>
                            
                            {{-- Status Dropdown --}}
                            <div class="relative w-36">
                                <select wire:change="updateStatus({{ $app->id }}, $event.target.value)" 
                                    class="w-full text-[10px] font-bold uppercase tracking-wider rounded-lg border-2 appearance-none px-2 py-1.5 focus:ring-0
                                    {{ $app->status === 'menunggu' ? 'border-yellow-200 bg-yellow-50 text-yellow-700' : '' }}
                                    {{ $app->status === 'dihubungi' ? 'border-blue-200 bg-blue-50 text-blue-700' : '' }}
                                    {{ $app->status === 'interview' ? 'border-purple-200 bg-purple-50 text-purple-700' : '' }}
                                    {{ $app->status === 'diterima' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : '' }}
                                    {{ $app->status === 'tidak_lolos' ? 'border-red-200 bg-red-50 text-red-700' : '' }}">
                                    @foreach($statuses as $val => $label)
                                        <option value="{{ $val }}" {{ $app->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Profil Info --}}
                        <div class="grid grid-cols-2 gap-3 mb-4 p-3 bg-slate-50 rounded-xl">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Pengalaman / Sekolah</p>
                                <p class="text-xs font-semibold text-slate-700 truncate">{{ $profile->work_experience ?: $profile->education_institution }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Domisili</p>
                                <p class="text-xs font-semibold text-slate-700 truncate">{{ $profile->city ?? '-' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Keahlian</p>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    @forelse($profile->skills ?? [] as $skill)
                                        <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded text-[10px] font-bold">{{ $skill }}</span>
                                    @empty
                                        <span class="text-xs text-slate-400">-</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- Contact Actions --}}
                        <div class="flex gap-2 border-t border-slate-100 pt-4 mt-2">
                            @if($app->contact_method === 'whatsapp')
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $app->user->whatsapp)) }}" target="_blank"
                                   class="flex-1 py-2 bg-green-50 hover:bg-green-100 text-green-700 font-bold rounded-xl text-center text-xs transition-colors border border-green-200">
                                    <i class='bx bxl-whatsapp'></i> Hubungi WA
                                </a>
                            @else
                                <a href="mailto:{{ $app->user->email }}" target="_blank"
                                   class="flex-1 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold rounded-xl text-center text-xs transition-colors border border-blue-200">
                                    <i class='bx bx-envelope'></i> Hubungi Email
                                </a>
                            @endif
                            
                            @if($profile->cv_generated)
                                <button class="flex-1 py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold rounded-xl text-center text-xs transition-colors border border-slate-200" onclick="alert('Demo: Unduh CV ATS (Fitur Premium Pelamar)')">
                                    <i class='bx bx-file'></i> Lihat CV ATS
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
