@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8 mt-4">
        <h3 class="text-xs font-bold text-slate-400 tracking-wider uppercase mb-1">RIWAYAT</h3>
        <h2 class="text-3xl font-extrabold text-[#0B1A2F] mb-2 tracking-tight">Aktivitas saldo</h2>
        <p class="text-slate-500">Semua job, tugas, referral, dan penarikan kamu.</p>
    </div>

    @if($history->isEmpty())
    <!-- Empty State -->
    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-16 flex flex-col items-center justify-center text-center mt-6">
        <div class="w-[52px] h-[52px] bg-[#F1F4F9] text-[#93A1B9] rounded-2xl flex items-center justify-center mb-5">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 class="text-[17px] font-semibold text-[#6E7B91] mb-1.5 tracking-tight">Belum ada riwayat.</h3>
        <p class="text-[#93A1B9] text-[15px]">Mulai kirim email untuk melihat aktivitasmu di sini.</p>
    </div>
    @else
    <!-- History List -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mt-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-slate-700">Tanggal</th>
                        <th class="px-6 py-4 font-semibold text-slate-700">Aktivitas</th>
                        <th class="px-6 py-4 font-semibold text-slate-700">Keterangan</th>
                        <th class="px-6 py-4 font-semibold text-slate-700 text-right">Jumlah</th>
                        <th class="px-6 py-4 font-semibold text-slate-700 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($history as $item)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item['date']->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 font-medium text-slate-800">
                            <div class="flex items-center gap-3">
                                @if($item['type'] === 'job')
                                <div class="w-8 h-8 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                @else
                                <div class="w-8 h-8 rounded-full bg-amber-500/10 text-amber-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                @endif
                                {{ $item['title'] }}
                            </div>
                        </td>
                        <td class="px-6 py-4">{{ $item['details'] }}</td>
                        <td class="px-6 py-4 text-right font-bold {{ $item['type'] === 'job' ? 'text-status-success' : 'text-slate-700' }}">
                            {{ $item['type'] === 'job' ? '+' : '-' }} Rp {{ number_format($item['amount'], 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($item['status'] == 'approved')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-status-success/10 text-status-success">
                                <span class="w-1.5 h-1.5 rounded-full bg-status-success"></span> Sukses
                            </span>
                            @elseif($item['status'] == 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-status-warning/10 text-status-warning">
                                <span class="w-1.5 h-1.5 rounded-full bg-status-warning"></span> Pending
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-status-danger/10 text-status-danger">
                                <span class="w-1.5 h-1.5 rounded-full bg-status-danger"></span> Gagal 
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
