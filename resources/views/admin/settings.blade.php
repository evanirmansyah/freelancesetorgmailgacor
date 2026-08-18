@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 mb-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800">Pengaturan Sistem & Harga</h2>
            <p class="text-xs sm:text-sm text-slate-500">Ubah harga reward, buka/tutup job, instruksi, dan banner pengumuman.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-status-success/10 border border-status-success/20 text-status-success px-4 py-3 rounded-xl flex items-center gap-2 text-sm font-semibold">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Section 1: Pengaturan Harga Job --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-sm sm:text-base flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Pengaturan Harga Job (Reward User)
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">Harga Email Khusus</label>
                        <div class="flex items-center border border-slate-300 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-brand-primary/20 focus-within:border-brand-primary shadow-xs">
                            <span class="bg-slate-50 border-r border-slate-300 px-3 py-2.5 text-slate-500 font-bold text-xs select-none">Rp</span>
                            <input type="text" name="harga_email_khusus" value="{{ $harga_email_khusus }}" class="flex-1 px-3.5 py-2.5 outline-none bg-white text-sm" placeholder="Contoh: 4300 atau 4300 - 6000" required>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Bisa angka (misal <code>4300</code>) atau range (misal <code>4300 - 6000</code>).</p>
                        @error('harga_email_khusus')<p class="text-status-danger text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">Harga Email Bebas</label>
                        <div class="flex items-center border border-slate-300 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-brand-primary/20 focus-within:border-brand-primary shadow-xs">
                            <span class="bg-slate-50 border-r border-slate-300 px-3 py-2.5 text-slate-500 font-bold text-xs select-none">Rp</span>
                            <input type="text" name="harga_email_bebas" value="{{ $harga_email_bebas }}" class="flex-1 px-3.5 py-2.5 outline-none bg-white text-sm" placeholder="Contoh: 3300" required>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Akan tampil otomatis di dashboard & halaman job user.</p>
                        @error('harga_email_bebas')<p class="text-status-danger text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Status Buka/Tutup Job --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-sm sm:text-base flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Status Ketersediaan Job
                </h3>
            </div>
            <div class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Email Khusus Status --}}
                <div class="rounded-xl border border-slate-200 p-4 flex items-center justify-between gap-3">
                    <div>
                        <p class="font-bold text-slate-800 text-sm">Job Email Khusus</p>
                        <p class="text-xs text-slate-500">Status saat ini: <span class="font-semibold {{ $status_email_khusus === 'open' ? 'text-status-success' : 'text-status-danger' }}">{{ $status_email_khusus === 'open' ? 'Dibuka' : 'Ditutup' }}</span></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="status_email_khusus" value="open" class="hidden peer/open" {{ $status_email_khusus === 'open' ? 'checked' : '' }}>
                            <span class="px-3 py-1.5 rounded-lg text-xs font-bold border transition-all peer-checked/open:bg-status-success peer-checked/open:text-white peer-checked/open:border-status-success border-slate-200 text-slate-600 hover:border-status-success">Buka</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="status_email_khusus" value="closed" class="hidden peer/closed" {{ $status_email_khusus === 'closed' ? 'checked' : '' }}>
                            <span class="px-3 py-1.5 rounded-lg text-xs font-bold border transition-all peer-checked/closed:bg-status-danger peer-checked/closed:text-white peer-checked/closed:border-status-danger border-slate-200 text-slate-600 hover:border-status-danger">Tutup</span>
                        </label>
                    </div>
                </div>

                {{-- Email Bebas Status --}}
                <div class="rounded-xl border border-slate-200 p-4 flex items-center justify-between gap-3">
                    <div>
                        <p class="font-bold text-slate-800 text-sm">Job Email Bebas</p>
                        <p class="text-xs text-slate-500">Status saat ini: <span class="font-semibold {{ $status_email_bebas === 'open' ? 'text-status-success' : 'text-status-danger' }}">{{ $status_email_bebas === 'open' ? 'Dibuka' : 'Ditutup' }}</span></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="status_email_bebas" value="open" class="hidden peer/open2" {{ $status_email_bebas === 'open' ? 'checked' : '' }}>
                            <span class="px-3 py-1.5 rounded-lg text-xs font-bold border transition-all peer-checked/open2:bg-status-success peer-checked/open2:text-white peer-checked/open2:border-status-success border-slate-200 text-slate-600 hover:border-status-success">Buka</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="status_email_bebas" value="closed" class="hidden peer/closed2" {{ $status_email_bebas === 'closed' ? 'checked' : '' }}>
                            <span class="px-3 py-1.5 rounded-lg text-xs font-bold border transition-all peer-checked/closed2:bg-status-danger peer-checked/closed2:text-white peer-checked/closed2:border-status-danger border-slate-200 text-slate-600 hover:border-status-danger">Tutup</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 3: Instruksi Job --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-sm sm:text-base flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Instruksi & Syarat Job
                </h3>
            </div>
            <div class="p-4 sm:p-6 space-y-4">
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">Instruksi <span class="text-brand-primary font-bold">Email Khusus</span></label>
                    <textarea name="instruksi_email_khusus" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-brand-primary outline-none transition-all text-xs sm:text-sm resize-none" placeholder="Tulis syarat pembuatan Email Khusus...">{{ $instruksi_email_khusus }}</textarea>
                </div>
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">Instruksi <span class="text-emerald-600 font-bold">Email Bebas</span></label>
                    <textarea name="instruksi_email_bebas" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-brand-primary outline-none transition-all text-xs sm:text-sm resize-none" placeholder="Tulis syarat pembuatan Email Bebas...">{{ $instruksi_email_bebas }}</textarea>
                </div>
            </div>
        </div>

        {{-- Section 4: Notice Banner --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-sm sm:text-base flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    Pesan Pengumuman / Notice Banner
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <label class="block text-xs sm:text-sm font-semibold text-slate-700 mb-1.5">Teks Banner</label>
                <input type="text" name="notice_banner" value="{{ $notice_banner }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-brand-primary outline-none transition-all text-xs sm:text-sm" placeholder="Contoh: Estimasi ACC 1-2 hari kerja.">
                <p class="text-[11px] text-slate-400 mt-1">Kosongkan jika tidak ingin menampilkan banner pengumuman di halaman Job user.</p>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-end pt-2">
            <button type="submit" class="w-full sm:w-auto bg-brand-primary text-white font-bold py-3 px-8 rounded-xl shadow-xs hover:bg-brand-secondary active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>Simpan Perubahan</span>
            </button>
        </div>

    </form>
</div>
@endsection
