<div class="min-h-screen flex items-center justify-center px-4 py-12" style="background: #f0f4f9;">
    <div style="width: 100%; max-width: 420px;">
        {{-- Logo --}}
        <div style="text-align: center; margin-bottom: 24px;">
            <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 10px; text-decoration: none;">
                <div style="width: 44px; height: 44px; border-radius: 16px; display: flex; align-items: center; justify-content: center; background: #2563eb; box-shadow: 0 8px 20px rgba(37,99,235,0.3);">
                    <svg style="width: 22px; height: 22px; color: white;" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                </div>
                <span style="font-size: 24px; font-weight: 900; color: #0f172a; letter-spacing: -0.02em;">NEAR JOB</span>
            </a>
        </div>

        {{-- Distinctive NearJob Card --}}
        <div style="background: #ffffff; border-radius: 28px; padding: 32px 28px; box-shadow: 0 20px 50px rgba(15,23,42,0.1); border: 1px solid #e2e8f0; position: relative; overflow: hidden;">
            <div style="height: 5px; width: 100%; background: linear-gradient(90deg, #2563eb, #3b82f6, #10b981); position: absolute; top: 0; left: 0;"></div>

            <div style="text-align: center; margin-bottom: 24px;">
                <h1 style="font-size: 22px; font-weight: 900; color: #0f172a; line-height: 1.3; margin: 0 0 6px;">
                    Masuk ke Akun Anda
                </h1>
                <p style="font-size: 12px; color: #64748b; font-weight: 600; margin: 0;">
                    Pilih metode masuk untuk mengelola lowongan & lamaran
                </p>
            </div>

            {{-- 1. Tombol Google --}}
            <div style="margin-bottom: 18px;">
                <a href="{{ route('auth.google') }}"
                   style="width: 100%; height: 48px; background: #ffffff; color: #1e293b; font-weight: 800; border-radius: 14px; font-size: 13.5px; display: flex; align-items: center; justify-content: center; gap: 10px; border: 2px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.04); text-decoration: none; cursor: pointer; transition: all .2s;">
                    <svg style="width: 20px; height: 20px;" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                    <span>Lanjutkan dengan Google</span>
                </a>
            </div>

            {{-- Divider --}}
            <div style="display: flex; align-items: center; margin-bottom: 18px;">
                <div style="flex-grow: 1; height: 1px; background: #e2e8f0;"></div>
                <span style="padding: 0 12px; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">atau Email</span>
                <div style="flex-grow: 1; height: 1px; background: #e2e8f0;"></div>
            </div>

            {{-- Form Email & Password --}}
            <form wire:submit="login" style="display: flex; flex-direction: column; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Email</label>
                    <input type="email" wire:model="email" id="login-email"
                        style="width: 100%; padding: 12px 14px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 13.5px; font-weight: bold; color: #0f172a; outline: none; box-sizing: border-box;"
                        placeholder="nama@email.com" autocomplete="email">
                    @error('email') <p style="font-size: 11px; color: #ef4444; font-weight: bold; margin: 4px 0 0;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">Kata Sandi</label>
                    <input type="password" wire:model="password" id="login-password"
                        style="width: 100%; padding: 12px 14px; background: #f8fafc; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 13.5px; font-weight: bold; color: #0f172a; outline: none; box-sizing: border-box;"
                        placeholder="••••••••" autocomplete="current-password">
                    @error('password') <p style="font-size: 11px; color: #ef4444; font-weight: bold; margin: 4px 0 0;">{{ $message }}</p> @enderror
                </div>
                <button type="submit"
                    style="width: 100%; padding: 13px; background: #2563eb; color: white; font-weight: 800; border-radius: 12px; font-size: 13.5px; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(37,99,235,0.3); display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class='bx bx-log-in' style="font-size: 18px;"></i> Masuk
                </button>
            </form>

            {{-- Links --}}
            <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid #f1f5f9; text-align: center; display: flex; flex-direction: column; gap: 8px;">
                <div style="font-size: 13px; color: #64748b; font-weight: 600;">
                    Belum punya akun? 
                    <a href="{{ route('register.applicant') }}" style="font-weight: 900; color: #2563eb; text-decoration: underline;">
                        Daftar
                    </a>
                    ·
                    <a href="{{ route('register.company') }}" style="font-weight: 800; color: #e60067; text-decoration: underline;">
                        Untuk Perusahaan
                    </a>
                </div>
                <div>
                    <a href="{{ route('home') }}" style="font-size: 12.5px; color: #64748b; font-weight: 700; text-decoration: underline;">
                        ← Kembali ke Peta Lowongan
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
