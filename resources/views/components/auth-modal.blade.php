{{-- JobStreet Style Auth Modal Pop-up --}}
<div x-data="{ 
        open: false, 
        title: 'Masuk untuk Melamar Lowongan', 
        subtitle: 'Masuk atau buat akun pencari kerja untuk langsung terhubung dengan perusahaan.',
        returnUrl: window.location.href 
     }"
     @open-auth-modal.window="
        open = true; 
        if ($event.detail && $event.detail.title) title = $event.detail.title;
        if ($event.detail && $event.detail.subtitle) subtitle = $event.detail.subtitle;
     "
     @keydown.escape.window="open = false"
     x-cloak
     x-show="open" 
     class="fixed inset-0 z-[1000] flex items-center justify-center p-4" 
     style="display: none;">
    
    {{-- Backdrop --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

    {{-- Modal Dialog --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full p-6 sm:p-8 overflow-hidden text-center z-10 border border-slate-100">
        
        {{-- Close Button --}}
        <button type="button" 
                @click="open = false" 
                class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors text-lg font-bold">
            <i class='bx bx-x text-xl leading-none'></i>
        </button>

        {{-- Icon / Header Graphic --}}
        <div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-lg"
             style="background: linear-gradient(135deg, #24427b, #5680d8); box-shadow: 0 8px 25px rgba(36,66,123,.3);">
            <i class='bx bx-lock-alt text-3xl text-white'></i>
        </div>

        {{-- Titles --}}
        <h3 class="text-xl sm:text-2xl font-black text-slate-900 leading-tight mb-2" x-text="title">
            Masuk untuk Melamar Lowongan
        </h3>
        <p class="text-slate-500 text-xs sm:text-sm mb-6 leading-relaxed" x-text="subtitle">
            Masuk atau buat akun pencari kerja untuk langsung terhubung dengan perusahaan.
        </p>

        {{-- Action Buttons (JobStreet Style) --}}
        <div class="space-y-3">
            {{-- Tombol Masuk --}}
            <a :href="'{{ route('login') }}?redirect=' + encodeURIComponent(returnUrl)" 
               class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-700 active:scale-98 text-white font-extrabold rounded-2xl text-sm shadow-md shadow-blue-600/25 transition-all flex items-center justify-center gap-2 text-decoration-none">
                <i class='bx bx-log-in text-lg'></i>
                Masuk ke Akun Anda
            </a>

            {{-- Tombol Daftar Pelamar --}}
            <a :href="'{{ route('register.applicant') }}?redirect=' + encodeURIComponent(returnUrl)" 
               class="w-full py-3.5 px-4 bg-slate-50 hover:bg-slate-100 border-2 border-slate-200 text-slate-800 font-extrabold rounded-2xl text-sm transition-all flex items-center justify-center gap-2 text-decoration-none">
                <i class='bx bx-user-plus text-lg text-blue-600'></i>
                Daftar sebagai Pencari Kerja
            </a>
        </div>

        {{-- Footer Link --}}
        <div class="mt-6 pt-4 border-t border-slate-100 flex flex-col items-center gap-2 text-xs">
            <span class="text-slate-400">Pemberi kerja atau perusahaan?</span>
            <a href="{{ route('register.company') }}" class="font-extrabold text-blue-600 hover:underline">
                Daftar Akun Perusahaan & Pasang Lowongan →
            </a>
        </div>
    </div>
</div>
