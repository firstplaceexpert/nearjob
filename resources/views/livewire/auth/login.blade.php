<div class="min-h-screen flex items-center justify-center px-4 py-12 bg-slate-50">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-800">Masuk ke NEAR JOB</h1>
            <p class="text-slate-500 text-sm mt-1">Masukkan email dan kata sandi Anda</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
            <form wire:submit="login" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Email</label>
                    <input type="email" wire:model="email" id="login-email"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 focus:bg-white transition-colors"
                        placeholder="email@contoh.com" autocomplete="email">
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi</label>
                    <input type="password" wire:model="password" id="login-password"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm bg-slate-50 focus:bg-white transition-colors"
                        placeholder="••••••••" autocomplete="current-password">
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit"
                    class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-colors text-sm shadow-lg shadow-blue-600/20">
                    Masuk
                </button>
            </form>

            <div class="mt-5 pt-5 border-t border-slate-100 space-y-2">
                <p class="text-xs text-slate-500 text-center font-medium">Belum punya akun?</p>
                <a href="{{ route('register.applicant') }}" class="flex items-center justify-center gap-2 w-full py-3 border-2 border-blue-200 text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition-colors text-sm">
                    <i class='bx bx-search'></i> Daftar sebagai Pencari Kerja
                </a>
                <a href="{{ route('register.company') }}" class="flex items-center justify-center gap-2 w-full py-3 border-2 border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors text-sm">
                    <i class='bx bx-buildings'></i> Daftar sebagai Pemberi Kerja
                </a>
            </div>
        </div>

        {{-- Demo credentials --}}
        <div class="mt-4 bg-blue-50 border border-blue-100 rounded-2xl p-4">
            <p class="text-xs font-bold text-blue-700 mb-2">🎯 Akun Demo:</p>
            <div class="space-y-1 text-xs text-blue-600">
                <p><strong>Pelamar:</strong> andi@demo.com / password</p>
                <p><strong>Pelamar (0 kredit):</strong> dewi@demo.com / password</p>
                <p><strong>Pemberi Kerja:</strong> hr@warungabc.com / password</p>
            </div>
        </div>
    </div>
</div>
