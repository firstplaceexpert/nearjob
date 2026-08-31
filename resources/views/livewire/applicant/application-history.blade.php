<div class="p-4 bg-slate-50 min-h-full pb-8">
    <div class="max-w-md mx-auto">
        <h1 class="text-2xl font-extrabold text-slate-800 mb-2">Riwayat Lamaran</h1>
        <p class="text-slate-500 text-sm mb-6">Pantau status lamaran pekerjaan Anda di sini.</p>

        @if($applications->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-100 shadow-sm mt-4">
                <div class="text-5xl mb-4"><i class='bx bx-notepad'></i></div>
                <h3 class="text-lg font-extrabold text-slate-700">Belum ada lamaran</h3>
                <p class="text-sm text-slate-500 mt-2 max-w-[250px] mx-auto">Anda belum melamar pekerjaan apapun. Ayo cari peluang kerja di sekitar Anda!</p>
                <a href="{{ route('applicant.map') }}" class="inline-block mt-6 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors">
                    Cari Pekerjaan
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($applications as $app)
                    <div class="bg-white rounded-3xl p-5 border border-slate-100 shadow-sm relative overflow-hidden">
                        {{-- Status Badge --}}
                        @php
                            $statusConfig = match($app->status) {
                                'menunggu' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-200', 'icon' => "<i class='bx bx-time'></i>"],
                                'dihubungi' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => "<i class='bx bxl-whatsapp'></i>"],
                                'interview' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'icon' => "<i class='bx bx-user-plus'></i>"],
                                'diterima' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => "<i class='bx bx-party'></i>"],
                                'tidak_lolos' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'icon' => "<i class='bx bx-sad'></i>"],
                                default => ['bg' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'icon' => "<i class='bx bx-pin'></i>"],
                            };
                        @endphp
                        
                        <div class="absolute top-0 right-0 px-3 py-1.5 rounded-bl-xl border-b border-l {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }} text-[10px] font-extrabold tracking-wide uppercase flex items-center gap-1">
                            {!! $statusConfig['icon'] !!} {{ $app->status_label }}
                        </div>

                        <div class="flex items-center gap-3 mb-4 mt-2">
                            <div class="w-12 h-12 bg-slate-50 text-slate-600 rounded-xl flex items-center justify-center text-xl shrink-0 font-black border border-slate-100">
                                {{ substr($app->jobListing->company->company_name, 0, 1) }}
                            </div>
                            <div class="min-w-0 pr-24">
                                <h4 class="font-extrabold text-slate-800 text-base truncate"><a href="{{ route('applicant.job.detail', $app->job_listing_id) }}" class="hover:text-blue-600">{{ $app->jobListing->position }}</a></h4>
                                <p class="text-xs text-slate-500 font-medium truncate">{{ $app->jobListing->company->company_name }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 mb-4 p-3 bg-slate-50 rounded-xl">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Tanggal Lamar</p>
                                <p class="text-xs font-semibold text-slate-700">{{ $app->application_date ? $app->application_date->format('d M Y') : $app->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Metode</p>
                                <p class="text-xs font-semibold {{ $app->contact_method === 'whatsapp' ? 'text-green-600' : 'text-blue-600' }} flex items-center gap-1">
                                    {!! $app->contact_method === 'whatsapp' ? "<i class='bx bxl-whatsapp'></i> WhatsApp" : "<i class='bx bx-envelope'></i> Email" !!}
                                </p>
                            </div>
                        </div>

                        @if($app->status === 'menunggu')
                            <p class="text-[11px] text-slate-500 text-center italic">Pemberi kerja belum merespons lamaran ini.</p>
                        @elseif($app->status === 'dihubungi')
                            <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 text-xs text-blue-700 font-medium flex items-start gap-2">
                                <span class="text-base"><i class='bx bx-bell'></i></span> Pemberi kerja mungkin akan segera menghubungi Anda. Pastikan HP Anda aktif.
                            </div>
                        @elseif($app->status === 'diterima')
                            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-3 text-xs text-emerald-700 font-bold flex items-start gap-2 text-center justify-center">
                                Selamat! Anda diterima bekerja.
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
