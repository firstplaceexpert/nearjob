<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        
        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Riwayat Lamaran Saya</h1>
                <p class="text-slate-500 text-sm mt-1">Daftar pekerjaan yang telah Anda lalui via Swipe Kanan</p>
            </div>
            <a href="{{ route('applicant.swipe') }}" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-xl text-xs shadow-sm hover:bg-indigo-700 transition-colors">
                + Swipe Lowongan Baru
            </a>
        </div>

        @if($applications->isEmpty())
            <div class="text-center py-12 text-slate-500 space-y-3">
                <div class="text-4xl">📭</div>
                <p class="font-semibold text-base">Belum Ada Lamaran Terkirim</p>
                <p class="text-xs text-slate-400">Mulailah swipe kanan pada kartu lowongan untuk mengirimkan CV Anda!</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($applications as $app)
                    <div class="p-5 rounded-2xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:shadow-md transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider bg-indigo-100 text-indigo-700">
                                    {{ $app->jobListing->work_type_label }}
                                </span>
                                <span class="text-xs text-slate-400">Dilamar pada {{ $app->created_at->format('d M Y, H:i') }}</span>
                            </div>

                            <h3 class="text-lg font-bold text-slate-900">{{ $app->jobListing->position }}</h3>
                            <p class="text-sm font-semibold text-slate-700">{{ $app->jobListing->company->company_name }} — <span class="text-slate-500 font-normal">📍 {{ $app->jobListing->city }}</span></p>
                        </div>

                        <!-- Status Badge -->
                        <div class="shrink-0 flex items-center gap-2">
                            @if($app->status === 'applied')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                    ⏳ CV Terkirim
                                </span>
                            @elseif($app->status === 'viewed')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                    👀 CV Dilihat HR
                                </span>
                            @elseif($app->status === 'contacted')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    ✉️ Dikontak HR
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-4">
                {{ $applications->links() }}
            </div>
        @endif
    </div>
</div>
