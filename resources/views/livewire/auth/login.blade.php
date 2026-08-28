<div class="min-h-[calc(100vh-10rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50">
        
        <div class="text-center">
            <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white font-extrabold text-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-200">
                N
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900">Masuk Akun NearJob</h2>
            <p class="mt-2 text-sm text-slate-600">Silakan masuk menggunakan email dan kata sandi Anda</p>
        </div>

        <form wire:submit="login" class="mt-8 space-y-5">
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                <input type="email" wire:model="email" id="email" 
                       class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 placeholder-slate-400 transition-colors"
                       placeholder="nama@email.com">
                @error('email') <span class="text-xs text-red-600 mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                <input type="password" wire:model="password" id="password" 
                       class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-slate-900 placeholder-slate-400 transition-colors"
                       placeholder="••••••••">
                @error('password') <span class="text-xs text-red-600 mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                    <input type="checkbox" wire:model="remember" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" 
                    class="w-full py-3.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all flex items-center justify-center gap-2 text-sm">
                <span>Masuk Sekarang</span>
            </button>
        </form>

        <div class="text-center pt-4 border-t border-slate-100 text-xs text-slate-500 space-y-2">
            <p>Belum punya akun?</p>
            <div class="flex justify-center gap-4 font-semibold text-indigo-600">
                <a href="{{ route('register.applicant') }}" class="hover:underline">Daftar Pencari Kerja</a>
                <span>•</span>
                <a href="{{ route('register.company') }}" class="hover:underline">Daftar Perusahaan</a>
            </div>
        </div>
    </div>
</div>
