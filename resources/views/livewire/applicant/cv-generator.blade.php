<div class="p-4 bg-slate-50 min-h-full pb-8">
    <div class="max-w-xl mx-auto">
        <h1 class="text-2xl font-extrabold text-slate-800 mb-2">Generator CV ATS</h1>
        <p class="text-slate-500 text-sm mb-6">Buat CV profesional yang ramah ATS (Applicant Tracking System) secara otomatis dari profil Anda.</p>

        @if(!$isPaid)
            {{-- Mock Payment Flow --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 text-center">
                <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-4">
                    <i class='bx bx-file'></i>
                </div>
                <h2 class="text-xl font-extrabold text-slate-800 mb-2">Buka Fitur CV ATS</h2>
                <p class="text-slate-500 text-sm mb-6 max-w-[280px] mx-auto">Hanya bayar sekali untuk dapat membuat dan mengunduh CV tanpa batas kapan saja.</p>

                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 mb-6 text-left max-w-sm mx-auto">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-bold text-slate-700">Akses Generator CV</span>
                        <span class="text-sm font-extrabold text-slate-800">Rp14.999</span>
                    </div>
                    <div class="flex justify-between items-center text-xs text-slate-500 pb-2 border-b border-slate-200">
                        <span>Biaya Layanan</span>
                        <span>Rp1.000</span>
                    </div>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-sm font-extrabold text-slate-700">Total</span>
                        <span class="text-lg font-black text-blue-600">Rp15.999</span>
                    </div>
                </div>

                <div class="max-w-sm mx-auto space-y-3">
                    <button wire:click="processPayment" wire:loading.attr="disabled" class="w-full py-3.5 bg-[#00AA13] hover:bg-[#008f10] text-white font-bold rounded-xl text-sm transition-colors flex items-center justify-center gap-2">
                        <span wire:loading.remove>Bayar dengan GoPay</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                    <button wire:click="processPayment" wire:loading.attr="disabled" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition-colors flex items-center justify-center gap-2">
                        <span wire:loading.remove>Bayar dengan QRIS / Bank Transfer</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
                <p class="text-[10px] text-slate-400 mt-4">*Ini adalah demo pembayaran. Tidak ada uang yang ditagih.</p>
            </div>
        @else
            {{-- CV Result --}}
            <div class="flex items-center justify-between mb-4">
                <span class="bg-emerald-100 text-emerald-700 font-bold text-xs px-3 py-1.5 rounded-full border border-emerald-200 flex items-center gap-1">
                    <i class='bx bx-check-circle'></i> Akses Aktif
                </span>
                <button onclick="window.print()" class="bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs px-4 py-2 rounded-lg transition-colors flex items-center gap-2 shadow-lg">
                    <i class='bx bx-printer'></i> Cetak / Simpan PDF
                </button>
            </div>

            {{-- The CV Template --}}
            <div id="cv-document" class="bg-white p-8 sm:p-12 shadow-md border border-slate-200 text-slate-800" style="font-family: 'Times New Roman', Times, serif; max-width: 21cm; margin: 0 auto; min-height: 29.7cm;">
                
                {{-- Header --}}
                <div class="text-center mb-6 border-b-2 border-slate-800 pb-4">
                    <h1 class="text-3xl font-bold uppercase tracking-wide mb-2">{{ $user->name }}</h1>
                    <p class="text-sm">
                        {{ $profile->city }} | {{ preg_replace('/(\d{4})(\d{4})(\d{4})/', '$1-$2-$3', $profile->whatsapp) }} | {{ $user->email }}
                    </p>
                </div>

                {{-- Summary --}}
                <div class="mb-6">
                    <h2 class="text-lg font-bold uppercase border-b border-slate-300 mb-2">Profil</h2>
                    <p class="text-sm leading-relaxed text-justify">
                        Seorang tenaga profesional yang berdomisili di {{ $profile->city }}. Lulusan {{ strtoupper($profile->education_level) }} dari {{ $profile->education_institution }} {{ $profile->field_of_study ? 'jurusan ' . $profile->field_of_study : '' }}. Memiliki kemampuan bekerja dalam tim, disiplin, dan bertanggung jawab terhadap target pekerjaan.
                    </p>
                </div>

                {{-- Experience --}}
                <div class="mb-6">
                    <h2 class="text-lg font-bold uppercase border-b border-slate-300 mb-2">Pengalaman Kerja</h2>
                    @if($profile->work_experience)
                        <div class="text-sm leading-relaxed whitespace-pre-line pl-4 border-l-2 border-slate-200">
                            {{ $profile->work_experience }}
                        </div>
                    @else
                        <p class="text-sm italic text-slate-500">Belum ada pengalaman kerja yang ditambahkan.</p>
                    @endif
                </div>

                {{-- Education --}}
                <div class="mb-6">
                    <h2 class="text-lg font-bold uppercase border-b border-slate-300 mb-2">Pendidikan</h2>
                    <div class="mb-2">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-sm">{{ $profile->education_institution }}</h3>
                        </div>
                        <p class="text-sm italic">{{ \App\Models\ApplicantProfile::educationLevels()[$profile->education_level] ?? strtoupper($profile->education_level) }} {{ $profile->field_of_study ? '- ' . $profile->field_of_study : '' }}</p>
                    </div>
                </div>

                {{-- Skills --}}
                <div class="mb-6">
                    <h2 class="text-lg font-bold uppercase border-b border-slate-300 mb-2">Keahlian (Skills)</h2>
                    @if(count($profile->skills ?? []) > 0)
                        <ul class="list-disc list-inside text-sm leading-relaxed columns-2">
                            @foreach($profile->skills as $skill)
                                <li>{{ $skill }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm italic text-slate-500">Belum ada keahlian yang ditambahkan.</p>
                    @endif
                </div>

                {{-- Additional Info --}}
                <div class="mb-6">
                    <h2 class="text-lg font-bold uppercase border-b border-slate-300 mb-2">Informasi Tambahan</h2>
                    <ul class="list-disc list-inside text-sm leading-relaxed">
                        <li><strong>Ekspektasi Gaji:</strong> {{ $profile->salary_expectation ?: 'Negosiasi' }}</li>
                        <li><strong>Usia:</strong> {{ $user->age }} Tahun (Lahir: {{ $user->date_of_birth->format('d M Y') }})</li>
                    </ul>
                </div>

            </div>
            
            <p class="text-center text-xs text-slate-400 mt-6">
                <i class='bx bx-bulb'></i> Tip: Untuk mengunduh PDF, klik tombol "Cetak / Simpan PDF", lalu pilih opsi "Save to PDF" pada dialog print browser Anda.
            </p>
        @endif
    </div>

    {{-- Print Styles --}}
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #cv-document, #cv-document * {
                visibility: visible;
            }
            #cv-document {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                border: none;
                box-shadow: none;
            }
            /* Hide URL printing */
            @page { margin: 0; }
        }
    </style>
</div>
