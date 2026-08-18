@extends('layouts.app')

@section('content')
@php
    function formatDisplayPrice($val, $default = '0') {
        if (empty($val)) return 'Rp ' . number_format((float)$default, 0, ',', '.');
        $val = trim($val);
        if (preg_match('/^rp/i', $val)) return $val;
        if (is_numeric($val)) return 'Rp ' . number_format((float)$val, 0, ',', '.');
        return 'Rp ' . $val;
    }
@endphp

<div class="space-y-6">

    <!-- Hero Section & Wallet Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Main Wallet Card (Optimized for Mobile Performance) -->
        <div class="lg:col-span-2 rounded-2xl bg-gradient-to-br from-brand-primary via-blue-700 to-indigo-800 p-6 sm:p-8 text-white shadow-md relative overflow-hidden">
            <div class="relative z-10 flex flex-col h-full justify-between gap-6">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-white/80 text-xs sm:text-sm font-medium tracking-wide uppercase">Total Saldo Tersedia</span>
                        <span class="px-2.5 py-1 rounded-full bg-white/20 text-white text-[11px] font-semibold border border-white/20">Siap Ditarik</span>
                    </div>
                    <div class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight">
                        Rp {{ number_format(auth()->user()->saldo ?? 0, 0, ',', '.') }}
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <button onclick="openWithdrawalModal()" class="flex-1 sm:flex-none px-6 py-2.5 bg-white text-brand-primary font-bold text-sm rounded-xl shadow-sm hover:bg-slate-50 active:scale-95 transition-all text-center">
                        Tarik Saldo
                    </button>
                    <a href="{{ route('history') }}" class="flex-1 sm:flex-none px-6 py-2.5 bg-white/15 text-white font-semibold text-sm rounded-xl hover:bg-white/25 active:scale-95 transition-all border border-white/20 text-center">
                        Riwayat Saldo
                    </a>
                </div>
            </div>
        </div>

        <!-- Mini Stats Harga Job Live -->
        <div class="grid grid-cols-2 lg:grid-cols-1 gap-3 sm:gap-4">
            <!-- Email Khusus -->
            <a href="{{ route('job') }}" class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between hover:border-brand-primary/40 transition-colors">
                <div>
                    <div class="text-xs text-slate-500 font-semibold mb-1">Job Email Khusus</div>
                    <div class="text-base sm:text-xl font-bold text-slate-800">
                        {{ formatDisplayPrice($harga_email_khusus, '4300') }}
                    </div>
                    <span class="text-[11px] text-brand-primary font-medium">Reward per email &rarr;</span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-brand-primary/10 flex items-center justify-center text-brand-primary shrink-0 mt-2 sm:mt-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </a>

            <!-- Email Bebas -->
            <a href="{{ route('job') }}" class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between hover:border-brand-primary/40 transition-colors">
                <div>
                    <div class="text-xs text-slate-500 font-semibold mb-1">Job Email Bebas</div>
                    <div class="text-base sm:text-xl font-bold text-slate-800">
                        {{ formatDisplayPrice($harga_email_bebas, '3300') }}
                    </div>
                    <span class="text-[11px] text-emerald-600 font-medium">Reward per email &rarr;</span>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-600 shrink-0 mt-2 sm:mt-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path></svg>
                </div>
            </a>
        </div>
    </div>

    <!-- Ringkasan Aktivitas Tugas Saya -->
    <div class="grid grid-cols-3 gap-3 sm:gap-6">
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200 shadow-xs border-l-4 border-l-status-warning">
            <h4 class="text-xs sm:text-sm text-slate-500 font-semibold mb-1">Pending</h4>
            <div class="text-2xl sm:text-3xl font-bold text-slate-800">{{ $pending_count ?? 0 }}</div>
            <span class="text-[11px] text-slate-400">Menunggu ACC</span>
        </div>
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200 shadow-xs border-l-4 border-l-status-success">
            <h4 class="text-xs sm:text-sm text-slate-500 font-semibold mb-1">Diterima</h4>
            <div class="text-2xl sm:text-3xl font-bold text-slate-800">{{ $approved_count ?? 0 }}</div>
            <span class="text-[11px] text-status-success">ACC Selesai</span>
        </div>
        <div class="bg-white p-4 sm:p-6 rounded-2xl border border-slate-200 shadow-xs border-l-4 border-l-brand-primary">
            <h4 class="text-xs sm:text-sm text-slate-500 font-semibold mb-1">Total Setor</h4>
            <div class="text-2xl sm:text-3xl font-bold text-slate-800">{{ ($pending_count ?? 0) + ($approved_count ?? 0) }}</div>
            <span class="text-[11px] text-slate-400">Total Tugas</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
        <!-- Shortcut Ambil Job Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5 sm:p-6 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-brand-primary/10 text-brand-primary flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-base sm:text-lg">Mulai Kirim Setoran</h3>
                        <p class="text-xs text-slate-500">Pilih job dan kirim email hasil pembuatanmu.</p>
                    </div>
                </div>
                <p class="text-sm text-slate-600 mb-4">
                    Sistem verifikasi otomatis kami aktif 24 jam. Saldo langsung otomatis bertambah ke akun Anda setelah admin meng-ACC tugas.
                </p>
            </div>
            <a href="{{ route('job') }}" class="w-full py-3 bg-brand-primary text-white font-bold rounded-xl text-sm shadow-xs hover:bg-brand-secondary active:scale-[0.99] transition-all text-center flex items-center justify-center gap-2">
                <span>Buka Halaman Job & Tugas</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

        <!-- Panduan & Bantuan -->
        <div class="bg-slate-900 rounded-2xl p-5 sm:p-6 text-white shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.01 2.014c-5.495 0-9.957 4.466-9.957 9.962 0 1.761.458 3.45 1.334 4.954L2.053 22l5.224-1.37a9.92 9.92 0 004.733 1.18h.005c5.494 0 9.957-4.466 9.957-9.96 0-2.66-1.037-5.163-2.918-7.045a9.926 9.926 0 00-7.044-2.79h-.001zm0 16.586h-.002c-1.493 0-2.96-.402-4.246-1.164l-.304-.18-3.155.827.842-3.076-.198-.315a8.27 8.27 0 01-1.272-4.475c0-4.57 3.723-8.293 8.295-8.293 2.215 0 4.298.863 5.864 2.428 1.567 1.566 2.43 3.65 2.43 5.866 0 4.57-3.722 8.293-8.293 8.293zm4.558-6.222c-.25-.125-1.477-.73-1.706-.814-.23-.083-.398-.125-.565.125-.167.25-.648.814-.795.981-.146.166-.293.187-.542.062-1.344-.672-2.39-1.3-3.32-2.766-.145-.228-.016-.353.11-.478.113-.112.25-.292.375-.438.125-.145.166-.25.25-.416.084-.167.042-.313-.02-.438-.063-.125-.566-1.365-.776-1.87-.203-.49-.41-.424-.565-.43-.146-.008-.314-.008-.48-.008s-.44.062-.67.313c-.23.25-.88.86-1.205 1.777s-.066 1.956.108 2.508c1.233 3.9 4.316 6.372 7.155 7.625 2.115.932 2.923.864 3.937.72 1.353-.193 2.422-.968 2.805-1.928.384-.96.384-1.782.268-1.956-.115-.175-.417-.278-.667-.404z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-base sm:text-lg">Komunitas & Bantuan</h3>
                        <p class="text-xs text-slate-400">Panduan lengkap cara pembuatan email.</p>
                    </div>
                </div>
                <p class="text-sm text-slate-300 mb-4">
                    Gabung grup WhatsApp kami untuk mendapatkan informasi update format email terbaru, tips anti-checkpoint, dan info jam setor.
                </p>
            </div>
            <a href="https://chat.whatsapp.com/" target="_blank" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm active:scale-[0.99] transition-all text-center flex items-center justify-center gap-2">
                <span>Gabung Grup WhatsApp</span>
            </a>
        </div>
    </div>

