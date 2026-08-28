<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-10 space-y-8">
        
        <div>
            <a href="{{ route('company.jobs') }}" class="text-xs font-bold text-indigo-600 hover:underline inline-flex items-center gap-1 mb-2">
                ← Kembali ke Daftar Lowongan
            </a>
            <h1 class="text-2xl font-extrabold text-slate-900">{{ $isEditing ? 'Edit Lowongan Kerja' : 'Pasang Lowongan Kerja Baru' }}</h1>
            <p class="text-slate-500 text-sm mt-1">Tentukan posisi, kualifikasi, dan radius jangkauan lokasi pelamar yang dicari</p>
        </div>

        <form wire:submit="save" class="space-y-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Posisi Pekerjaan</label>
                    <input type="text" wire:model="position" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm font-semibold" placeholder="Contoh: Staff Barista / Graphic Designer / Customer Service">
                    @error('position') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Kategori Pekerjaan</label>
                    <select wire:model="job_category" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                        @foreach($jobCategories as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('job_category') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Tipe Kerja</label>
                    <select wire:model="work_type" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                        @foreach($workTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('work_type') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Description & Qualifications -->
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Deskripsi Pekerjaan</label>
                    <textarea wire:model="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="Jelaskan tanggung jawab utama dan suasana kerja di tempat Anda..."></textarea>
                    @error('description') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Kualifikasi Persyaratan</label>
                    <textarea wire:model="qualifications" rows="4" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="Persyaratan khusus (misal: domisili lokal, siap shift malam, jujur, komunikatif)..."></textarea>
                    @error('qualifications') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Location & Matching Criteria -->
            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200 space-y-6">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="text-indigo-600">📍</span> Filter Location & Kriteria Matching
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Kota / Lokasi Kerja</label>
                        <select wire:model="city" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                            <option value="">-- Pilih Kota --</option>
                            @foreach($cities as $c)
                                <option value="{{ $c->name }}">{{ $c->name }} ({{ $c->province }})</option>
                            @endforeach
                        </select>
                        @error('city') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Radius Jarak (KM)</label>
                        <select wire:model="radius_km" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                            <option value="5">5 km (Sangat Lokal)</option>
                            <option value="10">10 km</option>
                            <option value="25">25 km (Standar Kota)</option>
                            <option value="50">50 km</option>
                            <option value="100">100 km (Regional)</option>
                        </select>
                        @error('radius_km') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Minimal Pendidikan</label>
                        <select wire:model="min_education" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                            @foreach($educationLevels as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('min_education') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Required Skill Tags -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">Skill Wajib Kandidat</label>
                    <div class="flex gap-2">
                        <input type="text" wire:model="newSkill" wire:keydown.enter.prevent="addSkill" 
                               class="flex-grow px-4 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm"
                               placeholder="Ketik skill wajib (misal: Kasir, Canva, Drivers License) dan tekan Enter">
                        <button type="button" wire:click="addSkill" class="px-4 py-2 bg-slate-900 text-white font-semibold text-xs rounded-xl">
                            + Tambah
                        </button>
                    </div>

                    <div class="flex flex-wrap gap-2 pt-2">
                        @foreach($required_skills as $idx => $sk)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-100 text-indigo-800 font-bold text-xs border border-indigo-200">
                                {{ $sk }}
                                <button type="button" wire:click="removeSkill({{ $idx }})" class="hover:text-red-600 font-bold">&times;</button>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 flex justify-end gap-4">
                <a href="{{ route('company.jobs') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-xl">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-200">
                    {{ $isEditing ? 'Simpan Perubahan' : 'Terbitkan Lowongan Sekarang' }}
                </button>
            </div>
        </form>
    </div>
</div>
