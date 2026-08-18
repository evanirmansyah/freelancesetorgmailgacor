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

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-slate-800">Job & Tugas Tersedia</h2>
            <p class="text-xs sm:text-sm text-slate-500">Kerjakan tugas di bawah ini untuk mendapatkan saldo instan.</p>
        </div>

        @if(!empty($notice_banner))
        <div class="bg-amber-50 border border-amber-200 text-amber-800 px-3.5 py-2.5 rounded-xl font-medium text-xs sm:text-sm flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <span>{{ $notice_banner }}</span>
        </div>
        @endif
    </div>

    <!-- Job Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
        
        <!-- Job 1: Email Khusus -->
        <div class="bg-white rounded-2xl border {{ $status_email_khusus === 'closed' ? 'border-slate-200 opacity-80' : 'border-slate-200 hover:border-brand-primary/50' }} shadow-xs overflow-hidden flex flex-col transition-all">
            <div class="h-1.5 {{ $status_email_khusus === 'closed' ? 'bg-slate-300' : 'bg-brand-primary' }}"></div>
            <div class="p-5 sm:p-6 flex-1 flex flex-col">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-11 h-11 rounded-xl {{ $status_email_khusus === 'closed' ? 'bg-slate-100 text-slate-400' : 'bg-brand-primary/10 text-brand-primary' }} flex items-center justify-center">
                        @if($status_email_khusus === 'closed')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        @endif
                    </div>
                    <div class="text-right">
                        <div class="text-xl sm:text-2xl font-extrabold text-slate-800">
                            {{ formatDisplayPrice($harga_email_khusus, '4300') }}
                        </div>
                        <div class="text-xs font-semibold {{ $status_email_khusus === 'closed' ? 'text-slate-400' : 'text-status-success' }}">
                            {{ $status_email_khusus === 'closed' ? 'Job Sedang Ditutup' : '✓ Reward Instan' }}
                        </div>
                    </div>
                </div>
                
                <h3 class="text-base sm:text-lg font-bold text-slate-800 mb-1.5">Pembuatan Email Khusus</h3>
                <p class="text-xs sm:text-sm text-slate-500 mb-6 flex-1 whitespace-pre-line">{{ $instruksi_email_khusus ?? 'Buat email dengan format tertentu sesuai panduan.' }}</p>
                
                @if($status_email_khusus === 'closed')
                <div class="w-full py-3 bg-slate-100 text-slate-400 font-bold text-sm rounded-xl flex items-center justify-center gap-2 cursor-not-allowed select-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Job Ditutup Sementara
                </div>
                @else
                <button onclick="openModal('Email Khusus')" class="w-full py-3 bg-brand-primary text-white font-bold text-sm rounded-xl shadow-xs hover:bg-brand-secondary active:scale-[0.98] transition-all">
                    Ambil Tugas Email Khusus
                </button>
                @endif
            </div>
        </div>

        <!-- Job 2: Email Bebas -->
        <div class="bg-white rounded-2xl border {{ $status_email_bebas === 'closed' ? 'border-slate-200 opacity-80' : 'border-slate-200 hover:border-emerald-500/50' }} shadow-xs overflow-hidden flex flex-col transition-all">
            <div class="h-1.5 {{ $status_email_bebas === 'closed' ? 'bg-slate-300' : 'bg-emerald-600' }}"></div>
            <div class="p-5 sm:p-6 flex-1 flex flex-col">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-11 h-11 rounded-xl {{ $status_email_bebas === 'closed' ? 'bg-slate-100 text-slate-400' : 'bg-emerald-500/10 text-emerald-600' }} flex items-center justify-center">
                        @if($status_email_bebas === 'closed')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path></svg>
                        @endif
                    </div>
                    <div class="text-right">
                        <div class="text-xl sm:text-2xl font-extrabold text-slate-800">
                            {{ formatDisplayPrice($harga_email_bebas, '3300') }}
                        </div>
                        <div class="text-xs font-semibold {{ $status_email_bebas === 'closed' ? 'text-slate-400' : 'text-emerald-600' }}">
                            {{ $status_email_bebas === 'closed' ? 'Job Sedang Ditutup' : '✓ Reward Instan' }}
                        </div>
                    </div>
                </div>
                
                <h3 class="text-base sm:text-lg font-bold text-slate-800 mb-1.5">Pembuatan Email Bebas</h3>
                <p class="text-xs sm:text-sm text-slate-500 mb-6 flex-1 whitespace-pre-line">{{ $instruksi_email_bebas ?? 'Buat email dengan nama bebas tanpa format khusus.' }}</p>
                
                @if($status_email_bebas === 'closed')
                <div class="w-full py-3 bg-slate-100 text-slate-400 font-bold text-sm rounded-xl flex items-center justify-center gap-2 cursor-not-allowed select-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Job Ditutup Sementara
                </div>
                @else
                <button onclick="openModal('Email Bebas')" class="w-full py-3 bg-emerald-600 text-white font-bold text-sm rounded-xl shadow-xs hover:bg-emerald-700 active:scale-[0.98] transition-all">
                    Ambil Tugas Email Bebas
                </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Riwayat Job Saya -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden mt-6">
        <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-sm sm:text-base">Riwayat Tugas Terakhir</h3>
            <a href="{{ route('history') }}" class="text-xs text-brand-primary font-semibold hover:underline">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto smooth-scroll">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 text-xs">
                    <tr>
                        <th class="px-4 sm:px-6 py-3.5 font-semibold text-slate-700">Tanggal</th>
                        <th class="px-4 sm:px-6 py-3.5 font-semibold text-slate-700">Tugas</th>
                        <th class="px-4 sm:px-6 py-3.5 font-semibold text-slate-700">Jumlah</th>
                        <th class="px-4 sm:px-6 py-3.5 font-semibold text-slate-700">Reward</th>
                        <th class="px-4 sm:px-6 py-3.5 font-semibold text-slate-700">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs sm:text-sm">
                    @forelse($history as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 sm:px-6 py-3.5 whitespace-nowrap">{{ $item->created_at->format('d M, H:i') }}</td>
                        <td class="px-4 sm:px-6 py-3.5 font-semibold text-slate-800">{{ $item->category }}</td>
                        <td class="px-4 sm:px-6 py-3.5 whitespace-nowrap">{{ $item->total_emails }} Akun</td>
                        <td class="px-4 sm:px-6 py-3.5 font-bold text-brand-primary whitespace-nowrap">Rp {{ number_format($item->total_reward, 0, ',', '.') }}</td>
                        <td class="px-4 sm:px-6 py-3.5 whitespace-nowrap">
                            @if($item->status == 'approved')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-status-success/10 text-status-success">
                                <span class="w-1.5 h-1.5 rounded-full bg-status-success"></span> ACC
                            </span>
                            @elseif($item->status == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-status-warning/10 text-status-warning">
                                <span class="w-1.5 h-1.5 rounded-full bg-status-warning"></span> Pending
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-status-danger/10 text-status-danger">
                                <span class="w-1.5 h-1.5 rounded-full bg-status-danger"></span> Ditolak
                            </span>
                            @if($item->admin_notes)
                            <div class="text-[11px] text-slate-500 mt-0.5">{{ $item->admin_notes }}</div>
                            @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 sm:px-6 py-8 text-center text-slate-400 text-xs sm:text-sm">Belum ada riwayat tugas dikirim.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Setor Email -->
<div id="submitModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in-95 duration-150">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-800">Setor <span id="modalCategoryName">Email</span></h3>
            <button onclick="closeModal()" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6">
            <form id="submitForm" onsubmit="submitEmail(event)">
                @csrf
                <input type="hidden" name="category" id="inputCategory">

                <!-- Input for Email Khusus (Single Account) -->
                <div id="singleAccountInput" class="hidden space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Email</label>
                        <input type="email" id="singleEmail" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary outline-none transition-all text-sm" placeholder="nama@gmail.com">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password Email</label>
                        <input type="text" id="singlePassword" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary outline-none transition-all text-sm" placeholder="Password email">
                    </div>
                </div>

                <!-- Input for Email Bebas (Bulk) -->
                <div id="bulkAccountInput" class="hidden mb-4">
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Daftar Akun (Email & Password)</label>
                    <p class="text-xs text-slate-500 mb-2">Format: <code>email@gmail.com|password123</code> (1 baris 1 akun)</p>
                    <textarea id="emailData" name="email_data" rows="6"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-brand-primary outline-none transition-all font-mono text-xs sm:text-sm"
                        placeholder="email1@gmail.com|pass1&#10;email2@gmail.com|pass2"></textarea>
                </div>
                
                <div id="alertMessage" class="hidden mb-4 p-3 rounded-xl text-sm"></div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-slate-600 font-medium hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                    <button type="submit" id="submitBtn" class="px-5 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-xs hover:bg-brand-secondary transition-colors flex items-center gap-2">
                        <span>Kirim Setoran</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(category) {
        document.getElementById('modalCategoryName').innerText = category;
        document.getElementById('inputCategory').value = category;
        document.getElementById('emailData').value = '';
        document.getElementById('singleEmail').value = '';
        document.getElementById('singlePassword').value = '';
        
        if (category === 'Email Khusus') {
            document.getElementById('singleAccountInput').classList.remove('hidden');
            document.getElementById('bulkAccountInput').classList.add('hidden');
            document.getElementById('emailData').removeAttribute('required');
            document.getElementById('singleEmail').setAttribute('required', 'required');
            document.getElementById('singlePassword').setAttribute('required', 'required');
        } else {
            document.getElementById('singleAccountInput').classList.add('hidden');
            document.getElementById('bulkAccountInput').classList.remove('hidden');
            document.getElementById('emailData').setAttribute('required', 'required');
            document.getElementById('singleEmail').removeAttribute('required');
            document.getElementById('singlePassword').removeAttribute('required');
        }

        document.getElementById('alertMessage').classList.add('hidden');
        document.getElementById('submitModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('submitModal').classList.add('hidden');
    }

    async function submitEmail(e) {
        e.preventDefault();
        
        const btn = document.getElementById('submitBtn');
        const alertMsg = document.getElementById('alertMessage');
        const form = document.getElementById('submitForm');
        
        btn.disabled = true;
        btn.innerHTML = 'Mengirim...';

        try {
            const formData = new FormData(form);
            
            if (document.getElementById('inputCategory').value === 'Email Khusus') {
                const email = document.getElementById('singleEmail').value;
                const pass = document.getElementById('singlePassword').value;
                formData.set('email_data', email + '|' + pass);
            }

            const response = await fetch('{{ route("job.submit") }}', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            });

            const result = await response.json();

            alertMsg.classList.remove('hidden', 'bg-red-50', 'text-red-600', 'bg-green-50', 'text-green-600');
            
            if (response.ok) {
                alertMsg.classList.add('bg-green-50', 'text-green-600');
                alertMsg.innerText = result.message;
                setTimeout(() => { window.location.reload(); }, 1200);
            } else {
                alertMsg.classList.add('bg-red-50', 'text-red-600');
                alertMsg.innerText = result.message || 'Terjadi kesalahan.';
                btn.disabled = false;
                btn.innerHTML = 'Kirim Setoran';
            }
        } catch (error) {
            alertMsg.classList.remove('hidden');
            alertMsg.classList.add('bg-red-50', 'text-red-600');
            alertMsg.innerText = 'Terjadi kesalahan jaringan.';
            btn.disabled = false;
            btn.innerHTML = 'Kirim Setoran';
        }
    }
</script>
@endsection
