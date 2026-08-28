<div class="max-w-7xl mx-auto px-4 py-8 space-y-8">
    
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-8 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Dashboard Perusahaan</span>
            <h1 class="text-3xl font-extrabold text-slate-900 mt-1">{{ $company->company_name }}</h1>
            <p class="text-slate-500 text-sm mt-1">📍 {{ $company->address }}, {{ $company->city }} • ✉️ Email kontak: {{ $company->contact_email }}</p>
        </div>

        <a href="{{ route('company.jobs.create') }}" class="px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 transition-all text-sm flex items-center justify-center gap-2">
            <span>+ Pasang Lowongan Baru</span>
        </a>
    </div>

    <!-- Overview Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Lowongan</span>
            <div class="text-3xl font-black text-slate-900 mt-2">{{ $stats['total_jobs'] }}</div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Lowongan Aktif</span>
            <div class="text-3xl font-black text-emerald-600 mt-2">{{ $stats['active_jobs'] }}</div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Total CV Masuk</span>
            <div class="text-3xl font-black text-indigo-600 mt-2">{{ $stats['total_applications'] }}</div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <span class="text-xs font-bold text-amber-600 uppercase tracking-wider">CV Belum Dilihat</span>
            <div class="text-3xl font-black text-amber-600 mt-2">{{ $stats['unviewed_applications'] }}</div>
        </div>
    </div>

    <!-- Recent Applications Section -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">CV Terbaru Masuk via Swipe</h2>
            <a href="{{ route('company.jobs') }}" class="text-indigo-600 font-semibold text-xs hover:underline">Kelola Lowongan →</a>
        </div>

        @if($recentApplications->isEmpty())
            <div class="text-center py-10 text-slate-500 space-y-2">
                <div class="text-3xl">📥</div>
                <p class="font-medium text-sm">Belum ada CV pelamar yang masuk.</p>
                <p class="text-xs text-slate-400">Pastikan Anda telah memasang lowongan aktif untuk menarik kandidat lokal.</p>
            </div>
        @else
            <div class="divide-y divide-slate-100">
                @foreach($recentApplications as $app)
                    <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-700 font-bold flex items-center justify-center text-lg shrink-0">
                                {{ strtoupper(substr($app->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-base">{{ $app->user->name }}</h4>
                                <p class="text-xs text-slate-500">
                                    Melamar posisi <span class="font-semibold text-slate-700">{{ $app->jobListing->position }}</span> • {{ $app->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('company.jobs.applicants', $app->jobListing->id) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs rounded-xl transition-colors text-center">
                            Lihat Detail Pelamar
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
