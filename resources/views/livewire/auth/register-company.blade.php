<div class="min-h-screen bg-[#fcfdfd] flex flex-col font-sans text-slate-800" style="font-family: 'Plus Jakarta Sans', system-ui, sans-serif;">
    <style>
        .seek-navy { color: #001b3a; }
        .seek-bg-navy { background-color: #001b3a; }
        .seek-btn-pink {
            background-color: #e60067 !important;
            color: #ffffff !important;
            font-weight: 700;
            border-radius: 8px;
            transition: background-color 0.15s ease-in-out, transform 0.05s ease;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .seek-btn-pink:hover {
            background-color: #c2005a !important;
        }
        .seek-btn-pink:active {
            transform: scale(0.99);
        }
        .seek-field {
            border: 1px solid #94a3b8;
            border-radius: 8px;
            background-color: #ffffff;
            color: #0f172a;
            font-size: 14px;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        .seek-field:focus {
            border-color: #001b3a;
            box-shadow: 0 0 0 1px #001b3a;
        }
        .seek-field-error {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 1px #dc2626 !important;
            background-color: #fef2f2 !important;
        }
        .seek-select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px 16px;
            padding-right: 36px;
        }
    </style>

    <!-- Header SEEK Perusahaan -->
    <header class="bg-white border-b border-slate-200/75 px-6 sm:px-12 h-16 flex items-center justify-between sticky top-0 z-30 shadow-none">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-decoration-none">
            <!-- SEEK style circle dot icon -->
            <div class="w-8 h-8 rounded-full seek-bg-navy flex items-center justify-center p-1.5 shadow-sm">
                <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="12" cy="12" r="2.2" />
                    <circle cx="12" cy="5" r="1.5" />
                    <circle cx="12" cy="19" r="1.5" />
                    <circle cx="5" cy="12" r="1.5" />
                    <circle cx="19" cy="12" r="1.5" />
                    <circle cx="7" cy="7" r="1.5" />
                    <circle cx="17" cy="17" r="1.5" />
                    <circle cx="7" cy="17" r="1.5" />
                    <circle cx="17" cy="7" r="1.5" />
                    <circle cx="12" cy="8.5" r="1.5" />
                    <circle cx="12" cy="15.5" r="1.5" />
                    <circle cx="8.5" cy="12" r="1.5" />
                    <circle cx="15.5" cy="12" r="1.5" />
                </svg>
            </div>
            <div class="flex items-baseline gap-1.5">
                <span class="text-xl font-extrabold tracking-tight seek-navy">nearjob</span>
                <span class="text-base font-normal text-slate-700">perusahaan</span>
            </div>
        </a>

        <div class="flex items-center gap-5 text-sm">
            @if($mode === 'register')
                <div class="hidden sm:flex items-center gap-1.5 text-slate-700 text-xs font-semibold px-2 py-1 rounded cursor-pointer hover:bg-slate-100 transition-colors">
                    <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                    </svg>
                    <i class='bx bx-chevron-down text-slate-500'></i>
                </div>
            @endif
            <a href="{{ route('applicant.map') }}" class="font-medium seek-navy underline hover:text-[#e60067] text-xs sm:text-sm transition-colors">
                Sedang mencari kerja?
            </a>
        </div>
    </header>

    <!-- Main Content Body -->
    <main class="flex-grow flex flex-col justify-center px-4 py-8 sm:py-12">
        @if($mode === 'login')
            <!-- ========================================== -->
            <!-- TAMPILAN MASUK PERUSAHAAN (Screenshot 1)  -->
            <!-- ========================================== -->
            <div class="w-full flex justify-center items-center my-auto">
                <div style="max-width: 480px; width: 100%; border: 1px solid #cbd5e1; border-radius: 16px; background-color: #ffffff; box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05); padding: 32px 36px;">
                    
                    @if($login_error)
                        <div style="background-color: #fffbeb; border: 1px solid #fef3c7; border-radius: 10px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px; margin-bottom: 24px;">
                            <svg style="width: 20px; height: 20px; color: #b45309; flex-shrink: 0; margin-top: 1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <p style="font-size: 13px; color: #92400e; line-height: 1.45; font-weight: 500; margin: 0;">
                                {{ $login_error }}
                            </p>
                        </div>
                    @endif

                    <h1 class="text-3xl font-extrabold seek-navy tracking-tight" style="margin: 0 0 28px 0;">Masuk</h1>

                    <form wire:submit.prevent="companyLogin" class="space-y-5">
                        <!-- Alamat Email -->
                        <div>
                            <label class="block text-sm font-semibold seek-navy mb-1.5">Alamat email</label>
                            <input type="email" wire:model="login_email"
                                class="w-full h-11 px-3.5 seek-field {{ $errors->has('login_email') ? 'seek-field-error' : '' }}"
                                autocomplete="email">
                            @error('login_email')
                                <div style="color: #dc2626; font-size: 12px; font-weight: 600; margin-top: 6px; display: flex; align-items: center; gap: 4px;">
                                    <span style="font-size: 10px;">◇</span> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Kata Sandi -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-sm font-semibold seek-navy">Kata sandi</label>
                                <a href="javascript:void(0)" class="text-xs sm:text-sm font-semibold seek-navy underline hover:text-[#e60067] transition-colors">
                                    Lupa kata sandi?
                                </a>
                            </div>
                            <div class="relative">
                                <input type="{{ $login_show_password ? 'text' : 'password' }}" wire:model="login_password"
                                    class="w-full h-11 px-3.5 pr-11 seek-field {{ $errors->has('login_password') ? 'seek-field-error' : '' }}"
                                    autocomplete="current-password">
                                <button type="button" wire:click="toggleLoginPassword" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 p-1 bg-transparent border-none cursor-pointer">
                                    <i class="bx {{ $login_show_password ? 'bx-show' : 'bx-hide' }}" style="font-size: 20px;"></i>
                                </button>
                            </div>
                            @error('login_password')
                                <div style="color: #dc2626; font-size: 12px; font-weight: 600; margin-top: 6px; display: flex; align-items: center; gap: 4px;">
                                    <span style="font-size: 10px;">◇</span> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Tombol Masuk Pink (SEEK) -->
                        <div class="pt-2">
                            <button type="submit" class="w-full h-11 seek-btn-pink text-sm font-bold shadow-sm">
                                <span wire:loading.remove wire:target="companyLogin">Masuk</span>
                                <span wire:loading wire:target="companyLogin" class="flex items-center gap-2">
                                    <i class='bx bx-loader-alt bx-spin text-base'></i> Masuk...
                                </span>
                            </button>
                        </div>
                    </form>

                    <!-- Footer Link Daftar -->
                    <div class="mt-6 text-sm text-slate-700">
                        Tidak punya akun? 
                        <button type="button" wire:click="setMode('register')" class="text-sm font-bold seek-navy underline hover:text-[#e60067] transition-colors bg-transparent border-none p-0 cursor-pointer">
                            Daftar
                        </button>
                    </div>
                </div>
            </div>

        @else
            <!-- ========================================================= -->
            <!-- TAMPILAN BUAT AKUN PERUSAHAAN (Screenshot 2 & Screenshot 3) -->
            <!-- ========================================================= -->
            <div class="w-full flex justify-center">
                <div style="max-width: 620px; width: 100%;">
                    <h1 class="text-2xl sm:text-[28px] font-extrabold seek-navy tracking-tight" style="margin: 0 0 6px 0;">Buat akun perusahaan</h1>
                    <p class="text-slate-600 text-sm" style="margin: 0 0 32px 0;">Lengkapi informasi berikut untuk membuat akun Anda.</p>

                    <form wire:submit.prevent="register" class="space-y-8">
                        <!-- SECTION 1: DETAIL PERUSAHAAN (Screenshot 2) -->
                        <div>
                            <h2 class="text-lg font-bold seek-navy mb-5" style="margin: 0 0 20px 0;">Detail perusahaaan</h2>

                            <div class="space-y-5">
                                <!-- Nama Perusahaan -->
                                <div>
                                    <label class="block text-sm font-semibold seek-navy mb-1">Nama perusahaan</label>
                                    <p class="text-xs text-slate-500 mb-2" style="margin: 0 0 8px 0;">Nama bisnis yang terdaftar atau resmi digunakan untuk kami verifikasi.</p>
                                    <input type="text" wire:model="company_name"
                                        class="w-full h-11 px-3.5 seek-field {{ $errors->has('company_name') ? 'seek-field-error' : '' }}">
                                    @error('company_name')
                                        <div style="color: #dc2626; font-size: 12px; font-weight: 600; margin-top: 6px; display: flex; align-items: center; gap: 4px;">
                                            <span style="font-size: 10px;">◇</span> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Negara -->
                                <div>
                                    <label class="block text-sm font-semibold seek-navy mb-1">Negara</label>
                                    <p class="text-xs text-slate-500 mb-2" style="margin: 0 0 8px 0;">Lokasi di mana perusahaan Anda terdaftar.</p>
                                    <div class="relative">
                                        <select wire:model="country" class="w-full h-11 px-3.5 seek-field seek-select cursor-pointer">
                                            <option value="Indonesia">Indonesia</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kota Penempatan / Domisili Kantor -->
                                <div>
                                    <label class="block text-sm font-semibold seek-navy mb-1">Kota Penempatan / Usaha</label>
                                    <p class="text-xs text-slate-500 mb-2" style="margin: 0 0 8px 0;">Pilih kota domisili kantor tempat lowongan Anda dibuka.</p>
                                    <div class="relative">
                                        <select wire:model="city" class="w-full h-11 px-3.5 seek-field seek-select cursor-pointer">
                                            @foreach($cities as $c)
                                                <option value="{{ $c->name }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Nomor Telepon (SEEK Dual Field) -->
                                <div>
                                    <label class="block text-sm font-semibold seek-navy mb-1">Nomor telepon</label>
                                    <p class="text-xs text-slate-500 mb-2" style="margin: 0 0 8px 0;">Ini akan jadi nomor utama untuk menghubungi Anda. Tidak akan dibagikan ke kandidat.</p>
                                    
                                    <div class="flex gap-2.5">
                                        <!-- Dropdown Kode Negara -->
                                        <div style="width: 44%; max-width: 220px; flex-shrink: 0;" class="relative">
                                            <select wire:model="phone_code" class="w-full h-11 px-3 seek-field seek-select text-xs sm:text-sm cursor-pointer">
                                                <option value="+62">Indonesia ( +62 )</option>
                                            </select>
                                        </div>
                                        
                                        <!-- Input Nomor Telepon (Hanya Angka) -->
                                        <div class="flex-grow">
                                            <div class="flex items-center h-11 seek-field {{ $errors->has('phone_number') ? 'seek-field-error' : '' }} overflow-hidden">
                                                <span class="pl-3.5 pr-2.5 text-xs sm:text-sm text-slate-600 font-medium select-none" style="border-right: 1px solid #cbd5e1;">
                                                    +62
                                                </span>
                                                <input type="tel" wire:model.live="phone_number" inputmode="numeric" pattern="[0-9]*"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                    placeholder="812345678"
                                                    class="w-full h-full px-3 text-sm text-slate-800 outline-none bg-transparent border-none">
                                            </div>
                                        </div>
                                    </div>
                                    @error('phone_number')
                                        <div style="color: #dc2626; font-size: 12px; font-weight: 600; margin-top: 6px; display: flex; align-items: center; gap: 4px;">
                                            <span style="font-size: 10px;">◇</span> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 2: DETAIL PRIBADI (Screenshot 3) -->
                        <div style="padding-top: 24px; border-top: 1px solid #e2e8f0;">
                            <h2 class="text-lg font-bold seek-navy" style="margin: 0 0 4px 0;">Detail pribadi</h2>
                            <p class="text-xs text-slate-500" style="margin: 0 0 20px 0;">Masukkan informasi Anda sebagai pembuat akun ini.</p>

                            <div class="space-y-5">
                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-semibold seek-navy mb-1.5">Email</label>
                                    <input type="email" wire:model="email"
                                        class="w-full h-11 px-3.5 seek-field {{ $errors->has('email') ? 'seek-field-error' : '' }}"
                                        placeholder="nama@email.com">
                                    @error('email')
                                        <div style="color: #dc2626; font-size: 12px; font-weight: 600; margin-top: 6px; display: flex; align-items: center; gap: 4px;">
                                            <span style="font-size: 10px;">◇</span> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Nama Depan & Nama Belakang (2 Kolom Sejajar) -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold seek-navy mb-1.5">Nama depan</label>
                                        <input type="text" wire:model="first_name"
                                            class="w-full h-11 px-3.5 seek-field {{ $errors->has('first_name') ? 'seek-field-error' : '' }}"
                                            placeholder="Masukkan nama depan">
                                        @error('first_name')
                                            <div style="color: #dc2626; font-size: 12px; font-weight: 600; margin-top: 6px; display: flex; align-items: center; gap: 4px;">
                                                <span style="font-size: 10px;">◇</span> {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold seek-navy mb-1.5">Nama belakang</label>
                                        <input type="text" wire:model="last_name"
                                            class="w-full h-11 px-3.5 seek-field"
                                            placeholder="Masukkan nama belakang">
                                    </div>
                                </div>

                                <!-- Kata Sandi Akun -->
                                <div>
                                    <label class="block text-sm font-semibold seek-navy mb-1.5">Kata sandi</label>
                                    <div class="relative">
                                        <input type="{{ $showPassword ? 'text' : 'password' }}" wire:model="password"
                                            class="w-full h-11 px-3.5 pr-11 seek-field {{ $errors->has('password') ? 'seek-field-error' : '' }}"
                                            placeholder="Minimal 6 karakter">
                                        <button type="button" wire:click="togglePassword" 
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-800 p-1 bg-transparent border-none cursor-pointer">
                                            <i class="bx {{ $showPassword ? 'bx-show' : 'bx-hide' }}" style="font-size: 20px;"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div style="color: #dc2626; font-size: 12px; font-weight: 600; margin-top: 6px; display: flex; align-items: center; gap: 4px;">
                                            <span style="font-size: 10px;">◇</span> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Buat Akun Baru (Pink SEEK) -->
                        <div class="pt-2">
                            <button type="submit" class="seek-btn-pink text-sm font-bold shadow-sm" style="padding: 12px 32px; height: 46px;">
                                <span wire:loading.remove wire:target="register">Buat akun baru</span>
                                <span wire:loading wire:target="register" class="flex items-center gap-2">
                                    <i class='bx bx-loader-alt bx-spin text-base'></i> Menyimpan...
                                </span>
                            </button>
                            
                            <p class="mt-4 text-sm text-slate-600">
                                Sudah punya akun? 
                                <button type="button" wire:click="setMode('login')" class="text-sm font-bold seek-navy underline hover:text-[#e60067] transition-colors bg-transparent border-none p-0 cursor-pointer">
                                    Masuk
                                </button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </main>
</div>
