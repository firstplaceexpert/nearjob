<div class="min-h-screen flex flex-col font-sans text-slate-800" style="background: #f0f4f9; font-family: 'Plus Jakarta Sans', system-ui, sans-serif;">

    <!-- Header Resmi NEAR JOB Pemberi Kerja -->
    <header class="bg-white border-b border-slate-200/80 px-4 sm:px-10 h-16 flex items-center justify-between sticky top-0 z-30 shadow-sm">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-decoration-none">
            <!-- NEAR JOB Logo Pin -->
            <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-blue-600 shadow-md shadow-blue-600/30 text-white">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xl font-black tracking-tight text-slate-900">NEAR JOB</span>
                <span class="text-[11px] font-extrabold uppercase px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 border border-blue-200">
                    Pemberi Kerja
                </span>
            </div>
        </a>

        <div class="flex items-center gap-4 text-sm">
            <a href="{{ route('applicant.map') }}" class="font-bold text-blue-600 hover:text-blue-800 underline text-xs sm:text-sm transition-colors">
                Sedang mencari kerja?
            </a>
        </div>
    </header>

    <!-- Main Content Body -->
    <main class="flex-grow flex flex-col justify-center px-4 py-8 sm:py-12">
        @if($mode === 'login')
            <!-- ========================================== -->
            <!-- TAMPILAN MASUK PERUSAHAAN (NEAR JOB THEME) -->
            <!-- ========================================== -->
            <div class="max-w-[440px] mx-auto w-full my-auto">
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-900/5 p-7 sm:p-9 relative overflow-hidden">
                    <!-- Accent Gradient Bar NearJob -->
                    <div class="h-1.5 w-full bg-gradient-to-r from-blue-600 via-blue-500 to-teal-500 absolute top-0 left-0"></div>

                    @if($login_error)
                        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-3.5 mb-6 flex items-start gap-2.5">
                            <i class='bx bx-error-circle text-amber-600 text-xl shrink-0 mt-0.5'></i>
                            <p class="text-xs text-amber-900 leading-relaxed font-semibold">
                                {{ $login_error }}
                            </p>
                        </div>
                    @endif

                    <div class="mb-7 text-center sm:text-left">
                        <div class="w-11 h-11 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mb-3 shadow-inner">
                            <i class='bx bx-buildings'></i>
                        </div>
                        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Masuk sebagai Pemberi Kerja</h1>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">Kelola lowongan dan temukan kandidat terbaik di sekitar Anda</p>
                    </div>

                    <form wire:submit.prevent="companyLogin" class="space-y-4">
                        <!-- Alamat Email -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                            <input type="email" wire:model="login_email"
                                class="w-full px-4 py-3 rounded-xl border {{ $errors->has('login_email') ? 'border-red-500 ring-2 ring-red-100 bg-red-50/20' : 'border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100' }} text-sm text-slate-800 bg-slate-50 focus:bg-white outline-none transition-all"
                                placeholder="email@perusahaan.com" autocomplete="email">
                            @error('login_email')
                                <p class="text-red-500 text-xs font-bold mt-1.5 flex items-center gap-1">
                                    <i class='bx bx-error-circle'></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Kata Sandi -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi</label>
                                <a href="javascript:void(0)" class="text-xs font-bold text-blue-600 hover:underline">
                                    Lupa kata sandi?
                                </a>
                            </div>
                            <div class="relative">
                                <input type="{{ $login_show_password ? 'text' : 'password' }}" wire:model="login_password"
                                    class="w-full px-4 py-3 pr-11 rounded-xl border {{ $errors->has('login_password') ? 'border-red-500 ring-2 ring-red-100 bg-red-50/20' : 'border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100' }} text-sm text-slate-800 bg-slate-50 focus:bg-white outline-none transition-all"
                                    placeholder="••••••••" autocomplete="current-password">
                                <button type="button" wire:click="toggleLoginPassword" 
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 p-1">
                                    <i class="bx {{ $login_show_password ? 'bx-show' : 'bx-hide' }} text-lg"></i>
                                </button>
                            </div>
                            @error('login_password')
                                <p class="text-red-500 text-xs font-bold mt-1.5 flex items-center gap-1">
                                    <i class='bx bx-error-circle'></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Tombol Masuk Biru NearJob -->
                        <div class="pt-3">
                            <button type="submit"
                                class="w-full py-3.5 text-white font-extrabold rounded-xl text-sm transition-all shadow-lg shadow-blue-600/25 flex items-center justify-center gap-2 hover:opacity-95 cursor-pointer"
                                style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                                <span wire:loading.remove wire:target="companyLogin" class="flex items-center gap-1.5">
                                    <i class='bx bx-log-in text-lg'></i> Masuk ke Dashboard
                                </span>
                                <span wire:loading wire:target="companyLogin" class="flex items-center gap-2">
                                    <i class='bx bx-loader-alt bx-spin text-base'></i> Masuk...
                                </span>
                            </button>
                        </div>
                    </form>

                    <!-- Footer Link Daftar -->
                    <div class="mt-6 pt-5 border-t border-slate-100 text-center text-xs text-slate-600 font-medium">
                        Belum memiliki akun perusahaan? 
                        <button type="button" wire:click="setMode('register')" class="text-blue-600 font-extrabold hover:underline ml-1 cursor-pointer">
                            Daftar Sekarang
                        </button>
                    </div>
                </div>
            </div>

        @else
            <!-- ============================================================== -->
            <!-- TAMPILAN BUAT AKUN PERUSAHAAN (NEAR JOB THEME)                  -->
            <!-- ============================================================== -->
            <div class="max-w-[660px] mx-auto w-full">
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-900/5 p-7 sm:p-10 relative overflow-hidden">
                    <!-- Accent Gradient Bar NearJob -->
                    <div class="h-1.5 w-full bg-gradient-to-r from-blue-600 via-blue-500 to-teal-500 absolute top-0 left-0"></div>

                    <div class="mb-8">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold mb-3 border border-blue-100">
                            <i class='bx bx-shield-quarter text-sm'></i> Registrasi Akun Resmi Pemberi Kerja
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Daftar Akun Perusahaan</h1>
                        <p class="text-slate-500 text-xs sm:text-sm mt-1.5 leading-relaxed font-medium">
                            Lengkapi data usaha dan identitas pemilik untuk mulai membuka lowongan kerja terdekat di NEAR JOB.
                        </p>
                    </div>

                    <form wire:submit.prevent="register" class="space-y-8">
                        
                        <!-- ============================================== -->
                        <!-- BAGIAN 1: INFORMASI USAHA / PERUSAHAAN        -->
                        <!-- ============================================== -->
                        <div>
                            <div class="pb-2.5 border-b border-slate-100 mb-5 flex items-center gap-2">
                                <i class='bx bx-buildings text-blue-600 text-lg'></i>
                                <h2 class="text-xs sm:text-sm font-black uppercase tracking-wider text-blue-700">1. Data Perusahaan / Tempat Usaha</h2>
                            </div>

                            <div class="space-y-4">
                                <!-- Nama Perusahaan -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                        Nama Usaha / Perusahaan <span class="text-red-500">*</span>
                                    </label>
                                    <p class="text-[11px] text-slate-400 mb-1.5">Nama bisnis atau outlet yang resmi digunakan dan dikenal calon pelamar.</p>
                                    <input type="text" wire:model="company_name"
                                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('company_name') ? 'border-red-500 ring-2 ring-red-100 bg-red-50/20' : 'border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100' }} text-sm text-slate-800 bg-slate-50 focus:bg-white outline-none transition-all"
                                        placeholder="Contoh: PT Solusi Maju Bersama / Resto ABC">
                                    @error('company_name')
                                        <p class="text-red-500 text-xs font-bold mt-1 flex items-center gap-1">
                                            <i class='bx bx-error-circle'></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Negara & Kota (2 Kolom) -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Negara</label>
                                        <input type="text" value="Indonesia" disabled
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-500 bg-slate-100 cursor-not-allowed">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                            Kota Domisili Usaha <span class="text-red-500">*</span>
                                        </label>
                                        <select wire:model="city"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-sm text-slate-800 bg-slate-50 focus:bg-white outline-none cursor-pointer">
                                            @foreach($cities as $c)
                                                <option value="{{ $c->name }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Nomor Telepon / WhatsApp -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                                        Nomor WhatsApp / Telepon Utama <span class="text-red-500">*</span>
                                    </label>
                                    <p class="text-[11px] text-slate-400 mb-1.5">Nomor utama untuk komunikasi dan notifikasi sistem (hanya angka).</p>
                                    
                                    <div class="flex items-center rounded-xl border {{ $errors->has('phone_number') ? 'border-red-500 ring-2 ring-red-100' : 'border-slate-200 focus-within:border-blue-600 focus-within:ring-2 focus-within:ring-blue-100' }} bg-slate-50 overflow-hidden">
                                        <div class="px-4 py-3 bg-slate-100 border-r border-slate-200 text-xs sm:text-sm font-bold text-slate-700 flex items-center gap-1 select-none">
                                            <span>🇮🇩 +62</span>
                                        </div>
                                        <input type="tel" wire:model.live="phone_number" inputmode="numeric" pattern="[0-9]*"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                            placeholder="81234567890"
                                            class="w-full py-3 px-3.5 text-sm text-slate-800 bg-transparent outline-none">
                                    </div>
                                    @error('phone_number')
                                        <p class="text-red-500 text-xs font-bold mt-1 flex items-center gap-1">
                                            <i class='bx bx-error-circle'></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- ============================================== -->
                        <!-- BAGIAN 2: DATA PEMILIK USAHA & VERIFIKASI KTP -->
                        <!-- ============================================== -->
                        <div>
                            <div class="pb-2.5 border-b border-slate-100 mb-5 flex items-center gap-2">
                                <i class='bx bx-id-card text-blue-600 text-lg'></i>
                                <h2 class="text-xs sm:text-sm font-black uppercase tracking-wider text-blue-700">2. Identitas Pemilik Usaha & Verifikasi</h2>
                            </div>

                            <div class="space-y-4">
                                <!-- Nama Depan & Belakang -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                            Nama Depan <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" wire:model="first_name"
                                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('first_name') ? 'border-red-500 ring-2 ring-red-100 bg-red-50/20' : 'border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100' }} text-sm text-slate-800 bg-slate-50 focus:bg-white outline-none transition-all"
                                            placeholder="Nama depan">
                                        @error('first_name')
                                            <p class="text-red-500 text-xs font-bold mt-1 flex items-center gap-1">
                                                <i class='bx bx-error-circle'></i> {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                            Nama Belakang
                                        </label>
                                        <input type="text" wire:model="last_name"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 text-sm text-slate-800 bg-slate-50 focus:bg-white outline-none transition-all"
                                            placeholder="Nama belakang">
                                    </div>
                                </div>

                                <!-- NIK Pemilik Usaha -->
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                                            NIK Pemilik Usaha <span class="text-red-500">*</span>
                                        </label>
                                        <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                                            Privasi Terproteksi
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-slate-400 mb-1.5">
                                        16 digit NIK pemilik usaha (hanya angka). Data NIK disensor di profil publik dan tidak dibocorkan.
                                    </p>
                                    <input type="text" wire:model.live="nik" maxlength="16" inputmode="numeric" pattern="[0-9]*"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        class="w-full px-4 py-3 rounded-xl border font-mono {{ $errors->has('nik') ? 'border-red-500 ring-2 ring-red-100 bg-red-50/20' : 'border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100' }} text-sm text-slate-800 bg-slate-50 focus:bg-white outline-none transition-all"
                                        placeholder="16 digit NIK pemilik usaha">
                                    @error('nik')
                                        <p class="text-red-500 text-xs font-bold mt-1 flex items-center gap-1">
                                            <i class='bx bx-error-circle'></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Upload Foto KTP Pemilik Usaha (Watermark NEAR JOB) -->
                                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                                    <div class="flex items-start justify-between gap-3 mb-1.5">
                                        <label class="block text-xs font-bold text-slate-700">
                                            <i class='bx bx-id-card text-blue-600 align-middle'></i> Foto KTP Pemilik Usaha (Verifikasi Akun)
                                        </label>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-blue-100 text-blue-800 border border-blue-200 shrink-0">
                                            Watermark NEAR JOB
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 leading-relaxed mb-3">
                                        Unggah foto KTP Anda. Gambar yang tersimpan di database <strong>otomatis distempel watermark resmi "NEAR JOB"</strong> permanen agar data Anda aman dari penyalahgunaan.
                                    </p>

                                    <input type="file" wire:model="ktp_file" accept="image/*"
                                        class="block w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">

                                    <div wire:loading wire:target="ktp_file" class="text-xs text-blue-600 font-bold mt-2">
                                        <i class='bx bx-loader-alt bx-spin'></i> Memproses KTP & watermark otomatis...
                                    </div>

                                    @if($ktp_file)
                                        <div class="mt-3 p-2 bg-white rounded-xl border border-slate-200 flex items-center gap-3">
                                            <img src="{{ $ktp_file->temporaryUrl() }}" class="w-14 h-10 object-cover rounded-lg border border-slate-200 shadow-sm" alt="Preview KTP">
                                            <div class="text-xs">
                                                <p class="font-bold text-slate-800">Preview KTP terpilih</p>
                                                <p class="text-[11px] text-emerald-600 font-bold">✓ KTP siap di-watermark "NEAR JOB" saat disimpan</p>
                                            </div>
                                        </div>
                                    @endif

                                    @error('ktp_file')
                                        <p class="text-red-500 text-xs font-bold mt-1.5 flex items-center gap-1">
                                            <i class='bx bx-error-circle'></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- ============================================== -->
                        <!-- BAGIAN 3: INFORMASI AKUN & KATA SANDI         -->
                        <!-- ============================================== -->
                        <div>
                            <div class="pb-2.5 border-b border-slate-100 mb-5 flex items-center gap-2">
                                <i class='bx bx-lock-alt text-blue-600 text-lg'></i>
                                <h2 class="text-xs sm:text-sm font-black uppercase tracking-wider text-blue-700">3. Akun & Keamanan</h2>
                            </div>

                            <div class="space-y-4">
                                <!-- Email Akun -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Alamat Email Perusahaan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" wire:model="email"
                                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-500 ring-2 ring-red-100 bg-red-50/20' : 'border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100' }} text-sm text-slate-800 bg-slate-50 focus:bg-white outline-none transition-all"
                                        placeholder="nama@perusahaan.com">
                                    @error('email')
                                        <p class="text-red-500 text-xs font-bold mt-1 flex items-center gap-1">
                                            <i class='bx bx-error-circle'></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Kata Sandi -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                                        Kata Sandi <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model="password"
                                            class="w-full px-4 py-3 pr-11 rounded-xl border {{ $errors->has('password') ? 'border-red-500 ring-2 ring-red-100 bg-red-50/20' : 'border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-100' }} text-sm text-slate-800 bg-slate-50 focus:bg-white outline-none transition-all"
                                            placeholder="Minimal 6 karakter">
                                        <button type="button" wire:click="togglePassword" 
                                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 p-1">
                                            <i class="bx {{ $showPassword ? 'bx-show' : 'bx-hide' }} text-lg"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="text-red-500 text-xs font-bold mt-1 flex items-center gap-1">
                                            <i class='bx bx-error-circle'></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Submit Pendaftaran Biru NEAR JOB -->
                        <div class="pt-2">
                            <button type="submit"
                                class="w-full py-4 text-white font-extrabold rounded-xl text-sm transition-all shadow-xl shadow-blue-600/30 flex items-center justify-center gap-2 hover:opacity-95 cursor-pointer"
                                style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                                <span wire:loading.remove wire:target="register" class="flex items-center gap-1.5">
                                    <i class='bx bx-check-shield text-lg'></i> Buat Akun Perusahaan & Mulai Pasang Loker
                                </span>
                                <span wire:loading wire:target="register" class="flex items-center gap-2">
                                    <i class='bx bx-loader-alt bx-spin text-base'></i> Menyimpan data & watermark KTP...
                                </span>
                            </button>

                            <p class="mt-5 text-center text-xs text-slate-500 font-medium">
                                Sudah memiliki akun perusahaan? 
                                <button type="button" wire:click="setMode('login')" class="text-blue-600 font-extrabold hover:underline ml-1 cursor-pointer">
                                    Masuk di sini
                                </button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </main>
</div>
