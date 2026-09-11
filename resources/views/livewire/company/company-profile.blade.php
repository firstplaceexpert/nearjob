<div class="min-h-screen pb-36 pt-16" style="background: #f0f4f9;">
    <div class="max-w-md mx-auto px-4 pt-5">
        <h1 class="text-2xl font-extrabold text-black mb-1">Profil Usaha</h1>
        <p class="text-black text-sm mb-5">Kelola informasi perusahaan dan data kontak Anda.</p>

        <div class="bg-white rounded-2xl overflow-hidden" style="border: 1px solid #e8edf5; box-shadow: 0 2px 12px rgba(0,0,0,.04);">
            <form wire:submit="save" class="space-y-4 p-5">
                <h3 class="text-xs font-extrabold uppercase tracking-widest pb-2" style="color: #000000; border-bottom: 1px solid rgba(0,0,0,0.15);">Data Pemilik</h3>
                
                <div>
                    <label class="block text-xs font-bold text-black mb-1">Nama Pemilik Usaha</label>
                    <input type="text" wire:model="owner_name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="block text-xs font-bold text-black">NIK Pemilik Usaha</label>
                        <span class="text-[10px] font-bold text-black border border-black/30 px-2 py-0.5 rounded bg-white">
                            Terproteksi Masking
                        </span>
                    </div>
                    <input type="text" value="{{ $masked_nik }}" disabled class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm bg-slate-100 text-black font-mono cursor-not-allowed">
                    <p class="text-[11px] text-black mt-1">NIK lengkap tersimpan aman dan tidak dipublikasikan.</p>
                </div>

                <!-- Verifikasi KTP Section (Wrap Garis Hitam & Tulisan Hitam) -->
                <div class="p-3.5 bg-white rounded-xl border border-black/20 space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-black">Status Verifikasi KTP</span>
                        @if($company->is_verified || $company->ktp_path)
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 border border-black text-black rounded bg-white">
                                <i class='bx bxs-badge-check text-sm text-black'></i> Terverifikasi (Watermark NEAR JOB)
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 border border-black/40 text-black rounded bg-white">
                                <i class='bx bx-time-five text-sm text-black'></i> Belum Verifikasi
                            </span>
                        @endif
                    </div>

                    @if($company->ktp_path)
                        <div>
                            <p class="text-[11px] text-black mb-1 font-medium">Foto KTP Resmi (Dengan Watermark Keamanan):</p>
                            <img src="{{ $company->ktp_url }}" alt="KTP Pemilik Usaha" class="w-full max-w-[260px] h-32 object-cover rounded-lg border border-black/20 shadow-sm">
                        </div>
                    @endif

                    <div class="pt-1">
                        <label class="block text-[11px] font-bold text-black mb-1">
                            {{ $company->ktp_path ? 'Perbarui Foto KTP Pemilik Usaha:' : 'Unggah Foto KTP Pemilik Usaha:' }}
                        </label>
                        <input type="file" wire:model="ktp_file" accept="image/*" class="block w-full text-xs text-black file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:text-white cursor-pointer" style="--tw-file-bg: #5680d8;">
                        <p class="text-[10px] text-black mt-1">Foto otomatis diberi watermark pengaman "NEAR JOB" sebelum disimpan.</p>
                        
                        <div wire:loading wire:target="ktp_file" class="text-xs text-black font-medium mt-1">
                            <i class='bx bx-loader-alt bx-spin text-black'></i> Memproses watermark & menyimpan KTP...
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-black mb-1">Nomor WhatsApp</label>
                    <input type="tel" wire:model="whatsapp" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white" placeholder="08xxxxxxxxxx">
                </div>

                <h3 class="text-xs font-extrabold uppercase tracking-widest pb-2 mt-6" style="color: #000000; border-bottom: 1px solid rgba(0,0,0,0.15);">Data Usaha</h3>

                <div>
                    <label class="block text-xs font-bold text-black mb-1">Nama Usaha</label>
                    <input type="text" wire:model="company_name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-black mb-1">Bidang Usaha</label>
                    <select wire:model="business_field" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                        @foreach($categories as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-black mb-1">NIB (opsional)</label>
                    <input type="text" wire:model="nib" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white" placeholder="Nomor Induk Berusaha (hanya angka)">
                </div>

                <div>
                    <label class="block text-xs font-bold text-black mb-1">Kota Lokasi Usaha</label>
                    <select wire:model="city" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                        @foreach($cities as $c)
                            <option value="{{ $c->name }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-black mb-1">Alamat Lengkap</label>
                    <input type="text" wire:model="address" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-black mb-1">Preferensi Kontak Utama</label>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" wire:click="$set('contact_method', 'whatsapp')"
                            class="py-3 rounded-xl border-2 text-sm font-bold transition-all {{ $contact_method === 'whatsapp' ? 'border-black bg-black text-white' : 'border-black/30 text-black bg-white hover:bg-black/5' }}">
                            <i class='bx bxl-whatsapp'></i> WhatsApp
                        </button>
                        <button type="button" wire:click="$set('contact_method', 'email')"
                            class="py-3 rounded-xl border-2 text-sm font-bold transition-all {{ $contact_method === 'email' ? 'border-black bg-black text-white' : 'border-black/30 text-black bg-white hover:bg-black/5' }}">
                            <i class='bx bx-envelope'></i> Email
                        </button>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3.5 text-white font-bold rounded-xl text-sm transition-all" style="background: #5680d8; box-shadow: 0 4px 15px rgba(86,128,216,.3);">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
