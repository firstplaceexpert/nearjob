<div class="pb-36 pt-16" style="background: #f0f4f9; min-height: 100vh;">
    <div class="max-w-xl mx-auto px-4 pt-5">
        <h1 class="text-2xl font-extrabold text-slate-800 mb-1">Generator CV ATS</h1>
        <p class="text-slate-400 text-sm mb-4">Buat CV profesional yang ramah ATS dari profil Anda secara otomatis.</p>

        {{-- Official CV ATS PLYGROWN Link Card --}}
        <div class="rounded-2xl p-5 mb-6 text-white relative overflow-hidden shadow-md" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 60%, #3b82f6 100%);">
            <div class="flex items-start justify-between gap-4">
                <div class="space-y-1.5">
                    <span class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full bg-white/20 text-blue-100">
                        <i class='bx bx-check-shield'></i> Mitra Resmi
                    </span>
                    <h2 class="text-lg font-black text-white">CV ATS PLYGROWN</h2>
                    <p class="text-xs text-blue-100 leading-relaxed max-w-sm">
                        Optimasi & uji resume Anda agar 100% lolos sistem Applicant Tracking System (ATS) dengan AI Optimizer dan Skor ATS.
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-2xl shrink-0">
                    <i class='bx bx-file-blank'></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/15">
                <a href="https://cvatsplygrown.vercel.app" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center justify-center gap-2 w-full py-3 bg-white font-extrabold text-xs sm:text-sm rounded-xl text-blue-700 shadow-sm hover:bg-blue-50 transition-all text-center"
                   style="text-decoration: none;">
                    <span>Buka Pembuat CV di CV ATS PLYGROWN</span>
                    <i class='bx bx-link-external'></i>
                </a>
            </div>
        </div>

        @if(!$isPaid)
            {{-- Mock Payment Flow --}}
            <div class="bg-white rounded-2xl p-6 text-center" style="border: 1px solid #e8edf5; box-shadow: 0 2px 12px rgba(37,67,155,.06);">
                <div class="w-20 h-20 rounded-full flex items-center justify-center text-4xl mx-auto mb-4" style="background: #eef2fb; color: #5680d8;">
                    <i class='bx bx-file'></i>
                </div>
                <h2 class="text-xl font-extrabold text-slate-800 mb-2">Buat CV ATS Profesional</h2>
                <p class="text-slate-400 text-sm mb-6 max-w-[260px] mx-auto">Data profil Anda akan digunakan untuk membuat CV secara otomatis. Bayar sekali, unduh kapan saja.</p>

                <div class="p-4 rounded-2xl mb-5 text-left max-w-sm mx-auto" style="background: #f8faff; border: 1px solid #e8edf5;">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-bold text-slate-700">Generator CV ATS</span>
                        <span class="text-sm font-extrabold text-slate-800">Rp14.999</span>
                    </div>
                    <div class="flex justify-between items-center text-xs text-slate-400 pb-2 mb-2" style="border-bottom: 1px solid #e8edf5;">
                        <span>Biaya Layanan</span>
                        <span>Rp1.000</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-extrabold text-slate-700">Total</span>
                        <span class="text-xl font-black" style="color: #5680d8;">Rp15.999</span>
                    </div>
                </div>

                <div class="max-w-sm mx-auto space-y-3">
                    <button wire:click="processPayment" wire:loading.attr="disabled" class="w-full py-3.5 text-white font-bold rounded-xl text-sm flex items-center justify-center gap-2" style="background: #00AA13;">
                        <span wire:loading.remove><i class='bx bx-money'></i> Bayar dengan GoPay</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                    <button wire:click="processPayment" wire:loading.attr="disabled" class="w-full py-3.5 text-white font-bold rounded-xl text-sm flex items-center justify-center gap-2" style="background: #5680d8; box-shadow: 0 4px 15px rgba(86,128,216,.3);">
                        <span wire:loading.remove><i class='bx bx-qr-scan'></i> Bayar dengan QRIS / Bank Transfer</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
                <p class="text-[10px] text-slate-400 mt-4">*Demo pembayaran. Tidak ada uang yang ditagih.</p>
            </div>
        @else
            {{-- CV Result --}}
            <div class="flex items-center justify-between mb-4">
                <span class="font-bold text-xs px-3 py-1.5 rounded-full flex items-center gap-1" style="background: #e6f8f6; color: #2a9d8f; border: 1px solid #99f6e4;">
                    <i class='bx bx-check-circle'></i> CV Tersedia
                </span>
                <button onclick="window.print()" class="text-white font-bold text-xs px-4 py-2 rounded-xl flex items-center gap-2 transition-all" style="background: #24427b; box-shadow: 0 4px 12px rgba(37,67,155,.3);">
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
