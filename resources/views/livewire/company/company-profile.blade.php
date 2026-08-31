<div class="p-4 bg-slate-50 min-h-full pb-8">
    <div class="max-w-md mx-auto">
        <h1 class="text-2xl font-extrabold text-slate-800 mb-2">Profil Usaha</h1>
        <p class="text-slate-500 text-sm mb-6">Kelola informasi perusahaan dan data kontak Anda.</p>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <form wire:submit="save" class="space-y-4">
                
                <h3 class="text-sm font-extrabold text-blue-600 uppercase tracking-widest border-b border-slate-100 pb-2">Data Pemilik</h3>
                
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Pemilik Usaha</label>
                    <input type="text" wire:model="owner_name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp</label>
                    <input type="tel" wire:model="whatsapp" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                </div>

                <h3 class="text-sm font-extrabold text-blue-600 uppercase tracking-widest border-b border-slate-100 pb-2 mt-6">Data Usaha</h3>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Usaha</label>
                    <input type="text" wire:model="company_name" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Bidang Usaha</label>
                    <select wire:model="business_field" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                        @foreach($categories as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">NIB (opsional)</label>
                    <input type="text" wire:model="nib" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kota Lokasi Usaha</label>
                    <select wire:model="city" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                        @foreach($cities as $c)
                            <option value="{{ $c->name }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap</label>
                    <input type="text" wire:model="address" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 text-sm bg-slate-50 focus:bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Preferensi Kontak Utama</label>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" wire:click="$set('contact_method', 'whatsapp')"
                            class="py-3 rounded-xl border-2 text-sm font-bold transition-all {{ $contact_method === 'whatsapp' ? 'border-green-500 bg-green-50 text-green-700' : 'border-slate-200 text-slate-500 hover:bg-slate-50' }}">
                            <i class='bx bxl-whatsapp'></i> WhatsApp
                        </button>
                        <button type="button" wire:click="$set('contact_method', 'email')"
                            class="py-3 rounded-xl border-2 text-sm font-bold transition-all {{ $contact_method === 'email' ? 'border-blue-500 bg-blue-50 text-blue-700' : 'border-slate-200 text-slate-500 hover:bg-slate-50' }}">
                            <i class='bx bx-envelope'></i> Email
                        </button>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm shadow-lg shadow-blue-600/20 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
