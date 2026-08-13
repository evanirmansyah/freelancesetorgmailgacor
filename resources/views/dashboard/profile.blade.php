@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Kolom Kiri: Info Profil & Referral -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Profil Card -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-6">
                <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-brand-primary to-brand-accent text-white flex items-center justify-center font-bold text-3xl shadow-sm shrink-0">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">{{ auth()->user()->name }}</h2>
                    <p class="text-slate-500 mb-2">{{ auth()->user()->email }}</p>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ auth()->user()->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-brand-primary/10 text-brand-primary' }}">
                            {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Member Reguler' }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-status-success/10 text-status-success">
                            <span class="w-1.5 h-1.5 rounded-full bg-status-success mr-1.5"></span> Akun Terverifikasi
                        </span>
                    </div>
                </div>
            </div>

            <!-- Program Referral -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Program Referral
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-slate-500 mb-4">Ajak teman bergabung dan dapatkan bonus saldo untuk setiap tugas pertama yang mereka selesaikan.</p>
                    
                    <div class="flex flex-col md:flex-row gap-3 mb-8">
                        <input type="text" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 font-medium focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" value="https://setoran.test/register?ref=EPA99" readonly>
                        <button class="bg-brand-primary text-white px-6 py-3 rounded-xl font-bold hover:bg-brand-secondary transition-colors shrink-0 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                            Salin Link
                        </button>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 text-center">
                            <div class="text-sm text-slate-500 mb-1">Teman Diundang</div>
                            <div class="text-2xl font-bold text-slate-800">12</div>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 text-center">
                            <div class="text-sm text-slate-500 mb-1">Email Diterima</div>
                            <div class="text-2xl font-bold text-slate-800">45</div>
                        </div>
                        <div class="bg-brand-primary/5 rounded-xl p-4 border border-brand-primary/20 text-center">
                            <div class="text-sm text-brand-primary font-medium mb-1">Total Bonus</div>
                            <div class="text-2xl font-bold text-brand-primary">Rp 45.000</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Pengaturan -->
        <div class="space-y-6">
            
            <!-- Keamanan Akun -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Keamanan Akun
                    </h3>
                </div>
                <div class="p-6">
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kata Sandi Lama</label>
                            <input type="password" class="block w-full px-3 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary outline-none transition-all" placeholder="••••••••">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kata Sandi Baru</label>
                            <input type="password" class="block w-full px-3 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary outline-none transition-all" placeholder="••••••••">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Ulangi Kata Sandi Baru</label>
                            <input type="password" class="block w-full px-3 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary outline-none transition-all" placeholder="••••••••">
                        </div>
                        <button type="button" class="w-full mt-2 py-2.5 bg-slate-800 text-white font-bold rounded-xl shadow-sm hover:bg-slate-900 transition-colors">
                            Perbarui Sandi
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
