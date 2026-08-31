<div class="p-4 bg-slate-50 min-h-full pb-8">
    <div class="max-w-md mx-auto">
        <h1 class="text-2xl font-extrabold text-slate-800 mb-2">Profil Saya</h1>
        <p class="text-slate-500 text-sm mb-6">Lengkapi profil Anda agar lebih mudah mendapatkan pekerjaan.</p>

        {{-- Top Cards: Credits & CV --}}
        <div class="grid grid-cols-2 gap-3 mb-6">
            <div class="bg-blue-600 rounded-3xl p-5 text-white flex flex-col justify-between relative overflow-hidden shadow-lg shadow-blue-600/20">
                <div class="absolute -right-4 -top-4 text-6xl opacity-10">🎫</div>
                <div>
                    <p class="text-xs font-bold text-blue-200 uppercase tracking-widest mb-1">Kredit Lamaran</p>
                    <p class="text-3xl font-black">{{ $credits }}</p>
                </div>
                <div class="mt-4">
                    <button class="text-xs font-bold bg-white/20 hover:bg-white/30 backdrop-blur-sm px-3 py-1.5 rounded-lg transition-colors w-full text-center">Beli Kredit</button>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm flex flex-col justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Status CV ATS</p>
                    @if($cv_generated)
                        <div class="flex items-center gap-1.5 text-emerald-600 font-extrabold text-sm mb-1">
                            <span class="text-lg"><i class='bx bx-check-circle'></i></span> Tersedia
                        </div>
                    @else
                        <div class="flex items-center gap-1.5 text-orange-500 font-extrabold text-sm mb-1">
                            <span class="text-lg"><i class='bx bx-time'></i></span> Belum Dibuat
                        </div>
                    @endif
                </div>
                <div class="mt-4">
                    <a href="{{ route('applicant.cv.generator') }}" class="inline-block w-full text-center text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-lg transition-colors">
                        {{ $cv_generated ? 'Lihat / Unduh CV' : 'Buat CV Sekarang' }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-5">
            <form wire:submit="save" class="space-y-4">
                
                <h3 class="text-sm font-extrabold text-blue-600 uppercase tracking-widest border-b border-slate-100 pb-2">Informasi Pribadi</h3>
                
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" wire:model="name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email</label>
                    <input type="email" wire:model="email" disabled class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-slate-100 text-slate-500 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp</label>
                    <input type="tel" wire:model="whatsapp" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kota Domisili</label>
                    <select wire:model="city" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                        <option value="">Pilih Kota</option>
                        @foreach($cities as $c)
                            <option value="{{ $c->name }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <h3 class="text-sm font-extrabold text-blue-600 uppercase tracking-widest border-b border-slate-100 pb-2 mt-6">Pendidikan & Pengalaman</h3>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pendidikan Terakhir</label>
                    <select wire:model="education_level" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                        @foreach($educationLevels as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Sekolah / Universitas</label>
                    <input type="text" wire:model="education_institution" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jurusan (Opsional)</label>
                    <input type="text" wire:model="field_of_study" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Keahlian (Skills)</label>
                    <div class="flex gap-2 mb-2">
                        <input type="text" wire:model="newSkill" wire:keydown.enter.prevent="addSkill" class="flex-grow px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white" placeholder="Contoh: Kasir, Memasak...">
                        <button type="button" wire:click="addSkill" class="px-4 py-2.5 bg-blue-600 text-white font-bold rounded-xl">+</button>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($skills as $i => $sk)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded-lg border border-blue-100">
                                {{ $sk }} <button type="button" wire:click="removeSkill({{ $i }})" class="hover:text-red-500 font-bold">×</button>
                            </span>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pengalaman Kerja</label>
                    <textarea wire:model="work_experience" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Ekspektasi Gaji (Opsional)</label>
                    <input type="text" wire:model="salary_expectation" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white" placeholder="Rp 2.000.000 - Rp 3.000.000">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm shadow-lg shadow-blue-600/20 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
