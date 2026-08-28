<div class="min-h-[calc(100vh-10rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-lg w-full space-y-6 bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50">
        
        <div class="text-center">
            <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full mb-2 uppercase tracking-wide">UMKM & Perusahaan</span>
            <h2 class="text-2xl font-extrabold text-slate-900">Daftar Akun Perusahaan</h2>
            <p class="mt-1 text-sm text-slate-600">Temukan kandidat lokal bertalenta dengan cepat</p>
        </div>

        <form wire:submit="register" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Nama Rekruter / PIC</label>
                    <input type="text" wire:model="name" id="name" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                    @error('name') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="company_name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Nama Perusahaan / UMKM</label>
                    <input type="text" wire:model="company_name" id="company_name" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                    @error('company_name') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Email Akun Login</label>
                    <input type="email" wire:model="email" id="email" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                    @error('email') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="contact_email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Email Terima CV</label>
                    <input type="email" wire:model="contact_email" id="contact_email" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="hrd@perusahaan.com">
                    @error('contact_email') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="city" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Kota / Kabupaten</label>
                    <select wire:model="city" id="city" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                        <option value="">-- Pilih Kota --</option>
                        @foreach($cities as $c)
                            <option value="{{ $c->name }}">{{ $c->name }} ({{ $c->province }})</option>
                        @endforeach
                    </select>
                    @error('city') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Alamat Kantor</label>
                    <input type="text" wire:model="address" id="address" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="Jl. Sudirman No. 12">
                    @error('address') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Password</label>
                    <input type="password" wire:model="password" id="password" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                    @error('password') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Konfirmasi Password</label>
                    <input type="password" wire:model="password_confirmation" id="password_confirmation" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                </div>
            </div>

            <!-- Mandatory Terms Agreement Checkbox -->
            <div class="p-4 bg-amber-50 rounded-xl border border-amber-200 text-amber-900 text-xs leading-relaxed space-y-2">
                <div class="font-bold flex items-center gap-1.5 text-amber-900">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Aturan Etika Rekrutmen NearJob</span>
                </div>
                <p>Perusahaan DILARANG meminta biaya pendaftaran, seragam, tes, atau uang dalam bentuk apa pun kepada pelamar kerja.</p>
                <label class="flex items-start gap-2 pt-1 font-semibold text-slate-800 cursor-pointer">
                    <input type="checkbox" wire:model="agreed_to_terms" class="mt-0.5 w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                    <span>Saya menyetujui aturan di atas dan menjamin lowongan valid.</span>
                </label>
                @error('agreed_to_terms') <span class="text-xs text-red-600 block font-bold">{{ $message }}</span> @enderror
            </div>

            <button type="submit" 
                    class="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-200 transition-all text-sm">
                Daftar Perusahaan & Masuk Dashboard →
            </button>
        </form>
    </div>
</div>