</div>

<!-- Modal Tarik Saldo -->
<div id="withdrawalModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in-95 duration-150">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-800">Tarik Saldo</h3>
            <button onclick="closeWithdrawalModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6">
            <form id="withdrawalForm" onsubmit="submitWithdrawal(event)">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Metode Penarikan</label>
                    <select name="metode" id="metodeSelect" onchange="toggleMetode()" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary focus:ring-1 focus:ring-brand-primary outline-none transition-all text-sm bg-white">
                        <option value="E-Wallet">E-Wallet (DANA, OVO, GoPay, ShopeePay)</option>
                        <option value="Bank">Transfer Bank</option>
                    </select>
                </div>

                <div id="ewalletContainer" class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih E-Wallet</label>
                    <select name="nama_ewallet" id="ewalletSelect" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary focus:ring-1 focus:ring-brand-primary outline-none transition-all text-sm bg-white">
                        <option value="DANA">DANA</option>
                        <option value="OVO">OVO</option>
                        <option value="GoPay">GoPay</option>
                        <option value="ShopeePay">ShopeePay</option>
                        <option value="LinkAja">LinkAja</option>
                    </select>
                </div>

                <div id="bankContainer" class="mb-4 hidden">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Bank</label>
                    <select name="nama_bank" id="bankSelect" onchange="toggleBankLainnya()" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary focus:ring-1 focus:ring-brand-primary outline-none transition-all text-sm bg-white">
                        <option value="BCA">BCA</option>
                        <option value="Mandiri">Mandiri</option>
                        <option value="BNI">BNI</option>
                        <option value="BRI">BRI</option>
                        <option value="BSI">BSI</option>
                        <option value="CIMB Niaga">CIMB Niaga</option>
                        <option value="Permata">Permata</option>
                        <option value="Jago">Bank Jago</option>
                        <option value="SeaBank">SeaBank</option>
                        <option value="Lainnya">Bank Lainnya</option>
                    </select>
                </div>
                
                <div id="bankLainnyaContainer" class="mb-4 hidden">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Ketik Nama Bank</label>
                    <input type="text" name="nama_bank_lainnya" id="bankLainnyaInput" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary outline-none transition-all text-sm" placeholder="Contoh: Bank DKI">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2" id="labelNomor">Nomor HP E-Wallet</label>
                    <input type="text" name="nomor_rekening_hp" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary outline-none transition-all text-sm" placeholder="08...">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Pemilik Akun / Rekening</label>
                    <input type="text" name="nama_pemilik" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary outline-none transition-all text-sm" placeholder="Atas Nama Pemilik...">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Penarikan (Rp)</label>
                    <input type="number" name="jumlah" required min="10000" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary outline-none transition-all text-sm" placeholder="Minimal 10.000">
                    <p class="text-xs text-slate-400 mt-1">Saldo kamu: Rp {{ number_format(auth()->user()->saldo ?? 0, 0, ',', '.') }}</p>
                </div>
                
                <div id="wdAlertMessage" class="hidden mb-4 p-3 rounded-xl text-sm"></div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeWithdrawalModal()" class="px-5 py-2.5 text-slate-600 font-medium hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                    <button type="submit" id="wdSubmitBtn" class="px-5 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-sm hover:bg-brand-secondary transition-colors flex items-center gap-2">
                        <span>Tarik Sekarang</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openWithdrawalModal() {
        document.getElementById('wdAlertMessage').classList.add('hidden');
        document.getElementById('withdrawalModal').classList.remove('hidden');
        toggleMetode();
    }

    function closeWithdrawalModal() {
        document.getElementById('withdrawalModal').classList.add('hidden');
    }

    function toggleMetode() {
        const metode = document.getElementById('metodeSelect').value;
        const ewalletContainer = document.getElementById('ewalletContainer');
        const bankContainer = document.getElementById('bankContainer');
        const bankLainnyaContainer = document.getElementById('bankLainnyaContainer');
        const labelNomor = document.getElementById('labelNomor');

        if (metode === 'Bank') {
            ewalletContainer.classList.add('hidden');
            bankContainer.classList.remove('hidden');
            labelNomor.innerText = 'Nomor Rekening Bank';
            toggleBankLainnya();
        } else {
            ewalletContainer.classList.remove('hidden');
            bankContainer.classList.add('hidden');
            bankLainnyaContainer.classList.add('hidden');
            labelNomor.innerText = 'Nomor HP E-Wallet';
        }
    }

    function toggleBankLainnya() {
        const bank = document.getElementById('bankSelect').value;
        const bankLainnyaContainer = document.getElementById('bankLainnyaContainer');
        if (bank === 'Lainnya') {
            bankLainnyaContainer.classList.remove('hidden');
        } else {
            bankLainnyaContainer.classList.add('hidden');
        }
    }

    async function submitWithdrawal(e) {
        e.preventDefault();
        
        const btn = document.getElementById('wdSubmitBtn');
        const alertMsg = document.getElementById('wdAlertMessage');
        const form = document.getElementById('withdrawalForm');
        
        btn.disabled = true;
        btn.innerHTML = 'Memproses...';

        try {
            const formData = new FormData(form);
            const response = await fetch('{{ route("withdrawal.submit") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            });

            const result = await response.json();

            alertMsg.classList.remove('hidden', 'bg-red-50', 'text-red-600', 'bg-green-50', 'text-green-600');
            
            if (response.ok) {
                alertMsg.classList.add('bg-green-50', 'text-green-600');
                alertMsg.innerText = result.message;
                setTimeout(() => {
                    window.location.reload();
                }, 1200);
            } else {
                alertMsg.classList.add('bg-red-50', 'text-red-600');
                alertMsg.innerText = result.message || 'Terjadi kesalahan.';
                btn.disabled = false;
                btn.innerHTML = 'Tarik Sekarang';
            }
        } catch (error) {
            alertMsg.classList.remove('hidden');
            alertMsg.classList.add('bg-red-50', 'text-red-600');
            alertMsg.innerText = 'Terjadi kesalahan jaringan.';
            btn.disabled = false;
            btn.innerHTML = 'Tarik Sekarang';
        }
    }
</script>
@endsection
