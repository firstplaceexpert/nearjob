<div class="min-h-[calc(100vh-10rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-6 bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50">
        
        <div class="text-center">
            <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-full mb-2 uppercase tracking-wide">Gen Z & Fresh Graduate</span>
            <h2 class="text-2xl font-extrabold text-slate-900">Daftar Pencari Kerja</h2>
            <p class="mt-1 text-sm text-slate-600">Temukan pekerjaan lokal impian dengan cepat</p>
        </div>

        <form wire:submit="register" class="space-y-4">
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Nama Lengkap</label>
                <input type="text" wire:model="name" id="name" 
                       class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 text-sm"
                       placeholder="Contoh: Budi Pratama">
                @error('name') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Email</label>
                <input type="email" wire:model="email" id="email" 
                       class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 text-sm"
                       placeholder="budi@gmail.com">
                @error('email') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Password</label>
                <input type="password" wire:model="password" id="password" 
                       class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 text-sm"
                       placeholder="Minimal 8 karakter">
                @error('password') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Konfirmasi Password</label>
                <input type="password" wire:model="password_confirmation" id="password_confirmation" 
                       class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 text-sm"
                       placeholder="Ulangi password">
            </div>

            <button type="submit" 
                    class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all text-sm mt-4">
                Daftar & Isi Profil →
            </button>
        </form>

        <div class="text-center pt-4 border-t border-slate-100 text-xs text-slate-500">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:underline">Masuk disini</a>
        </div>
    </div>
</div>
