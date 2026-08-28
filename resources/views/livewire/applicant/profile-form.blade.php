<div class="max-w-4xl mx-auto px-4 py-8">
    
    <!-- Status Toggle Banner -->
    <div class="mb-8 p-6 rounded-3xl {{ $is_active ? 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white' : 'bg-slate-800 text-white' }} shadow-lg transition-colors">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="space-y-1 text-center sm:text-left">
                <div class="flex items-center gap-2 justify-center sm:justify-start">
                    <span class="w-3 h-3 rounded-full {{ $is_active ? 'bg-white animate-pulse' : 'bg-slate-400' }}"></span>
                    <h2 class="text-xl font-bold">Status Pencarian Kerja: {{ $is_active ? 'Aktif Mencari Kerja' : 'Sudah Bekerja / Non-aktif' }}</h2>
                </div>
                <p class="text-sm opacity-90">
                    {{ $is_active ? 'Profil Anda muncul di sistem matching dan siap swipe kartu lowongan.' : 'Profil Anda disembunyikan sementara dari sistem matching lowongan baru.' }}
                </p>
            </div>

            <button type="button" wire:click="toggleActive" 
                    class="px-5 py-2.5 rounded-xl font-bold text-sm bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/40 transition-all shrink-0">
                {{ $is_active ? 'Tandai Sudah Bekerja' : 'Aktifkan Kembali Profil' }}
            </button>
        </div>
    </div>

    <!-- Main Profile Edit Form -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-10 space-y-8">
        
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Kelola Profil Pelamar</h1>
            <p class="text-slate-500 text-sm mt-1">Lengkapi data Anda agar sistem matching dapat menyaring lowongan yang paling sesuai di sekitar Anda.</p>
        </div>

        <form wire:submit="save" class="space-y-8">
            
            <!-- Photo & Basic Info Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start pb-8 border-b border-slate-200">
                <div class="space-y-3">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">Foto Profil</label>
                    <div class="flex items-center gap-4">
                        <div class="w-24 h-24 rounded-2xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif ($existing_photo)
                                <img src="{{ asset('storage/' . $existing_photo) }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            @endif
                        </div>
                        <div class="space-y-2">
                            <input type="file" wire:model="photo" id="photo_input" class="hidden">
                            <label for="photo_input" class="inline-block px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl cursor-pointer transition-colors">
                                Unggah Foto
                            </label>
                            <p class="text-[11px] text-slate-400">JPG/PNG maks 2MB</p>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Email Kontak CV</label>
                            <input type="email" wire:model="contact_email" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                            @error('contact_email') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Kota Domisili</label>
                            <select wire:model="city" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                                <option value="">-- Pilih Kota Domisili --</option>
                                @foreach($cities as $c)
                                    <option value="{{ $c->name }}">{{ $c->name }} ({{ $c->province }})</option>
                                @endforeach
                            </select>
                            @error('city') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Education Section -->
            <div class="space-y-4 pb-8 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-black">🎓</span>
                    Riwayat Pendidikan
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Tingkat Pendidikan</label>
                        <select wire:model="education_level" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                            <option value="">-- Pilih Pendidikan --</option>
                            @foreach($educationLevels as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('education_level') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Nama Sekolah / Universitas</label>
                        <input type="text" wire:model="education_institution" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="Universitas Gadjah Mada">
                        @error('education_institution') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Jurusan / Program Studi</label>
                        <input type="text" wire:model="field_of_study" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="Informatika / Administrasi">
                    </div>
                </div>
            </div>

            <!-- Skills Section -->
            <div class="space-y-4 pb-8 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-black">⚡</span>
                    Keahlian / Skills
                </h3>

                <div class="flex gap-2">
                    <input type="text" wire:model="newSkill" wire:keydown.enter.prevent="addSkill" 
                           class="flex-grow px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm"
                           placeholder="Ketik skill (misal: Laravel, Microsoft Excel, Social Media) dan tekan Enter">
                    <button type="button" wire:click="addSkill" class="px-5 py-2.5 bg-slate-900 text-white font-semibold text-sm rounded-xl hover:bg-slate-800 transition-colors">
                        + Tambah
                    </button>
                </div>

                <div class="flex flex-wrap gap-2 pt-2">
                    @foreach($skills as $idx => $sk)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 text-indigo-700 font-semibold text-xs border border-indigo-200">
                            {{ $sk }}
                            <button type="button" wire:click="removeSkill({{ $idx }})" class="hover:text-red-600 font-bold">&times;</button>
                        </span>
                    @endforeach
                    @if(empty($skills))
                        <p class="text-xs text-slate-400">Belum ada skill ditambahkan.</p>
                    @endif
                </div>
            </div>

            <!-- Work Experience Section -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm font-black">💼</span>
                    Pengalaman Kerja / Magang / Organisasi
                </h3>

                <div>
                    <textarea wire:model="work_experience" rows="4" 
                              class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm"
                              placeholder="Tuliskan riwayat pengalaman Anda secara singkat (posisi, perusahaan/organisasi, durasi, deskripsi tugas)..."></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end">
                <button type="submit" 
                        class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all text-sm">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>
</div>
