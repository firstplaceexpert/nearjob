<div x-data="{ open: @entangle('isOpen') }" 
     x-cloak 
     x-show="open" 
     @keydown.escape.window="$wire.closeModal()"
     style="position: fixed; top: 56px; bottom: 0; left: 0; right: 0; z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 16px; box-sizing: border-box;">

    {{-- Backdrop blur covering everything below the header (Header remains 100% crystal clear) --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="$wire.closeModal()"
         style="position: absolute; inset: 0; background: rgba(15, 23, 42, 0.55); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);"></div>

    {{-- Modal Card: Exact Layout from Screenshot --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-3"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-3"
         style="position: relative; margin: auto; background: #ffffff; border-radius: 24px; box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(0, 0, 0, 0.05); max-width: 440px; width: calc(100% - 32px); overflow: hidden; z-index: 10; max-height: calc(100vh - 90px); display: flex; flex-direction: column;">

        {{-- Close Button --}}
        <button type="button" 
                wire:click="closeModal" 
                title="Tutup"
                style="position: absolute; top: 16px; right: 16px; z-index: 20; width: 32px; height: 32px; border-radius: 50%; background: #f1f5f9; border: none; color: #000000; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 20px; font-weight: bold; transition: all .2s;">
            <i class='bx bx-x'></i>
        </button>

        {{-- Error Banner --}}
        @if($errorMessage)
        <div style="margin: 16px 24px 0; padding: 10px 14px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; display: flex; align-items: center; gap: 8px; color: #dc2626; font-size: 12px; font-weight: bold; flex-shrink: 0;">
            <i class='bx bx-error-circle' style="font-size: 18px; flex-shrink: 0;"></i>
            <span>{{ $errorMessage }}</span>
        </div>
        @endif

        {{-- Modal Body (Scrollable) --}}
        <div style="padding: 44px 32px 36px; overflow-y: auto; flex: 1;">

            {{-- ======================================================== --}}
            {{-- STEP 0: EXACT SCREENSHOT CARD CONTENT --}}
            {{-- ======================================================== --}}
            @if($step === 'welcome')
            <div style="text-align: center;">
                
                {{-- Heading Title --}}
                <h2 style="font-size: 25px; font-weight: 800; color: #000000; line-height: 1.3; margin: 0 auto 32px; max-width: 320px; letter-spacing: -0.02em; font-family: inherit;">
                    Masuk untuk temukan<br>lowongan yang cocok
                </h2>

                {{-- Action Buttons --}}
                <div style="display: flex; flex-direction: column; gap: 14px; max-width: 340px; margin: 0 auto 26px;">
                    
                    {{-- 1. Tombol Lanjutkan dengan Google --}}
                    <a href="{{ route('auth.google') }}"
                       style="position: relative; width: 100%; height: 52px; background: #1a73e8; color: white; border-radius: 10px; font-size: 14.5px; font-weight: 700; display: flex; align-items: center; justify-content: center; text-decoration: none; border: none; cursor: pointer; transition: background .2s, box-shadow .2s; box-shadow: 0 2px 6px rgba(26, 115, 232, 0.25);">
                        
                        {{-- White square box with Google Icon on the left --}}
                        <div style="position: absolute; left: 2px; top: 2px; bottom: 2px; width: 48px; background: #ffffff; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <svg style="width: 22px; height: 22px;" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                            </svg>
                        </div>
                        <span style="padding-left: 36px;">Lanjutkan dengan Google</span>
                    </a>

                    {{-- 2. Tombol Lanjutkan dengan Email --}}
                    <button type="button" 
                            wire:click="startEmailFlow"
                            style="width: 100%; height: 52px; background: #ffffff; color: #000000; font-weight: 700; border-radius: 10px; font-size: 14.5px; border: 2px solid #000000; display: flex; align-items: center; justify-content: center; gap: 10px; cursor: pointer; transition: background .2s;">
                        <i class='bx bx-envelope' style="font-size: 21px; color: #000000;"></i>
                        <span>Lanjutkan dengan Email</span>
                    </button>
                </div>

                {{-- Links --}}
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    <div style="font-size: 14.5px; color: #000000; font-weight: 600;">
                        Belum punya akun? 
                        <button type="button" wire:click="startEmailFlow" style="background: none; border: none; font-weight: 800; color: #000000; text-decoration: underline; cursor: pointer; font-size: 14.5px; padding: 0;">
                            Daftar
                        </button>
                    </div>

                    <div x-data="{ showReason: false }">
                        <button type="button" 
                                @click="showReason = !showReason"
                                style="background: none; border: none; font-size: 14.5px; color: #000000; font-weight: 800; text-decoration: underline; cursor: pointer; padding: 0;">
                            Mengapa harus masuk?
                        </button>
                        
                        <div x-show="showReason" 
                             x-collapse
                             x-cloak
                             style="margin-top: 12px; padding: 12px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; text-align: left; font-size: 12px; color: #000000; line-height: 1.5;">
                            <div style="font-weight: 800; color: #000000; margin-bottom: 4px; display: flex; align-items: center; gap: 4px;">
                                <i class='bx bxs-badge-check' style="color: #5680d8; font-size: 16px;"></i> Manfaat Masuk Akun:
                            </div>
                            • Rekomendasi loker terdekat sesuai keahlian & lokasi Anda.<br>
                            • Simpan lowongan impian dan pantau status lamaran kerja.<br>
                            • Kirim CV langsung ke HRD dalam 1 klik dengan kuota gratis.
                        </div>
                    </div>
                </div>

            </div>
            @endif

            {{-- ======================================================== --}}
            {{-- STEP 1: INPUT EMAIL (GMAIL CHECK) --}}
            {{-- ======================================================== --}}
            @if($step === 'email')
            <div>
                <div style="text-align: center; margin-bottom: 18px;">
                    <div style="width: 46px; height: 46px; border-radius: 14px; background: #eff6ff; color: #5680d8; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; font-size: 22px; border: 1px solid #bfdbfe;">
                        <i class='bx bx-envelope'></i>
                    </div>
                    <h2 style="font-size: 17px; font-weight: 900; color: #000000; margin: 0;">Masukkan Alamat Email Anda</h2>
                    <p style="font-size: 12px; color: #000000; font-weight: 600; margin: 3px 0 0;">
                        Email belum terdaftar akan otomatis diarahkan untuk melengkapi profil.
                    </p>
                </div>

                <form wire:submit.prevent="checkEmail" style="display: flex; flex-direction: column; gap: 14px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 5px;">
                            Gmail / Email
                        </label>
                        <input type="email" 
                               wire:model="email" 
                               placeholder="nama.anda@gmail.com" 
                               required
                               autofocus
                               style="width: 100%; padding: 12px 14px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 13.5px; font-weight: bold; color: #000000; outline: none; box-sizing: border-box;">
                    </div>

                    <button type="submit" 
                            wire:loading.attr="disabled"
                            style="width: 100%; padding: 13px; background: #5680d8; color: white; font-weight: 800; border-radius: 12px; font-size: 13.5px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);">
                        <span wire:loading.remove wire:target="checkEmail">Periksa & Lanjutkan →</span>
                        <span wire:loading wire:target="checkEmail">Memeriksa...</span>
                    </button>

                    <div style="text-align: center; padding-top: 2px;">
                        <button type="button" 
                                wire:click="goBackToWelcome" 
                                style="background: none; border: none; font-size: 12px; font-weight: 700; color: #000000; cursor: pointer;">
                            ← Kembali ke Pilihan Masuk
                        </button>
                    </div>
                </form>
            </div>
            @endif

            {{-- ======================================================== --}}
            {{-- STEP LOGIN (IF EMAIL EXISTS) --}}
            {{-- ======================================================== --}}
            @if($step === 'login')
            <div>
                <div style="text-align: center; margin-bottom: 18px;">
                    <div style="width: 46px; height: 46px; border-radius: 14px; background: #eff6ff; color: #5680d8; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; font-size: 22px; border: 1px solid #bfdbfe;">
                        <i class='bx bx-user-check'></i>
                    </div>
                    <h2 style="font-size: 17px; font-weight: 900; color: #000000; margin: 0;">Selamat Datang Kembali!</h2>
                    <p style="font-size: 12px; color: #000000; font-weight: 600; margin: 3px 0 0;">
                        Akun: <span style="color: #5680d8; font-weight: 800;">{{ $email }}</span>
                    </p>
                </div>

                <form wire:submit.prevent="login" style="display: flex; flex-direction: column; gap: 14px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 5px;">
                            Kata Sandi
                        </label>
                        <input type="password" 
                               wire:model="password" 
                               placeholder="Masukkan password Anda" 
                               required
                               autofocus
                               style="width: 100%; padding: 12px 14px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 13.5px; font-weight: bold; color: #000000; outline: none; box-sizing: border-box;">
                    </div>

                    <button type="submit" 
                            wire:loading.attr="disabled"
                            style="width: 100%; padding: 13px; background: #5680d8; color: white; font-weight: 800; border-radius: 12px; font-size: 13.5px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);">
                        <span wire:loading.remove wire:target="login">Masuk & Buka Lowongan →</span>
                        <span wire:loading wire:target="login">Memproses...</span>
                    </button>

                    <div style="text-align: center; padding-top: 4px;">
                        <button type="button" 
                                wire:click="goBackToWelcome" 
                                style="background: none; border: none; font-size: 12px; font-weight: 700; color: #000000; cursor: pointer;">
                            ← Kembali ke Pilihan Masuk
                        </button>
                    </div>
                </form>
            </div>
            @endif

            {{-- ======================================================== --}}
            {{-- STEP QUIZ 1: BIDANG YANG DIMINATI --}}
            {{-- ======================================================== --}}
            @if($step === 'quiz_interest')
            <div>
                <div style="margin-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; font-size: 10.5px; font-weight: 800; color: #94a3b8; margin-bottom: 4px;">
                        <span style="color: #5680d8;">Langkah 1 dari 3: Minat Pekerjaan</span>
                        <span>33%</span>
                    </div>
                    <div style="width: 100%; height: 5px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                        <div style="width: 33%; height: 100%; background: #5680d8; border-radius: 10px; transition: all .3s;"></div>
                    </div>
                </div>

                <div style="margin-bottom: 12px;">
                    <h2 style="font-size: 15px; font-weight: 900; color: #000000; margin: 0 0 3px;">
                        Apa bidang pekerjaan yang Anda cari?
                    </h2>
                    <p style="font-size: 11px; color: #000000; font-weight: 600; margin: 0;">
                        Pilih satu atau lebih bidang yang Anda minati.
                    </p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-bottom: 16px;">
                    @foreach($categories as $key => $label)
                    @php $selected = in_array($key, $selectedCategories); @endphp
                    <button type="button" 
                            wire:click="toggleCategory('{{ $key }}')" 
                            style="padding: 9px 10px; border-radius: 12px; border: 2px solid {{ $selected ? '#2563eb' : '#e2e8f0' }}; background: {{ $selected ? '#eff6ff' : '#f8fafc' }}; color: {{ $selected ? '#1e40af' : '#334155' }}; text-align: left; cursor: pointer; display: flex; align-items: center; justify-content: space-between; transition: all .15s;">
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <i class='bx {{ $selected ? "bxs-check-circle" : "bx-circle" }}' style="font-size: 14px; color: {{ $selected ? '#2563eb' : '#94a3b8' }};"></i>
                            <span style="font-size: 10.5px; font-weight: 800; line-height: 1.3;">{{ $label }}</span>
                        </div>
                    </button>
                    @endforeach
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 10px;">
                    <button type="button" 
                            wire:click="goBackFromQuizInterest" 
                            style="background: none; border: none; font-size: 11.5px; font-weight: 700; color: #000000; cursor: pointer;">
                        ← Kembali
                    </button>
                    <button type="button" 
                            wire:click="goToLocationStep" 
                            style="padding: 10px 16px; background: #5680d8; color: white; font-weight: 800; border-radius: 10px; font-size: 11.5px; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                        Lanjut ke Domisili →
                    </button>
                </div>
            </div>
            @endif

            {{-- ======================================================== --}}
            {{-- STEP QUIZ 2: DOMISILI / LOKASI --}}
            {{-- ======================================================== --}}
            @if($step === 'quiz_location')
            <div>
                <div style="margin-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; font-size: 10.5px; font-weight: 800; color: #94a3b8; margin-bottom: 4px;">
                        <span style="color: #5680d8;">Langkah 2 dari 3: Lokasi / Domisili</span>
                        <span>66%</span>
                    </div>
                    <div style="width: 100%; height: 5px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                        <div style="width: 66%; height: 100%; background: #5680d8; border-radius: 10px; transition: all .3s;"></div>
                    </div>
                </div>

                <div style="margin-bottom: 12px;">
                    <h2 style="font-size: 15px; font-weight: 900; color: #000000; margin: 0 0 3px;">
                        Di mana domisili atau lokasi Anda saat ini?
                    </h2>
                    <p style="font-size: 11px; color: #000000; font-weight: 600; margin: 0;">
                        Peta akan otomatis memprioritaskan lowongan kerja terdekat.
                    </p>
                </div>

                <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 16px;">
                    <div>
                        <label style="display: block; font-size: 10.5px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">
                            Pilih Kota
                        </label>
                        <select wire:model="city" 
                                style="width: 100%; padding: 10px 12px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 10px; font-size: 12px; font-weight: bold; color: #000000; outline: none;">
                            @foreach($cities as $c)
                            <option value="{{ $c->name }}">{{ $c->name }} ({{ $c->province }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <div style="font-size: 9.5px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">
                            Pilihan Cepat:
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                            @foreach(['Yogyakarta', 'Sleman', 'Bantul', 'Jakarta Pusat', 'Surabaya', 'Bandung', 'Semarang'] as $quickCity)
                            <button type="button" 
                                    wire:click="$set('city', '{{ $quickCity }}')"
                                    style="font-size: 10.5px; font-weight: 800; padding: 4px 8px; border-radius: 8px; border: 1px solid {{ $city === $quickCity ? '#2563eb' : '#e2e8f0' }}; background: {{ $city === $quickCity ? '#2563eb' : '#f1f5f9' }}; color: {{ $city === $quickCity ? 'white' : '#475569' }}; cursor: pointer; display: flex; align-items: center; gap: 3px;">
                                <i class='bx bxs-map' style="font-size: 11px; color: #5680d8;"></i> {{ $quickCity }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 10px;">
                    <button type="button" 
                            wire:click="$set('step', 'quiz_interest')" 
                            style="background: none; border: none; font-size: 11.5px; font-weight: 700; color: #000000; cursor: pointer;">
                        ← Kembali
                    </button>
                    <button type="button" 
                            wire:click="goToProfileStep" 
                            style="padding: 10px 16px; background: #5680d8; color: white; font-weight: 800; border-radius: 10px; font-size: 11.5px; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);">
                        Lanjut ke Profil & Akun →
                    </button>
                </div>
            </div>
            @endif

            {{-- ======================================================== --}}
            {{-- STEP QUIZ 3: PENDIDIKAN & DATA AKUN --}}
            {{-- ======================================================== --}}
            @if($step === 'quiz_profile')
            <div>
                <div style="margin-bottom: 12px;">
                    <div style="display: flex; justify-content: space-between; font-size: 10.5px; font-weight: 800; color: #94a3b8; margin-bottom: 4px;">
                        <span style="color: #10b981;">Langkah 3 dari 3: Data Akun</span>
                        <span>100%</span>
                    </div>
                    <div style="width: 100%; height: 5px; background: #f1f5f9; border-radius: 10px; overflow: hidden;">
                        <div style="width: 100%; height: 100%; background: #10b981; border-radius: 10px; transition: all .3s;"></div>
                    </div>
                </div>

                <div style="margin-bottom: 10px;">
                    <h2 style="font-size: 14px; font-weight: 900; color: #000000; margin: 0 0 2px;">
                        Satu langkah lagi! Lengkapi profil
                    </h2>
                    <p style="font-size: 10.5px; color: #000000; font-weight: 600; margin: 0;">
                        Akun otomatis dibuat dan Anda mendapatkan <b>3 Kuota Lamaran Gratis</b>.
                    </p>
                </div>

                <form wire:submit.prevent="completeRegistration" style="display: flex; flex-direction: column; gap: 9px; margin-bottom: 12px;">
                    <div>
                        <label style="display: block; font-size: 10px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 3px;">
                            Nama Lengkap
                        </label>
                        <input type="text" 
                               wire:model="name" 
                               placeholder="Nama sesuai KTP" 
                               required
                               style="width: 100%; padding: 8px 10px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 9px; font-size: 12px; font-weight: bold; color: #000000; outline: none; box-sizing: border-box;">
                    </div>

                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3px;">
                            <label style="font-size: 10px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.05em;">
                                NIK (Nomor Induk Kependudukan)
                            </label>
                            <span style="font-size: 9px; font-weight: 800; color: #5680d8; background: #eff6ff; padding: 1px 6px; border-radius: 4px;">
                                1 NIK = 1 Akun
                            </span>
                        </div>
                        <input type="text" 
                               wire:model="nik" 
                               maxlength="16"
                               inputmode="numeric"
                               pattern="[0-9]*"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               placeholder="16 digit nomor KTP (Contoh: 347101...)" 
                               required
                               style="width: 100%; padding: 8px 10px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 9px; font-size: 12px; font-weight: bold; color: #000000; outline: none; box-sizing: border-box;">
                        <p style="font-size: 9.5px; color: #000000; margin: 2px 0 0; font-weight: 600;">
                            Satu NIK hanya dapat digunakan untuk satu akun pencari kerja.
                        </p>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px;">
                        <div>
                            <label style="display: block; font-size: 10px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 3px;">
                                Pend. Terakhir
                            </label>
                            <select wire:model="education_level" 
                                    style="width: 100%; padding: 8px 8px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 9px; font-size: 11px; font-weight: bold; color: #000000; outline: none;">
                                @foreach($educationLevels as $lvlKey => $lvlLabel)
                                <option value="{{ $lvlKey }}">{{ $lvlLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 10px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 3px;">
                                Pengalaman
                            </label>
                            <select wire:model="work_experience" 
                                    style="width: 100%; padding: 8px 8px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 9px; font-size: 11px; font-weight: bold; color: #000000; outline: none;">
                                <option value="fresh_graduate">Fresh Graduate</option>
                                <option value="1_tahun">1 Tahun</option>
                                <option value="2_tahun">2 Tahun</option>
                                <option value="3_tahun_lebih">3+ Tahun</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-size: 10px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 3px;">
                            Nomor WhatsApp
                        </label>
                        <input type="tel" 
                               wire:model="whatsapp" 
                               inputmode="numeric"
                               pattern="[0-9]*"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               placeholder="081234567890" 
                               style="width: 100%; padding: 8px 10px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 9px; font-size: 12px; font-weight: bold; color: #000000; outline: none; box-sizing: border-box;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 10px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 3px;">
                            Buat Kata Sandi Akun
                        </label>
                        <input type="password" 
                               wire:model="password" 
                               placeholder="Minimal 6 karakter" 
                               required
                               style="width: 100%; padding: 8px 10px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 9px; font-size: 12px; font-weight: bold; color: #000000; outline: none; box-sizing: border-box;">
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 10px;">
                        <button type="button" 
                                wire:click="$set('step', 'quiz_location')" 
                                style="background: none; border: none; font-size: 11.5px; font-weight: 700; color: #000000; cursor: pointer;">
                            ← Kembali
                        </button>
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                style="padding: 10px 16px; background: #059669; color: white; font-weight: 800; border-radius: 10px; font-size: 11.5px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(5, 150, 105, 0.3); display: flex; align-items: center; gap: 5px;">
                            <i class='bx bxs-check-shield' style="font-size: 15px;"></i>
                            <span wire:loading.remove wire:target="completeRegistration">Selesaikan & Buka Lowongan</span>
                            <span wire:loading wire:target="completeRegistration">Membuat...</span>
                        </button>
                    </div>
                </form>
            </div>
            @endif

        </div>

    </div>
</div>
