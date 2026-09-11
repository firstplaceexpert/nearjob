{{-- Riwayat Lamaran Pelamar --}}
<div style="background: #f0f4f9; min-height: calc(100vh - 172px); padding: 16px 0 100px;">
    <div class="max-w-2xl mx-auto px-4">

        {{-- ===== HEADER ===== --}}
        <div class="flex items-center justify-between mb-8 pb-5 border-b border-slate-200/80">
            <div>
                <h1 class="text-2xl font-black text-black tracking-tight">Riwayat Lamaran</h1>
                <p class="text-black text-xs mt-1.5 font-semibold">Pantau status lamaran pekerjaan yang Anda kirimkan</p>
            </div>
            <a href="{{ route('applicant.map') }}"
               class="px-4 py-2.5 rounded-xl flex items-center gap-2 text-xs font-extrabold transition-all text-white shadow-md hover:opacity-95"
               style="background: #5680d8; box-shadow: 0 4px 16px rgba(86,128,216,.35);">
                <i class='bx bx-map-alt text-base'></i> Cari Lowongan
            </a>
        </div>

        @if($applications->isEmpty())
            <div class="text-center py-16 px-6 bg-white rounded-3xl my-6 border" style="border-color: #e8edf5; box-shadow: 0 4px 20px rgba(0,0,0,.03);">
                <div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center shadow-sm" style="background: #eef2fb; color: #5680d8;">
                    <i class='bx bx-notepad text-3xl'></i>
                </div>
                <h3 class="text-base font-extrabold text-black">Belum Ada Lamaran Kiriman</h3>
                <p class="text-xs text-black mt-2 max-w-[260px] mx-auto leading-relaxed font-medium">Anda belum pernah melamar pekerjaan. Ayo temukan berbagai peluang kerja terdekat di sekitar lokasi Anda!</p>
                <a href="{{ route('applicant.map') }}"
                   class="inline-flex items-center gap-2 mt-6 px-6 py-3 text-white text-xs font-extrabold rounded-xl shadow-lg"
                   style="background: #5680d8; box-shadow: 0 4px 15px rgba(86,128,216,.35);">
                    <i class='bx bx-map-alt text-base'></i> Buka Peta Lowongan Pekerjaan
                </a>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 32px; margin-bottom: 48px;">
                @foreach($applications as $app)
                @php
                    $statusConfig = match($app->status) {
                        'menunggu'    => ['label' => 'Menunggu Respons', 'icon' => 'bx-time-five'],
                        'dihubungi'   => ['label' => 'Dihubungi Pemberi Kerja', 'icon' => 'bxl-whatsapp'],
                        'interview'   => ['label' => 'Tahap Interview', 'icon' => 'bx-user-voice'],
                        'diterima'    => ['label' => 'Diterima Bekerja!', 'icon' => 'bx-check-circle'],
                        'tidak_lolos' => ['label' => 'Belum Sesuai', 'icon' => 'bx-x-circle'],
                        default       => ['label' => 'Diproses', 'icon' => 'bx-loader'],
                    };
                @endphp

                <div class="bg-white rounded-3xl overflow-hidden transition-all duration-200 border border-black/15 shadow-sm">
                    
                    {{-- Status Bar Top (Wrap Garis Hitam & Tulisan Hitam) --}}
                    <div class="px-6 py-3.5 flex items-center justify-between gap-3 bg-white border-b border-black/15">
                        <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md border border-black text-black text-xs font-bold bg-white">
                            <i class='bx {{ $statusConfig['icon'] }} text-sm'></i>
                            <span>{{ $statusConfig['label'] }}</span>
                        </div>
                        <span class="text-xs font-bold text-black/60">
                            {{ $app->application_date ? $app->application_date->format('d M Y') : $app->created_at->format('d M Y') }}
                        </span>
                    </div>

                    {{-- Card Body dengan Spasi Luas --}}
                    <div style="padding: 26px 26px 30px;">
                        {{-- Company & Position --}}
                        <div class="flex items-start gap-4" style="margin-bottom: 24px;">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl font-black shrink-0 border shadow-sm"
                                 style="background: {{ $app->jobListing->category_bg }}; color: {{ $app->jobListing->category_color }}; border-color: {{ $app->jobListing->category_color }}44;">
                                <i class='{{ $app->jobListing->category_icon }} text-2xl'></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-black text-base text-black leading-snug mb-1.5 truncate">
                                    <a href="{{ route('applicant.job.detail', $app->job_listing_id) }}" class="hover:underline text-black">
                                        {{ $app->jobListing->position }}
                                    </a>
                                </h3>
                                <p class="text-xs text-black font-extrabold mb-2 truncate">{{ $app->jobListing->company->company_name }}</p>
                                
                                {{-- Kota & Gaji Wrap Garis Hitam & Tulisan Hitam --}}
                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-top: 6px;">
                                    <span style="display: inline-flex; align-items: center; gap: 5px; background: #ffffff; color: #000000; padding: 4px 12px; border-radius: 8px; font-size: 11.5px; font-weight: 700; border: 1px solid rgba(0,0,0,0.25);">
                                        <i class='bx bx-map-pin text-[#5680d8]'></i> {{ $app->jobListing->company->city }}
                                    </span>
                                    <span style="display: inline-flex; align-items: center; gap: 5px; background: #ffffff; color: #000000; padding: 4px 12px; border-radius: 8px; font-size: 11.5px; font-weight: 800; border: 1px solid rgba(0,0,0,0.25);">
                                        <i class='bx bx-wallet text-[#5680d8]'></i> {{ $app->jobListing->salary_range }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Details Box (Wrap Garis Hitam & Tulisan Hitam) --}}
                        <div class="grid grid-cols-2 gap-4 rounded-2xl text-xs" 
                             style="background: #ffffff; border: 1px solid rgba(0,0,0,0.15); padding: 18px 20px; margin-bottom: 20px;">
                            <div>
                                <span class="text-[10px] font-extrabold uppercase tracking-widest text-black/60 block mb-1">JENIS KERJA</span>
                                <span class="font-black text-black text-xs sm:text-sm">{{ $app->jobListing->work_type_label }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] font-extrabold uppercase tracking-widest text-black/60 block mb-1">KONTAK LAMAR</span>
                                <span class="font-extrabold text-xs sm:text-sm text-black inline-flex items-center gap-1.5">
                                    {!! $app->contact_method === 'whatsapp' ? "<i class='bx bxl-whatsapp text-base'></i> WhatsApp" : "<i class='bx bx-envelope text-base'></i> Email" !!}
                                </span>
                            </div>
                        </div>

                        {{-- Status Message Banner (Wrap Garis Hitam & Tulisan Hitam) --}}
                        @if($app->status === 'menunggu')
                            <div class="rounded-xl text-center bg-white border border-black/20" style="padding: 14px 18px;">
                                <p class="text-xs text-black font-medium italic">Menunggu respons & verifikasi dari pihak pemberi kerja...</p>
                            </div>
                        @elseif($app->status === 'dihubungi')
                            <div class="rounded-xl flex items-center gap-3 bg-white border border-black/20" style="padding: 14px 18px;">
                                <i class='bx bxl-whatsapp text-2xl shrink-0 text-black'></i>
                                <span class="text-xs font-bold text-black leading-relaxed">Pemberi kerja akan segera menghubungi Anda via WhatsApp. Harap pastikan nomor HP aktif.</span>
                            </div>
                        @elseif($app->status === 'diterima')
                            <div class="rounded-xl text-center bg-white border-2 border-black" style="padding: 14px 18px;">
                                <p class="text-xs font-black text-black"><i class='bx bxs-party text-[#5680d8] align-middle text-sm'></i> Selamat! Anda telah diterima bekerja di tempat ini!</p>
                            </div>
                        @elseif($app->status === 'tidak_lolos')
                            <div class="rounded-xl text-center bg-white border border-black/20" style="padding: 14px 18px;">
                                <p class="text-xs font-bold text-black">Tetap semangat! Masih banyak peluang lowongan lain di Near Job.</p>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
