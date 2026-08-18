@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
        
        <!-- Kolom Kiri: Info Profil & Referral -->
        <div class="md:col-span-2 space-y-4 sm:space-y-6">
            
            <!-- Profil Card -->
            <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-4 sm:gap-6">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-gradient-to-tr from-brand-primary to-brand-secondary text-white flex items-center justify-center font-bold text-2xl sm:text-3xl shadow-xs shrink-0">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="min-w-0">
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-800 truncate">{{ auth()->user()->name }}</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mb-2 truncate">{{ auth()->user()->email }}</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ auth()->user()->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-brand-primary/10 text-brand-primary' }}">
                            {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Member' }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-status-success/10 text-status-success">
                            <span class="w-1.5 h-1.5 rounded-full bg-status-success mr-1.5"></span> Aktif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Program Referral -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 text-sm sm:text-base flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Program Referral
                    </h3>
                </div>
                <div class="p-5 sm:p-6">
                    <p class="text-xs sm:text-sm text-slate-500 mb-4">Bagikan tautan referral kamu ke teman untuk mengundang mereka bergabung.</p>
                    
                    <div class="flex flex-col sm:flex-row gap-2 mb-6">
                        <input type="text" id="refLink" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs sm:text-sm text-slate-700 font-mono outline-none" value="{{ url('/register') }}?ref={{ auth()->user()->id }}" readonly>
                        <button onclick="copyRef()" id="btnCopyRef" class="bg-brand-primary text-white px-5 py-2.5 rounded-xl font-bold text-xs sm:text-sm hover:bg-brand-secondary active:scale-95 transition-all shrink-0 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                            <span>Salin Link</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-slate-50 rounded-xl p-3.5 border border-slate-100 text-center">
                            <div class="text-xs text-slate-500 mb-0.5">Kode Referral</div>
                            <div class="text-lg font-extrabold text-brand-primary font-mono">REF-{{ auth()->user()->id }}</div>
                        </div>
                        <div class="bg-emerald-50/50 rounded-xl p-3.5 border border-emerald-100 text-center">
                            <div class="text-xs text-emerald-700 mb-0.5">Status Akun</div>
                            <div class="text-lg font-extrabold text-emerald-600">Terverifikasi</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Keamanan / Logout -->
        <div class="space-y-4 sm:space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6">
                <h3 class="font-bold text-slate-800 text-sm sm:text-base mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Aksi Akun
                </h3>
                <p class="text-xs text-slate-500 mb-5">Gunakan tombol di bawah jika ingin keluar dari sesi login ini.</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-2.5 bg-status-danger/10 text-status-danger hover:bg-status-danger/20 font-bold text-xs sm:text-sm rounded-xl transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar dari Akun
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function copyRef() {
        const link = document.getElementById('refLink');
        link.select();
        link.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(link.value).then(() => {
            const btn = document.getElementById('btnCopyRef');
            btn.innerHTML = '<span>Tersalin! ✓</span>';
            setTimeout(() => {
                btn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg><span>Salin Link</span>';
            }, 2000);
        });
    }
</script>
@endsection
