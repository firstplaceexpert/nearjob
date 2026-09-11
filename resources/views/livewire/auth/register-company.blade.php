<div class="min-h-screen flex flex-col font-sans bg-white text-black" style="font-family: 'Plus Jakarta Sans', system-ui, sans-serif;">

    <!-- Header Bersih NEAR JOB Pemberi Kerja -->
    <header class="bg-white border-b border-black/10 px-4 sm:px-10 h-16 flex items-center justify-between sticky top-0 z-30">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-decoration-none">
            <!-- NEAR JOB Logo Pin -->
            <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-blue-600 text-white shadow-sm">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xl font-black tracking-tight text-black">NEAR JOB</span>
                <span class="text-[11px] font-bold uppercase px-2 py-0.5 rounded border border-black/30 text-black">
                    Pemberi Kerja
                </span>
            </div>
        </a>

        <div class="flex items-center gap-4 text-sm">
            <a href="{{ route('applicant.map') }}" class="font-bold text-black underline text-xs sm:text-sm hover:opacity-75 transition-opacity">
                Sedang mencari kerja?
            </a>
        </div>
    </header>

    <!-- Main Content Body (Langsung Di Atas Background Tanpa Kartu Mandiri) -->
    <main class="flex-grow flex flex-col justify-center px-4 py-8 sm:py-12 bg-white">
        @if($mode === 'login')
            <!-- ========================================== -->
            <!-- TAMPILAN MASUK PERUSAHAAN                 -->
            <!-- ========================================== -->
            <div class="max-w-[440px] mx-auto w-full my-auto">
                @if($login_error)
                    <div class="border-2 border-black rounded-xl p-3.5 mb-6 flex items-start gap-2.5 bg-white text-black">
                        <i class='bx bx-error-circle text-xl shrink-0 mt-0.5 text-black'></i>
                        <p class="text-xs text-black leading-relaxed font-bold">
                            {{ $login_error }}
                        </p>
                    </div>
                @endif

                <div class="mb-7 text-left">
                    <h1 class="text-2xl font-black text-black tracking-tight">Masuk sebagai Pemberi Kerja</h1>
                    <p class="text-xs sm:text-sm text-black mt-1 font-medium">Kelola lowongan dan temukan kandidat terbaik di sekitar Anda</p>
                </div>

                <form wire:submit.prevent="companyLogin" class="space-y-4">
                    <!-- Alamat Email -->
                    <div>
                        <label class="block text-xs font-bold text-black uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <input type="email" wire:model="login_email"
                            class="w-full px-4 py-3 rounded-xl border {{ $errors->has('login_email') ? 'border-black ring-2 ring-black' : 'border-black/20 focus:border-black focus:ring-1 focus:ring-black' }} text-sm text-black bg-white outline-none transition-all placeholder:text-black/40"
                            placeholder="email@perusahaan.com" autocomplete="email">
                        @error('login_email')
                            <p class="text-black text-xs font-bold mt-1.5 flex items-center gap-1">
                                <i class='bx bx-error-circle text-black'></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Kata Sandi -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-black uppercase tracking-wider">Kata Sandi</label>
                            <a href="javascript:void(0)" class="text-xs font-bold text-black underline hover:opacity-75">
                                Lupa kata sandi?
                            </a>
                        </div>
                        <div class="relative">
                            <input type="{{ $login_show_password ? 'text' : 'password' }}" wire:model="login_password"
                                class="w-full px-4 py-3 pr-11 rounded-xl border {{ $errors->has('login_password') ? 'border-black ring-2 ring-black' : 'border-black/20 focus:border-black focus:ring-1 focus:ring-black' }} text-sm text-black bg-white outline-none transition-all placeholder:text-black/40"
                                placeholder="••••••••" autocomplete="current-password">
                            <button type="button" wire:click="toggleLoginPassword" 
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-black hover:opacity-70 p-1">
                                <i class="bx {{ $login_show_password ? 'bx-show' : 'bx-hide' }} text-lg text-black"></i>
                            </button>
                        </div>
                        @error('login_password')
                            <p class="text-black text-xs font-bold mt-1.5 flex items-center gap-1">
                                <i class='bx bx-error-circle text-black'></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tombol Masuk -->
                    <div class="pt-3">
                        <button type="submit"
                            class="w-full py-3.5 text-white font-extrabold rounded-xl text-sm transition-all flex items-center justify-center gap-2 hover:opacity-90 cursor-pointer bg-blue-600">
                            <span wire:loading.remove wire:target="companyLogin" class="flex items-center gap-1.5 text-white">
                                <i class='bx bx-log-in text-lg text-white'></i> Masuk ke Dashboard
                            </span>
                            <span wire:loading wire:target="companyLogin" class="flex items-center gap-2 text-white">
                                <i class='bx bx-loader-alt bx-spin text-base text-white'></i> Masuk...
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Footer Link Daftar -->
                <div class="mt-6 pt-5 border-t border-black/10 text-center text-xs text-black font-medium">
                    Belum memiliki akun perusahaan? 
                    <button type="button" wire:click="setMode('register')" class="text-black font-extrabold underline ml-1 cursor-pointer hover:opacity-75">
                        Daftar Sekarang
                    </button>
                </div>
            </div>

        @else
            <!-- ============================================================== -->
            <!-- TAMPILAN BUAT AKUN PERUSAHAAN (LANGSUNG DI ATAS BACKGROUND)     -->
            <!-- ============================================================== -->
            <div class="max-w-[620px] mx-auto w-full">
                
                <div class="mb-8">
                    <p class="text-xs font-bold text-black uppercase tracking-wider mb-2">Registrasi Akun Resmi</p>
                    <h1 class="text-2xl sm:text-3xl font-black text-black tracking-tight">Daftar Akun Perusahaan</h1>
                    <p class="text-black text-xs sm:text-sm mt-1.5 leading-relaxed font-medium">
                        Lengkapi data usaha dan identitas pemilik untuk mulai membuka lowongan kerja terdekat di NEAR JOB.
                    </p>
                </div>

                <form wire:submit.prevent="register" class="space-y-8">
                    
                    <!-- ============================================== -->
                    <!-- BAGIAN 1: INFORMASI USAHA / PERUSAHAAN        -->
                    <!-- ============================================== -->
                    <div>
                        <div class="pb-2 border-b border-black/15 mb-5 flex items-center gap-2">
                            <i class='bx bx-buildings text-black text-lg'></i>
                            <h2 class="text-xs sm:text-sm font-black uppercase tracking-wider text-black">1. Data Perusahaan / Tempat Usaha</h2>
                        </div>

                        <div class="space-y-4">
                            <!-- Nama Perusahaan -->
                            <div>
                                <label class="block text-xs font-bold text-black uppercase tracking-wider mb-1">
                                    Nama Usaha / Perusahaan *
                                </label>
                                <p class="text-[11px] text-black mb-1.5 font-medium">Nama bisnis atau outlet yang resmi digunakan dan dikenal calon pelamar.</p>
                                <input type="text" wire:model="company_name"
                                    class="w-full px-4 py-3 rounded-xl border {{ $errors->has('company_name') ? 'border-black ring-2 ring-black' : 'border-black/20 focus:border-black focus:ring-1 focus:ring-black' }} text-sm text-black bg-white outline-none transition-all placeholder:text-black/40"
                                    placeholder="Contoh: PT Solusi Maju Bersama / Resto ABC">
                                @error('company_name')
                                    <p class="text-black text-xs font-bold mt-1 flex items-center gap-1">
                                        <i class='bx bx-error-circle text-black'></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Negara & Kota (2 Kolom) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-black uppercase tracking-wider mb-1.5">Negara</label>
                                    <input type="text" value="Indonesia" disabled
                                        class="w-full px-4 py-3 rounded-xl border border-black/20 text-sm text-black bg-black/5 cursor-not-allowed font-medium">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-black uppercase tracking-wider mb-1.5">
                                        Kota Domisili Usaha *
                                    </label>
                                    <select wire:model="city"
                                        class="w-full px-4 py-3 rounded-xl border border-black/20 focus:border-black focus:ring-1 focus:ring-black text-sm text-black bg-white outline-none cursor-pointer">
                                        @foreach($cities as $c)
                                            <option value="{{ $c->name }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Nomor Telepon / WhatsApp -->
                            <div>
                                <label class="block text-xs font-bold text-black uppercase tracking-wider mb-1">
                                    Nomor WhatsApp / Telepon Utama *
                                </label>
                                <p class="text-[11px] text-black mb-1.5 font-medium">Nomor utama untuk komunikasi dan notifikasi sistem (hanya angka).</p>
                                
                                <div class="flex items-center rounded-xl border {{ $errors->has('phone_number') ? 'border-black ring-2 ring-black' : 'border-black/20 focus-within:border-black focus-within:ring-1 focus-within:ring-black' }} bg-white overflow-hidden">
                                    <div class="px-4 py-3 bg-black/5 border-r border-black/20 text-xs sm:text-sm font-bold text-black flex items-center gap-1 select-none">
                                        <span>🇮🇩 +62</span>
                                    </div>
                                    <input type="tel" wire:model.live="phone_number" inputmode="numeric" pattern="[0-9]*"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        placeholder="81234567890"
                                        class="w-full py-3 px-3.5 text-sm text-black bg-transparent outline-none placeholder:text-black/40">
                                </div>
                                @error('phone_number')
                                    <p class="text-black text-xs font-bold mt-1 flex items-center gap-1">
                                        <i class='bx bx-error-circle text-black'></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- BAGIAN 2: DATA PEMILIK USAHA & VERIFIKASI KTP -->
                    <!-- ============================================== -->
                    <div>
                        <div class="pb-2 border-b border-black/15 mb-5 flex items-center gap-2">
                            <i class='bx bx-id-card text-black text-lg'></i>
                            <h2 class="text-xs sm:text-sm font-black uppercase tracking-wider text-black">2. Identitas Pemilik Usaha & Verifikasi</h2>
                        </div>

                        <div class="space-y-4">
                            <!-- Nama Depan & Belakang -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-black uppercase tracking-wider mb-1.5">
                                        Nama Depan *
                                    </label>
                                    <input type="text" wire:model="first_name"
                                        class="w-full px-4 py-3 rounded-xl border {{ $errors->has('first_name') ? 'border-black ring-2 ring-black' : 'border-black/20 focus:border-black focus:ring-1 focus:ring-black' }} text-sm text-black bg-white outline-none transition-all placeholder:text-black/40"
                                        placeholder="Nama depan">
                                    @error('first_name')
                                        <p class="text-black text-xs font-bold mt-1 flex items-center gap-1">
                                            <i class='bx bx-error-circle text-black'></i> {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-black uppercase tracking-wider mb-1.5">
                                        Nama Belakang
                                    </label>
                                    <input type="text" wire:model="last_name"
                                        class="w-full px-4 py-3 rounded-xl border border-black/20 focus:border-black focus:ring-1 focus:ring-black text-sm text-black bg-white outline-none transition-all placeholder:text-black/40"
                                        placeholder="Nama belakang">
                                </div>
                            </div>

                            <!-- NIK Pemilik Usaha -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block text-xs font-bold text-black uppercase tracking-wider">
                                        NIK Pemilik Usaha *
                                    </label>
                                    <span class="text-[10px] font-bold text-black border border-black/30 px-2 py-0.5 rounded">
                                        Privasi Terproteksi
                                    </span>
                                </div>
                                <p class="text-[11px] text-black mb-1.5 font-medium">
                                    16 digit NIK pemilik usaha (hanya angka). Data NIK disensor di profil publik dan tidak dibocorkan.
                                </p>
                                <input type="text" wire:model.live="nik" maxlength="16" inputmode="numeric" pattern="[0-9]*"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    class="w-full px-4 py-3 rounded-xl border font-mono {{ $errors->has('nik') ? 'border-black ring-2 ring-black' : 'border-black/20 focus:border-black focus:ring-1 focus:ring-black' }} text-sm text-black bg-white outline-none transition-all placeholder:text-black/40"
                                    placeholder="16 digit NIK pemilik usaha">
                                @error('nik')
                                    <p class="text-black text-xs font-bold mt-1 flex items-center gap-1">
                                        <i class='bx bx-error-circle text-black'></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Upload Foto KTP Pemilik Usaha (Opsional - Tanda Verify) -->
                            <div class="p-4 rounded-xl border border-black/20 bg-white">
                                <div class="flex items-start justify-between gap-3 mb-1.5">
                                    <label class="block text-xs font-bold text-black">
                                        <i class='bx bx-id-card text-black align-middle'></i> Foto KTP Pemilik Usaha (Opsional)
                                    </label>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded border border-black/30 text-black shrink-0">
                                        Opsional — Untuk Tanda Verify
                                    </span>
                                </div>
                                <p class="text-[11px] text-black leading-relaxed mb-3 font-medium">
                                    Unggah foto KTP bersifat <strong>opsional</strong>. Unggah jika Anda ingin profil perusahaan memiliki tanda verifikasi resmi (Verify). Foto yang diunggah otomatis distempel watermark permanen "NEAR JOB" agar aman dari penyalahgunaan.
                                </p>

                                <input type="file" wire:model="ktp_file" accept="image/*"
                                    class="block w-full text-xs text-black file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-black file:text-white hover:file:bg-black/80 cursor-pointer">

                                <div wire:loading wire:target="ktp_file" class="text-xs text-black font-bold mt-2">
                                    <i class='bx bx-loader-alt bx-spin text-black'></i> Memproses KTP & watermark otomatis...
                                </div>

                                @if($ktp_file)
                                    <div class="mt-3 p-2.5 bg-white rounded-xl border border-black/20 flex items-center gap-3">
                                        <img src="{{ $ktp_file->temporaryUrl() }}" class="w-14 h-10 object-cover rounded border border-black/20" alt="Preview KTP">
                                        <div class="text-xs">
                                            <p class="font-bold text-black">Preview KTP terpilih</p>
                                            <p class="text-[11px] text-black font-medium">✓ Akun akan otomatis mendapatkan tanda verifikasi resmi</p>
                                        </div>
                                    </div>
                                @endif

                                @error('ktp_file')
                                    <p class="text-black text-xs font-bold mt-1.5 flex items-center gap-1">
                                        <i class='bx bx-error-circle text-black'></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- ============================================== -->
                    <!-- BAGIAN 3: INFORMASI AKUN & KATA SANDI         -->
                    <!-- ============================================== -->
                    <div>
                        <div class="pb-2 border-b border-black/15 mb-5 flex items-center gap-2">
                            <i class='bx bx-lock-alt text-black text-lg'></i>
                            <h2 class="text-xs sm:text-sm font-black uppercase tracking-wider text-black">3. Akun & Keamanan</h2>
                        </div>

                        <div class="space-y-4">
                            <!-- Email Akun -->
                            <div>
                                <label class="block text-xs font-bold text-black uppercase tracking-wider mb-1.5">
                                    Alamat Email Perusahaan *
                                </label>
                                <input type="email" wire:model="email"
                                    class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-black ring-2 ring-black' : 'border-black/20 focus:border-black focus:ring-1 focus:ring-black' }} text-sm text-black bg-white outline-none transition-all placeholder:text-black/40"
                                    placeholder="nama@perusahaan.com">
                                @error('email')
                                    <p class="text-black text-xs font-bold mt-1 flex items-center gap-1">
                                        <i class='bx bx-error-circle text-black'></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Kata Sandi -->
                            <div>
                                <label class="block text-xs font-bold text-black uppercase tracking-wider mb-1.5">
                                    Kata Sandi *
                                </label>
                                <div class="relative">
                                    <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model="password"
                                        class="w-full px-4 py-3 pr-11 rounded-xl border {{ $errors->has('password') ? 'border-black ring-2 ring-black' : 'border-black/20 focus:border-black focus:ring-1 focus:ring-black' }} text-sm text-black bg-white outline-none transition-all placeholder:text-black/40"
                                        placeholder="Minimal 6 karakter">
                                    <button type="button" wire:click="togglePassword" 
                                        class="absolute right-3.5 top-1/2 -translate-y-1/2 text-black hover:opacity-70 p-1">
                                        <i class="bx {{ $showPassword ? 'bx-show' : 'bx-hide' }} text-lg text-black"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="text-black text-xs font-bold mt-1 flex items-center gap-1">
                                        <i class='bx bx-error-circle text-black'></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit Pendaftaran -->
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full py-4 text-white font-extrabold rounded-xl text-sm transition-all flex items-center justify-center gap-2 hover:opacity-90 cursor-pointer bg-blue-600">
                            <span wire:loading.remove wire:target="register" class="flex items-center gap-1.5 text-white">
                                <i class='bx bx-check-shield text-lg text-white'></i> Buat Akun Perusahaan & Mulai Pasang Loker
                            </span>
                            <span wire:loading wire:target="register" class="flex items-center gap-2 text-white">
                                <i class='bx bx-loader-alt bx-spin text-base text-white'></i> Menyimpan data & watermark KTP...
                            </span>
                        </button>

                        <p class="mt-5 text-center text-xs text-black font-medium">
                            Sudah memiliki akun perusahaan? 
                            <button type="button" wire:click="setMode('login')" class="text-black font-extrabold underline ml-1 cursor-pointer hover:opacity-75">
                                Masuk di sini
                            </button>
                        </p>
                    </div>
                </form>
            </div>
        @endif
    </main>
</div>
