@extends('layouts.auth')

@section('content')
<div class="mb-10 text-center">
    <h2 class="text-3xl font-bold text-slate-900 mb-2">Masuk ke akunmu</h2>
    <p class="text-slate-500">Belum punya akun? <a href="{{ route('register') }}" class="text-brand-primary font-semibold hover:underline">Daftar sekarang</a></p>
</div>

<form action="{{ route('login') }}" method="POST" class="space-y-5">
    @csrf
    
    @if($errors->any())
        <div class="bg-status-danger/10 text-status-danger text-sm p-3 rounded-xl border border-status-danger/20 mb-4">
            {{ $errors->first() }}
        </div>
    @endif
    
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Email</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
            <input type="email" name="email" value="{{ old('email') }}" class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary outline-none transition-all shadow-sm" placeholder="nama@email.com" required>
        </div>
    </div>

    <div>
        <div class="flex items-center justify-between mb-1.5">
            <label class="block text-sm font-medium text-slate-700">Kata Sandi</label>
            <a href="#" class="text-sm font-medium text-brand-primary hover:underline">Lupa sandi?</a>
        </div>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <input type="password" name="password" class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary outline-none transition-all shadow-sm" placeholder="••••••••" required>
        </div>
    </div>

    <div class="flex items-center">
        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-brand-primary focus:ring-brand-primary border-slate-300 rounded">
        <label for="remember" class="ml-2 block text-sm text-slate-600">
            Ingat saya
        </label>
    </div>

    <!-- Captcha Widget Placeholder -->
    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <input type="checkbox" class="h-5 w-5 text-brand-primary rounded border-slate-300">
            <span class="text-sm font-medium text-slate-700">Saya bukan robot</span>
        </div>
        <div class="flex flex-col items-center">
            <svg class="w-6 h-6 text-slate-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
            <span class="text-[10px] text-slate-500 mt-1">reCAPTCHA</span>
        </div>
    </div>

    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-brand-primary hover:bg-brand-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary transition-all active:scale-[0.98]">
        Masuk ke Dashboard
    </button>
</form>
@endsection
