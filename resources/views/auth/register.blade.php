@extends('layouts.auth')

@section('content')
<div class="mb-8 text-center">
    <h2 class="text-3xl font-bold text-slate-900 mb-2">Buat Akun Baru</h2>
    <p class="text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="text-brand-primary font-semibold hover:underline">Masuk di sini</a></p>
</div>

<!-- Referral Banner -->
<div class="mb-6 bg-brand-primary/10 border border-brand-primary/20 rounded-xl p-3 flex items-center gap-3">
    <div class="w-8 h-8 rounded-full bg-brand-primary text-white flex items-center justify-center shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
    </div>
    <div class="text-sm">
        <span class="text-slate-600">Kamu diundang oleh</span>
        <span class="font-bold text-brand-primary block">Epanganteng (Kode: EPA99)</span>
    </div>
</div>

<form action="{{ route('register') }}" method="POST" class="space-y-4">
    @csrf
    
    @if($errors->any())
        <div class="bg-status-danger/10 text-status-danger text-sm p-3 rounded-xl border border-status-danger/20 mb-4">
            {{ $errors->first() }}
        </div>
    @endif
    
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
        <input type="text" name="name" value="{{ old('name') }}" class="block w-full px-3 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary outline-none transition-all shadow-sm" placeholder="John Doe" required>
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="block w-full px-3 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary outline-none transition-all shadow-sm" placeholder="nama@email.com" required>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kata Sandi</label>
            <input type="password" name="password" class="block w-full px-3 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary outline-none transition-all shadow-sm" placeholder="••••••••" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi</label>
            <input type="password" name="password_confirmation" class="block w-full px-3 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary outline-none transition-all shadow-sm" placeholder="••••••••" required>
        </div>
    </div>

    <!-- Captcha Widget Placeholder -->
    <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 flex items-center justify-between mt-2">
        <div class="flex items-center gap-3">
            <input type="checkbox" class="h-5 w-5 text-brand-primary rounded border-slate-300">
            <span class="text-sm font-medium text-slate-700">Saya bukan robot</span>
        </div>
        <div class="flex flex-col items-center">
            <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
        </div>
    </div>

    <button type="submit" class="w-full mt-4 flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-brand-primary hover:bg-brand-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary transition-all active:scale-[0.98]">
        Daftar Sekarang
    </button>
    
    <p class="text-xs text-center text-slate-500 mt-4">
        Dengan mendaftar, Anda menyetujui <a href="#" class="text-brand-primary hover:underline">Syarat & Ketentuan</a> kami.
    </p>
</form>
@endsection
