@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <!-- Hero Section & Wallet Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Wallet Card -->
        <div class="lg:col-span-2 rounded-2xl bg-gradient-to-br from-brand-primary to-brand-accent p-8 text-white shadow-lg relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute -top-12 -right-12 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 right-0 w-32 h-32 bg-brand-secondary/50 rounded-tl-full blur-xl"></div>
            
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div>
                    <h3 class="text-white/80 font-medium mb-1">Total Saldo Kamu</h3>
                    <div class="text-4xl lg:text-5xl font-bold tracking-tight">Rp {{ number_format(auth()->user()->saldo ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="mt-8 flex gap-4">
                    <button onclick="openWithdrawalModal()" class="px-6 py-2.5 bg-white text-brand-primary font-bold rounded-xl shadow-sm hover:bg-slate-50 transition-colors">
                        Tarik Saldo
                    </button>
                    <button class="px-6 py-2.5 bg-white/20 text-white font-medium rounded-xl hover:bg-white/30 backdrop-blur-sm transition-colors border border-white/20">
                        Riwayat
                    </button>
                </div>
            </div>
        </div>

        <!-- Mini Stats -->
        <div class="flex flex-col gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500 font-medium mb-1">Email Khusus</div>
                    <div class="text-xl font-bold text-slate-800">Rp {{ is_numeric($harga_email_khusus) ? number_format($harga_email_khusus, 0, ',', '.') : $harga_email_khusus }} <span class="text-xs text-slate-400 font-normal">/ email</span></div>
                </div>
                <div class="w-10 h-10 rounded-full bg-brand-primary/10 flex items-center justify-center text-brand-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <div class="text-sm text-slate-500 font-medium mb-1">Email Bebas</div>
                    <div class="text-xl font-bold text-slate-800">Rp {{ is_numeric($harga_email_bebas) ? number_format($harga_email_bebas, 0, ',', '.') : $harga_email_bebas }} <span class="text-xs text-slate-400 font-normal">/ email</span></div>
                </div>
                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Aktivitas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-status-warning">
            <h4 class="text-sm text-slate-500 font-medium mb-2">Pending</h4>
            <div class="text-3xl font-bold text-slate-800">12</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-status-success">
            <h4 class="text-sm text-slate-500 font-medium mb-2">Diterima (ACC)</h4>
            <div class="text-3xl font-bold text-slate-800">45</div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-brand-primary">
            <h4 class="text-sm text-slate-500 font-medium mb-2">Total Mendaftar</h4>
            <div class="text-3xl font-bold text-slate-800">57</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Leaderboard -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    Leaderboard Mingguan
                </h3>
                <span class="text-xs font-medium text-brand-primary bg-brand-primary/10 px-2.5 py-1 rounded-full">Top 3</span>
            </div>
            <div class="p-2 flex-1">
                <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center font-bold border border-yellow-200">1</div>
                    <img src="https://i.pravatar.cc/150?u=1" class="w-10 h-10 rounded-full border border-slate-200">
                    <div class="flex-1">
                        <div class="font-semibold text-slate-800">Alex_Pro</div>
                        <div class="text-xs text-slate-500">240 Job Selesai</div>
                    </div>
                    <div class="font-bold text-brand-primary">Rp 820.000</div>
                </div>
                <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold border border-slate-300">2</div>
                    <img src="https://i.pravatar.cc/150?u=2" class="w-10 h-10 rounded-full border border-slate-200">
                    <div class="flex-1">
                        <div class="font-semibold text-slate-800">Sarah123</div>
                        <div class="text-xs text-slate-500">185 Job Selesai</div>
                    </div>
                    <div class="font-bold text-brand-primary">Rp 640.000</div>
                </div>
                <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-700 flex items-center justify-center font-bold border border-orange-200">3</div>
                    <img src="https://i.pravatar.cc/150?u=3" class="w-10 h-10 rounded-full border border-slate-200">
                    <div class="flex-1">
                        <div class="font-semibold text-slate-800">Budi_Setor</div>
                        <div class="text-xs text-slate-500">150 Job Selesai</div>
                    </div>
                    <div class="font-bold text-brand-primary">Rp 510.000</div>
                </div>
            </div>
        </div>

        <!-- Quick Tools -->
        <div class="flex flex-col gap-6">
            <!-- Email Generator -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden group">
                <div class="absolute inset-0 bg-brand-primary/5 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                <div class="relative z-10">
                    <h3 class="font-bold text-slate-800 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        Alat Generate Email
                    </h3>
                    <p class="text-sm text-slate-500 mb-4">Gunakan alat ini untuk membuat nama email unik secara otomatis sebelum mengerjakan tugas.</p>
                    
                    <div class="flex gap-2">
                        <input type="text" class="flex-1 bg-slate-50 border border-slate-300 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" placeholder="Teks dasar (Opsional)">
                        <button class="bg-brand-primary text-white px-4 py-2 rounded-xl font-medium hover:bg-brand-secondary transition-colors">
                            Generate
                        </button>
                    </div>
                </div>
            </div>

            <!-- Panduan -->
            <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-sm flex items-center justify-between relative overflow-hidden">
                <div class="absolute right-0 top-0 opacity-10">
                    <svg width="120" height="120" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>
                </div>
                <div class="relative z-10">
                    <h3 class="font-bold text-lg mb-1">Butuh Panduan?</h3>
                    <p class="text-sm text-slate-400 mb-4">Gabung grup resmi kami untuk tips.</p>
                    <a href="#" class="inline-flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-xl font-medium text-sm hover:bg-green-600 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.01 2.014c-5.495 0-9.957 4.466-9.957 9.962 0 1.761.458 3.45 1.334 4.954L2.053 22l5.224-1.37a9.92 9.92 0 004.733 1.18h.005c5.494 0 9.957-4.466 9.957-9.96 0-2.66-1.037-5.163-2.918-7.045a9.926 9.926 0 00-7.044-2.79h-.001zm0 16.586h-.002c-1.493 0-2.96-.402-4.246-1.164l-.304-.18-3.155.827.842-3.076-.198-.315a8.27 8.27 0 01-1.272-4.475c0-4.57 3.723-8.293 8.295-8.293 2.215 0 4.298.863 5.864 2.428 1.567 1.566 2.43 3.65 2.43 5.866 0 4.57-3.722 8.293-8.293 8.293zm4.558-6.222c-.25-.125-1.477-.73-1.706-.814-.23-.083-.398-.125-.565.125-.167.25-.648.814-.795.981-.146.166-.293.187-.542.062-1.344-.672-2.39-1.3-3.32-2.766-.145-.228-.016-.353.11-.478.113-.112.25-.292.375-.438.125-.145.166-.25.25-.416.084-.167.042-.313-.02-.438-.063-.125-.566-1.365-.776-1.87-.203-.49-.41-.424-.565-.43-.146-.008-.314-.008-.48-.008s-.44.062-.67.313c-.23.25-.88.86-1.205 1.777s-.066 1.956.108 2.508c1.233 3.9 4.316 6.372 7.155 7.625 2.115.932 2.923.864 3.937.72 1.353-.193 2.422-.968 2.805-1.928.384-.96.384-1.782.268-1.956-.115-.175-.417-.278-.667-.404z"/></svg>
                        Join Grup WA
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Modal Tarik Saldo -->
<div id="withdrawalModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-800">Tarik Saldo</h3>
            <button onclick="closeWithdrawalModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6">
            <form id="withdrawalForm" onsubmit="submitWithdrawal(event)">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Metode Penarikan</label>
                    <select name="metode" id="metodeSelect" onchange="toggleMetode()" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary focus:ring-1 focus:ring-brand-primary outline-none transition-all text-sm">
                        <option value="E-Wallet">E-Wallet</option>
                        <option value="Bank">Transfer Bank</option>
                    </select>
                </div>

                <div id="ewalletContainer" class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih E-Wallet</label>
                    <select name="nama_ewallet" id="ewalletSelect" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary focus:ring-1 focus:ring-brand-primary outline-none transition-all text-sm">
                        <option value="DANA">DANA</option>
                        <option value="OVO">OVO</option>
                        <option value="GoPay">GoPay</option>
                        <option value="ShopeePay">ShopeePay</option>
                        <option value="LinkAja">LinkAja</option>
                    </select>
                </div>

                <div id="bankContainer" class="mb-4 hidden">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pilih Bank</label>
                    <select name="nama_bank" id="bankSelect" onchange="toggleBankLainnya()" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary focus:ring-1 focus:ring-brand-primary outline-none transition-all text-sm">
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
                    <label class="block text-sm font-semibold text-slate-700 mb-2" id="labelNomor">Nomor HP DANA</label>
                    <input type="text" name="nomor_rekening_hp" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary outline-none transition-all text-sm" placeholder="08...">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Pemilik Akun / Rekening</label>
                    <input type="text" name="nama_pemilik" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary outline-none transition-all text-sm" placeholder="Atas Nama...">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jumlah Penarikan (Rp)</label>
                    <input type="number" name="jumlah" required min="10000" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary outline-none transition-all text-sm" placeholder="Minimal 10.000">
                </div>
                
                <div id="wdAlertMessage" class="hidden mb-4 p-3 rounded-lg text-sm"></div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeWithdrawalModal()" class="px-5 py-2.5 text-slate-600 font-medium hover:bg-slate-50 rounded-xl transition-colors">Batal</button>
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
            labelNomor.innerText = 'Nomor Rekening';
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
                }, 1500);
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
